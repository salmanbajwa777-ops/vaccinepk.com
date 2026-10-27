# Vaccinepk.com — Project Improvement Plan

**Date:** 2026-09-18
**Scope:** vaccinepk.com only. Vaccine.pk (the booking/service platform) is the source of truth for business data and stays the transactional engine.

## Product Positioning

Two domains, two jobs — don't let them blur:

| Domain | Role | Flow |
|---|---|---|
| **vaccine.pk** | The vaccination *service* | Book → Vaccinate → Record → Reminder |
| **vaccinepk.com** | The vaccine *information + discovery* platform | Search → Learn → Check → Price → Book |

Target end-state architecture:

> Turn vaccinepk.com into Pakistan's authoritative vaccine information and discovery platform, while vaccine.pk remains the primary vaccination-service platform. Every vaccine page should eventually connect **knowledge → eligibility → availability → price → quote → booking**.

Don't rebuild everything at once. **Fix credibility and conversion first, then build the information/SEO layer.**

---

## Step 1 — Fix Factual Inconsistencies (🔴 Immediate)

Before adding anything new, make the site internally consistent, and consistent with vaccine.pk.

Known issues found:
- Homepage claims "9+ cities" but the visible city section lists 7, and the FAQ mentions additional cities.
- Contact page lists Karachi twice.
- Homepage states "800K+ vaccines administered" alongside a separate "1.5M+ vaccination reminders" stat — undefined/unreconciled metrics.
- Multiple knowledge articles and tools are marked "Coming Soon."
- vaccine.pk and vaccinepk.com show different pricing structures/figures for the same vaccines.

**Action:** Create one master business data sheet as the single source of truth:
- Cities served
- Phone / WhatsApp / Email
- Home vaccination fee
- Vaccine prices (per vaccine)
- Available vs. unavailable vaccines
- Working hours
- Services offered
- Doses administered (lifetime count)
- Reminder count
- Years of operation

Both domains pull from this same data — no divergence.

---

## Step 2 — Lock In the Positioning (🔴 Immediate)

Confirm and document (see Product Positioning above). Don't let vaccinepk.com become a second copy of vaccine.pk. Homepage tagline direction: *"Pakistan's Most Trusted Vaccine & Vaccination Resource."*

---

## Step 3 — Redesign Homepage Around 4 User Intentions (🔴 High)

Current homepage is information-rich but long. Restructure the top section:

**Headline:** Pakistan's Vaccine & Vaccination Resource
**Subhead:** Find the right vaccine. Understand why you need it. Check availability and price. Book vaccination.

**"What are you looking for?"** — 4 entry points:
- 👶 Child Vaccines
- 👨 Adult Vaccines
- ✈️ Travel Vaccines
- 🤰 Pregnancy Vaccines

Plus a search bar: *"Search vaccines, diseases, brands or vaccination questions..."*

Goal: purpose obvious within 5 seconds.

---

## Step 4 — Make "Book Vaccination" a Permanent Primary CTA (🔴 High)

- Desktop: persistent **BOOK VACCINATION** button.
- Mobile: sticky **WhatsApp | Call | Book** bar.
- Every vaccine page gets: **Check Price & Availability** + **Book This Vaccine**.
- Keep existing booking page categories (Child, Adult, Flu, Travel).

---

## Step 5 — Remove the "Coming Soon" Problem (🔴 High)

Large blocks of "Coming Soon" (HPV Guide, Adult Vaccination Guide, Flu Vaccine Guide, Pregnancy Vaccines, plus 5+ tools) make the site feel unfinished.

**Action:** Hide unavailable tools/guides from the homepage entirely. Show only a small "Featured Tools" section with what actually works today (e.g., Baby Vaccine Schedule, Missed Vaccine / Catch-up Planner, Adult Vaccine Finder — only if functional).

