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

## WordPress theme
The same pages are also packaged as a WordPress theme, with Insights listing WordPress posts.
```bash
node tools/build-wp.mjs     # → dist/grainzmedia/ and dist/grainzmedia.zip
```
- `wordpress/theme/` holds the hand-written theme files (templates, `functions.php`, `assets/css/wp.css` for posts). The page designs are generated from `src/pages/` into `pages/*.php`, so edit `src/` and rebuild — never the files in `dist/`.
- Install: WordPress admin → Appearance → Themes → Add New → Upload Theme → `dist/grainzmedia.zip` → Activate.
- On activation the theme creates the pages (Home, Retail Media, Performance Marketing, Insights, About, Contact, Press, Privacy Policy, Cookie Policy), sets Home as the front page and Insights as the posts page, creates the categories *Retail Media Insights* and *Performance Insights*, and turns on `/%postname%/` permalinks if none are set. Existing pages and settings are left alone.
- Home, Retail Media, Performance Marketing, About and Contact always show the built-in design. Press, Privacy Policy and Cookie Policy show their placeholder until you write content for them in the editor.
- Old static URLs such as `/about.html` redirect to the new pages.

## Adding a photo
Drop a master JPEG in `tools/photos/`, run `bash tools/images.sh`, then use it in a page with
`{{picture name="file-name" alt="…" sizes="…"}}` (add `eager` for above-the-fold images).

## To finish before launch
- `SITE_URL` defaults to https://www.grainzmedia.com (canonical, Open Graph and sitemap URLs). Override with `SITE_URL=https://other-domain node tools/build.mjs` if needed.
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
