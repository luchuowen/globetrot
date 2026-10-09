# Globetrot Cargolink International — Website Blueprint

Version 1.0 · 2026-10-09 · Owner sign-off required before build · Source of truth for every page change.
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
| 9 | Definition of done + launch checklist | `/verify`, launch |

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
| Interactivity | Astro islands with **Preact** for tools/forms only | small bundles where JS is needed |
| Styling | CSS custom properties in `src/styles/tokens.css` + scoped component CSS | design-direction swap = one file |
| Content | Astro **content collections** (`src/content/{services,lanes,industries,insights,faq}`) as MDX/JSON | one template renders many pages → fastest build, fewest tokens |
| Images | `astro:assets` (AVIF/WebP, responsive `srcset`), source files in `src/assets/img/<slot-id>.jpg` | performance + gate against hotlinks |
| Motion | CSS + View Transitions; **GSAP** only for the hero route-map animation | premium feel, small cost |
| Maps | inline SVG corridor map (no map API) + one lazy Google Maps embed on Contact | fast, no key needed |
| Forms | `/api/quote` + `/api/contact` server endpoints (Astro hybrid) → email via **Resend**; honeypot + rate limit; WhatsApp fallback | critical path |
| Hosting | **Vercel** (or Firebase Hosting + Cloud Function) — `{{OWNER: hosting choice}}` | preview URLs per branch |
| Analytics | Plausible or GA4 — `{{OWNER}}`; events: quote_submit, whatsapp_click, calc_use | measure conversions |
| Checks | `astro check` (typecheck), Playwright smoke (each route 200, no console errors, 390/1440 screenshots), Lighthouse CI budget (perf ≥ 90, a11y ≥ 95) | wired into `factory-check` |

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

---

## 3. Sitemap and build order

### 3.1 Sitemap (29 routes)
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
/tools                              Importer's toolkit hub
  /tools/cbm-calculator             CBM + chargeable weight
  /tools/landed-cost                Landed-cost estimator
  /tools/document-checklist         Documents by cargo type
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
| # | Change | Size | Depends on | Est. |
|---|---|---|---|---|
| 0 | Walking skeleton: Astro, tokens (chosen direction), Base layout, nav, footer, WhatsApp button, `site.ts`, SEO component, checks wired into manifest | standard | design pick | 1 session |
| 1 | Home | standard | 0 | 1 |
| 2 | Quote page + `/api/quote` + Resend + thank-you state | **critical** | 0 | 1 |
| 3 | Service template + 7 service MDX files + Services hub | standard | 0 | 1 |
| 4 | Lane template + 5 lane MDX files + Lanes hub + CorridorMap | standard | 3 | 1 |
| 5 | Import guide (pillar) | standard | 0 | 1 |
| 6 | Tools: CBM calc, landed-cost calc, document checklist + hub | standard | 5 | 1 |
| 7 | About + Industries | standard | 0 | 1 |
| 8 | FAQ + Contact + `/api/contact` | **critical** (form) | 2 | 1 |
| 9 | Insights index + 3 seed articles | standard | 0 | 0.5 |
| 10 | Legal, 404, sitemap.xml, robots, OG images, favicons, JSON-LD audit | standard | all | 0.5 |
| 11 | Launch audit (`web-quality-review`), fill `{{OWNER}}` facts, deploy, domain | **critical** | all | 0.5 |

Images (§6) are generated in batches before the page that needs them: batch A (home + global) before #1,
batch B (services) before #3, batch C (lanes) before #4, batch D (about/industries/insights) before #7.

---

## 4. Global elements

### 4.1 Header
- Logo (left). Nav: **Services ▾** (7 items, mega-menu with one-line descriptions + mode icons),
  **Trade lanes ▾** (5), **Import guide**, **Tools ▾** (3), **About**, **Contact**. Right: phone (desktop),
  **Get a quote** (primary button).
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

---

## 5. Page-by-page content

Format per page: **Purpose · Keyword · Sections (in order) with exact copy or copy brief · Images · CTA.**
Copy marked "write:" is a brief for the build agent, constrained by §1.6 and §7.

