<?php
// Globetrot Cargolink website relay: quote, contact and WhatsApp-chat forms post here (same origin).
// Forwards each submission server-to-server into NAVAC BMS (Contacts, Pipeline, Communications inbox,
// emails). The BMS address and secret live OUTSIDE public_html in ../globetrot-bms.php and are never
// sent to the browser. If BMS is not configured or unreachable, the enquiry is emailed to the team so
// nothing is lost.
header('Content-Type: application/json');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function out($code, $arr) { http_response_code($code); echo json_encode($arr); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(405, ['error' => 'Method not allowed']);

// Same-site only: the browser must be on this website.
$host = strtolower($_SERVER['HTTP_HOST'] ?? '');
$origin = $_SERVER['HTTP_ORIGIN'] ?? ($_SERVER['HTTP_REFERER'] ?? '');
$oh = strtolower(parse_url($origin, PHP_URL_HOST) ?: '');
if ($oh === '' || ($oh !== $host && $oh !== 'www.' . $host && 'www.' . $oh !== $host)) out(403, ['error' => 'Forbidden']);

$raw = file_get_contents('php://input', false, null, 0, 65536);
$in = json_decode($raw ?: '', true);
if (!is_array($in)) out(400, ['error' => 'Bad request']);

// Simple per-IP rate limit: 8 submissions per 10 minutes.
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$rlFile = sys_get_temp_dir() . '/gcl_rl_' . md5($ip);
$now = time(); $hits = [];
if (is_file($rlFile)) { $hits = array_filter(array_map('intval', explode(',', (string)@file_get_contents($rlFile))), function ($t) use ($now) { return $t > $now - 600; }); }
if (count($hits) >= 8) out(429, ['error' => 'Too many requests. Please try again in a few minutes.']);
$hits[] = $now; @file_put_contents($rlFile, implode(',', $hits));

$kind = in_array($in['kind'] ?? '', ['quote', 'message', 'whatsapp'], true) ? $in['kind'] : null;
if (!$kind) out(400, ['error' => 'Bad request']);
$f = is_array($in['fields'] ?? null) ? $in['fields'] : [];
$clean = function ($v, $max) { $v = is_bool($v) ? ($v ? 'true' : '') : (string)$v; $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $v); return function_exists('mb_substr') ? mb_substr(trim($v), 0, $max) : substr(trim($v), 0, $max); };
$fields = [];
foreach ($f as $k => $v) { if (preg_match('/^[A-Za-z]{1,20}$/', (string)$k)) $fields[$k] = $clean($v, $k === 'notes' || $k === 'message' || $k === 'cargo' ? 4000 : 200); }
$hp = $clean($in['hp'] ?? '', 200);
if ($hp !== '') out(200, ['success' => true, 'reference' => null]); // bot
$submissionId = preg_match('/^[A-Za-z0-9_\-:.]{8,80}$/', (string)($in['submissionId'] ?? '')) ? $in['submissionId'] : bin2hex(random_bytes(12));

// 1) NAVAC BMS
$cfgFile = dirname(__DIR__, 2) . '/globetrot-bms.php';
$cfg = is_file($cfgFile) ? (include $cfgFile) : null;
if (is_array($cfg) && !empty($cfg['url']) && !empty($cfg['siteKey'])) {
  $ch = curl_init($cfg['url']);
  curl_setopt_array($ch, [
    CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20, CURLOPT_CONNECTTIMEOUT => 8,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'x-site-key: ' . $cfg['siteKey'], 'x-forwarded-for: ' . $ip],
    CURLOPT_POSTFIELDS => json_encode(['kind' => $kind, 'submissionId' => $submissionId, 'fields' => $fields, 'hp' => '']),
  ]);
  $res = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
  if ($code >= 200 && $code < 300) { $j = json_decode((string)$res, true); out(200, ['success' => true, 'reference' => $j['reference'] ?? null]); }
  if ($code === 400) { $j = json_decode((string)$res, true); out(400, ['error' => $j['error'] ?? 'Please check the form and try again.']); }
  error_log('[gcl-relay] BMS forward failed: HTTP ' . $code);
}

// 2) Fallback: email the team directly.
$to = 'info@globetrotcargolink.com';
$labels = ['quote' => 'Quote request', 'message' => 'Website message', 'whatsapp' => 'WhatsApp chat request'];
$subject = $labels[$kind] . ' from ' . ($fields['name'] ?? 'website visitor');
$lines = [$labels[$kind] . ' (website)', ''];
foreach ($fields as $k => $v) { if ($v !== '') $lines[] = ucfirst($k) . ': ' . $v; }
$lines[] = ''; $lines[] = 'Submitted ' . gmdate('Y-m-d H:i') . ' UTC';
$headers = "From: Globetrot Website <website@globetrotcargolink.com>\r\nContent-Type: text/plain; charset=UTF-8\r\n";
$email = $fields['email'] ?? '';
if (filter_var($email, FILTER_VALIDATE_EMAIL)) $headers .= 'Reply-To: ' . $email . "\r\n";
$ok = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', implode("\n", $lines), $headers);
if (!$ok) out(502, ['error' => 'Could not send right now. Please try again.']);
out(200, ['success' => true, 'reference' => null]);
