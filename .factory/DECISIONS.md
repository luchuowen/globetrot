# Decisions & facts (current truth, ≤ 250 lines)

## Business
- Name: Globetrot Cargolink International (new company, Nairobi, Kenya). Site has the same name.
- Founder previously at Globetrot Logistics Ltd (globetrotlogisticsltd.com) — reference only; never named on the site.
- Services mirror the previous company (air, sea, land freight, customs clearing, warehousing…) — see blueprint.md.
- Old logo reference: docs/reference/old-logo.jpeg (GT globe, blue/lime, AIR | LAND | SEA). New logo must be original.

## Process
- 2026-10-09 factory v2.1 installed. Next: blueprint.md → 4 site design directions + 3 logo directions (artifacts) → owner picks → build page by page.
- GitHub: github.com/luchuowen/globetrot (empty at start).
- 2026-10-09 Owner direction: "best logistics website, period" — award-level motion (GSAP/Lenis, WebGL globe, scrollytelling), video loops, Remotion explainers voiced by Christine, all importer tools online, client portal, social presence. Target ≥ 9.8 on every blueprint §9.3 line.
- Social accounts are created by the owner (platform identity rules); NAVAC gets admin access and supplies the launch kit.
- Tool maths (duty, CBM, chargeable weight, vehicle) are critical: golden tests required.
- 2026-10-09 Owner picks: portal + live tracking = Phase 2 (after launch); Christine VO = consented voice clone (written consent required before any generation); video loops = AI-generated with capped budget, swap in real footage as available.
- 2026-10-09 Blueprint v1.1 approved. Design artifacts: website directions https://claude.ai/artifact/7HhQbSYVjzXpW7YnNqPioh (A Port at Night, B Manifest, C Savannah Corridor, D Cobalt Signal); logos https://claude.ai/artifact/XAbpaDmZYpj4vwieF53bBC (1 The Link, 2 Route G, 3 Meridian Seal). Sources in docs/design/. Awaiting picks.
- 2026-10-09 Owner picked Port at Night colours (harbour navy, sodium amber #f3a43b, white). Premium round: E Night Shift https://claude.ai/artifact/JnxbBkn6MoKbXvC21ztduB · F Control Tower https://claude.ai/artifact/6jwokh2Zszuea5y3X8EgSR · G Cargo Cinema https://claude.ai/artifact/C11Jf4vSijjn9Lqt3UdFE5 — awaiting pick/combination.
- Logo: owner wants flat GT + globe + aeroplane (from sample) in Port at Night colours, "The Link" wordmark style with CARGOLINK INTERNATIONAL fitted to GLOBETROT width. Variants Orbit/Contrail/Launch: https://claude.ai/artifact/E7YER5aqowxN2pUhHk84oT
- 2026-10-09 Owner's chosen design basis: G Cargo Cinema (hero, fonts, stage-to-stage container, explainer) as primary + E's horizontal journey and stacking mode cards + F's radar. Fused homepage: https://claude.ai/artifact/Uq56ZNciavyJ8Cn244ti3e (docs/design/fusion-home.html). Owner wants real footage that feels like motion, not drawings.
- Preview media: Pexels stock (free licence) in media/source (gitignored originals) → media/web (720p H.264, -g 6 for scroll scrubbing). Placeholders until AI/real footage. Some clips show third-party brands (Delta, MSC) — must be replaced before launch.
- Logo track: Contrail → Vapour → Halftone globe (owner likes halftone). Latest: https://claude.ai/artifact/9AwjZ4ND6iXo1aHQNm27Co
- 2026-10-09 LOGO LOCKED: Halftone dot globe + Vapour trail + white plane, GT (G white, T amber), GLOBETROT / CARGOLINK INTERNATIONAL fitted to same width. https://claude.ai/artifact/6vudFebdB6H3jF6n7vezTP (docs/design/logo-selected.html)

- 2026-10-10: Inner pages (services, network, import-guide, tools, track, about, contact, quote, faq) built in site/ from src fragments via build.py; shared site.css/site.js. Awaiting owner approval before GCP (Firestore, europe-west3, globetrot.navac.co.ke).

- 2026-10-10: Media refresh: local scenes use Black Kenyan people (8 Canva-generated images, AI-upscaled to 3840px); videos re-encoded to 1080p; j7 delivery and cus replaced (Pexels 4K); air clip made from generated JKIA image (stock air clips all showed airline livery). Hero scrim strengthened for text legibility. Prompts in docs/design/media-prompts.md.
- 2026-10-10: All videos now 3840x2160; j2/j3/j6 swapped to 4K stock; city/coast photos 3840. Removed journey header text per owner.
- 2026-10-10: Breadcrumbs removed from all inner pages. Mobile (<=760px): logo centred in nav, content centred site-wide (lists/forms stay left for readability).
- 2026-10-10: AI apron image replaced with a real Kenya Airways Boeing 787-8 photo (5Y-KZB at Schiphol), public domain, Wikimedia Commons; 4K crop + 4K air clip made from it. Map key and route cells shortened.
- 2026-10-10: LIVE on Firebase Hosting site globetrot-cargolink in project smart-diary-e103c (account luchuowen@gmail.com; Firebase project limit reached so reused unused project). Billing: Firebase Payment (018CF3-5A66CF-6A435C), $5/mo budget alert. Firestore (default) europe-west3, create-only rules for globetrot_messages / globetrot_quotes. DNS: only added CNAME globetrot -> globetrot-cargolink.web.app. in DirectAdmin. OG card og.jpg 1200x630.
- 2026-10-10: Replaced j2 (Origin warehouse, AI forklift posture) and j4 (Mombasa, washed-out/branded) with new dark cinematic Canva images → 4K clips. Deployed live.