**✅ Done (2026-09-19):** "Coming Soon" labels removed. Since a label alone wasn't the real problem — the content behind it didn't exist — the sections themselves were hidden rather than left showing a finished-looking card that does nothing. That means real work is now hidden from visitors, not just relabeled, so it must not be forgotten:

| Hidden item | Where | What it needs to come back | Tracked in |
|---|---|---|---|
| Baby Vaccine Due Calculator | Homepage, was "Interactive Tools" section | Build the actual calculator | Step 6, Phase 5 item 27 |
| Adult Vaccine Finder | same | Build the actual tool | Phase 5 item 29 |
| Travel Vaccine Advisor | same | Build the actual tool | Phase 5 item 30 |
| Missed Vaccine Planner | same | Build the actual tool | Phase 5 item 28 |
| Pregnancy Vaccine Checker | same | Build the actual tool | Phase 5 item 31 |
| Complete HPV Vaccine Guide | Homepage "Featured Knowledge" | Publish a post titled exactly `Complete HPV Vaccine Guide` | Step 15 |
| Can Vaccines Be Delayed? | same | Publish a matching post | Step 15 |
| Adult Vaccination Guide | same | Publish a matching post | Step 15 |
| Flu Vaccine Guide | same | Publish a matching post | Step 15 |
| Difference Between PCV10 and PCV13 | same | Publish a matching post | Step 15 |
| Travel Vaccines Explained | same | Publish a matching post | Step 15 |
| Pregnancy Vaccines | same | Publish a matching post | Step 15 |

The whole "Featured Knowledge" section is currently hidden site-wide, because **none** of the 7 topics above have a matching published post yet — it only reappears once at least one does (`$featured_knowledge` in [home.php](home.php), matched by exact post title). Same mechanism for each tool card in "Interactive Tools": it doesn't reappear piecemeal — the whole section stays hidden in [home.php](home.php) until it's rebuilt with tools that actually work, per Phase 5.

Also found while removing this: the `/knowledge-centre` link in this section's own CTA button currently 404s — needs its own fix, unrelated to the above.

---

## Step 6 — Port the Vaccine.pk Schedule Tool (🔴 Very High)

Don't rebuild from scratch — vaccine.pk already has a working, valuable schedule generator (Birth → 6–8wk → 10–16wk → 14–24wk → ... with a personalized immunization record).

**Feature: "Check My Child's Vaccination Schedule"**
Flow: Enter DOB → Enter vaccines already received → Get personalized schedule → Download / Print / Save / Book missing vaccines.

Potentially the single most valuable feature on the site.

---

## Step 7 — Standardize the Vaccine Database (🟠 Very High)

Existing vaccine pages (ABRYSVO, ANFLU, HEXAXIM, MMR, NIMENRIX, Prevenar 13, Rotarix, STAMARIL, Typbar, VAXAPOX, etc.) need **one consistent template**.

**Standard vaccine page fields:**
1. Vaccine name
2. Manufacturer
3. What it protects against
4. Who should receive it
5. Age
6. Dose / number of doses
7. Route
8. Schedule
9. Contraindications / precautions
10. Common side effects
11. Storage
12. Can it be co-administered with other vaccines?
13. Availability in Pakistan
14. Current price
15. Home vaccination option
16. FAQs
17. References
18. **Book This Vaccine** CTA

Relevant file: [single-vaccine.php](single-vaccine.php)

---

## Step 8 — Make Price + Availability Dynamic (🟠 Very High)

Current pricing page (categorized, "add to quote") is a good base — extend it.

**Per-vaccine card:**
```
VAXAPOX — Chickenpox vaccine
Manufacturer: BCHT
Available ✓
PKR 4,267
Home vaccination: + PKR 1,500/person
[ADD TO MY QUOTE]  [BOOK NOW]
```

Connects information → money → booking directly.

---

## Step 9 — Build "My Vaccine Quote" (🟠 High)

