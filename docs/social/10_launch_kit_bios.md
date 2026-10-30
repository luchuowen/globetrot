# Launch kit — handles, bios, categories, setup checklists
Status: RECOMMENDED (draft for approval). Facts used are only those CONFIRMED in 01. Limits are platform limits as understood on 2026-10-30 — re-check in the sign-up screen.

## Handles
Primary: **@globetrotcargolink** (all platforms). Pre-check 2026-10-30: free on Facebook, Instagram, LinkedIn, TikTok by URL lookup.
Fallbacks in order: `@globetrotcargo` · `@globetrot.cargolink` · `@globetrotcargolinkke`. Whatever is taken, use the SAME fallback everywhere.
Display name (all): **Globetrot Cargolink International** (Instagram/TikTok short name: **Globetrot Cargolink**).
Website link (all): https://globetrotcargolink.com/ — use UTM tags on every profile link (see 06).

## Visuals (in `assets/`)
- `avatar-1080.png` — all platforms + WhatsApp (white ground so the navy globe/plane stay visible in circle crops).
- `facebook-cover-1640x624.png` — Facebook cover (key content centred for mobile crop).
- `linkedin-cover-2256x382.png` — LinkedIn company banner.
- Instagram/TikTok/WhatsApp have no cover. Instagram Highlight covers: TO DO.
- Cover line "Ship · Clear · Deliver" comes from the live site hero; "Air · Sea · Road · Customs · Delivery" from the proposal cover. No unapproved tagline used.

## Bios (copy-paste; counts verified)
**Instagram (124/150):**
Air, sea & road freight into Kenya. Customs clearance, warehousing & delivery. China · Dubai · India · UK · Europe. Nairobi.
Link: website. Button: WhatsApp / Email. Category: Shipping & Delivery (closest available — confirm).

**TikTok (70/80):**
Importing to Kenya, made clear. Freight · Customs · Delivery. Nairobi.
Switch to Business account; link: website (link in bio may need account eligibility).

**Facebook intro (76/101):**
Freight forwarding & customs clearance into Kenya. Air, sea & road. Nairobi.
Category: closest of Freight Forwarding / Shipping & Delivery Service. Buttons: WhatsApp message + Get quote (site /quote). Phone, email, website filled.
**Facebook About (long):**
Globetrot Cargolink International coordinates cargo from China, Dubai, India, the UK and Europe to Kenya, by air, sea and road. We handle freight, customs clearance, consolidation, warehousing and delivery, so you deal with one team from supplier to your door. Ask us for an itemised quote on WhatsApp +254 792 330 000 or at globetrotcargolink.com.

**LinkedIn tagline (86/120):**
Freight, customs clearance and delivery into Kenya and East Africa. Air, sea and road.
**LinkedIn About:**
Globetrot Cargolink International is a Nairobi-based freight forwarding and logistics company. We move cargo from China, Dubai, India, the UK and Europe into Kenya and onward across East Africa, by air, sea and road.
One team handles the whole journey: freight booking, cargo consolidation, customs clearance and import documentation, warehousing in Nairobi and delivery.
We publish practical guides on duties, standards and documentation so importers can plan with confidence. Request a quote at globetrotcargolink.com or on WhatsApp +254 792 330 000.
Industry: Transportation, Logistics, Supply Chain and Storage (confirm in form). Company size/Founded year: `{{OWNER}}` — leave blank if unknown. Location: Nairobi, Kenya (address `{{OWNER}}`). Needs a personal LinkedIn profile as first admin; add a 2nd admin.

**WhatsApp Business**
- Business name: Globetrot Cargolink International
- Description (200/256): Globetrot Cargolink International: air, sea and road freight, customs clearance, consolidation, warehousing and delivery into Kenya from China, Dubai, India, the UK and Europe. Message us for a quote.
- Category: closest of Shipping/Freight/Logistics. Email: info@globetrotcargolink.com. Website. Address/hours: `{{OWNER}}`.
- Greeting: "Hello, thanks for contacting Globetrot Cargolink International. Tell us what you are shipping, from where, and roughly how much, and our team will reply with next steps."
- Away message (no hours claimed): "Thanks for your message. Our team is currently away and will reply when we are back. For a quote, share the goods, origin country and approximate weight or volume."
- Quick replies (to build): /quote (what we need for a quote) · /docs (documents to prepare) · /track · /address `{{OWNER}}` · /hours `{{OWNER}}`.
- Labels: New enquiry · Quote sent · Awaiting documents · Won · Not now.
- Catalogue: services only (Air, Sea, Consolidation, Customs clearance, Warehousing, Road/transit, Advisory) — no prices.

**Google Business Profile (if approved):** name Globetrot Cargolink International; category Freight forwarding service; needs verified address `{{OWNER}}`; reviews enabled.

## Setup checklist (per platform, in this order)
1. **Meta Business portfolio** (owner) → 2FA on admin accounts.
2. **Facebook Page** → name, handle, category, intro, About, avatar, cover, contacts, WhatsApp button, CTA, hide fake-looking sections, set roles (Globetrot x2 admins, NAVAC manager).
3. **Instagram** professional account → connect to Page → bio/avatar/link → Highlights placeholders → 2FA.
4. **WhatsApp Business** → profile, catalogue, labels, greeting/away, quick replies → link to Page/IG.
5. **LinkedIn Page** → logo, cover, tagline, About, website, industry, CTA "Contact us"/"Visit website" → admins.
6. **TikTok** business account → bio, avatar, link, 2FA; no posting until launch.
7. Record in 03_accounts_register.md (no secrets). Add URLs to `GT_SOCIAL` in site.js, deploy, click-test.
Privacy settings: allow messages, turn on message replies in business hours only if approved, no auto-follow, comment filtering for spam words, page visibility published only after profile is complete.
