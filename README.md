# GrainzMedia website

Static site (HTML/CSS/JS, no framework). Pages are assembled from templates by a zero-dependency Node script.

## Structure
```
src/partials/   head.html, header.html, footer.html   (shared across pages)
src/pages/      one file per page; first line is a JSON front-matter comment
assets/         css, js, img (photos/ holds generated responsive renditions)
tools/          build.mjs (templates → HTML), images.sh (photo renditions), photos/ (photo masters)
```
The built `*.html`, `sitemap.xml` and `robots.txt` in the project root are generated — edit `src/`, not the root files.

## Commands
```bash
node tools/build.mjs        # rebuild all pages (set SITE_URL=https://example.com for canonical/OG/sitemap URLs)
bash tools/images.sh        # regenerate WebP/JPEG renditions from tools/photos (needs ImageMagick 7)
python3 -m http.server 8765 # preview at http://localhost:8765
```

## Adding a photo
Drop a master JPEG in `tools/photos/`, run `bash tools/images.sh`, then use it in a page with
`{{picture name="file-name" alt="…" sizes="…"}}` (add `eager` for above-the-fold images).

## To finish before launch
- `SITE_URL` defaults to https://grainzmedia.github.io. When a custom domain is attached, rebuild with `SITE_URL=https://your-domain node tools/build.mjs` (canonical, Open Graph and sitemap URLs).
- Confirm the LinkedIn URL in `src/partials/footer.html` (currently a placeholder guess).
- Replace the placeholder Privacy / Cookie / Press pages with real content.
- Enquiry form: until a Google Form is connected (below) it opens the visitor's mail client.

## Sending the contact form to a Google Form
1. Create a Google Form with five questions: *I'm interested in* (dropdown with exactly `Retail Media`, `Performance Marketing`, `Integrated campaign`, `Something else`), *Name*, *Company*, *Email*, *How can we help?* (paragraph). Don't require sign-in and don't add file uploads.
2. Form menu (⋮) → **Get pre-filled link**, fill every question with any value, click **Get link**, and open that link. In the URL you'll see `entry.123456789=…` for each question — note which id belongs to which question.
3. Take the form's address `https://docs.google.com/forms/d/e/<FORM_ID>/viewform` and change `viewform` to `formResponse`.
4. In `src/pages/contact.html` set `data-google-form` to that `formResponse` URL and fill `data-entries`, e.g.
   `{"topic":"entry.111","name":"entry.222","company":"entry.333","email":"entry.444","message":"entry.555"}`
5. Run `node tools/build.mjs`. Optional: in the Form's Responses tab, link a Sheet and turn on email notifications.

Note: browsers can't read Google's reply (no-cors), so the page shows "sent" whenever the request leaves successfully. Submit a real test entry after connecting.
