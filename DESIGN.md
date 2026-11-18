---
name: GrainzMedia
description: A dusk-lit atrium of navy and glowing teal, where shopper photography meets soft glass, pill buttons and arched horizons.
colors:
  harbour-teal: "#007d88"
  harbour-teal-hover: "#006f79"
  lagoon-teal: "#00a8b5"
  beacon-cyan: "#00c2d1"
  signal-cyan: "#00e5f7"
  midnight-atrium: "#0f2d41"
  atrium-navy: "#172c3f"
  tide-navy: "#163850"
  ice-atrium: "#8dc7d3"
  ice-mist: "#eef9fc"
  dusk-slate: "#253e4e"
  panel-mist: "#466475"
  lobby-white: "#ffffff"
  blush-error: "#ffb4b4"
typography:
  display:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(2.3rem, 6.25vw, 7.5rem)"
    fontWeight: 700
    lineHeight: 1.07
    letterSpacing: "0.005em"
  display-cta:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(2.1rem, 6.25vw, 7.5rem)"
    fontWeight: 700
    lineHeight: 1.12
  headline:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(1.9rem, 3.125vw, 3.75rem)"
    fontWeight: 700
    lineHeight: 1.15
  title:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(1.4rem, 2.35vw, 2.9rem)"
    fontWeight: 700
    lineHeight: 1.2
  body:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(1rem, 1.5vw, 1.85rem)"
    fontWeight: 500
    lineHeight: 1.45
  small:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(0.95rem, 1.2vw, 1.5rem)"
    fontWeight: 500
    lineHeight: 1.45
  eyebrow:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(0.95rem, 1.65vw, 2rem)"
    fontWeight: 700
    lineHeight: 1.45
    letterSpacing: "0.005em"
  nav:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(0.9rem, 1.2vw, 1.5rem)"
    fontWeight: 700
    lineHeight: 1.15
  button:
    fontFamily: 'Futura, "Futura PT", Jost, "Century Gothic", "Avenir Next", sans-serif'
    fontSize: "clamp(0.95rem, 1.2vw, 1.5rem)"
    fontWeight: 500
    lineHeight: 1.2
  numeral:
    fontFamily: '"Bebas Neue", "Bebas Kai", Oswald, "Arial Narrow", sans-serif'
    fontSize: "clamp(1.1rem, 2.4vw, 2.9rem)"
    fontWeight: 400
    lineHeight: 1
    letterSpacing: "0.02em"
rounded:
  field: "16px"
  chip: "clamp(8px, 0.8vw, 16px)"
  glass: "clamp(16px, 1.6vw, 30px)"
  image: "clamp(28px, 4.4vw, 84px)"
  panel: "clamp(36px, 4.9vw, 94px)"
  arch: "clamp(50px, 8vw, 154px)"
  pill: "999px"
spacing:
  gutter: "clamp(20px, 14.2vw, 272px)"
  container: "1376px"
  header: "clamp(64px, 6.56vw, 126px)"
  section: "clamp(56px, 7vw, 140px)"
  grid-gap: "clamp(14px, 1.9vw, 36px)"
  card-gap: "clamp(60px, 6.5vw, 125px)"
