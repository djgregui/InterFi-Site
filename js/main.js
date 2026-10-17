/* =========================================================
   InterFi — main.js
   Navegação, menu mobile, progresso de scroll, formulário.
   ========================================================= */

(function () {

  'use strict';

  var nav = document.getElementById('nav');
  var toggle = document.getElementById('navToggle');
  var links = document.getElementById('navLinks');
  var progress = document.getElementById('navProgress');
  var toTop = document.getElementById('toTop');

  /* ---------- Menu mobile ---------- */

  function setMenu(open) {

    links.classList.toggle('is-open', open);

    toggle.setAttribute('aria-expanded', String(open));

    toggle.setAttribute(
      'aria-label',
      open ? 'Fechar menu' : 'Abrir menu'
    );

    toggle.innerHTML =
      '<svg class="icon" aria-hidden="true"><use href="#' +
      (open ? 'i-close' : 'i-menu') +
      '"></use></svg>';

    document.body.style.overflow = open ? 'hidden' : '';
  }

  toggle.addEventListener('click', function () {
    setMenu(!links.classList.contains('is-open'));
  });

  links.addEventListener('click', function (e) {

    if (e.target.closest('a')) {
      setMenu(false);
    }

  });

  document.addEventListener('keydown', function (e) {

    if (
      e.key === 'Escape' &&
      links.classList.contains('is-open')
    ) {
      setMenu(false);
    }

  });

  window.addEventListener('resize', function () {

    if (
      window.innerWidth > 1024 &&
      links.classList.contains('is-open')
    ) {
      setMenu(false);
    }

  });


  /* ---------- Estado da navbar + progresso + botão topo ---------- */

  var sections = Array.prototype.slice.call(
    document.querySelectorAll('section[id]')
  );

  var navAnchors = Array.prototype.slice.call(
    links.querySelectorAll('a[href^="#"]')
  );

  var ticking = false;

  function onScroll() {

    var y = window.scrollY;

    nav.classList.toggle('is-stuck', y > 24);

    if (toTop) {
      toTop.classList.toggle('is-visible', y > 700);
    }

    var h =
      document.documentElement.scrollHeight -
      window.innerHeight;

    if (progress) {
      progress.style.width =
        (h > 0 ? (y / h) * 100 : 0) + '%';
    }

    var current = '';

    sections.forEach(function (s) {

      if (s.getBoundingClientRect().top <= 140) {
        current = s.id;
      }

    });

    navAnchors.forEach(function (a) {

      a.classList.toggle(
        'is-active',
        a.getAttribute('href') === '#' + current
      );

    });

  }

  window.addEventListener('scroll', function () {

    if (ticking) return;

    ticking = true;

    requestAnimationFrame(function () {

      ticking = false;

      onScroll();

    });

  }, { passive: true });

  onScroll();


  /* ---------- Ano no rodapé ---------- */

  var year = document.getElementById('year');

  if (year) {
    year.textContent = new Date().getFullYear();
  }


  /* ---------- Validação do formulário ---------- */

  var form = document.getElementById('demoForm');

  if (!form) return;

  var status = document.getElementById('formStatus');

  var rules = {

    nome: function (v) {

      if (!v.trim()) {
        return 'Indique o seu nome.';
      }

      if (v.trim().length < 2) {
        return 'O nome parece demasiado curto.';
      }

      return '';
    },

    empresa: function (v) {

      if (!v.trim()) {
        return 'Indique o nome da empresa.';
      }

      return '';
    },

    email: function (v) {

      if (!v.trim()) {
        return 'Indique um e-mail de contato.';
      }

      if (!/^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(v.trim())) {
        return 'Verifique o formato do e-mail.';
      }

      return '';
    },

    telefone: function (v) {

      if (!v.trim()) {
        return 'Indique um telefone.';
      }

      if (v.replace(/\D/g, '').length < 9) {
        return 'O telefone precisa de pelo menos 9 dígitos.';
      }

      return '';
    },

    veiculos: function (v) {

      if (!v) {
        return 'Selecione o número de veículos.';
      }

      return '';
    },

    mensagem: function () {
      return '';
    }

  };


  function fieldOf(input) {
    return input.closest('.field');
  }


  function validate(input) {

    var rule = rules[input.name];

    if (!rule) return true;

    var msg = rule(input.value);

    var field = fieldOf(input);

    var err = field.querySelector('[data-err]');

    field.classList.toggle('is-invalid', !!msg);

    input.setAttribute(
      'aria-invalid',
      msg ? 'true' : 'false'
    );

    if (err) {
      err.textContent = msg;
    }

    return !msg;
  }


  form.querySelectorAll(
    'input,select,textarea'
  ).forEach(function (input) {

    input.addEventListener('blur', function () {
      validate(input);
    });

    input.addEventListener('input', function () {

      if (
        fieldOf(input).classList.contains('is-invalid')
      ) {
        validate(input);
      }

    });

  });


  /* ---------- Envio do formulário ---------- */

  form.addEventListener('submit', function (e) {

    e.preventDefault();

    var ok = true;
    var first = null;

    form.querySelectorAll(
      'input,select,textarea'
    ).forEach(function (input) {

      var valid = validate(input);

      if (!valid && !first) {
        first = input;
      }

      ok = ok && valid;

    });


    if (!ok) {

      status.classList.remove('is-ok');

      status.textContent =
        'Reveja os campos assinalados para continuar.';

      if (first) {
        first.focus();
      }

      return;
    }


    var btn = form.querySelector(
      'button[type="submit"]'
    );

    btn.disabled = true;

    btn.textContent = 'A enviar…';

    status.classList.remove('is-ok');

    status.textContent = '';


    /* ---------- Envio real para o PHP ---------- */

    fetch('enviar-demo.php', {

      method: 'POST',

      body: new FormData(form)

    })

    .then(function (response) {

      if (!response.ok) {
        throw new Error('Erro HTTP ' + response.status);
      }

      return response.json();

    })

    .then(function (data) {

      btn.disabled = false;

      btn.textContent = 'Solicitar demonstração';


      if (data.ok) {

        status.classList.add('is-ok');

        status.textContent =
          'Pedido enviado com sucesso. ' +
          'A nossa equipa entra em contacto em até um dia útil.';

        form.reset();

      } else {

        status.classList.remove('is-ok');

        status.textContent =
          data.message ||
          'Não foi possível enviar o pedido.';

      }

    })

    .catch(function () {

      btn.disabled = false;

      btn.textContent = 'Solicitar demonstração';

      status.classList.remove('is-ok');

      status.textContent =
        'Ocorreu um erro ao enviar o pedido. ' +
        'Tente novamente.';

    });

  });

})();