User selects multiple vaccines (e.g., Hexaxim ×1, Prevenar 13 ×1, Rotarix ×1) → running total calculated:

```
Vaccines:          PKR XX,XXX
Home vaccination:  PKR 1,500
Total:             PKR XX,XXX
[BOOK THIS QUOTE]
```

Removes the "how much?" WhatsApp friction step.

---

## Step 10 — Build the Disease Library (🟠 High)

Structured, not generic blog content. Template per disease:

1. What is it?
2. How does it spread?
3. Symptoms
4. Complications
5. Who is at risk?
6. Can it be prevented?
7. Vaccine(s) available (linked)
8. Who should consider vaccination?
9. Price in Pakistan
10. Book vaccination

Relevant file: [single-disease.php](single-disease.php)

---

## Step 11 — Build Pakistan-Specific Reference Pages (🟠 High)

This is where vaccinepk.com can outperform generic international vaccine sites. These are **reference pages, not sales pages** — they lead naturally into booking, not the other way around.

- `/vaccines-in-pakistan/`
- `/child-vaccination-schedule-pakistan/`
- `/adult-vaccination-pakistan/`
- `/travel-vaccines-pakistan/`
- `/hajj-umrah-vaccines/`
- `/flu-vaccine-pakistan/`
- `/hpv-vaccine-pakistan/`
- `/shingrix-pakistan/`
- `/pneumococcal-vaccine-pakistan/`

---

## Step 12 — Build City Pages (🟠 High)

Not thin SEO pages — each must carry real local information.

Cities: Islamabad, Rawalpindi, Lahore, Karachi, Multan, Faisalabad, Gujranwala, Sialkot, Wah Cantt, etc.

**Template:**
- Child / Adult / Flu / Travel / Home vaccination availability
- Available vaccines
- Service fee
- Areas covered
- Book vaccination CTA

Relevant file: [single-city.php](single-city.php)

---

## Step 13 — Strengthen Professional/Medical Authority (🟠 High)

Genuine differentiator: the site is backed by a real clinician.

**Build a "Medical Leadership" page** for Dr. Salman Ahmad Bajwa, MBBS, DHPE (CEO / Vaccine.pk):
- Clinical experience
- Vaccination experience
- Vaccination education & professional vaccinology training
- Campaigns
- Cold-chain training
- Vaccination team
- Professional memberships/courses

Goal: read as a real medical platform led by a clinician, not an anonymous commercial site.

---

## Step 14 — "Reviewed by Dr. Salman Bajwa" System (🟠 High)

Every medical article carries:
```
Written by: [author]
Medically reviewed by: Dr. Salman Ahmad Bajwa
Last updated: [month/year]
References: WHO / CDC / NITAG / manufacturer PI / national guidance
```

Creates a defensible, professional medical-content structure (also helps E-E-A-T for SEO).

---

## Step 15 — Replace Generic Posts with High-Intent Questions (🟡 Medium)

Stop writing "Importance of vaccination"-style generic posts. Write to real search intent.

**Parents:**
- My child missed a vaccine. What should I do?
- Can vaccines be given during a fever?
- Can two vaccines be given on the same day?
- What if my child's vaccination card is lost?
- Hexaxim vs Pentaxim
- PCV10 vs PCV13
- When should my child get MMR?

**Adults:**
- Which vaccines should adults get?
- Who should get Shingrix?
- Does an adult need pneumococcal vaccination?
- How often should adults get the flu vaccine?

**Travel:**
- Which vaccines are required for Umrah?
- Which vaccine is required for Saudi Arabia?
- Where can I get a Yellow Fever certificate in Pakistan?

---

## Step 16 — Improve Navigation (🟡 Medium)

Proposed main menu:

```
VACCINES     — All / Child / Adult / Travel / Flu
SCHEDULES    — Child / Adult / Catch-up
DISEASES     — Disease Library
TOOLS        — Baby Vaccine Calculator / Adult Vaccine Finder / Travel Vaccine Advisor
PRICES       — Vaccine Prices
SERVICES     — Home / Clinic / Corporate Vaccination
KNOWLEDGE    — Guides / FAQs
[BOOK NOW]   — persistent CTA, separate from the info nav
```

Separates information architecture from the service/booking path.

Relevant file: [header.php](header.php)

---

## Step 17 — Medical Content & Terminology Audit (🟡 Medium)

Full pass needed for clinical precision, since the site positions itself as an information authority:

- Vaccine indications, age ranges, dosing, schedules
- Disease names, manufacturer names, spelling
- EPI terminology
- WHO references — "WHO compliant" vs. actual WHO recommendations (don't overclaim)
- "Certified" claims, safety claims — must be verifiable

Known issue: [single-service.php](single-service.php) child vaccination content groups diseases like otitis media awkwardly — needs review.

---

## Step 18 — Real Trust Signals, Not Just Icons (🟡 Medium)

Current homepage badges: Doctor Led, WHO Guidelines, Cold Chain Protected, Imported Genuine Vaccines, Digital Records, Home Vaccination, Corporate Vaccination.

**Make each clickable → explain it:**
- **Cold Chain:** storage, temperature monitoring, transport, home-visit equipment, documentation
- **Genuine Vaccines:** sourcing and verification process
- **Digital Records:** show a sample of what the patient actually receives

Stronger than a bare claim.

---

## Step 19 — Improve Testimonials (🟡 Medium)

Replace generic city-labeled testimonials with real **Google Reviews**: first name, city, date, review text, link to Google Reviews. No manufactured testimonials.

---

## Step 20 — Connect to the Full Business System (🟢 Long-Term)

End-state flow:

```
Find vaccine → Check eligibility → Check availability → See price
→ Get quote → Book → Vaccination → Digital record → Automated reminder
→ Next vaccination
```

This is the complete Vaccine.pk ecosystem — vaccinepk.com becomes the front door into it.

---

## Execution Order

Don't do all 20 steps simultaneously. Phase them:

### 🔴 Phase 1 — Fix (Week 1)
1. Correct all statistics
2. Correct cities
3. Correct contact details
4. Standardize prices
5. Correct vaccine information
6. Remove questionable/unverifiable claims
7. Remove or temporarily hide "Coming Soon" content

### 🟠 Phase 2 — Conversion (Week 2)
8. Redesign homepage
9. Strong, persistent Book CTA
10. Improve pricing page
11. Build quote calculator
12. Improve booking flow
13. Connect vaccine pages → pricing → booking

### 🟡 Phase 3 — Authority (Weeks 3–6)
14. Build out the standardized vaccine database/template
15. Build the disease library
16. Build Pakistan vaccination schedule content
17. Add the Dr. Salman medical-review system
18. Add references + last-updated dates across articles
19. Write 20–30 high-quality guides

### 🟢 Phase 4 — SEO / AI-Overview Optimization (Month 2+)
20. City pages
21. Pakistan-specific vaccine reference pages
22. FAQ architecture (structured, schema-marked)
23. Internal linking pass
24. Structured data / schema markup
25. Search Console monitoring
26. Track which questions drive traffic

### 🔵 Phase 5 — Tools (after foundation is solid)
27. Baby vaccine calculator
28. Catch-up planner
29. Adult vaccine finder
30. Travel vaccine advisor
31. Pregnancy vaccine checker

---

## The One-Line Brief

If handing this to a developer tomorrow, don't say "redesign vaccinepk.com." Say:

> **"Turn vaccinepk.com into Pakistan's authoritative vaccine information and discovery platform, while vaccine.pk remains the primary vaccination-service platform. Every vaccine page should eventually connect knowledge → eligibility → availability → price → quote → booking."**

Start with **Step 1: factual/data cleanup.** SEO and design work is wasted while the two domains show users conflicting information.
