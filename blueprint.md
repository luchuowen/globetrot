# Globetrot Cargolink International — Website Blueprint

Version 1.1 · 2026-10-09 (v1.1: experience layer, full toolset, client portal, video & voice, social, 9.8 scorecard) · Owner sign-off required before build · Source of truth for every page change.
Build agents: read §1–§3 once, then only the section of the page you are building.

---

## 0. How to use this file

| § | Contents | Read when |
|---|---|---|
| 1 | Positioning, audience, voice | first session; any copy work |
| 2 | Stack, structure, conventions | walking skeleton; any new component |
| 3 | Sitemap + build order | picking the next change |
| 4 | Global elements (nav, footer, CTAs, SEO) | skeleton; layout work |
| 5 | Page-by-page content | building that page |
| 6 | Image slots + generation guide | generating/placing images |
| 7 | Verified Kenya trade facts | any page quoting rates, rules, places |
| 8 | Open facts (`{{OWNER: …}}`) | before launch; owner fills these |
| 9 | Definition of done, launch checklist, 9.8 scorecard | `/verify`, launch |

Rule: anything marked `{{OWNER: …}}` is unknown. It renders as a neutral fallback in dev and blocks launch
(§9). Never replace it with an invented value.

---

## 1. Positioning

### 1.1 What the research says wins
- **Speed to a real answer.** Industry tests found forwarders took ~90–100 hours to answer online quote
  requests and many never replied. A promised, kept response time is the single biggest differentiator.
- **Price and transit transparency.** 65% of B2B buyers rank easy access to pricing in their top three wants.
  Small Nairobi consolidators that publish "from" rates, calculators and WhatsApp lines win SME importers.
- **Lane pages beat generic service pages.** Importers search "shipping from China to Kenya", not "sea freight".
  The strongest pages (DP World lane pages) state ports, transit ranges, frequency, documents, FAQ.
- **Kenya-specific know-how is the trust signal.** IDF 2.5%, RDL 2%, PVoC/CoC, iCMS, the 8-year car rule —
  explained clearly and correctly — proves competence better than stock claims.
- **WhatsApp first.** WhatsApp is Kenya's most-used platform. Sticky WhatsApp on every page.
- **Real proof only.** Licence numbers, memberships, named office, named people, real case notes. The previous
  company's site lost trust through broken counters ("1"), contradictions (24/7 vs Mon–Fri) and typos.

### 1.2 Positioning statement
Globetrot Cargolink International moves goods into, out of and across East Africa — by air, sea and land —
and clears them through Kenyan customs, with one accountable team from origin warehouse to final door.
Strongest on the **China → Kenya** corridor and on **SME and mid-size importers** who need clear prices,
honest timelines and a person who answers.

### 1.3 Brand essence
- **Promise:** "Cleared. Moved. Delivered." — one team, one quote, one point of contact.
- **Personality:** precise, calm, globally fluent, unmistakably Nairobi.
- **Proof pillars:** (1) Corridor expertise (China, UAE, India, UK → Kenya → region); (2) Customs mastery
  (KRA iCMS, KenTrade, PVoC); (3) Transparent pricing and timelines; (4) People who answer.

### 1.4 Tagline options (owner picks one)
1. **Cleared. Moved. Delivered.**
2. **The world, linked to your door.**
3. **East Africa's cargo link to the world.**

### 1.5 Audiences (priority order)
1. **SME importers** (retail, electronics, hardware, fashion, beauty, e-commerce) buying from China/Dubai.
   Need: all-in cost, timeline, duty, documents, someone on WhatsApp.
2. **Corporate and industrial importers** (manufacturing inputs, machinery, auto parts, energy).
   Need: reliability, FCL, project cargo, warehousing, account management, compliance.
3. **Regional transit shippers** (Uganda, Rwanda, South Sudan, DRC, Tanzania) using Mombasa / Nairobi ICD.
4. **Individuals** (personal effects, returning residents, vehicles). Lower value; served via guides + FAQ.
5. **Other agents / overseas partners** needing a Kenyan clearing partner.

### 1.6 Voice
- Short sentences. Specific nouns (Nansha, Mombasa, JKIA, Nairobi ICD, CBM, CoC). Numbers with units.
- British spelling (Kenyan business norm): "organise", "centre", "programme".
- Banned: "one-stop shop", "seamless", "cutting-edge", "world-class", "leveraging", "solutions" as a noun
  on its own, "24/7" unless true, unverifiable stats.
- Every claim either cites a §7 fact or an `{{OWNER}}` fact.

---

## 2. Stack and conventions

| Concern | Choice | Why |
|---|---|---|
| Framework | **Astro 5** (static output, TypeScript strict) | content site; ships ~0 JS; best Core Web Vitals; cheap to verify |
| Interactivity | Astro islands with **Preact** for tools, forms, portal | small bundles where JS is needed |
| Motion | **GSAP + ScrollTrigger** (scroll-scrubbed timelines, pinned chapters), **Lenis** smooth scroll, View Transitions between pages, SplitText-style line reveals (own utility) | award-level motion with one engine |
| 3D | **Three.js** route globe in home hero (lazy, GPU-tier aware; falls back to looping video, then to still) | signature moment |
| Video | Self-hosted MP4 (H.264) + WebM (AV1/VP9) loops ≤ 2.5 MB each, poster frames; long-form explainers on **Cloudflare Stream or Mux** (HLS, adaptive) — `{{OWNER: pick}}`; YouTube mirrors for SEO/social | cinematic without killing load time |
| Explainers | **Remotion** (React motion graphics in repo `/video`) — scripted, versioned, re-renderable when facts change; voice-over by **Christine** (§6.4) + burned-in captions | process explainers that stay accurate |
| AI assistant | `/api/assistant` → Claude API, grounded only on §7 facts + FAQ + service/lane content; hands off to WhatsApp/human; logs questions to improve FAQ | 24/7 answers without fake "24/7 staff" claims |
| Data | **Firebase** (Auth, Firestore, Storage, Functions) for portal, tracking, schedules, quote records | Owen's stack; pay-as-you-go, budget alerts |
| Maps | SVG corridor map (animated) + **MapLibre GL** with free vector tiles for the Track page | live vessel/flight position without Google Maps cost |
| Styling | CSS custom properties in `src/styles/tokens.css` + scoped component CSS | design-direction swap = one file |
| Content | Astro **content collections** (`src/content/{services,lanes,industries,insights,faq}`) as MDX/JSON | one template renders many pages → fastest build, fewest tokens |
| Images | `astro:assets` (AVIF/WebP, responsive `srcset`), source files in `src/assets/img/<slot-id>.jpg` | performance + gate against hotlinks |
| Forms | `/api/quote` + `/api/contact` server endpoints (Astro hybrid) → email via **Resend**; honeypot + rate limit; WhatsApp fallback | critical path |
| Hosting | **Vercel** (or Firebase Hosting + Cloud Function) — `{{OWNER: hosting choice}}` | preview URLs per branch |
| Analytics | Plausible or GA4 — `{{OWNER}}`; events: quote_submit, whatsapp_click, calc_use | measure conversions |
| Checks | `astro check`, Vitest for tool maths (duty, CBM, chargeable weight — golden tests), Playwright smoke (each route 200, no console errors, 390/1440 screenshots, reduced-motion run), Lighthouse CI budget (§9.3) | wired into `factory-check` |

