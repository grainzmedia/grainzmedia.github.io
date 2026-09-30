(() => {
  'use strict';
  const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)');

  // ---------- Header: mobile menu + scroll elevation ----------
  const header = document.querySelector('[data-header]');
  const toggle = header?.querySelector('.nav-toggle');
  if (header && toggle) {
    const setOpen = open => {
      header.classList.toggle('nav-open', open);
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Close menu' : 'Menu');
    };
    toggle.addEventListener('click', () => setOpen(!header.classList.contains('nav-open')));
    header.querySelectorAll('.nav a').forEach(a => a.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') setOpen(false); });
    matchMedia('(min-width: 961px)').addEventListener('change', e => { if (e.matches) setOpen(false); });
  }
  if (header) {
    const onScroll = () => header.classList.toggle('is-scrolled', scrollY > 8);
    onScroll();
    addEventListener('scroll', onScroll, { passive: true });
  }

  // Footer year
  document.querySelectorAll('[data-year]').forEach(el => { el.textContent = new Date().getFullYear(); });

  // ---------- Carousels ----------
  // [data-carousel] contains .slide elements, [data-prev]/[data-next] buttons and an optional .dots container.
  document.querySelectorAll('[data-carousel]').forEach(root => {
    const slides = [...root.querySelectorAll('.slide')];
    if (slides.length < 2) return;
    const dotsWrap = root.querySelector('.dots');
    let index = Math.max(0, slides.findIndex(s => s.classList.contains('is-active')));
    let timer = null;

    const dots = dotsWrap ? slides.map((_, i) => {
      const b = document.createElement('button');
      b.type = 'button';
      b.setAttribute('aria-label', `Show slide ${i + 1} of ${slides.length}`);
      b.addEventListener('click', () => { go(i); restart(); });
      dotsWrap.appendChild(b);
      return b;
    }) : [];

    function go(i) {
      index = (i + slides.length) % slides.length;
      slides.forEach((s, n) => {
        const active = n === index;
        s.classList.toggle('is-active', active);
        s.setAttribute('aria-hidden', String(!active));
        s.toggleAttribute('inert', !active);
      });
      dots.forEach((d, n) => {
        d.classList.toggle('is-active', n === index);
        d.setAttribute('aria-current', n === index ? 'true' : 'false');
      });
    }
    const stop = () => { clearInterval(timer); timer = null; };
    function restart() {
      stop();
      const ms = Number(root.dataset.autoplay);
      if (ms && !reduceMotion.matches && !document.hidden) timer = setInterval(() => go(index + 1), ms);
    }

    root.querySelector('[data-prev]')?.addEventListener('click', () => { go(index - 1); restart(); });
    root.querySelector('[data-next]')?.addEventListener('click', () => { go(index + 1); restart(); });
    root.addEventListener('keydown', e => {
      if (e.key === 'ArrowLeft') { go(index - 1); restart(); }
      if (e.key === 'ArrowRight') { go(index + 1); restart(); }
    });
    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', restart);
    root.addEventListener('focusin', stop);
    root.addEventListener('focusout', restart);
    document.addEventListener('visibilitychange', () => (document.hidden ? stop() : restart()));

    // Touch swipe
    let x0 = null;
    root.addEventListener('touchstart', e => { x0 = e.touches[0].clientX; }, { passive: true });
    root.addEventListener('touchend', e => {
      if (x0 === null) return;
      const dx = e.changedTouches[0].clientX - x0;
      x0 = null;
      if (Math.abs(dx) > 40) { go(index + (dx < 0 ? 1 : -1)); restart(); }
    });

    go(index);
    restart();
  });

  // ---------- Scroll reveal (with sibling stagger) ----------
  document.querySelectorAll('.glass, .engine, .pill').forEach((el, _, all) => {
    el.classList.add('reveal');
    const siblings = [...el.parentElement.children];
    el.style.transitionDelay = `${siblings.indexOf(el) * 90}ms`;
  });
  const items = document.querySelectorAll('.reveal');
  const clearDelay = el => { if (el.style.transitionDelay) setTimeout(() => { el.style.transitionDelay = ''; }, 1400); };
  if ('IntersectionObserver' in window && !reduceMotion.matches) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); clearDelay(e.target); } });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
    items.forEach(el => io.observe(el));
  } else {
    items.forEach(el => el.classList.add('in'));
  }

  // ---------- Contact form ----------
  // Submits to a Google Form when configured on the <form> (data-google-form + data-entries), otherwise falls back to email.
  const form = document.querySelector('#enquiry-form');
  if (form) {
    const status = form.querySelector('.status');
    const type = new URLSearchParams(location.search).get('type');
    if (type && form.elements.topic && [...form.elements.topic.options].some(o => o.value === type || o.text === type)) {
      form.elements.topic.value = type;
    }

    const messages = {
      name: 'Please tell us your name.',
      email: 'Please enter a valid email address.',
      message: 'Please tell us a little about what you need.'
    };
    const check = field => {
      const err = form.querySelector(`#e-${field.name}`);
      if (!err) return true;
      const ok = field.checkValidity() && field.value.trim() !== '';
      field.setAttribute('aria-invalid', String(!ok));
      err.hidden = ok;
      err.textContent = ok ? '' : messages[field.name];
      return ok;
    };
    const required = ['name', 'email', 'message'].map(n => form.elements[n]);
    required.forEach(f => {
      f.addEventListener('blur', () => f.value && check(f));
      f.addEventListener('input', () => f.getAttribute('aria-invalid') === 'true' && check(f));
    });

    form.addEventListener('submit', e => {
      e.preventDefault();
      status.className = 'status';
      const results = required.map(check);
      if (results.includes(false)) {
        required[results.indexOf(false)].focus();
        status.textContent = 'Please check the highlighted fields.';
        return;
      }
      const d = new FormData(form);
      if (d.get('website')) return; // honeypot: bots fill this hidden field

      const action = form.dataset.googleForm;
      let entries = {};
      try { entries = JSON.parse(form.dataset.entries || '{}'); } catch { /* ignore */ }

      // Preferred path: post to a Google Form ("formResponse" endpoint).
      if (action && Object.keys(entries).length) {
        const body = new URLSearchParams();
        for (const [field, entryId] of Object.entries(entries)) body.append(entryId, String(d.get(field) ?? ''));
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        status.textContent = 'Sending…';
        // no-cors: Google does not return a readable response, so a resolved request means "sent".
        fetch(action, { method: 'POST', mode: 'no-cors', body })
          .then(() => {
            form.reset();
            required.forEach(f => f.removeAttribute('aria-invalid'));
            status.classList.add('ok');
            status.textContent = 'Thank you — your enquiry has been sent. We’ll be in touch soon.';
          })
          .catch(() => {
            status.textContent = 'Sorry, we couldn’t send that. Please email hello@grainzmedia.com instead.';
          })
          .finally(() => { button.disabled = false; });
        return;
      }

      // Fallback (no Google Form configured): open the visitor's mail client with the enquiry prefilled.
      const subject = `${d.get('topic')} enquiry — ${d.get('name')}`;
      const body = [`Name: ${d.get('name')}`, `Company: ${d.get('company') || '-'}`, `Email: ${d.get('email')}`, '', d.get('message')].join('\n');
      status.classList.add('ok');
      status.textContent = 'Opening your email app… if nothing happens, write to hello@grainzmedia.com.';
      location.href = `mailto:hello@grainzmedia.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    });
  }
})();
