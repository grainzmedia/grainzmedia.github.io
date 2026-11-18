#!/usr/bin/env node
// Zero-dependency static site builder.
//   node tools/build.mjs
// Combines src/partials/{head,header,footer}.html with each src/pages/*.html and writes the
// finished pages to the project root. Also writes sitemap.xml and robots.txt.
import { readFileSync, writeFileSync, readdirSync, existsSync } from 'node:fs';
import { createHash } from 'node:crypto';
import { join, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const SITE = process.env.SITE_URL || 'https://www.grainzmedia.com';
const read = p => readFileSync(join(root, p), 'utf8');
const partial = n => read(`src/partials/${n}.html`);

const manifestPath = join(root, 'assets/img/photos/manifest.json');
const manifest = existsSync(manifestPath) ? JSON.parse(readFileSync(manifestPath, 'utf8')) : {};

// Cache-busting: append a short content hash to CSS/JS URLs so browsers never serve a stale copy after a rebuild.
const hashOf = p => createHash('md5').update(readFileSync(join(root, p))).digest('hex').slice(0, 8);
const assetVersions = { 'assets/css/style.css': hashOf('assets/css/style.css'), 'assets/js/main.js': hashOf('assets/js/main.js') };

const esc = s => String(s).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');

// {{picture name="hero-mall" alt="…" class="…" sizes="…" eager}} → responsive <picture>
function picture(attrs) {
  const a = {};
  for (const m of attrs.matchAll(/(\w+)(?:="([^"]*)")?/g)) a[m[1]] = m[2] ?? true;
  const info = manifest[a.name];
  if (!info) throw new Error(`Unknown photo "${a.name}" — run tools/images.sh first`);
  const src = w => `assets/img/photos/${a.name}-${w}`;
  const set = ext => info.widths.map(w => `${src(w)}.${ext} ${w}w`).join(', ');
  const fallbackW = info.widths.includes(1024) ? 1024 : info.widths.at(-1);
  const sizes = a.sizes || '100vw';
  const eager = a.eager === true;
  return `<picture${a.pclass ? ` class="${a.pclass}"` : ''}>` +
    `<source type="image/webp" srcset="${set('webp')}" sizes="${sizes}">` +
    `<img${a.class ? ` class="${a.class}"` : ''} src="${src(fallbackW)}.jpg" srcset="${set('jpg')}" sizes="${sizes}" ` +
    `alt="${esc(a.alt ?? '')}" width="${info.width}" height="${info.height}" ` +
    (eager ? 'fetchpriority="high" decoding="async"' : 'loading="lazy" decoding="async"') + '></picture>';
}

const pages = readdirSync(join(root, 'src/pages')).filter(f => f.endsWith('.html')).sort();
const urls = [];

for (const file of pages) {
  const raw = read(`src/pages/${file}`);
  const m = raw.match(/^<!--\s*(\{[\s\S]*?\})\s*-->\s*/);
  if (!m) throw new Error(`${file}: missing front-matter comment`);
  const meta = JSON.parse(m[1]);
  let body = raw.slice(m[0].length);
  body = body.replace(/\{\{picture\s+([^}]*)\}\}/g, (_, a) => picture(a));

  const out = meta.out || file;
  const canonicalPath = out === 'index.html' ? '' : out;
  const preload = meta.preload
    ? `<link rel="preload" as="image" type="image/webp" fetchpriority="high" imagesrcset="${manifest[meta.preload].widths.map(w => `assets/img/photos/${meta.preload}-${w}.webp ${w}w`).join(', ')}" imagesizes="100vw">`
    : '';

  let head = partial('head')
    .replaceAll('{{title}}', esc(meta.title))
    .replaceAll('{{description}}', esc(meta.description))
    .replaceAll('{{site}}', SITE)
    .replaceAll('{{canonicalPath}}', canonicalPath)
    .replaceAll('{{bodyClass}}', meta.bodyClass || '')
    .replace('{{preload}}', preload);

  let header = partial('header');
  if (meta.nav) {
    header = header.replace(new RegExp(`<a href="([^"]+)" data-nav="${meta.nav}"`), '<a href="$1" data-nav="' + meta.nav + '" aria-current="page"');
  }
  header = header.replace(/ data-nav="\w+"/g, '');

  let html = `${head}\n${header}\n${body.trim()}\n\n${partial('footer')}`;
  for (const [path, v] of Object.entries(assetVersions)) html = html.replaceAll(`"${path}"`, `"${path}?v=${v}"`);
  writeFileSync(join(root, out), html);
  if (!meta.noindex) urls.push(canonicalPath);
  console.log('built', out);
}

const today = new Date().toISOString().slice(0, 10);
writeFileSync(join(root, 'sitemap.xml'),
  `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n` +
  urls.map(u => `  <url><loc>${SITE}/${u}</loc><lastmod>${today}</lastmod></url>`).join('\n') + '\n</urlset>\n');
writeFileSync(join(root, 'robots.txt'), `User-agent: *\nAllow: /\n\nSitemap: ${SITE}/sitemap.xml\n`);
console.log('built sitemap.xml, robots.txt');
