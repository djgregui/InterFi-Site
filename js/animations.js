/* =========================================================
   InterFi — animations.js
   Reveals no scroll, contadores, tilt 3D, parallax leve.
   Tudo degrada com segurança em dispositivos lentos.
   ========================================================= */
(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var cores = navigator.hardwareConcurrency || 4;
  var mem = navigator.deviceMemory || 4;
  var coarse = window.matchMedia('(pointer: coarse)').matches;
  var lowPower = reduced || cores <= 4 || mem <= 4;

  if (lowPower) document.body.classList.add('low-power');

  /* ---------- 1. Reveal ---------- */
  var reveals = document.querySelectorAll('.reveal');

  function showAll() {
    reveals.forEach(function (el) { el.classList.add('is-in'); });
  }

  if (!('IntersectionObserver' in window) || reduced) {
    showAll();
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        io.unobserve(entry.target);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

    reveals.forEach(function (el) { io.observe(el); });

    // O hero entra imediatamente, sem esperar pelo scroll.
    requestAnimationFrame(function () {
      document.querySelectorAll('.hero .reveal').forEach(function (el) {
        el.classList.add('is-in');
      });
    });
  }

  /* ---------- 2. Contadores ---------- */
  var counters = document.querySelectorAll('[data-count]');

  function runCounter(el) {
    var target = parseFloat(el.getAttribute('data-count')) || 0;
    if (reduced) { el.textContent = target; return; }
    var dur = 1100;
    var start = performance.now();
    function step(now) {
      var p = Math.min((now - start) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased);
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  if ('IntersectionObserver' in window) {
    var cio = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        runCounter(entry.target);
        cio.unobserve(entry.target);
      });
    }, { threshold: 0.6 });
    counters.forEach(function (el) { cio.observe(el); });
  } else {
    counters.forEach(runCounter);
  }

  /* ---------- 3. Tilt 3D (apenas rato, apenas desktop capaz) ---------- */
  if (!lowPower && !coarse) {
    document.querySelectorAll('[data-tilt]').forEach(function (zone) {
      var target = zone.querySelector('.screen') || zone;
      var raf = null;

      zone.addEventListener('mousemove', function (e) {
        if (raf) return;
        raf = requestAnimationFrame(function () {
          raf = null;
          var r = zone.getBoundingClientRect();
          var x = (e.clientX - r.left) / r.width - 0.5;
          var y = (e.clientY - r.top) / r.height - 0.5;
          target.style.transform =
            'perspective(1500px) rotateY(' + (-9 + x * 7).toFixed(2) + 'deg) rotateX(' +
            (3 - y * 5).toFixed(2) + 'deg)';
        });
      });

      zone.addEventListener('mouseleave', function () {
        target.style.transform = '';
      });
    });

    document.querySelectorAll('[data-tilt-soft]').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        card.style.transform =
          'translateY(-6px) perspective(900px) rotateY(' + (x * 5).toFixed(2) +
          'deg) rotateX(' + (-y * 5).toFixed(2) + 'deg)';
      });
      card.addEventListener('mouseleave', function () { card.style.transform = ''; });
    });
  }

  /* ---------- 4. Parallax leve no hero ---------- */
  if (!lowPower) {
    var glow = document.querySelector('.hero__glow');
    var visual = document.querySelector('.hero__visual');
    var ticking = false;

    window.addEventListener('scroll', function () {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        ticking = false;
        var y = window.scrollY;
        if (y > window.innerHeight * 1.2) return;
        if (glow) glow.style.transform = 'translateY(' + (y * 0.12).toFixed(1) + 'px)';
        if (visual) visual.style.transform = 'translateY(' + (y * -0.04).toFixed(1) + 'px)';
      });
    }, { passive: true });
  }
  /* ---------- 5. Scroll-scrub: liga elementos ao scroll de forma contínua,
     em vez de um único disparo — a página reage como um vídeo que se
     percorre manualmente. Desativado em ecrãs pequenos/toque e em
     dispositivos de baixo desempenho, onde o CSS já mostra o estado final. */
  var canScrub = !lowPower && !coarse && window.innerWidth > 1024;

  if (canScrub) {
    var clamp01 = function (n) { return Math.max(0, Math.min(1, n)); };

    var scrubIn = Array.prototype.slice.call(document.querySelectorAll('.scrub-in, .scrub-tilt'));
    var pins = Array.prototype.slice.call(document.querySelectorAll('[data-pin]'));
    var tires = Array.prototype.slice.call(document.querySelectorAll('.scrub-tire'));

    var pinData = pins.map(function (el) {
      return {
        wrapper: el,
        flow: el.querySelector('[data-flow]'),
        bar: el.querySelector('[data-flow-bar]'),
        steps: parseInt(el.getAttribute('data-steps') || '0', 10),
        hub: el.querySelector('[data-hub]')
      };
    });

    var winH = window.innerHeight;
    window.addEventListener('resize', function () { winH = window.innerHeight; }, { passive: true });

    function updateScrub() {
      var vh = winH;

      scrubIn.forEach(function (el) {
        var r = el.getBoundingClientRect();
        var p = clamp01((vh - r.top - r.height * 0.12) / (vh * 0.82));
        el.style.setProperty('--sp', p.toFixed(3));
      });

      pinData.forEach(function (d) {
        var r = d.wrapper.getBoundingClientRect();
        var total = r.height - vh;
        var p = total > 0 ? clamp01(-r.top / total) : (r.top < 0 ? 1 : 0);

        if (d.bar) d.bar.style.width = (p * 100).toFixed(1) + '%';

        if (d.flow && d.steps) {
          var active = Math.min(d.steps - 1, Math.floor(p * d.steps * 1.06));
          var items = d.flow.children;
          for (var i = 0; i < items.length; i++) {
            items[i].classList.toggle('is-active', i === active);
            items[i].classList.toggle('is-done', i < active);
          }
        }

        if (d.hub) d.hub.style.setProperty('--hp', p.toFixed(3));
      });

      tires.forEach(function (el) {
        var r = el.getBoundingClientRect();
        var p = clamp01((vh - r.top) / (vh + r.height));
        el.style.setProperty('--tp', p.toFixed(3));
      });
    }

    var scrubTicking = false;
    window.addEventListener('scroll', function () {
      if (scrubTicking) return;
      scrubTicking = true;
      requestAnimationFrame(function () { scrubTicking = false; updateScrub(); });
    }, { passive: true });

    updateScrub();
  } else {
    document.body.classList.add('no-scrub');
  }
})();