components:
  button-primary:
    backgroundColor: "{colors.harbour-teal}"
    textColor: "{colors.lobby-white}"
    typography: "{typography.button}"
    rounded: "{rounded.pill}"
    padding: "0.5em clamp(24px, 2.7vw, 52px)"
    height: "clamp(46px, 4.05vw, 78px)"
  button-primary-hover:
    backgroundColor: "{colors.harbour-teal-hover}"
  button-white:
    backgroundColor: "{colors.lobby-white}"
    textColor: "{colors.lagoon-teal}"
    typography: "{typography.button}"
    rounded: "{rounded.pill}"
    padding: "0.5em clamp(24px, 2.7vw, 52px)"
    height: "clamp(46px, 4.05vw, 78px)"
  button-white-hover:
    backgroundColor: "{colors.ice-mist}"
  button-header:
    backgroundColor: "{colors.harbour-teal}"
    textColor: "{colors.lobby-white}"
    typography: "{typography.button}"
    rounded: "{rounded.pill}"
    padding: "0.5em clamp(20px, 2.2vw, 42px)"
    height: "clamp(38px, 3.05vw, 59px)"
  nav-link:
    textColor: "{colors.lobby-white}"
    typography: "{typography.nav}"
  nav-link-hover:
    textColor: "{colors.signal-cyan}"
  card-solution:
    backgroundColor: "rgba(20, 40, 66, 0.45)"
    textColor: "{colors.lobby-white}"
    rounded: "{rounded.arch}"
    padding: "clamp(28px, 3.6vw, 70px) clamp(16px, 2vw, 40px)"
  card-glass-step:
    backgroundColor: "{colors.harbour-teal}"
    textColor: "{colors.lobby-white}"
    rounded: "{rounded.glass}"
    padding: "clamp(18px, 1.7vw, 32px) clamp(12px, 1.4vw, 26px) clamp(20px, 2.2vw, 42px)"
  pill-step:
    backgroundColor: "{colors.harbour-teal}"
    textColor: "{colors.lobby-white}"
    rounded: "{rounded.chip}"
    padding: "0.4em 0.6em"
    height: "clamp(48px, 4.1vw, 79px)"
  panel-phygital:
    backgroundColor: "{colors.panel-mist}"
    textColor: "{colors.lobby-white}"
    rounded: "{rounded.panel}"
    padding: "clamp(28px, 4.9vw, 94px) clamp(20px, 5vw, 94px) clamp(70px, 6.5vw, 125px)"
  field-input:
    backgroundColor: "rgba(255, 255, 255, 0.08)"
    textColor: "{colors.lobby-white}"
    typography: "{typography.small}"
    rounded: "{rounded.field}"
    padding: "0.75em 1em"
  tag-chip:
    textColor: "{colors.beacon-cyan}"
    typography: "{typography.small}"
    rounded: "{rounded.pill}"
    padding: "0.3em 1em"
---

# Design System: GrainzMedia

## Overview

**Creative North Star: "The Atrium at Dusk"**

GrainzMedia is a mall atrium after the daylight has gone: deep navy interiors rising into pale ice-blue light, with a run of teal and cyan glowing like signage. Every page sits on one long vertical gradient that starts in Midnight Atrium and lightens toward ice-blue, and its edges are arches, not corners. The hero ends in a shallow dome, the closing call-to-action rests on another, and cards carry the same curve in their top corners. The system is calm and premium. It is spacious, quiet in its chroma and generous with vertical air, and it never raises its voice with anything except a single uppercase headline.

The warmth comes from people. Photography of shoppers, friends over bubble tea and bright mall concourses sits inside the cool navy and softens it. UI chrome stays glassy and soft (pills, translucent cards, 16px fields), so the photographs read as the human center and the interface as the building around them. Type is a single geometric sans, set large and fluid; it is scaled from a 1920px design canvas, so headlines grow with the viewport instead of stepping at breakpoints.

Light is the only accent strategy. Four steps of teal and cyan carry progress, the "attention to action" idea, through numbered loops, pills and step cards. The brightest, Signal Cyan, is reserved for light itself: highlighted words, focus rings, active links and glows.

**Key Characteristics:**
- One continuous navy-to-ice vertical gradient as the page, never flat blocks of color.
- Arches and domes as the horizon line; pills for every button; circles for every node and control.
- A four-step teal-to-cyan ramp used as a sequence, with Signal Cyan treated as light.
- Fluid, viewport-scaled type and spacing from a 1920px canvas, with a 1376px content cap.
- Soft depth: translucent glass over navy, ambient shadows that deepen only on response.
- Photography that is human and warm (people first, retail second), tinted toward navy by a directional scrim.
- A white geometric wordmark (GRAINZ over MEDIA, with a dot above the second I) that lives on navy; no colored variant exists in the repo.
- Confirmed visual rejection: the generic ad-tech/SaaS look (dashboard screenshots, neon-on-black, stock chart graphics).

## Colors

A cool, nocturnal palette: navy depth, one teal-to-cyan ramp for progress and light, ice-blue as the horizon glow, and white for every word.

