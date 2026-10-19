/* =========================================================
   InterFi — main.js
   Navegação, menu mobile, progresso de scroll, formulário.
   ========================================================= */

(function () {
  'use strict';
  /* Partilha as traduções do PHP, incluindo as mensagens de validação. */
  function tr(message) {
    return (window.interfiTranslations && window.interfiTranslations[message]) || message;
  }
  var nav = document.getElementById('nav');
  var toggle = document.getElementById('navToggle');
  var links = document.getElementById('navLinks');
  var progress = document.getElementById('navProgress');
  var toTop = document.getElementById('toTop');

  /* Preserva o ponto da página ao alternar o idioma. */
  document.querySelectorAll('.lang-switch__link').forEach(function (a) {
    a.addEventListener('click', function () {
      if (window.location.hash) {
        a.href = a.getAttribute('href') + window.location.hash;
      }
    });
  });

  /* ---------- Menu mobile ---------- */
  function setMenu(open) {
    links.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute(
      'aria-label',
      open ? tr('Fechar menu') : tr('Abrir menu')
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
  
/* Fechar o menu ao clicar fora dele */
document.addEventListener('click', function (e) {

    const menuAberto = links.classList.contains('is-open');

    const clicouFora =
        !links.contains(e.target) &&
        !toggle.contains(e.target);

    if (menuAberto && clicouFora) {
        setMenu(false);
    }

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
        return tr('Indique o seu nome.');
      }
      if (v.trim().length < 2) {
        return tr('O nome parece demasiado curto.');
      }
      return '';
    },
    empresa: function (v) {
      if (!v.trim()) {
        return tr('Indique o nome da empresa.');
      }
      return '';
    },
    email: function (v) {
      if (!v.trim()) {
        return tr('Indique um e-mail de contato.');
      }
      if (!/^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i.test(v.trim())) {
        return tr('Verifique o formato do e-mail.');
      }
      return '';
    },
    telefone: function (v) {
      if (!v.trim()) {
        return tr('Indique um telefone.');
      }
      if (v.replace(/\D/g, '').length < 9) {
        return tr('O telefone precisa de pelo menos 9 dígitos.');
      }
      return '';
    },
    veiculos: function (v) {
      if (!v) {
        return tr('Selecione o número de veículos.');
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
        tr('Reveja os campos assinalados para continuar.');
      if (first) {
        first.focus();
      }
      return;
    }
    var btn = form.querySelector(
      'button[type="submit"]'
    );
    btn.disabled = true;
    btn.textContent = tr('A enviar…');
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
      btn.textContent = tr('Solicitar demonstração');
      if (data.ok) {
        status.classList.add('is-ok');
        status.textContent = tr('Pedido enviado com sucesso. A nossa equipa entra em contacto em até um dia útil.');
        form.reset();
      } else {
        status.classList.remove('is-ok');
        status.textContent =
          tr(data.message || 'Não foi possível enviar o pedido.');
      }
    })
    .catch(function () {
      btn.disabled = false;
      btn.textContent = tr('Solicitar demonstração');
      status.classList.remove('is-ok');
      status.textContent = tr('Ocorreu um erro ao enviar o pedido. Tente novamente.');
    });
  });
})();