### 2.1 Directory layout
```
src/
  styles/tokens.css        colours, type scale, spacing, radii, shadows, motion (from chosen direction)
  styles/global.css
  layouts/Base.astro       head/SEO, nav, footer, WhatsApp button
  components/              Button, Section, Eyebrow, StatRow, ModeCard, LaneCard, Steps, FAQ, CTA band,
                           CorridorMap, TransitTable, DocChecklist, QuoteForm*, CbmCalc*, LandedCostCalc*  (* island)
  content/                 services/*.mdx, lanes/*.mdx, industries/*.json, insights/*.mdx, faq/*.json
  data/site.ts             company facts (name, phones, emails, address, hours, licences) — single source
  pages/                   routes in §3
  pages/api/               quote.ts, contact.ts (critical)
  assets/img/              slot images (§6)
public/                    favicon set, og default, robots.txt
```

### 2.2 Conventions
- Every company fact comes from `src/data/site.ts`. Pages never hard-code a phone, email or address.
- Every page: one H1, `<title>` ≤ 60 chars, meta description ≤ 155 chars, OG image, canonical, breadcrumb JSON-LD.
- Sitewide JSON-LD: `Organization` + `LocalBusiness` (MovingCompany/FreightForwarder-like), FAQ pages: `FAQPage`.
- Primary CTA everywhere: **Get a quote**. Secondary: **WhatsApp us**. Never more than two CTAs per section.
- Breakpoints: 390 / 768 / 1024 / 1440. Mobile nav = full-screen sheet with vertical list.

### 2.3 Experience layer — what makes it award-level
The site should feel like following one shipment around the world. Motion always explains something:
where cargo is, what happens next, how long it takes. It is never there just for decoration.

**Motion system (tokens in `src/styles/motion.css` + `src/lib/motion.ts`)**
- Easing: one house curve (`--ease-cargo: cubic-bezier(.22,.8,.2,1)`) + one spring for UI; durations 200 / 450 / 900 ms.
- Scroll language: (1) **pinned chapters** scrubbed by scroll; (2) **line-by-line headline reveals**; (3) **route-line drawing** (SVG stroke) for every journey; (4) **counters** that tick in units (days, CBM, kg), never vanity stats; (5) **parallax depth** on hero media only.
- Page transitions: View Transitions API — the mode icon / lane card morphs into the next page's hero.
- Micro-interactions: magnetic primary buttons, mode cards that play a 3-s video loop on hover/visibility, quote stepper with animated cargo box filling as steps complete.
- **Accessibility first:** `prefers-reduced-motion` → all scrubs become fades, videos show posters, no smooth-scroll hijack; every animated state also exists static; keyboard focus never trapped in pinned sections.
- **Performance guardrails:** GSAP/Three loaded only on pages that use them; videos lazy, muted, `playsinline`, paused off-screen; GPU-tier check before WebGL; save-data / 2G → stills only. Total JS budget per page ≤ 170 KB gz (home ≤ 260 KB with globe).

**Signature moments (one per key page, no more)**
| Page | Moment |
|---|---|
| Home hero | **Live route globe**: WebGL Earth at night; glowing arcs from Guangzhou, Dubai, Mumbai, London converge on Mombasa/JKIA; scroll rotates the camera down into Mombasa and dissolves into the port video (`vid-home-hero`). |
| Home | **"The Journey" pinned scrollytelling** (7 chapters, ~600vh): Factory in Guangzhou → origin warehouse → vessel at sea → Mombasa berth → SGR to Nairobi ICD → customs released (iCMS) → delivered to a Nairobi shop. A day counter (Day 0 → Day ~30) and a progress route run alongside; each chapter swaps a scrubbed video clip and one line of copy. Ends: "Your cargo, this journey, one team. → Get a quote". |
| Services | Each service hero = full-bleed video loop + scroll-drawn diagram of that service's process. |
| Lanes | Animated lane map: origin pin pulses → route draws → transit-day ruler fills; switch Sea/Air toggles route and day range. |
| Import guide | Sticky "duty stack" visual that builds layer by layer (CIF → duty → excise → IDF → RDL → VAT) as you scroll the taxes section. |
| Track | Live map with vessel/flight position and milestone timeline. |
| About | Scroll-scrubbed timeline of the founder's journey (owner facts only). |

**Video & sound**
- Ambient loops: silent, 6–10 s, seamless, graded to the chosen palette (§6.3).
- Explainers: 60–120 s with Christine's voice-over, captions always on, transcript below every video (SEO + accessibility) (§6.4).
- No autoplay sound anywhere. A global "sound" toggle only appears on pages with explainers.

---

## 3. Sitemap and build order

### 3.1 Sitemap (~45 routes)
```
/                                   Home
/services                           Services hub
  /services/air-freight
  /services/sea-freight              (FCL, LCL, RoRo)
  /services/cargo-consolidation      (China groupage)
  /services/customs-clearing         (clearing & forwarding)
  /services/land-transport           (local haulage + regional transit)
  /services/warehousing
  /services/import-advisory          (sourcing support, compliance, consultancy)
/lanes                              Trade lanes hub
  /lanes/china-to-kenya
  /lanes/uae-to-kenya
  /lanes/india-to-kenya             {{OWNER: confirm lane}}
  /lanes/uk-europe-to-kenya
  /lanes/kenya-to-east-africa        (transit: UG, RW, SS, DRC, TZ)
/industries                         Industries (single page, anchored sections)
/import-guide                       Importing into Kenya — pillar guide
/tools                              Importer's toolkit hub (14 tools, §5.8)
  /tools/cbm-calculator  /tools/container-fit  /tools/landed-cost  /tools/hs-code
  /tools/vehicle-import  /tools/document-checklist  /tools/restricted-goods
  /tools/transit-time  /tools/schedule  /tools/incoterms
/track                              Track a shipment (phase 2 live data)
/ask                                AI import assistant (also a site-wide drawer)
/book                               Book a consultation
/portal  /portal/*                  Client portal (login, phase 2)
/links                              Link-in-bio for social profiles
/insights                           Insights (blog index)
  /insights/[slug]                  3 seed articles
/about                              Company, people, standards
/faq                                FAQ
/contact                            Contact
/quote                              Get a quote (multi-step)
/privacy  /terms                    Legal
/404
```