### Primary
- **Harbour Teal** (#007d88): The brand's anchor. Primary buttons, the first step in every sequence, and the underline/rule color on headings. Deepened from the guide's #008691 so white labels reach 4.9:1. Its hover state, **Harbour Teal Hover** (#006f79), steps one shade deeper (5.9:1); the lift and sheen carry the response. As text on navy it is too dark, so `.hl` highlights use Lagoon Teal.

### Secondary
- **Lagoon Teal** (#00a8b5): The second step of the ramp. Step pill 2, glass card 2, loop node 02, the text color on the white button, and the border of the performance funnel's closing ring.
- **Beacon Cyan** (#00c2d1): The third step. Step pill 3, loop node 03, highlighted words in headlines (`hl-mid`), tag chips, and the Performance page's section headings.

### Tertiary
- **Signal Cyan** (#00e5f7): The light source. The fourth and final step of every sequence, the `hl-cyan` highlight in headlines, hover and active nav links, the 3px focus ring, the selection color, the carousel's active dot, and the form status line.

### Neutral
- **Midnight Atrium** (#0f2d41): The top of the page gradient and the shallow dome that closes every hero. The deepest navy.
- **Atrium Navy** (#172c3f): The base `body` background and `theme-color`; the surface behind everything and the text color on light controls (skip link, native select options).
- **Tide Navy** (#163850): The middle of the page gradient (at 40%); used where navy needs to read a touch lighter than Midnight.
- **Ice Atrium** (#8dc7d3): The brand gradient's nominal floor (the page eases toward it but stops at #4a7f93 so copy keeps contrast), and the radial glow rising from the lower-left of every closing CTA. It is light, not a text surface.
- **Dusk Slate** (#253e4e): The closing dome and the footer. A desaturated slate that quietly ends the page.
- **Panel Mist** (#466475): The blue-gray frosted panel behind the Phygital loop (running from #466475 to #516f80 top to bottom, so white copy holds ≥5.3:1 and Signal Cyan highlights ≥3.4:1).
- **Lobby White** (#ffffff): All text on dark surfaces and the white button fill.
- **Ice Mist** (#eef9fc): The white button's hover fill.
- **Blush Error** (#ffb4b4): Validation messages and the invalid field border (#ff9c9c on the border itself); the only warm color in the system.

### Named Rules
**The Dusk Gradient Rule.** The page is the brand gradient, eased in steps from Midnight Atrium through #12344b, Tide Navy, #1f4a62 and #2c5d74 down to #4a7f93, so white copy keeps its contrast. Ice Atrium is the glow at the foot of the page, not a place for body text.

**The Ramp Is a Sequence Rule.** Harbour, Lagoon, Beacon and Signal are used as ordered steps (pills, glass cards, loop nodes, approach headings, funnel steps) and always in one direction within a sequence. Do not assign them to unrelated items as decoration.

**The Cyan Is Light Rule.** Signal Cyan appears as highlight, glow, focus and active state. It is never a large fill carrying white type.

**The Navy Neutral Rule.** Every dark and every shadow is tinted navy (shadows are rgba(3–6, 12–20, 22–34)). There is no pure black and no neutral gray anywhere in the interface.

## Typography

**Display Font:** Futura (with Futura PT, Jost, Century Gothic, Avenir Next, sans-serif)
**Body Font:** Futura (same stack)
**Numeral Font:** Bebas Neue (with Bebas Kai, Oswald, Arial Narrow)

**Character:** A single geometric sans carries everything: Futura where installed (Apple platforms) and Jost (400, 500, 700, delivered from Google Fonts) elsewhere. Round, wide-set and calm, it matches the wordmark's geometry. Bebas Neue appears only for the numerals inside the loop nodes, a small condensed counterpoint.

### Hierarchy
- **Display** (700, clamp(2.3rem, 6.25vw, 7.5rem), 1.07): Hero headlines on every page, set uppercase with 0.005em tracking and a soft text shadow over the photograph.
- **Display CTA** (700, clamp(2.1rem, 6.25vw, 7.5rem), 1.12): The closing "Ready to move from attention to action?" headline, uppercase, max-width 11 to 12em, centered.
- **Headline** (700, clamp(1.9rem, 3.125vw, 3.75rem), 1.15): Section headings in sentence case ("Two ways we create growth"), balanced wrapping.
- **Title** (700, clamp(1.4rem, 2.35vw, 2.9rem), 1.2): Card and feature titles; engine titles step down to clamp(1.05rem, 1.6vw, 1.95rem).
- **Body** (500, clamp(1rem, 1.5vw, 1.85rem), 1.45): Lead paragraphs, with a measure of 30 to 41em; hero lede up to 37em.
- **Small** (500, clamp(0.95rem, 1.2vw, 1.5rem), 1.45): Card supporting text, lists, footer, form labels; footer text and the cards' inline lists step lower still (clamp(0.8rem, 1.05vw, 1.35rem) and clamp(0.72rem, 0.96vw, 1.2rem)).
- **Eyebrow** (700, clamp(0.95rem, 1.65vw, 2rem), uppercase): The line above a hero headline; a smaller tracked variant (0.12em, Beacon Cyan) is used in simple pages.
- **Nav / Button** (700 for nav, 500 for buttons, clamp(0.9rem, 1.2vw, 1.5rem)): Navigation links and button labels.
- **Numeral** (Bebas Neue 400, clamp(1.1rem, 2.4vw, 2.9rem), 0.02em): Loop node numbers 01 to 04 only.

### Named Rules
**The Signage Rule.** Uppercase is reserved for hero headlines, the closing call-to-action, the "Built in Singapore" line, funnel steps and eyebrows. Section headings stay in sentence case.

**The One Word Rule.** A headline highlights one or two words in teal or cyan (`hl`, `hl-mid`, `hl-cyan`), sometimes underlined at 0.07em thickness with a 0.16em offset. It never colors a whole line.

**The Bebas Boundary.** Bebas Neue is for numerals in the loop only. Everything else is Futura/Jost.

## Layout

The layout is designed on a 1920px canvas and scales fluidly: type, gaps, radii and section padding are all `clamp()` expressions keyed to `vw`, so the composition keeps its proportions from small laptops to wide monitors. Content sits in a centered 1376px container (`min(1376px, 100% - 2 × gutter)`) whose side gutter is clamp(20px, 14.2vw, 272px), roughly the design's 272px margins on a 1920px screen, which gives desktop copy a measure around 72% of the viewport.

Rhythm is vertical and generous: sections open with clamp(56px, 7vw, 140px) of padding, and the page-level moments (hero, engines, CTA) take 100 to 250px of breathing room. Text blocks are centered with narrow measures (25 to 41em); the hero and a few feature blocks are left-aligned. Grids are simple: two columns for cards and the ideas row, three for engines and pills, four for the retail glass cards, and the footer is four unequal columns (1.65 / 1.4 / 1.2 / 1.4).

The header is sticky at clamp(64px, 6.56vw, 126px), carrying a gradient image from pale ice-blue at the left to deep navy at the right. Heroes run clamp(520px, 50.5vw, 970px) tall (longer variants up to 1010px) and end in a shallow arch wider than the viewport so the curve never turns vertical.

Responsive behavior has three steps:
- **1100px and below:** the gutter tightens to clamp(20px, 8vw, 96px).
- **960px and below:** the nav collapses into a hamburger and a full-width dropdown (Midnight-tinted #0f2438), the footer goes to two columns, and retail glass cards go to two columns.
- **720px and below:** the gutter is 20px, body type fixes at 1.05rem / .98rem, button rows stack and buttons go full width, card lists stack in a single column, pills stack with a vertical rule, the phygital loop is replaced by a numbered list, ideas and form rows become one column, and the strategy carousel's arrows move below its slide.

## Elevation & Depth

Depth is mostly tonal: translucent glass surfaces layered over the navy gradient, a hairline white border (22%) around cards, and photography masked by gradient scrims. Shadows are ambient and navy-tinted, and they carry state: buttons rest a little off the surface and rise on hover; cards and glass tiles gain depth only when pointed at.

### Shadow Vocabulary
- **Button rest** (`box-shadow: 0 6px 18px rgba(4, 16, 30, 0.28)`): Pill buttons at rest. Hover lifts to `0 10px 24px rgba(4, 16, 30, 0.36)` with a 2px rise; press drops to `0 3px 10px rgba(4, 16, 30, 0.3)` and scales to 0.985.
- **Header scroll** (`box-shadow: 0 10px 30px rgba(3, 12, 22, 0.38)`): Appears on the sticky header only once the page has scrolled past 8px.
- **Phygital panel** (`box-shadow: 0 30px 60px rgba(5, 15, 28, 0.25)`): The frosted panel is the one surface that rests lifted.
- **Solution card hover** (`box-shadow: 0 30px 70px rgba(3, 12, 22, 0.35)` plus a border brightening from 22% to 40% white): Hover-capable devices only.
- **Glass tile** (`box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25), 0 10px 30px rgba(6, 20, 34, 0.25)`): Retail step cards; on hover they rise 6px and deepen to `0 22px 44px rgba(6, 20, 34, 0.38)`.
- **Field focus** (`box-shadow: 0 0 0 3px rgba(108, 228, 249, 0.25)`, border to Signal Cyan): Inputs, selects and textareas.

### Named Rules
**The Lift On Response Rule.** Surfaces are quiet at rest. Shadows grow, borders brighten and elements rise 2 to 6px only in response to hover, focus or press; the phygital panel is the single permanent exception.

**The Scrim Rule.** Photography sits under a directional gradient scrim (a dark-navy wash heaviest at the left, where copy sits) rather than under a flat overlay.

## Shapes

The form language is soft and architectural. Buttons, chips and tag labels are full pills (999px). Large containers take the atrium's arch: solution cards have a top radius of clamp(50px, 8vw, 154px) with smaller bottom corners (clamp(44px, 5.3vw, 102px)), so each reads like a dome sitting on a base. The hero and CTA ground themselves with shallow circular segments wider than the screen. Photographs, panels and carousels use large rounded corners (clamp(28px, 4.4vw, 84px) for images, clamp(36px, 4.9vw, 94px) for the frosted panel). Smaller glass tiles (clamp(16px, 1.6vw, 30px)), step pills (clamp(8px, 0.8vw, 16px)) and fields (16px) step down the scale. Nodes, carousel arrows and dots are circles. The signature outline is a dashed stadium (2px white, 22px dash with 18px gap) that traces the phygital loop. Hairlines are 1px at 35% to 70% white; teal rules under headings are 2 to 4px.

## Components

Soft, rounded and luminous: generous curves, glassy fills, and a light that moves on hover.

### Buttons
- **Shape:** Full pill (999px), minimum height clamp(46px, 4.05vw, 78px); large variants have a minimum width of clamp(210px, 21.6vw, 414px).
- **Primary:** Harbour Teal fill, white label at 500 weight, padding 0.5em × clamp(24px, 2.7vw, 52px), button-rest shadow.
- **Hover / Focus:** Hover shifts the fill to Harbour Teal Hover, lifts 2px and sweeps a 100° white sheen (22% at the center) across over 0.7s; press scales to 0.985; focus shows the 3px Signal Cyan ring with a 3px offset.
- **White:** White fill with Lagoon Teal label, used on the Phygital panel; hover fills Ice Mist.
- **Header:** The "Contact Us" pill drops to clamp(38px, 3.05vw, 59px) tall and loses its shadow; on the Contact page it is a muted #2f7480.
- **Placement:** Solution-card and panel buttons straddle their container's bottom edge (translate 50% down, centered).

### Navigation
- **Style:** Links in Futura 700 at clamp(0.9rem, 1.2vw, 1.5rem) on the gradient header, 20 to 70px apart; "Performance Marketing" wraps in a 7.6em column.
- **States:** Hover and current page turn the label Signal Cyan and draw a 2px underline from the center outward to 12% inset.
- **Mobile:** At 960px the links become a full-width dropdown with 1px dividers (12% white) and a full-width Contact button; the hamburger is a 44px tap target that morphs to an X.

### Solution Cards
- **Corner Style:** Arched top (clamp(50px, 8vw, 154px)), shallower bottom radius; 1px hairline at 22% white.
- **Background:** Translucent navy-to-slate gradient (rgba(20, 40, 66, 0.55) at the top to rgba(92, 106, 132, 0.55) at the base).
- **Content:** Centered title, tagline, a bulleted inline list, a full-bleed photo banner (cropped to roughly 3.2:1), a short paragraph, and a pill button on the bottom edge.
- **Shadow Strategy:** Lift on response only (see Elevation).

### Glass Step Cards
- **Style:** Four tiles with a teal-to-cyan gradient fill (Harbour at left, Signal at right), a 1px 65% pale-cyan border, an inset top highlight, and a circular icon badge with a 1.8px white line icon.
- **Connectors:** A 2px line and a glowing 12px dot (#8beeff halo) join each tile to the next; the connectors hide at the single-column breakpoint.
- **Behavior:** They reveal in stagger on scroll (90ms apart) and rise 6px on hover.

### Pills and Tag Chips
- **Step pills:** Three full-width rounded rectangles in Harbour, Lagoon and Beacon, strung on a 4px Harbour line behind them; they rise 3px and brighten 8% on hover.
- **Tag chip:** An inline pill outlined 1px in Lagoon Teal with Beacon Cyan text.

### Engines Row
- **Style:** Three columns of line illustration, title and a short line, framed above and below by 1px hairlines (70% white) and separated by vertical hairlines; the illustration rises 6px on hover.

### Phygital Panel and Loop (signature)
- **Panel:** A frosted Panel Mist surface, up to 94px radius, lifted by a deep shadow, with a soft text shadow on the heading.
- **Loop:** A dashed white stadium outline (2px, dashes slowly marching over 28 seconds) carries four circular nodes: Harbour 01, Lagoon 02, Beacon 03 and Signal 04 on the stadium's four sides, each with a numeral in Bebas Neue and a caption beside it. On mobile it becomes a four-row numbered list.

### Inputs / Fields
- **Style:** 8% white fill, 1px 30% white border, 16px radius, 0.75em × 1em padding, Futura 500; a chevron icon sits in selects.
- **Focus:** Border turns Signal Cyan with a 3px, 25% cyan glow; the border brightens to 50% white on hover.
- **Error / Disabled:** Invalid fields take a #ff9c9c border and a Blush Error message; a disabled submit button drops to 70% opacity and shows a progress cursor.

### Carousels
- **Style:** Slides fade over 0.6s inside the large-radius viewport; circular arrows up to 66px (2px white outline over a 35% navy fill) straddle the frame's edge, with 10px dots below (active dot is Signal Cyan). The Performance strategy carousel uses cyan-outlined line arrows beside a centered heading.

## Do's and Don'ts

### Do:
- **Do** let the page be one eased gradient (Midnight Atrium lightening toward Ice Atrium); end heroes and the final CTA on arches, not straight edges.
- **Do** use `clamp()` expressions keyed to `vw` for type, gaps and radii, and keep the 1376px container and clamp(20px, 14.2vw, 272px) gutter.
- **Do** make every button a full pill in Harbour Teal with a white 500-weight label, a 2px rise on hover and a visible 3px Signal Cyan focus ring offset by 3px.
- **Do** keep sequences in ramp order (Harbour, Lagoon, Beacon, Signal) and highlight at most one or two words in a headline.
- **Do** put text on Beacon Cyan and Signal Cyan fills in Atrium Navy (#172c3f gives 6.6:1 and 9.2:1).
- **Do** use people-led photography, tinted with a left-weighted navy scrim, and keep illustrations in thin white line style.
- **Do** keep the wordmark white on navy or the header gradient, at the sizes in use (clamp(34px, 2.65vw, 52px) in the header).
- **Do** gate motion behind `prefers-reduced-motion` and keep entrances to a 22 to 26px rise (hero: 0.9s with ease (.2, .7, .2, 1); scroll reveals: 0.8s ease).

### Don't:
- **Don't** slide into the generic ad-tech/SaaS look: dashboard screenshots, neon-on-black or stock chart graphics (confirmed rejection).
- **Don't** set white text on Lagoon, Beacon or Signal fills (2.9, 2.2 and 1.6:1). Step pills 2–3, loop nodes 02–04 and retail glass cards 3–4 carry Atrium Navy type; glass cards 1–2 use deepened teal so white holds ≥4.5:1.
- **Don't** put Beacon or Lagoon text on the lower half of the page gradient (below #1f4a62) or on the Phygital panel; highlights there use Signal Cyan.
- **Don't** use pure black, neutral gray or a second typeface; keep every dark navy-tinted and Futura/Jost the only text face (Bebas Neue for loop numerals).
- **Don't** put shadows, brightening or movement on surfaces at rest, apart from the Phygital panel.
- **Don't** introduce rectangular, sharp-cornered containers or buttons; the smallest corner in use is a 16px field.
- **Don't** color whole headline lines in teal or cyan, or use uppercase for section headings.
- **Don't** treat Ice Atrium as a text surface or let it appear as a flat fill; it is the glow at the foot of the page.