### 5.1 Home `/`
Purpose: in 10 seconds, tell an importer what we move, where, and how to get a price. Keyword: *freight forwarding and customs clearing Kenya*.

1. **Hero** (full-bleed, slot `home-hero`; animated route lines China/UAE/UK/India → Mombasa/JKIA/Nairobi)
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
4. **Corridors section** — interactive CorridorMap (SVG): pins Guangzhou/Shenzhen/Yiwu, Dubai (Jebel Ali), Nhava Sheva/Mumbai, UK/Europe → Mombasa / JKIA / Nairobi ICD / Naivasha ICD → Kampala, Kigali, Juba, Goma. Click a lane → card with mode, indicative transit range (§7.3), "View lane" link.
   - H2: **Your corridor, mapped.**
5. **How it works — 4 steps** (Steps component)
   1. Tell us what you're shipping — share supplier details, cargo, destination.
   2. We quote all-in — freight, clearing, duties estimate and delivery, itemised.
   3. We move and clear — booking, documents, iCMS entry, release.
   4. Delivered to your door — with updates on WhatsApp at every milestone.
6. **Why Globetrot Cargolink — 4 pillars** (from §1.3) each with 1 sentence + icon. Write: concise, factual.
7. **Proof band** — only verified items: years of team experience `{{OWNER}}`, shipments handled by team `{{OWNER}}`, client logos `{{OWNER}}`, one testimonial `{{OWNER}}`. If none confirmed at launch, this band shows licences + office + named people instead (never empty counters).
8. **Importer's toolkit teaser** — 3 cards: CBM calculator, Landed-cost estimator, Document checklist.
9. **Industries strip** — 5 chips linking to /industries anchors.
10. **Insights** — latest 3 articles.
11. **CTA band** — H2: **Have a shipment coming? Get a clear price today.**

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

### 5.8 Tools
- **Hub `/tools`** H1: **Importer's toolkit.** 3 cards + disclaimer.
- **CBM calculator** — inputs: rows of L×W×H (cm) × qty, gross weight kg. Outputs: total CBM, volumetric
  weight air (÷6000), chargeable weight, "sea or air?" hint. Button: "Quote this shipment" (prefill).
- **Landed-cost estimator** — inputs: product value (USD), freight, insurance, duty band (0/10/25/35%),
  excise % (optional), exchange rate (editable, default `{{OWNER}}`). Outputs itemised: CIF, duty, excise,
  IDF 2.5%, RDL 2%, VAT 16% on (CIF+duty+excise), total. Disclaimer: "Estimate only; final figures are set by KRA at entry."
- **Document checklist** — select cargo type (general goods, food, pharma/cosmetics, vehicles, machinery,
  personal effects) → checklist with permit authority; print/download.
Events tracked: calc_use, calc_to_quote.

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
| 15 | Social handles | footer |

---

## 9. Definition of done

### 9.1 Per page (enforced by `/verify` + reviewer)
- `factory-check full` green (gates, astro check, Playwright smoke, build).
- Renders correctly at 390 / 768 / 1440; no horizontal scroll; tap targets ≥ 44px.
- Lighthouse mobile: Performance ≥ 90, Accessibility ≥ 95, Best Practices ≥ 95, SEO 100.
- One H1; meta title/description within limits; JSON-LD valid; all images have alt; LCP image preloaded.
- Every claim traceable to §7 or §8; no `{{OWNER}}` visible in production build (gate added at #11).

### 9.2 Launch checklist (#11)
- All bold §8 facts filled; `{{OWNER` gate on; forms tested end-to-end (email received, auto-reply, WhatsApp fallback).
- Domain + HTTPS + www redirect; sitemap submitted to Google Search Console; Google Business Profile linked.
- Security headers (CSP, HSTS, X-Frame-Options); 404 works; analytics events firing.
- `web-quality-review` PASS.

---

## 10. Next steps after sign-off
1. **4 website design directions** (artifact) — owner picks one → becomes `tokens.css` + component styling.
2. **3 logo directions** (artifact) — owner picks one → SVG master, favicon set, OG.
3. Owner answers §8 bold items.
4. Build in §3.2 order, one page per change.