### 3.2 Build order (one change per row; each ends shipped and green)
**Phase 1 — launch site (marketing + all public tools + motion + video)**
| # | Change | Size |
|---|---|---|
| 0 | Walking skeleton: Astro, tokens + motion tokens (chosen direction), Base layout, nav, footer, WhatsApp, `site.ts`, SEO component, Lenis/GSAP setup, reduced-motion plumbing, checks + Lighthouse CI wired | standard |
| 1 | Home incl. route globe + "The Journey" scrollytelling | standard |
| 2 | Quote flow + `/api/quote` + Firestore record + Resend + WhatsApp fallback | **critical** |
| 3 | Service template + 7 services + hub | standard |
| 4 | Lane template + 5 lanes + hub + animated lane map | standard |
| 5 | Import guide (pillar) with duty-stack visual | standard |
| 6a | Tools: CBM, container fit, landed cost, transit time, document checklist, incoterms (pure maths/data, golden tests) | standard |
| 6b | Tools: HS finder, vehicle checker, restricted goods (data indexing) + explainer scripts for owner approval | standard |
| 7 | About + Industries | standard |
| 8 | FAQ + Contact + Book + `/api/contact` | **critical** |
| 9 | AI import assistant (`/api/assistant`, grounding, rate limits, handoff) | **critical** |
| 10 | Insights + 3 articles + `/links` (link-in-bio) | standard |
| 11 | Video pass: drop in §6.3 loops + §6.4 explainers (Remotion renders + Christine VO), transcripts | standard |
| 12 | Legal, 404, sitemap, OG, favicons, JSON-LD audit, social launch kit | standard |
| 13 | Launch audit vs §9.3 scorecard, deploy, domain, Search Console, Google Business Profile | **critical** |

**Phase 2 — operations (after launch)**
| # | Change | Size |
|---|---|---|
| 14 | Track page with live tracking API + Globetrot milestones | **critical** |
| 15 | Sailing & cut-off calendar (ops-editable) | standard |
| 16 | Client portal: auth, dashboard, documents, quotes | **critical** |
| 17 | Portal billing + payments + notifications | **critical** |
| 18 | Ops console (or NAVAC CRM integration) | **critical** |

Media is generated in batches before the page that needs it: A (home + global, incl. globe textures and journey clips) before #1; B (services) before #3; C (lanes) before #4; D (about/industries/insights) before #7; explainers before #11.


---

## 4. Global elements

### 4.1 Header
- Logo (left). Nav: **Services ▾** (7 items, mega-menu with one-line descriptions + mode icons),
  **Trade lanes ▾** (5), **Import guide**, **Tools ▾** (3), **About**, **Contact**. Right: **Track** (icon link), phone (desktop),
  **Get a quote** (primary button), **Client login** (phase 2).
- Utility strip (desktop only, thin): "Mon–Fri {{OWNER: hours}} · WhatsApp {{OWNER}} · info@{{OWNER: domain}}".
- Sticky, condenses on scroll. Mobile: logo + quote button + menu → full-height sheet, vertical list.

### 4.2 Footer
- Columns: Services · Trade lanes · Importer resources · Company · Contact block (address, phones, emails,
  hours, WhatsApp, map link).
- Standards row: licence / membership badges — only those in §8 confirmed by owner.
- Newsletter (optional, `{{OWNER}}`): "Monthly freight & customs brief".
- Legal line: © 2026 Globetrot Cargolink International · Privacy · Terms · Standard trading conditions.

### 4.3 Persistent CTAs
- Floating WhatsApp button (bottom-right; prefilled: "Hi Globetrot Cargolink, I'd like a quote for…").
- End-of-page CTA band on every page (variant per page): headline + Get a quote + WhatsApp.

### 4.4 SEO base
- Title pattern: `<Page topic> | Globetrot Cargolink` (home: `Freight Forwarding & Customs Clearing in Kenya | Globetrot Cargolink`).
- Target keyword per page listed in §5. Internal linking: every service links to ≥ 2 lanes and the guide;
  every lane links to the services it uses and to /quote with lane prefilled (`/quote?lane=china-to-kenya`).

