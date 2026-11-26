// Shared by build.mjs (static site) and build-wp.mjs (WordPress theme).
// {{picture name="hero-mall" alt="…" class="…" sizes="…" eager}} → responsive <picture>
export const esc = s => String(s).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');

export function picture(attrs, manifest) {
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

export const expandPictures = (html, manifest) => html.replace(/\{\{picture\s+([^}]*)\}\}/g, (_, a) => picture(a, manifest));