### 4.5 Social presence
Channels, in priority order: **WhatsApp Business** (catalogue of services, quick replies, labels, greeting/away messages) · **Google Business Profile** (reviews, map pack — biggest local SEO lever) · **LinkedIn** company page (corporate importers) · **Instagram** · **TikTok** (explainer cutdowns, "a day at Mombasa port") · **Facebook** · **YouTube** (explainers, embedded on site).
- **Accounts are created by the owner** (platform rules require the business owner's identity and phone). Then he adds NAVAC as admin/manager. We supply a **Social launch kit**: handle availability check (`@globetrotcargolink` or similar), bios per platform, profile + cover art from the chosen logo, highlight covers, link-in-bio page (`/links` on the site), 30-day launch calendar, 12 ready posts + 6 reels cut from the explainers.
- Site integration: footer icons (only live accounts), Open Graph/Twitter cards per page, share buttons on Insights, Google reviews widget on Home/About (static, cached daily — no heavy third-party script), Instagram strip on About (optional, cached).

---

## 5. Page-by-page content

Format per page: **Purpose · Keyword · Sections (in order) with exact copy or copy brief · Images · CTA.**
Copy marked "write:" is a brief for the build agent, constrained by §1.6 and §7.

### 5.1 Home `/`
Purpose: in 10 seconds, tell an importer what we move, where, and how to get a price. Keyword: *freight forwarding and customs clearing Kenya*.

1. **Hero** — live route globe (§2.3) that dissolves into `vid-home-hero` on scroll; still `home-hero` as poster/fallback
   - Eyebrow: AIR · SEA · LAND · CUSTOMS
   - H1: **Cargo from anywhere. Cleared and delivered in Kenya.**
   - Sub: Air, sea and road freight with customs clearing handled in-house — one team from the supplier's door in China, Dubai or the UK to yours in Nairobi, Mombasa or Kampala.
   - CTAs: Get a quote · WhatsApp us
   - Micro-proof under CTAs: "Quote reply within {{OWNER: e.g. 4 working hours}}" · "KRA-licensed customs agent {{OWNER: confirm}}"
2. **Quick quote strip** (overlapping hero bottom): Mode (Air / Sea FCL / Sea LCL / Road) · From · To · Weight or CBM → "Get my quote" (deep-links to /quote prefilled).
3. **What we move — 4 mode cards** (slots `mode-air`, `mode-sea`, `mode-land`, `mode-customs`)
   - Air freight — "Urgent and high-value cargo into JKIA, with express and consolidated options."
   - Sea freight — "FCL and LCL into Mombasa and Lamu, railed to Nairobi ICD on the SGR."
   - Land & transit — "Local haulage and Northern Corridor transit to Uganda, Rwanda, South Sudan and DRC."
   - Customs clearing — "Entries lodged on KRA iCMS, permits through KenTrade, cargo released without the runaround."
4. **The Journey** — pinned 7-chapter scrollytelling (§2.3, clips `vid-journey-1..7`). Chapter lines:
   1 "Day 0 · Guangzhou. Your supplier packs the order." 2 "Day 2 · Our origin warehouse checks, photographs and consolidates it." 3 "Day 5 · On the water. Booked, documented, insured." 4 "Day ~27 · Mombasa. Discharged and lined up for clearing." 5 "SGR to Nairobi ICD. Overnight." 6 "Entry lodged on iCMS. Duties paid. Released." 7 "Delivered to your door — with a WhatsApp update at every step." (Day figures illustrative, labelled "typical sea journey", from §7.3.)
5. **Watch how it works** — explainer `exp-01` (90 s, Christine) in a cinematic player with chapter markers.
6. **Corridors section** — interactive CorridorMap (SVG): pins Guangzhou/Shenzhen/Yiwu, Dubai (Jebel Ali), Nhava Sheva/Mumbai, UK/Europe → Mombasa / JKIA / Nairobi ICD / Naivasha ICD → Kampala, Kigali, Juba, Goma. Click a lane → card with mode, indicative transit range (§7.3), "View lane" link.
   - H2: **Your corridor, mapped.**
7. **How it works — 4 steps** (Steps component; condensed recap after the Journey)
   1. Tell us what you're shipping — share supplier details, cargo, destination.
   2. We quote all-in — freight, clearing, duties estimate and delivery, itemised.
   3. We move and clear — booking, documents, iCMS entry, release.
   4. Delivered to your door — with updates on WhatsApp at every milestone.
8. **Why Globetrot Cargolink — 4 pillars** (from §1.3) each with 1 sentence + icon. Write: concise, factual.
9. **Proof band** — only verified items: years of team experience `{{OWNER}}`, shipments handled by team `{{OWNER}}`, client logos `{{OWNER}}`, one testimonial `{{OWNER}}`. If none confirmed at launch, this band shows licences + office + named people instead (never empty counters).
10. **Importer's toolkit teaser** — bento grid of 6 tools (Track, Landed cost, CBM, HS finder, Vehicle checker, AI assistant) with live mini-interactions.
11. **Industries strip** — 5 chips linking to /industries anchors.
12. **Insights** — latest 3 articles + social strip (live accounts only).
13. **CTA band** — H2: **Have a shipment coming? Get a clear price today.**

### 5.2 Services hub `/services`
Keyword: *clearing and forwarding services Nairobi*. H1: **Freight and customs services, end to end.**
Intro (write: 2 sentences). Grid of 7 service cards (image + 1 line + link). "Not sure which you need?" → WhatsApp. CTA band.

### 5.3 Service template (all 7 share it)
Sections: Hero (H1, sub, image, CTAs) → **What's included** (4–6 bullets) → **How it works** (3–5 steps) →
**Options** table/cards → **Transit & timing** (where relevant, from §7.3) → **Documents you'll need** →
**Related lanes** (cards) → **FAQ** (4–6, FAQPage schema) → CTA band (quote prefilled with mode).

| Service | H1 | Keyword | What's included (build agent expands to copy) | Options | Image slots |
|---|---|---|---|---|---|
| Air freight | Air freight into JKIA, cleared fast | air freight to Kenya | consolidated & direct (back-to-back) airfreight; express for urgent parcels; airport-to-airport or door-to-door; dangerous-goods handling `{{OWNER: confirm DG capability}}`; perishables & export from JKIA `{{OWNER}}`; chargeable-weight explained (÷6000) | Express · Consolidated · Direct · Charter on request | `svc-air-hero`, `svc-air-detail` |
| Sea freight | Sea freight into Mombasa — FCL and LCL | sea freight to Kenya | FCL 20'/40'/40'HC; LCL; RoRo vehicles & machinery; port clearing at Mombasa; SGR rail to Nairobi ICD; container delivery & empty return | FCL · LCL · RoRo · Breakbulk/project | `svc-sea-hero`, `svc-sea-detail` |
| Cargo consolidation | Consolidated shipping from China, priced per CBM | consolidated shipping China to Kenya | receiving at origin warehouse `{{OWNER: Guangzhou/Yiwu warehouse address}}`; supplier coordination; inspection & photos on arrival; combining many suppliers into one shipment; weekly/fortnightly sailings `{{OWNER}}`; per-CBM and per-kg pricing; door delivery in Kenya | Sea LCL groupage · Air consolidation | `svc-consol-hero`, `svc-consol-detail` |
| Customs clearing | Customs clearing in Kenya, done right first time | clearing agents Nairobi / Mombasa | tariff classification (HS); duty & tax computation; iCMS entry lodging; KenTrade permits (KEBS, KEPHIS, PPB etc.); PVoC/CoC guidance; IDF; exemptions & diplomatic cargo (PRO 1B); post-release support | Import · Export · Transit · Re-export | `svc-customs-hero`, `svc-customs-detail` |
| Land transport | Road and rail across Kenya and East Africa | transit cargo Mombasa to Kampala | FTL/LTL trucking; container haulage from Mombasa/Nairobi ICD; Northern Corridor transit to UG, RW, SS, DRC, and to TZ; bond & transit documentation; last-mile distribution in Nairobi | Local · Upcountry · Cross-border transit | `svc-land-hero`, `svc-land-detail` |
| Warehousing | Warehousing and distribution in Nairobi | warehousing in Nairobi | short- and long-term storage `{{OWNER: location, size, bonded?}}`; receiving & inspection; pick, pack & kitting; cross-docking; stock reporting; distribution | Storage · Cross-dock · Fulfilment | `svc-warehouse-hero`, `svc-warehouse-detail` |
| Import advisory | Import advisory, sourcing support and compliance | how to import goods from China to Kenya | supplier verification & factory coordination; pre-shipment inspection; Incoterms advice; landed-cost planning; regulatory checks (KEBS, PPB, KEPHIS); commission agency `{{OWNER: confirm}}` | Sourcing support · Compliance check · Landed-cost plan | `svc-advisory-hero` |

### 5.4 Trade lanes hub `/lanes`
H1: **Trade lanes into and across East Africa.** Full-width CorridorMap; 5 lane cards; CTA band.

### 5.5 Lane template (all 5 share it)
Sections: Hero (lane name, origin→destination graphic, slot) → **At a glance** (modes, origin ports/airports,
destination gateways, indicative transit ranges, frequency `{{OWNER}}`) → **How we run this lane** (4 steps,
origin pickup → main leg → clearing → delivery) → **Pricing guide** ("from" bands only if `{{OWNER: rates}}`
supplied; otherwise "what affects your price" list + quote CTA) → **Documents** → **Common cargo** →
**Lane FAQ** (5) → CTA band (quote prefilled with lane).

| Lane | H1 | Keyword | Origin points | Kenya gateway | Indicative transit (see §7.3) | Slot |
|---|---|---|---|---|---|---|
| China → Kenya | Shipping from China to Kenya | shipping from China to Kenya | Guangzhou/Nansha, Shenzhen, Ningbo, Shanghai, Yiwu (consolidation) | Mombasa → SGR → Nairobi ICD; JKIA | sea ~22–30 days port-to-port; air ~2–7 days | `lane-china` |
| UAE → Kenya | Shipping from Dubai to Kenya | shipping from Dubai to Kenya | Jebel Ali, DXB/DWC | Mombasa; JKIA | `{{OWNER: confirm}}` | `lane-uae` |
| India → Kenya | Shipping from India to Kenya | shipping from India to Kenya | Nhava Sheva, Mundra, Chennai; BOM/DEL | Mombasa; JKIA | `{{OWNER}}` | `lane-india` |
| UK/Europe → Kenya | Shipping from the UK and Europe to Kenya | shipping from UK to Kenya | Felixstowe, Southampton, Rotterdam, Antwerp; LHR, AMS | Mombasa; JKIA | `{{OWNER}}` | `lane-uk` |
| Kenya → East Africa | Transit cargo from Mombasa to Uganda, Rwanda, South Sudan and DRC | transit cargo to Uganda | Mombasa, Nairobi ICD, Naivasha ICD | Malaba, Busia borders → Kampala, Kigali, Juba, Goma | `{{OWNER}}` | `lane-transit` |

### 5.6 Industries `/industries`
H1: **Built around what you import.** Five anchored sections, each: image, 2-sentence challenge, what we do
(3 bullets), related service links. Case note only if owner supplies one.
1. Retail & e-commerce (`ind-retail`) 2. Electronics & technology (`ind-electronics`) 3. Automotive & spare parts (`ind-auto`)
4. Manufacturing & industrial inputs (`ind-manufacturing`) 5. Energy, construction & projects (`ind-energy`)

### 5.7 Import guide `/import-guide` (pillar, ~2,500 words)
Keyword: *how to import goods into Kenya*. H1: **Importing into Kenya: the complete guide.** Sticky table of contents.
Sections (all facts from §7, each cited in a "Sources" footnote list):
1. The import journey in 7 steps (supplier → PVoC → booking → arrival → iCMS entry → duties & release → delivery)
2. Documents you need (commercial invoice, packing list, B/L or AWB, CoC, IDF/UCR, KRA PIN, permits)
3. Duties and taxes explained — CIF value → import duty (EAC CET 0/10/25/35%) → excise (where applicable) → IDF 2.5% → RDL 2% → VAT 16% (worked example with neutral numbers, clearly labelled illustrative)
4. KEBS PVoC and Certificate of Conformity
5. Permits through KenTrade (KEBS, KEPHIS, PPB, Port Health…)
6. Importing a vehicle (8-year rule: from 1 Jan 2026 only RHD vehicles first registered 2019 or later)
7. Personal effects & returning residents (VAT-free threshold USD 2,000, Finance Act 2026)
8. Transit to neighbouring countries
9. New in 2026 (Finance Act 2026: keep export documents 5 years from 1 Sep 2026)
10. Common mistakes that cause delays (write: 6 items)
CTA: "Want us to check your shipment before it leaves?" → quote.

### 5.8 Tools — the Importer's toolkit (all free, no login; results can be emailed/WhatsApped and turned into a quote)
Hub `/tools` H1: **Importer's toolkit.** Card grid grouped as Plan · Cost · Comply · Ship. Disclaimer:
estimates only; KRA sets the final figures at entry. Every tool ends with "Quote this shipment" (prefilled) and "Ask on WhatsApp".

| # | Tool | Route | What it does | Data source |
|---|---|---|---|---|
| 1 | **Instant quote** | `/quote` | multi-step request → reference no. → reply SLA (§5.13) | owner pricing desk |
| 2 | **Track a shipment** | `/track` | enter B/L, container no., AWB or Globetrot ref → live map + milestone timeline + ETA | container/AWB tracking API `{{OWNER: provider, e.g. ShipsGo / Terminal49 / Vizion — paid}}` + Globetrot ops milestones from Firestore |
| 3 | **CBM & chargeable-weight calculator** | `/tools/cbm-calculator` | rows of L×W×H×qty + weight → CBM, volumetric weight (÷6000), chargeable weight, sea-vs-air hint, 3D carton stack preview | maths (golden tests) |
| 4 | **Container fit planner** | `/tools/container-fit` | cartons → how many fit a 20' / 40' / 40'HC, % utilisation, LCL vs FCL breakpoint | standard container dims |
| 5 | **Landed-cost & duty estimator** | `/tools/landed-cost` | value, freight, insurance, HS/duty band, excise, FX → itemised CIF, duty, excise, IDF 2.5%, RDL 2%, VAT 16%, total in KES & USD; PDF download | §7 + editable FX (daily CBK rate fetch `{{OWNER: confirm}}`) |
| 6 | **HS code & duty finder** | `/tools/hs-code` | search by product words → likely HS headings + CET duty band; "confirm with us" | EAC CET 2022 tariff (public document) indexed at build |
| 7 | **Vehicle import checker** | `/tools/vehicle-import` | year of first registration, drive side, engine cc, CRSP value → eligible? + duty/excise/VAT/IDF/RDL estimate | §7.2 rule + KRA CRSP list `{{OWNER: confirm source}}` |
| 8 | **Document checklist generator** | `/tools/document-checklist` | cargo type + origin + mode → exact document & permit list with issuing agency; print/PDF | §7.2 |
| 9 | **Prohibited & restricted goods checker** | `/tools/restricted-goods` | search item → allowed / needs permit (which agency) / prohibited | EACCMA schedules + KenTrade agencies, curated |
| 10 | **Transit-time estimator** | `/tools/transit-time` | lane × mode → door-to-door range broken into legs (origin, main leg, port, clearing, delivery) | §7.3 + owner data |
| 11 | **Sailing & cut-off calendar** | `/tools/schedule` | next consolidation closing dates per origin warehouse; add to calendar | owner schedule in Firestore |
| 12 | **Incoterms® 2020 explorer** | `/tools/incoterms` | pick a term → animated who-pays-what along the route | ICC definitions (paraphrased) |
| 13 | **AI import assistant** | site-wide drawer + `/ask` | answers import questions in plain language, cites the guide, hands off to WhatsApp/human, never quotes binding prices | §7, FAQ, guide (Claude API) |
| 14 | **Book a consultation** | `/book` | 20-min call / office visit slots | Cal.com or Google Calendar booking `{{OWNER}}` |

Events: tool_use, tool_to_quote, tool_to_whatsapp, assistant_handoff.
Every maths tool has golden tests (`npm test`) that run in `factory-check full`.

### 5.8a Client portal `/portal` (login) — critical
For account clients. Firebase Auth (email link + phone OTP).
- Dashboard: active shipments with milestone timeline and map, ETAs, alerts.
- Documents: B/L, AWB, invoices, entries, release orders (download); upload supplier invoice/packing list.
- Quotes: history, accept a quote, convert to booking.
- Billing: invoices & statements, payment via M-Pesa/card `{{OWNER: payment rail, e.g. TaifaPay}}`.
- Notifications: WhatsApp/SMS/email on each milestone (opt-in).
- Ops side (`/portal/ops`, staff role): create shipments, post milestones, attach documents, manage schedules. Option: power this from **NAVAC CRM/BMS** instead of a new back office `{{OWNER: decide}}`.

### 5.9 Insights `/insights`
Index with category filter (Customs · Freight markets · Guides). Seed articles (write ~900 words each, sourced):
1. "IDF and RDL in 2026: what importers actually pay" 2. "LCL vs FCL from China: when to switch" 3. "Kenya's 8-year vehicle rule in 2026, explained"
Slots: `insight-1..3`.

### 5.10 About `/about`
H1: **The cargo link between Kenya and the world.**
1. Story (write from `{{OWNER: founder story — years in freight, why start Cargolink}}`; never name the previous company)
2. Mission & values — Accountable · Transparent · Fast · Compliant (1 line each)
3. People — founder + key team with photo (slot `team-*`, real photos preferred) `{{OWNER}}`
4. Standards & memberships — only confirmed (§8)
5. Our network — origin agents/partners by country `{{OWNER}}` + map
6. Office — photo (`about-office`), address, hours
CTA band.

### 5.11 FAQ `/faq`
Grouped accordions (FAQPage schema). Seed questions (answers from §7 + owner):
- Quotes & pricing: How fast do you quote? What's included in an all-in quote? How is chargeable weight worked out? Do you charge per CBM or per kg? When do I pay?
- Customs: What documents do I need? What are IDF and RDL? Do I need a CoC? How long does clearing take? Can you clear diplomatic/exempt cargo?
- Shipping: How long from China by sea / air? Can you collect from multiple suppliers? Do you insure cargo? What if my cargo is damaged? (report concealed damage within `{{OWNER: e.g. 48 hours}}`)
- Regional: Can you deliver to Uganda/Rwanda/South Sudan/DRC?

### 5.12 Contact `/contact`
H1: **Talk to a person.** Cards: Call · WhatsApp · Email · Visit (address + lazy map). Hours. Short contact form
(name, phone, email, message, topic). Response promise `{{OWNER}}`. Slot `contact-hero`.

### 5.13 Get a quote `/quote` (critical)
H1: **Get a clear, itemised quote.** Multi-step (progress bar, saves to sessionStorage):
1. Mode: Air · Sea FCL · Sea LCL · Road/transit · Customs clearing only · Not sure
2. Route: origin country/city, destination (city), incoterm (optional), pickup needed?
3. Cargo: description, HS code (optional), weight, CBM or dimensions (inline CBM calc), packages, value (USD), dangerous goods?, needs CoC?
4. You: name, company (optional), phone (WhatsApp), email, preferred contact
Submit → `/api/quote` (validate server-side, honeypot, rate-limit, email to `{{OWNER: sales email}}` + auto-reply to customer with reference number `GCL-YYMMDD-XXXX`) → success state: reference + "We'll reply within {{OWNER}}" + WhatsApp button with reference prefilled.
Fallback if API fails: show WhatsApp button with full summary prefilled.

### 5.14 Legal & 404
- Privacy (Kenya Data Protection Act 2019 aware; what the forms collect, retention, contact) — write.
- Terms of website use + link to standard trading conditions `{{OWNER: confirm KIFWA STC or own}}`.
- 404: H1 "This cargo took a wrong turn." links: Home, Services, Quote.

---

## 6. Image slots

### 6.1 Generation guide (applies to every slot)
- **Look:** cinematic editorial photography; golden-hour or blue-hour light; shallow depth of field; true-to-life
  East African settings (Mombasa port, Nairobi skyline, SGR, JKIA-type apron); people are Kenyan professionals
  in hi-vis/PPE or business attire, diverse; no visible third-party logos, airline liveries, shipping-line
  branding or readable text; no fake signage. Colour grade tuned to the chosen design direction.
- **Format:** generate at ≥ 2400px on the long edge; save as `src/assets/img/<slot-id>.jpg`; `astro:assets` makes AVIF/WebP.
- **Prompt suffix (append to every prompt):** "photorealistic, shot on a full-frame camera, 35mm lens, natural
  light, high dynamic range, no text, no logos, no watermarks, editorial magazine quality".
- Team and office slots: **real photography preferred** (owner to supply); generated placeholders are marked `draft-` and must be replaced before launch.

### 6.2 Slot register
| Slot ID | Page / section | Aspect | Prompt (before suffix) | Alt text |
|---|---|---|---|---|
| `home-hero` | Home hero | 16:9 (+ 4:5 mobile crop) | Aerial view at dawn of a busy East African container port, gantry cranes loading a large vessel, ocean haze, warm sunrise over the Indian Ocean | Container ship being loaded at dawn in a Kenyan port |
| `mode-air` | Home mode card | 4:5 | Cargo aircraft nose door open on an apron at dusk, palletised cargo on loaders, Nairobi skyline faint in distance | Air cargo being loaded onto a freighter at dusk |
| `mode-sea` | Home mode card | 4:5 | Stacked colourful unbranded containers at a port terminal, low angle, dramatic sky | Shipping containers stacked at a port terminal |
| `mode-land` | Home mode card | 4:5 | Long-haul truck with container on an open highway through the Kenyan savannah at golden hour, acacia trees | Container truck on a highway across the Kenyan savannah |
| `mode-customs` | Home mode card | 4:5 | Kenyan customs specialist in a hi-vis vest reviewing documents on a tablet beside an open container | Customs specialist checking cargo documents beside a container |
| `svc-air-hero` | Air freight | 21:9 | Wide shot of a cargo apron at blue hour, ULD containers lined up, aircraft silhouettes | Air cargo containers lined up on an airport apron |
| `svc-air-detail` | Air freight | 3:2 | Close-up of hands securing a cargo net over a pallet in an air cargo warehouse | Handler securing an air cargo pallet |
| `svc-sea-hero` | Sea freight | 21:9 | Container vessel entering a harbour channel between palm-lined shores, morning light | Container vessel entering a tropical harbour |
| `svc-sea-detail` | Sea freight | 3:2 | Freight train carrying containers on a modern standard-gauge railway through dry grassland | Container train on Kenya's standard-gauge railway |
| `svc-consol-hero` | Consolidation | 21:9 | Large, orderly warehouse with mixed cartons on pallets being sorted into consolidated loads, workers with scanners | Mixed cartons being consolidated into one shipment |
| `svc-consol-detail` | Consolidation | 3:2 | LCL container half loaded with neatly stacked labelled cartons (labels unreadable) | Neatly stacked cartons inside a consolidation container |
| `svc-customs-hero` | Customs | 21:9 | Calm modern office overlooking a port, specialist working on customs entries across two screens, documents on desk | Customs team preparing import entries |
| `svc-customs-detail` | Customs | 3:2 | Officer and agent inspecting an open container with clipboard, port setting | Cargo inspection at an open container |
| `svc-land-hero` | Land transport | 21:9 | Convoy of container trucks on a highway climbing an escarpment with Rift Valley views | Container trucks crossing the Rift Valley escarpment |
| `svc-land-detail` | Land transport | 3:2 | Truck at a border logistics yard at dawn, driver with documents | Truck at a cross-border logistics yard |
| `svc-warehouse-hero` | Warehousing | 21:9 | High-bay warehouse with racking, forklift in motion, clean lighting | Modern high-bay warehouse with a forklift at work |
| `svc-warehouse-detail` | Warehousing | 3:2 | Warehouse staff picking and packing orders at a workstation | Staff picking and packing orders |
| `svc-advisory-hero` | Import advisory | 21:9 | Kenyan business owner and logistics advisor reviewing product samples and a shipping plan in a bright office | Advisor and importer planning a shipment |
| `lane-china` | China lane | 21:9 | Busy South China port at night, illuminated cranes and containers, reflections on water | South China container port at night |
| `lane-uae` | UAE lane | 21:9 | Large Gulf port at sunset with dhows in the foreground and container cranes behind | Gulf port at sunset with traditional dhows |
| `lane-india` | India lane | 21:9 | West Indian container terminal at morning, cranes and haze | Indian container terminal in morning haze |
| `lane-uk` | UK/Europe lane | 21:9 | North-European container port under dramatic grey-blue sky | European container port under a dramatic sky |
| `lane-transit` | Transit lane | 21:9 | Highway through green Ugandan-style hills with trucks, tea fields | Trucks on a highway through green East African hills |
| `ind-retail` | Industries | 3:2 | Neatly packed retail cartons arriving at a Nairobi shop's back store | Retail stock arriving at a store |
| `ind-electronics` | Industries | 3:2 | Sealed electronics cartons on a pallet being scanned | Electronics cartons being scanned on arrival |
| `ind-auto` | Industries | 3:2 | Auto spare parts in labelled crates in a warehouse, mechanic checking | Vehicle spare parts in crates |
| `ind-manufacturing` | Industries | 3:2 | Industrial machinery crate lifted by a forklift in a factory | Machinery crate being moved in a factory |
| `ind-energy` | Industries | 3:2 | Wind turbine blade on an extended trailer on a Kenyan highway | Wind-turbine blade transported by road |
| `about-hero` | About | 21:9 | Nairobi skyline at golden hour seen from the southeast, Mombasa Road traffic, warm haze | Nairobi skyline at golden hour |
| `about-office` | About | 3:2 | `draft-` placeholder: modern logistics office reception, warm wood and glass (replace with real photo) | Globetrot Cargolink office |
| `team-*` | About | 4:5 | **Owner supplies real portraits** | Name, role |
| `contact-hero` | Contact | 21:9 | Friendly Kenyan logistics coordinator on a call at a desk with a port map on the wall | Logistics coordinator on a call with a client |
| `insight-1` | Insight 1 | 16:9 | Calculator, customs forms and a container model on a desk, top-down | Import cost paperwork on a desk |
| `insight-2` | Insight 2 | 16:9 | Half-full vs full container side by side, aerial | Part-loaded and fully loaded containers |
| `insight-3` | Insight 3 | 16:9 | Row of right-hand-drive cars on a RoRo ship deck | Vehicles on the deck of a RoRo ship |
| `og-default` | Social share | 1200×630 | Composite of `home-hero` with logo and tagline (built in code, not generated) | — |

### 6.3 Video register (ambient loops)
Production route per clip: **(a)** real footage from the owner's operations (best, most authentic); **(b)** AI-generated cinematic video (Google Veo / Runway / Kling) using the prompts below, with a hard budget cap `{{OWNER: video budget}}`; **(c)** licensed stock (Artgrid/Storyblocks) as fallback. Same rules as §6.1: no logos, no liveries, no readable text. Export 1920×1080 + 1080×1350 mobile crop, ≤ 2.5 MB WebM / ≤ 4 MB MP4, with a poster JPG. File: `src/assets/video/<id>.{webm,mp4,jpg}`.

| ID | Where | Length | Shot |
|---|---|---|---|
| `vid-home-hero` | Home hero (after globe) | 10 s loop | Slow aerial drone push over a container terminal at sunrise, cranes moving, ship being worked |
| `vid-journey-1..7` | Home "The Journey" | 4–6 s each, scrubbed | 1 factory floor packing cartons · 2 warehouse consolidation · 3 vessel at sea, aerial · 4 vessel berthing, crane lift · 5 SGR container train through savannah · 6 customs officer & agent releasing cargo, tablet · 7 truck arriving at a Nairobi shop, cartons received |
| `vid-mode-air/sea/land/customs` | Mode cards | 3 s loops | aircraft loading · container lift · truck on highway · document check & seal cut |
| `vid-svc-*` (7) | Service heroes | 8 s loops | one per service, matching image slot prompts in §6.2 |
| `vid-lane-*` (5) | Lane heroes | 8 s loops | origin port atmosphere per lane |
| `vid-about` | About hero | 10 s | Nairobi skyline time-lapse dusk → night |

### 6.4 Explainer videos (Remotion + Christine's voice)
Format: 16:9 for site/YouTube + 9:16 cutdowns (15–30 s) for social. Motion-graphic style in the chosen design direction (route lines, icons, document cards, the duty stack), mixed with §6.3 footage. Captions burned in for social, a separate caption track + transcript on site.

**Voice — Christine:** record her real voice (preferred: warm, credible, Kenyan English). Studio-quality USB mic, quiet room, scripts below, ~2 hours for all. Option: a licensed voice clone (e.g. ElevenLabs Professional Voice Clone) **only with Christine's written consent**, used just for this client's explainers, so re-renders after rule changes don't need re-recording. `{{OWNER: Christine consent + choice}}`.

| ID | Title | Length | Placed on | Script outline |
|---|---|---|---|---|
| `exp-01` | How importing with Globetrot Cargolink works | 90 s | Home, About | supplier → we collect → we ship → we clear → you receive; WhatsApp updates; one quote |
| `exp-02` | Customs clearing in Kenya, explained | 120 s | Customs service, Import guide | documents → HS classification → iCMS entry → duties paid → release; common delays |
| `exp-03` | What makes up your landed cost | 90 s | Landed-cost tool, Import guide | CIF → duty (CET bands) → excise → IDF 2.5% → RDL 2% → VAT 16%; worked example |
| `exp-04` | Shipping from China: LCL vs FCL | 90 s | China lane, Consolidation | CBM, when to switch, consolidation timeline |
| `exp-05` | Air freight: chargeable weight in 60 seconds | 60 s | Air freight, CBM tool | volumetric ÷6000 vs actual weight |
| `exp-06` | Do you need a KEBS Certificate of Conformity? | 75 s | Import guide, Checklist tool | PVoC, CoC, what happens without one |
| `exp-07` | Importing a car into Kenya in 2026 | 90 s | Vehicle tool, Insights | 8-year rule (2019+), RHD, duty components |
| `exp-08` | Transit cargo to Uganda, Rwanda & beyond | 75 s | Transit lane, Land service | Northern Corridor, bond, borders, ICDs |
| `exp-09` | How to read your quote | 60 s | Quote success page, Portal | itemised lines explained |

Scripts are written in build #6b from §7 facts, approved by the owner before recording.

---

## 7. Verified Kenya trade facts (use only these; re-verify before launch)

### 7.1 Taxes and levies
- Import Declaration Fee (IDF): **2.5%** of customs value; Railway Development Levy (RDL): **2.0%** — Miscellaneous Fees and Levies Act ss.7–8, consolidated 1 Jan 2026 (kenyalaw.org). Finance Act 2026 changed exemptions, not rates (kra.go.ke).
- EAC Common External Tariff bands: **0%, 10%, 25%, 35%** (35% band since 1 Jul 2022).
- VAT on imports: **16%** (standard rate).
- Finance Act 2026: from **1 Sep 2026** importers keep exporting-country documents **5 years**; returning-resident VAT-free threshold **USD 2,000** (kra.go.ke).

### 7.2 Systems and regulators
- **KRA iCMS** (Integrated Customs Management System) replaced Simba; containerised cargo fully on iCMS since Oct 2021.
- **KenTrade** — Kenya National Electronic Single Window (since 2014), 35+ agency permits.
- **KEBS PVoC** — regulated goods need a Certificate of Conformity before shipment; fees 0.60/0.55/0.50% of FOB (Routes A/B/C); without CoC: inspection at destination at 0.6% of customs value (plus penalties) — confirm current contractor list with KEBS.
- **Vehicles** — from 1 Jan 2026 only RHD vehicles first registered **2019 or later** (KS 1515, 8-year rule).
- **Customs agent licence** — KRA, annual renewal, requires KIFWA membership.
- **AEO** — KRA National and EAC Regional AEO programmes (claim only if held).

### 7.3 Infrastructure and transit (indicative — never promise)
- Gateways: Port of Mombasa; Lamu Port (Phase I berths operational); JKIA (East Africa's main air-cargo hub); Nairobi ICD (450,000+ TEU/yr capacity, SGR-linked), Naivasha ICD (transit cargo), Eldoret ICD.
- Northern Corridor: Mombasa → Uganda, Rwanda, Burundi, DRC, South Sudan.
- China → Mombasa by sea: ~22–30 days port-to-port; China → JKIA by air: ~2–7 days (DP World lane page). Display as "typically", with "+ clearing and delivery".

---

## 8. Open facts — owner to supply (launch blockers in bold)
| # | Fact | Used on |
|---|---|---|
| 1 | **Registered company name, domain, emails (info@, sales@)** | everywhere |
| 2 | **Office address, phones, WhatsApp number, hours** | header, footer, contact, JSON-LD |
| 3 | **KRA customs agent licence status / number; KIFWA membership** (or "in progress" — then omit) | trust row, about, customs |
| 4 | Other memberships/certs (IATA, FIATA, AEO, WCA, insurance partner) — only real ones | footer, about |
| 5 | Founder story, years of experience, team names/roles/photos | about, home proof |
| 6 | Origin warehouse/agents (China city + address, UAE, India, UK) | consolidation, lanes |
| 7 | Lanes actually served (confirm India; any exports?) | lanes, nav |
| 8 | Sailing/flight frequency per lane; indicative "from" rates (optional) | lanes, pricing guide |
| 9 | Warehouse: location, size, bonded or not | warehousing |
| 10 | Quote response promise (e.g. "within 4 working hours") | hero, quote, contact |
| 11 | Client logos/testimonials with permission; case notes | home, industries |
| 12 | Payment model (e.g. pay after delivery for account clients) | FAQ |
| 13 | Hosting choice; analytics choice; Resend/sending domain | build #0, #2 |
| 14 | Logo direction pick (3 options) and tagline pick (§1.4) | everything |
| 15 | Social accounts created by owner; NAVAC added as admin | footer, social kit |
| 16 | **Christine's consent; real recording vs licensed voice clone** | explainers |
| 17 | Video route (real footage / AI-generated / stock) + budget cap | §6.3 |
| 18 | Tracking API provider (paid) — phase 2 | /track |
| 19 | Portal back office: new Firebase ops console or NAVAC CRM integration; payment rail | portal |

---

## 9. Definition of done

### 9.1 Per page (enforced by `/verify` + reviewer)
- `factory-check full` green (gates, astro check, Playwright smoke, build).
- Renders correctly at 390 / 768 / 1440; no horizontal scroll; tap targets ≥ 44px.
- Meets every §9.3 scorecard line (Lighthouse mobile ≥ 95 perf, 100 a11y/BP/SEO), including a reduced-motion pass.
- One H1; meta title/description within limits; JSON-LD valid; all images have alt; LCP image preloaded.
- Every claim traceable to §7 or §8; no `{{OWNER}}` visible in production build (gate added at #11).

### 9.2 Launch checklist (#13)
- All bold §8 facts filled; `{{OWNER` gate on; forms tested end-to-end (email received, auto-reply, WhatsApp fallback).
- Domain + HTTPS + www redirect; sitemap submitted to Google Search Console; Google Business Profile linked.
- Security headers (CSP, HSTS, X-Frame-Options); 404 works; analytics events firing.
- `web-quality-review` PASS.

### 9.3 The 9.8 scorecard (measured, not claimed)
Awards are judged by others, so we can't promise one. What we can control is every score that is measured.
Target ≥ 9.8/10 on each line. A page isn't done until it scores that.

| Dimension | How measured | Target |
|---|---|---|
| Design | Owner + 2 external designers score against Awwwards criteria (design 40 / usability 30 / creativity 20 / content 10) | ≥ 9.8 |
| Performance | Lighthouse mobile & desktop (CI), real-user Core Web Vitals | mobile ≥ 95, desktop 100; LCP < 2.0 s, INP < 150 ms, CLS < 0.05 |
| Accessibility | Lighthouse + axe + manual keyboard/screen-reader pass + reduced-motion pass | 100, zero axe violations, WCAG 2.2 AA |
| SEO | Lighthouse SEO, valid JSON-LD, every page has keyword + internal links, Search Console clean | 100 |
| Best practices / security | Lighthouse BP, securityheaders.com, no third-party trackers without consent | 100, A+ |
| Content | Every fact traceable (§7/§8), readability grade ≤ 9, zero typos (spellcheck gate) | 0 untraceable claims |
| Conversion | Quote form completion test with 5 real users; time-to-quote-start ≤ 10 s from landing | 5/5 complete unaided |
| Tools accuracy | Golden tests for duty, CBM, chargeable weight, vehicle eligibility | 100% pass |
| Mobile | Every page tested on a mid-range Android (e.g. Samsung A-series) over 4G | smooth 60 fps scroll, no jank |

---

## 10. Next steps after sign-off
1. **4 website design directions** (artifact) — owner picks one → becomes `tokens.css` + component styling.
2. **3 logo directions** (artifact) — owner picks one → SVG master, favicon set, OG.
3. Owner answers §8 bold items.
4. Build in §3.2 order, one page per change.
