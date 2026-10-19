<?php
/**
 * InterFi - Português / English.
 * Idioma: ?lang=pt ou ?lang=en; preferência guardada em cookie.
 * Textos: edite lang/en.json sem duplicar o HTML.
 */
$choice = $_GET['lang'] ?? null;
if ($choice !== 'pt' && $choice !== 'en') {
    $choice = null;
}
$lang = $choice ?? ((($_COOKIE['interfi_lang'] ?? '') === 'en') ? 'en' : 'pt');
if ($choice !== null) {
    setcookie('interfi_lang', $lang, [
        'expires' => time() + 365 * 24 * 60 * 60,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}
header('Cache-Control: private, max-age=0, must-revalidate');
header('Content-Language: ' . ($lang === 'en' ? 'en-GB' : 'pt-PT'));
$translations = json_decode(file_get_contents(__DIR__ . '/lang/en.json'), true) ?: [];
function t(string $original): string {
    global $lang, $translations;
    return $lang === 'en' ? ($translations[$original] ?? $original) : $original;
}
function e(string $original): string {
    return htmlspecialchars(t($original), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>

<html lang="<?= $lang === "en" ? "en-GB" : "pt-PT" ?>">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1, viewport-fit=cover" name="viewport"/>
<title><?= e('InterFi | Gestão completa para empresas de transporte') ?></title>
<meta content="<?= e('InterFi é uma plataforma completa para gestão de empresas de transporte. Controle frota, manutenção, pneus, abastecimento, documentos, colaboradores, ocorrências e muito mais.') ?>" name="description"/>
<meta content="#011C2F" name="theme-color"/>
<meta content="InterFi Soluções" name="author"/>
<link href="<?= $lang === "en" ? "https://www.interfi.net/?lang=en" : "https://www.interfi.net/" ?>" rel="canonical"/>
<meta content="website" property="og:type"/>
<meta content="InterFi" property="og:site_name"/>
<meta content="<?= $lang === "en" ? "en_GB" : "pt_PT" ?>" property="og:locale"/>
<meta content="<?= e('InterFi | Gestão completa para empresas de transporte') ?>" property="og:title"/>
<meta content="<?= e('Uma plataforma. Toda a operação. Frota, manutenção, pneus, abastecimento, documentos, colaboradores e ocorrências num único ambiente.') ?>" property="og:description"/>
<meta content="<?= $lang === "en" ? "https://www.interfi.net/?lang=en" : "https://www.interfi.net/" ?>" property="og:url"/>
<meta content="assets/screenshots/interfi-modulos.png" property="og:image"/>
<meta content="summary_large_image" name="twitter:card"/>
<meta content="<?= e('InterFi | Gestão completa para empresas de transporte') ?>" name="twitter:title"/>
<meta content="<?= e('Uma plataforma. Toda a operação.') ?>" name="twitter:description"/>
<meta content="assets/screenshots/interfi-modulos.png" name="twitter:image"/>
<link href="assets/brand/favicon.png" rel="icon" type="image/png"/>
<link href="assets/brand/favicon.png" rel="apple-touch-icon"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="css/style.css" rel="stylesheet"/>
<link href="css/responsive.css" rel="stylesheet"/>
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "InterFi",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web",
    "description": <?= json_encode(t("Plataforma completa de gestão para empresas de transporte: frota, manutenção, pneus, abastecimento, documentos, colaboradores, operação e administração."), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>,
    "url": "https://www.interfi.net/",
    "publisher": { "@type": "Organization", "name": "InterFi Soluções" }
  }
  </script>
<link href="https://www.interfi.net/" hreflang="pt-PT" rel="alternate"/><link href="https://www.interfi.net/?lang=en" hreflang="en-GB" rel="alternate"/><link href="https://www.interfi.net/" hreflang="x-default" rel="alternate"/></head>
<body>
<!-- ===== Sprite de ícones ===== -->
<svg aria-hidden="true" class="sprite" focusable="false" xmlns="http://www.w3.org/2000/svg">
<symbol id="i-frota" viewbox="0 0 24 24"><path d="M3 7a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"></path><path d="M3 10h18"></path><path d="M6 17v2M18 17v2"></path><circle cx="7.5" cy="14" r="1.1"></circle><circle cx="16.5" cy="14" r="1.1"></circle></symbol>
<symbol id="i-manutencao" viewbox="0 0 24 24"><path d="M14.7 6.3a4 4 0 0 0 5 5L15 16l-4-4 3.7-5.7Z"></path><path d="m11 12-6.2 6.2a2 2 0 1 0 2.8 2.8L14 15"></path></symbol>
<symbol id="i-pneus" viewbox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="3.4"></circle><path d="M12 3v5.6M12 15.4V21M3 12h5.6M15.4 12H21"></path></symbol>
<symbol id="i-abastecimento" viewbox="0 0 24 24"><path d="M4 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16"></path><path d="M3 21h12"></path><path d="M6 8h6v4H6z"></path><path d="M14 9h3a2 2 0 0 1 2 2v5a1.5 1.5 0 0 0 3 0V9l-2.5-2.5"></path></symbol>
<symbol id="i-documentos" viewbox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"></path><path d="M14 3v5h5"></path><path d="M9 13h6M9 17h4"></path></symbol>
<symbol id="i-colaboradores" viewbox="0 0 24 24"><circle cx="9" cy="8" r="3.4"></circle><path d="M3 20a6 6 0 0 1 12 0"></path><path d="M16.5 5.2a3.4 3.4 0 0 1 0 6.6M17 14.5A6 6 0 0 1 21 20"></path></symbol>
<symbol id="i-ocorrencias" viewbox="0 0 24 24"><path d="M10.3 4.2 2.6 17.4A2 2 0 0 0 4.3 20.5h15.4a2 2 0 0 0 1.7-3.1L13.7 4.2a2 2 0 0 0-3.4 0Z"></path><path d="M12 9.5v4M12 17h.01"></path></symbol>
<symbol id="i-operacao" viewbox="0 0 24 24"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11Z"></path><circle cx="12" cy="10" r="2.6"></circle></symbol>
<symbol id="i-rh" viewbox="0 0 24 24"><path d="M3 8h18v12H3z"></path><path d="M9 8V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path><path d="M3 13h18"></path></symbol>
<symbol id="i-admin" viewbox="0 0 24 24"><path d="M4 21V9l8-5 8 5v12"></path><path d="M9 21v-6h6v6"></path><path d="M2 21h20"></path></symbol>
<symbol id="i-check" viewbox="0 0 24 24"><path d="m4.5 12.5 5 5 10-11"></path></symbol>
<symbol id="i-clock" viewbox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5.2l3.3 2"></path></symbol>
<symbol id="i-chart" viewbox="0 0 24 24"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"></path></symbol>
<symbol id="i-shield" viewbox="0 0 24 24"><path d="M12 3 4.5 6v6c0 4.5 3.2 7.9 7.5 9 4.3-1.1 7.5-4.5 7.5-9V6L12 3Z"></path><path d="m9 12 2 2 4-4"></path></symbol>
<symbol id="i-bus" viewbox="0 0 24 24"><rect height="15" rx="3" width="16" x="4" y="3"></rect><path d="M4 9h16"></path><path d="M7 18v2.5M17 18v2.5"></path><circle cx="8" cy="14.5" r="1"></circle><circle cx="16" cy="14.5" r="1"></circle></symbol>
<symbol id="i-truck" viewbox="0 0 24 24"><path d="M2 6h11v10H2z"></path><path d="M13 9h4l4 3.5V16h-8"></path><circle cx="6.5" cy="18" r="2"></circle><circle cx="17.5" cy="18" r="2"></circle></symbol>
<symbol id="i-car" viewbox="0 0 24 24"><path d="M4 16v3M20 16v3"></path><path d="M3 15v-3l2-5h14l2 5v3a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Z"></path><path d="M5 12h14"></path><circle cx="7" cy="15.5" r=".8"></circle><circle cx="17" cy="15.5" r=".8"></circle></symbol>
<symbol id="i-globe" viewbox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M3 12h18M12 3c2.6 2.6 3.9 5.6 3.9 9S14.6 18.4 12 21c-2.6-2.6-3.9-5.6-3.9-9S9.4 5.6 12 3Z"></path></symbol>
<symbol id="i-pin-multi" viewbox="0 0 24 24"><path d="M7 11.5S3.5 8.9 3.5 6.2a3.5 3.5 0 1 1 7 0C10.5 8.9 7 11.5 7 11.5Z"></path><path d="M17 21s-3.5-2.6-3.5-5.3a3.5 3.5 0 1 1 7 0C20.5 18.4 17 21 17 21Z"></path><path d="M9.5 13.5 14 17"></path></symbol>
<symbol id="i-wrenchbox" viewbox="0 0 24 24"><rect height="12" rx="2" width="19" x="2.5" y="8"></rect><path d="M8 8V5.5A1.5 1.5 0 0 1 9.5 4h5A1.5 1.5 0 0 1 16 5.5V8"></path><path d="M12 12v4"></path></symbol>
<symbol id="i-arrow" viewbox="0 0 24 24"><path d="M5 12h13M13 6l6 6-6 6"></path></symbol>
<symbol id="i-menu" viewbox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"></path></symbol>
<symbol id="i-close" viewbox="0 0 24 24"><path d="M6 6l12 12M18 6 6 18"></path></symbol>
<symbol id="i-spark" viewbox="0 0 24 24"><path d="M12 3v4M12 17v4M3 12h4M17 12h4M6 6l2.6 2.6M15.4 15.4 18 18M18 6l-2.6 2.6M8.6 15.4 6 18"></path></symbol>
</svg>
<a class="skip" href="#inicio"><?= e('Saltar para o conteúdo') ?></a>
<!-- ===== Navbar ===== -->
<header class="nav" id="nav">
<div class="nav__inner">
<a aria-label="<?= e('InterFi — início') ?>" class="logo" href="#inicio">
<img alt="InterFi" class="logo__img" height="92" src="assets/brand/interfi-logo.png" width="175"/>
</a>
<nav aria-label="<?= e('Navegação principal') ?>" class="nav__links" id="navLinks">
<a class="is-active" href="#inicio"><?= e('Início') ?></a>
<a href="#plataforma">Plataforma</a>
<a href="#funcionalidades"><?= e('Funcionalidades') ?></a>
<a href="#solucoes"><?= e('Soluções') ?></a>
<a href="#sobre"><?= e('Sobre') ?></a>
<a href="#contato"><?= e('Contato') ?></a>
<div class="nav__links-cta">
<a class="btn btn--ghost" href="https://dash.interfi.net/gestao/login.php" rel="noopener" target="_blank"><?= e('Entrar') ?></a>
<a class="btn btn--primary" data-close-menu="" href="#contato"><?= e('Solicitar demonstração') ?></a>
</div>
</nav>
<div class="nav__actions"><div aria-label="Idioma / Language" class="lang-switch" role="group"><a aria-current="<?= $lang === "pt" ? "page" : "false" ?>" aria-label="Ver site em português" class="lang-switch__link<?= $lang === "pt" ? " is-active" : "" ?>" data-lang="pt" href="?lang=pt" hreflang="pt-PT" lang="pt-PT">PT</a><span aria-hidden="true" class="lang-switch__divider">/</span><a aria-current="<?= $lang === "en" ? "page" : "false" ?>" aria-label="View site in English" class="lang-switch__link<?= $lang === "en" ? " is-active" : "" ?>" data-lang="en" href="?lang=en" hreflang="en-GB" lang="en-GB">EN</a></div>
<a class="btn btn--ghost" href="https://dash.interfi.net/gestao/login.php" rel="noopener" target="_blank"><?= e('Entrar') ?></a>
<a class="btn btn--primary" href="#contato"><?= e('Solicitar demonstração') ?></a>
<button aria-controls="navLinks" aria-expanded="false" aria-label="<?= e('Abrir menu') ?>" class="nav__toggle" id="navToggle">
<svg aria-hidden="true" class="icon"><use href="#i-menu"></use></svg>
</button>
</div>
</div>
<div aria-hidden="true" class="nav__progress" id="navProgress"></div>
</header>
<main>
<!-- ===== 1. HERO ===== -->
<section class="hero" id="inicio">
<div aria-hidden="true" class="hero__bg">
<div class="hero__glow"></div>
<div class="hero__road"></div>
<div class="hero__grid"></div>
</div>
<div class="wrap hero__inner">
<div class="hero__copy">
<p class="eyebrow reveal"><?= e('Gestão para empresas de transporte') ?></p>
<h1 class="reveal" data-delay="1"><?= e('A gestão da sua frota') ?><br/><?= e('começa aqui.') ?></h1>
<p class="lead reveal" data-delay="2"><?= e('Controle veículos, manutenção, pneus, abastecimento, documentos, colaboradores, ocorrências e toda a operação da sua empresa em uma única plataforma.') ?></p>
<div class="hero__cta reveal" data-delay="3">
<a class="btn btn--primary btn--lg" href="#plataforma"><?= e('Conhecer o InterFi') ?></a>
<a class="btn btn--outline btn--lg" href="#contato"><?= e('Agendar uma demonstração') ?></a>
</div>
<ul class="hero__stats reveal" data-delay="4">
<li><strong data-count="15">0</strong><span><?= e('módulos na plataforma') ?></span></li>
<li><strong data-count="3">0</strong><span><?= e('áreas da empresa') ?></span></li>
<li><strong data-count="1">0</strong><span><?= e('ambiente único') ?></span></li>
</ul>
</div>
<div class="hero__visual reveal" data-delay="3">
<div class="tilt" data-tilt="">
<figure class="screen screen--hero">
<div aria-hidden="true" class="screen__bar"><i></i><i></i><i></i><span><?= e('InterFi · Gestão') ?></span></div>
<picture>
<source srcset="assets/screenshots/interfi-modulos.webp" type="image/webp"/>
<img alt="<?= e('Ecrã de módulos da plataforma InterFi, com os grupos Mecânica, Administração e Operação') ?>" decoding="async" fetchpriority="high" height="898" src="assets/screenshots/interfi-modulos.png" width="1901"/>
</picture>
</figure>
<div class="float float--a" data-float="">
<svg aria-hidden="true" class="icon"><use href="#i-manutencao"></use></svg>
<div><strong><?= e('Ordem de serviço') ?></strong><span><?= e('aberta e rastreada') ?></span></div>
</div>
<div class="float float--b" data-float="">
<svg aria-hidden="true" class="icon"><use href="#i-documentos"></use></svg>
<div><strong><?= e('Validades') ?></strong><span><?= e('acompanhadas por veículo') ?></span></div>
</div>
<div class="float float--c" data-float="">
<svg aria-hidden="true" class="icon"><use href="#i-pneus"></use></svg>
<div><strong><?= e('Pneu 03') ?></strong><span><?= e('posição e histórico') ?></span></div>
</div>
</div>
<p class="hero__caption"><?= e('Uma plataforma. Toda a operação.') ?></p>
</div>
</div>
</section>
<!-- ===== 2. PROBLEMA ===== -->
<section class="sec sec--problema on-light" id="problema">
<div class="wrap grid-2">
<div class="reveal">
<p class="eyebrow"><?= e('O problema') ?></p>
<h2><?= e('Quanto da sua operação ainda depende de planilhas, papéis e informação espalhada?') ?></h2>
<p class="body"><?= e('Uma empresa de transporte precisa controlar milhares de informações todos os dias.') ?></p>
<p class="body"><?= e('Quanto maior a operação, maior a quantidade de informação que precisa ser gerida.') ?></p>
<blockquote class="quote">
<svg aria-hidden="true" class="icon"><use href="#i-spark"></use></svg>
<p><?= e('O problema não é ter informação.') ?><br/><b><?= e('É conseguir transformá-la em controle.') ?></b></p>
</blockquote>
</div>
<div aria-hidden="false" class="converge reveal" data-delay="1">
<ul class="converge__grid">
<li class="scrub-in" data-c="1"><svg aria-hidden="true" class="icon"><use href="#i-frota"></use></svg><?= e('Veículos') ?></li>
<li class="scrub-in" data-c="2"><svg aria-hidden="true" class="icon"><use href="#i-manutencao"></use></svg><?= e('Manutenção') ?></li>
<li class="scrub-in" data-c="3"><svg aria-hidden="true" class="icon"><use href="#i-pneus"></use></svg><?= e('Pneus') ?></li>
<li class="scrub-in" data-c="4"><svg aria-hidden="true" class="icon"><use href="#i-abastecimento"></use></svg><?= e('Combustível') ?></li>
<li class="scrub-in" data-c="5"><svg aria-hidden="true" class="icon"><use href="#i-documentos"></use></svg><?= e('Documentos') ?></li>
<li class="scrub-in" data-c="6"><svg aria-hidden="true" class="icon"><use href="#i-colaboradores"></use></svg><?= e('Colaboradores') ?></li>
<li class="scrub-in" data-c="7"><svg aria-hidden="true" class="icon"><use href="#i-ocorrencias"></use></svg><?= e('Ocorrências') ?></li>
<li class="scrub-in" data-c="8"><svg aria-hidden="true" class="icon"><use href="#i-operacao"></use></svg><?= e('Operação') ?></li>
</ul>
<div class="converge__target"><span class="logo__text sm">inter<span>Fi</span></span></div>
</div>
</div>
</section>
<!-- ===== 3. PLATAFORMA ===== -->
<section class="sec sec--plataforma on-light" id="plataforma">
<div class="wrap grid-2 grid-2--wide">
<div class="reveal">
<p class="eyebrow"><?= e('Conheça o InterFi') ?></p>
<h2><?= e('Tudo o que a sua empresa precisa. Em um só lugar.') ?></h2>
<p class="body"><?= e('O InterFi reúne em uma única plataforma as principais áreas da gestão de uma empresa de transporte.') ?></p>
<ul class="ticks">
<li><svg aria-hidden="true" class="icon"><use href="#i-check"></use></svg><?= e('Mecânica: manutenção, pneus, estoque, frota, abastecimento, lubrificação e higienização') ?></li>
<li><svg aria-hidden="true" class="icon"><use href="#i-check"></use></svg><?= e('Administração: RH, administração, contabilidade e comunicação interna') ?></li>
<li><svg aria-hidden="true" class="icon"><use href="#i-check"></use></svg><?= e('Operação: apontamento, fiscalização e ocorrências') ?></li>
</ul>
<a class="btn btn--outline" href="#funcionalidades"><?= e('Ver todas as funcionalidades') ?></a>
</div>
<figure class="screen screen--perspective scrub-tilt">
<div aria-hidden="true" class="screen__bar"><i></i><i></i><i></i><span><?= e('interfi.net · Módulos') ?></span></div>
<picture>
<source srcset="assets/screenshots/interfi-modulos.webp" type="image/webp"/>
<img alt="<?= e('Painel de módulos do InterFi com Manutenção, Pneus, Estoque, Frota, Abastecimento, Lubrificação e Higienização') ?>" decoding="async" height="898" loading="lazy" src="assets/screenshots/interfi-modulos.png" width="1901"/>
</picture>
<figcaption><?= e('Ecrã real da plataforma InterFi') ?></figcaption>
</figure>
</div>
</section>
<!-- ===== 4. FUNCIONALIDADES ===== -->
<section class="sec sec--features on-light" id="funcionalidades">
<div class="wrap">
<header class="sec__head reveal">
<p class="eyebrow"><?= e('Funcionalidades') ?></p>
<h2><?= e('Mais do que gestão de frota.') ?><br/><?= e('É gestão da sua operação.') ?></h2>
</header>
<div class="cards">
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-frota"></use></svg>
<h3><?= e('Frota') ?></h3>
<p><?= e('Tenha uma visão completa dos seus veículos, dados, documentação e histórico.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-manutencao"></use></svg>
<h3><?= e('Manutenção') ?></h3>
<p><?= e('Controle ordens de serviço, manutenções, intervenções, peças, custos e histórico.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-pneus"></use></svg>
<h3><?= e('Pneus') ?></h3>
<p><?= e('Controle posições, movimentações, quilometragem, desgaste e histórico dos pneus.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-abastecimento"></use></svg>
<h3><?= e('Abastecimento') ?></h3>
<p><?= e('Registre abastecimentos, consumo, quilometragem e custos.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-documentos"></use></svg>
<h3><?= e('Documentos') ?></h3>
<p><?= e('Controle documentos e validades de veículos e colaboradores.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-colaboradores"></use></svg>
<h3><?= e('Colaboradores') ?></h3>
<p><?= e('Centralize informações e documentos da sua equipe.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-ocorrencias"></use></svg>
<h3><?= e('Ocorrências') ?></h3>
<p><?= e('Registre anomalias e ocorrências e acompanhe sua resolução.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
<article class="card scrub-in" data-tilt-soft="">
<svg aria-hidden="true" class="icon icon--lg"><use href="#i-operacao"></use></svg>
<h3><?= e('Operação') ?></h3>
<p><?= e('Centralize apontamentos, fiscalização e informações operacionais.') ?></p>
<span aria-hidden="true" class="card__line"></span>
</article>
</div>
</div>
</section>
<!-- ===== 5. FROTA ===== -->
<section class="sec sec--frota on-light">
<div class="wrap grid-2 grid-2--rev">
<figure class="screen screen--perspective screen--left scrub-tilt">
<div aria-hidden="true" class="screen__bar"><i></i><i></i><i></i><span><?= e('InterFi · Mecânica') ?></span></div>
<picture>
<source srcset="assets/screenshots/interfi-mecanica.webp" type="image/webp"/>
<img alt="<?= e('Módulos de mecânica do InterFi: manutenção, pneus, estoque, frota e abastecimento') ?>" decoding="async" height="720" loading="lazy" src="assets/screenshots/interfi-mecanica.png" width="1410"/>
</picture>
</figure>
<div class="reveal" data-delay="1">
<p class="eyebrow"><?= e('Frota') ?></p>
<h2><?= e('Conheça cada veículo da sua operação.') ?></h2>
<p class="body"><?= e('Tenha acesso centralizado às informações da sua frota e acompanhe o histórico de cada veículo.') ?></p>
<ul class="chips">
<li><?= e('Dados do veículo') ?></li><li><?= e('Documentação') ?></li><li><?= e('Manutenção') ?></li><li><?= e('Custos') ?></li>
<li><?= e('Abastecimento') ?></li><li><?= e('Pneus') ?></li><li><?= e('Histórico') ?></li><li><?= e('Ocorrências') ?></li>
</ul>
<a class="btn btn--primary" href="#contato"><?= e('Solicitar demonstração') ?></a>
</div>
</div>
</section>
<!-- ===== 6. MANUTENÇÃO ===== -->
<section class="sec sec--flow on-light">
<div class="pin-scrub" data-pin="" data-steps="7">
<div class="pin-scrub__sticky">
<div class="wrap">
<header class="sec__head sec__head--left reveal">
<p class="eyebrow"><?= e('Manutenção') ?></p>
<h2><?= e('Manutenção não precisa ser uma caixa-preta.') ?></h2>
<p class="body"><?= e('Saiba o que está acontecendo com cada veículo, quais serviços estão pendentes e todo o histórico de intervenções realizadas.') ?></p>
</header>
<ol class="flow" data-flow="">
<li><span class="flow__n">1</span><?= e('Anomalia') ?></li>
<li><span class="flow__n">2</span><?= e('Ordem de serviço') ?></li>
<li><span class="flow__n">3</span><?= e('Diagnóstico') ?></li>
<li><span class="flow__n">4</span><?= e('Manutenção') ?></li>
<li><span class="flow__n">5</span><?= e('Execução') ?></li>
<li><span class="flow__n">6</span><?= e('Encerramento') ?></li>
<li><span class="flow__n">7</span><?= e('Histórico') ?></li>
</ol>
<div aria-hidden="true" class="flow-progress"><span class="flow-progress__bar" data-flow-bar=""></span></div>
<p class="pull"><?= e('Da anomalia à solução. Tudo registrado.') ?></p>
</div>
</div>
</div>
</section>
<!-- ===== 7. DOCUMENTOS ===== -->
<section class="sec sec--docs">
<div class="wrap grid-2">
<div class="reveal">
<p class="eyebrow"><?= e('Documentos e validades') ?></p>
<h2><?= e('Não espere o vencimento para descobrir o problema.') ?></h2>
<p class="body"><?= e('O InterFi permite acompanhar as validades e informações importantes de veículos, colaboradores e documentação.') ?></p>
<p class="note"><?= e('Os prazos apresentados ao lado são apenas exemplos visuais.') ?></p>
</div>
<ul class="docs">
<li class="scrub-in"><div><svg aria-hidden="true" class="icon"><use href="#i-shield"></use></svg><strong><?= e('Seguro') ?></strong></div><span class="tag tag--warn"><?= e('12 dias') ?></span></li>
<li class="scrub-in"><div><svg aria-hidden="true" class="icon"><use href="#i-wrenchbox"></use></svg><strong><?= e('Inspeção') ?></strong></div><span class="tag tag--warn"><?= e('23 dias') ?></span></li>
<li class="scrub-in"><div><svg aria-hidden="true" class="icon"><use href="#i-documentos"></use></svg><strong><?= e('Licença') ?></strong></div><span class="tag"><?= e('47 dias') ?></span></li>
<li class="scrub-in"><div><svg aria-hidden="true" class="icon"><use href="#i-frota"></use></svg><strong>CAM</strong></div><span class="tag"><?= e('63 dias') ?></span></li>
<li class="scrub-in"><div><svg aria-hidden="true" class="icon"><use href="#i-colaboradores"></use></svg><strong><?= e('Carta de condução') ?></strong></div><span class="tag"><?= e('90 dias') ?></span></li>
<li class="scrub-in"><div><svg aria-hidden="true" class="icon"><use href="#i-clock"></use></svg><strong><?= e('Documentos') ?></strong></div><span class="tag"><?= e('em dia') ?></span></li>
</ul>
</div>
</section>
<!-- ===== 8. PNEUS ===== -->
<section class="sec sec--pneus">
<div class="wrap grid-2 grid-2--rev">
<div aria-hidden="true" class="tire scrub-in scrub-tire">
<div class="tire__wheel"><span></span></div>
<em class="tire__tag tire__tag--1"><?= e('Posição') ?></em>
<em class="tire__tag tire__tag--2"><?= e('Quilometragem') ?></em>
<em class="tire__tag tire__tag--3"><?= e('Movimentação') ?></em>
<em class="tire__tag tire__tag--4"><?= e('Desgaste') ?></em>
<em class="tire__tag tire__tag--5"><?= e('Histórico') ?></em>
</div>
<div class="reveal" data-delay="1">
<p class="eyebrow"><?= e('Pneus') ?></p>
<h2><?= e('Controle cada pneu.') ?></h2>
<p class="body"><?= e('Saiba onde cada pneu está, em qual veículo foi utilizado, suas movimentações e seu histórico.') ?></p>
<a class="btn btn--outline" href="#contato"><?= e('Ver na prática') ?></a>
</div>
</div>
</section>
<!-- ===== 9. ABASTECIMENTO ===== -->
<section class="sec sec--fuel on-light">
<div class="wrap grid-2">
<div class="reveal">
<p class="eyebrow"><?= e('Abastecimento') ?></p>
<h2><?= e('Cada abastecimento gera informação.') ?></h2>
<p class="body"><?= e('Registre e acompanhe o abastecimento da sua frota e transforme esses dados em informação para gestão.') ?></p>
</div>
<ul class="metrics">
<li class="scrub-in"><svg aria-hidden="true" class="icon"><use href="#i-chart"></use></svg><strong><?= e('Consumo') ?></strong><span><?= e('por veículo e período') ?></span></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon"><use href="#i-frota"></use></svg><strong><?= e('Quilometragem') ?></strong><span><?= e('registada a cada abastecimento') ?></span></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon"><use href="#i-abastecimento"></use></svg><strong><?= e('Custos') ?></strong><span><?= e('acompanhados ao longo do tempo') ?></span></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon"><use href="#i-clock"></use></svg><strong><?= e('Histórico') ?></strong><span><?= e('tudo fica registado') ?></span></li>
</ul>
</div>
</section>
<!-- ===== 10. OCORRÊNCIAS ===== -->
<section class="sec sec--flow sec--flow-alt on-light">
<div class="pin-scrub" data-pin="" data-steps="6">
<div class="pin-scrub__sticky">
<div class="wrap">
<header class="sec__head sec__head--left reveal">
<p class="eyebrow"><?= e('Ocorrências e anomalias') ?></p>
<h2><?= e('Um problema identificado não pode desaparecer no meio da operação.') ?></h2>
<p class="body"><?= e('Registre anomalias, ocorrências e situações identificadas na operação e acompanhe cada caso até sua resolução.') ?></p>
</header>
<ol class="flow" data-flow="">
<li><span class="flow__n">1</span><?= e('Anomalia') ?></li>
<li><span class="flow__n">2</span><?= e('Registro') ?></li>
<li><span class="flow__n">3</span><?= e('Análise') ?></li>
<li><span class="flow__n">4</span><?= e('Ação') ?></li>
<li><span class="flow__n">5</span><?= e('Resolução') ?></li>
<li><span class="flow__n">6</span><?= e('Histórico') ?></li>
</ol>
<div aria-hidden="true" class="flow-progress"><span class="flow-progress__bar" data-flow-bar=""></span></div>
</div>
</div>
</div>
</section>
<!-- ===== 11. TUDO CONECTADO ===== -->
<section class="sec sec--hub" id="sobre">
<div class="pin-scrub pin-scrub--hub" data-pin="">
<div class="pin-scrub__sticky">
<div class="wrap grid-2 grid-2--hub">
<div class="reveal">
<h2><?= e('Tudo conectado.') ?></h2>
<p class="sub"><?= e('Informação isolada não gera gestão.') ?></p>
<p class="body"><?= e('Quando os dados da sua operação estão conectados, você consegue enxergar o todo.') ?></p>
<a class="btn btn--primary" href="#contato"><?= e('Ver na prática') ?></a>
</div>
<div class="hub" data-hub="">
<svg aria-hidden="true" class="hub__lines" viewbox="0 0 520 520">
<circle class="hub__ring" cx="260" cy="260" r="198"></circle>
<circle class="hub__ring hub__ring--2" cx="260" cy="260" r="120"></circle>
<g class="hub__spokes">
<line style="--start:.10" x1="260" x2="260" y1="260" y2="62"></line>
<line style="--start:.17" x1="260" x2="400" y1="260" y2="120"></line>
<line style="--start:.24" x1="260" x2="458" y1="260" y2="260"></line>
<line style="--start:.31" x1="260" x2="400" y1="260" y2="400"></line>
<line style="--start:.38" x1="260" x2="260" y1="260" y2="458"></line>
<line style="--start:.45" x1="260" x2="120" y1="260" y2="400"></line>
<line style="--start:.52" x1="260" x2="62" y1="260" y2="260"></line>
<line style="--start:.59" x1="260" x2="120" y1="260" y2="120"></line>
</g>
</svg>
<div class="hub__core"><span class="logo__text sm">inter<span>Fi</span></span></div>
<ul class="hub__nodes">
<li style="--x:50%;--y:12%;--start:.10"><svg aria-hidden="true" class="icon"><use href="#i-frota"></use></svg><?= e('Frota') ?></li>
<li style="--x:76.9%;--y:23.1%;--start:.17"><svg aria-hidden="true" class="icon"><use href="#i-manutencao"></use></svg><?= e('Manutenção') ?></li>
<li style="--x:88%;--y:50%;--start:.24"><svg aria-hidden="true" class="icon"><use href="#i-pneus"></use></svg><?= e('Pneus') ?></li>
<li style="--x:76.9%;--y:76.9%;--start:.31"><svg aria-hidden="true" class="icon"><use href="#i-abastecimento"></use></svg><?= e('Abastecimento') ?></li>
<li style="--x:50%;--y:88%;--start:.38"><svg aria-hidden="true" class="icon"><use href="#i-documentos"></use></svg><?= e('Documentos') ?></li>
<li style="--x:23.1%;--y:76.9%;--start:.45"><svg aria-hidden="true" class="icon"><use href="#i-rh"></use></svg><?= e('RH') ?></li>
<li style="--x:12%;--y:50%;--start:.52"><svg aria-hidden="true" class="icon"><use href="#i-operacao"></use></svg><?= e('Operação') ?></li>
<li style="--x:23.1%;--y:23.1%;--start:.59"><svg aria-hidden="true" class="icon"><use href="#i-admin"></use></svg><?= e('Administração') ?></li>
</ul>
</div>
</div>
</div>
</div>
</section>
<!-- ===== 12. MEMÓRIA OPERACIONAL ===== -->
<section class="sec sec--memoria on-light">
<div class="wrap">
<div class="memoria">
<div class="reveal">
<h2><?= e('Tudo deixa um histórico.') ?></h2>
<ul class="memoria__list">
<li><?= e('Veículos.') ?></li><li><?= e('Manutenções.') ?></li><li><?= e('Pneus.') ?></li><li><?= e('Abastecimentos.') ?></li>
<li><?= e('Ocorrências.') ?></li><li><?= e('Documentos.') ?></li><li><?= e('Pessoas.') ?></li>
</ul>
</div>
<p class="pull pull--big reveal" data-delay="1"><?= e('O InterFi cria uma memória operacional da sua empresa.') ?></p>
</div>
</div>
</section>
<!-- ===== 13. PARA QUEM É ===== -->
<section class="sec sec--light on-light" id="solucoes">
<div class="wrap">
<header class="sec__head sec__head--left reveal">
<p class="eyebrow"><?= e('Soluções') ?></p>
<h2><?= e('Feito para quem vive o transporte.') ?></h2>
<p class="body"><?= e('Se a sua empresa possui veículos, pessoas, manutenção e operação, o InterFi foi desenvolvido para si.') ?></p>
</header>
<ul class="audience">
<li class="scrub-in"><svg aria-hidden="true" class="icon icon--lg"><use href="#i-bus"></use></svg><?= e('Transporte de passageiros') ?></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon icon--lg"><use href="#i-truck"></use></svg><?= e('Transporte rodoviário') ?></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon icon--lg"><use href="#i-car"></use></svg><?= e('Frotas de ligeiros e pesados') ?></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon icon--lg"><use href="#i-globe"></use></svg><?= e('Turismo e fretamento') ?></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon icon--lg"><use href="#i-pin-multi"></use></svg><?= e('Empresas com múltiplas bases') ?></li>
<li class="scrub-in"><svg aria-hidden="true" class="icon icon--lg"><use href="#i-wrenchbox"></use></svg><?= e('Oficinas e manutenção') ?></li>
</ul>
</div>
</section>
<!-- ===== 14. VALOR ===== -->
<section class="sec sec--valor on-light">
<div class="wrap grid-2">
<div class="reveal">
<h2><?= e('Quanto custa não ter controle?') ?></h2>
<p class="body"><?= e('Pequenas falhas de informação podem gerar grandes impactos na operação.') ?></p>
<p class="pull"><?= e('O InterFi ajuda sua empresa a transformar informação em controle.') ?></p>
<a class="btn btn--primary btn--lg" href="#contato"><?= e('Solicitar demonstração') ?></a>
</div>
<ul class="risks">
<li class="scrub-in"><?= e('Uma manutenção esquecida.') ?></li>
<li class="scrub-in"><?= e('Um documento vencido.') ?></li>
<li class="scrub-in"><?= e('Um veículo parado.') ?></li>
<li class="scrub-in"><?= e('Um pneu sem histórico.') ?></li>
<li class="scrub-in"><?= e('Um abastecimento sem controle.') ?></li>
<li class="scrub-in"><?= e('Uma ocorrência que não foi registrada.') ?></li>
</ul>
</div>
</section>
<!-- ===== 15. DEMONSTRAÇÃO ===== -->
<section class="sec sec--demo" id="contato">
<div class="wrap grid-2 grid-2--form">
<div class="reveal">
<p class="eyebrow"><?= e('Demonstração') ?></p>
<h2><?= e('Quer ver o InterFi em funcionamento?') ?></h2>
<p class="body"><?= e('Solicite uma demonstração e conheça como a plataforma pode ser aplicada à realidade da sua empresa.') ?></p>
<ul class="ticks ticks--sm">
<li><svg aria-hidden="true" class="icon"><use href="#i-check"></use></svg><?= e('Apresentação guiada da plataforma') ?></li>
<li><svg aria-hidden="true" class="icon"><use href="#i-check"></use></svg><?= e('Sem compromisso') ?></li>
<li><svg aria-hidden="true" class="icon"><use href="#i-check"></use></svg><?= e('Resposta em até um dia útil') ?></li>
</ul>
</div>
<form class="form reveal" data-delay="1" id="demoForm" novalidate="">
<div class="field">
<label for="nome"><?= e('Nome') ?></label>
<input autocomplete="name" id="nome" minlength="2" name="nome" placeholder="<?= e('O seu nome') ?>" required="" type="text"/>
<small class="err" data-err=""></small>
</div>
<div class="field">
<label for="empresa"><?= e('Empresa') ?></label>
<input autocomplete="organization" id="empresa" minlength="2" name="empresa" placeholder="<?= e('Nome da empresa') ?>" required="" type="text"/>
<small class="err" data-err=""></small>
</div>
<div class="field">
<label for="email">E-mail</label>
<input autocomplete="email" id="email" name="email" placeholder="nome@empresa.com" required="" type="email"/>
<small class="err" data-err=""></small>
</div>
<div class="field">
<label for="telefone"><?= e('Telefone') ?></label>
<input autocomplete="tel" id="telefone" name="telefone" placeholder="+351 000 000 000" required="" type="tel"/>
<small class="err" data-err=""></small>
</div>
<div class="field field--full">
<label for="veiculos"><?= e('Número de veículos') ?></label>
<select id="veiculos" name="veiculos" required="">
<option value=""><?= e('Selecione uma opção') ?></option>
<option><?= e('1 a 10') ?></option>
<option><?= e('11 a 30') ?></option>
<option><?= e('31 a 80') ?></option>
<option><?= e('81 a 200') ?></option>
<option><?= e('Mais de 200') ?></option>
</select>
<small class="err" data-err=""></small>
</div>
<div class="field field--full">
<label for="mensagem"><?= e('Mensagem') ?></label>
<textarea id="mensagem" name="mensagem" placeholder="<?= e('Conte-nos um pouco sobre a sua operação (opcional)') ?>" rows="4"></textarea>
<small class="err" data-err=""></small>
</div>
<button class="btn btn--primary btn--lg btn--block" type="submit"><?= e('Solicitar demonstração') ?></button>
<p aria-live="polite" class="form__status" id="formStatus" role="status"></p>
</form>
</div>
</section>
</main>
<!-- ===== FOOTER ===== -->
<footer class="footer">
<div class="wrap">
<div class="footer__top">
<div class="footer__brand">
<a aria-label="<?= e('InterFi — início') ?>" class="logo" href="#inicio">
<img alt="InterFi" class="logo__img" height="284" loading="lazy" src="assets/brand/interfi-logo.png" width="700"/>
</a>
<p class="footer__claim"><?= e('O futuro da mobilidade começa aqui.') ?></p>
<p class="footer__desc"><?= e('Plataforma de gestão para empresas de transporte.') ?></p>
</div>
<nav aria-label="<?= e('Módulos') ?>" class="footer__nav">
<h3>Plataforma</h3>
<ul>
<li><a href="#funcionalidades"><?= e('Frota') ?></a></li>
<li><a href="#funcionalidades"><?= e('Manutenção') ?></a></li>
<li><a href="#funcionalidades"><?= e('Operação') ?></a></li>
<li><a href="#funcionalidades"><?= e('Pneus') ?></a></li>
</ul>
</nav>
<nav aria-label="<?= e('Mais módulos') ?>" class="footer__nav">
<h3><?= e('Módulos') ?></h3>
<ul>
<li><a href="#funcionalidades"><?= e('Abastecimento') ?></a></li>
<li><a href="#funcionalidades"><?= e('Documentos') ?></a></li>
<li><a href="#funcionalidades"><?= e('RH') ?></a></li>
<li><a href="#funcionalidades"><?= e('Administração') ?></a></li>
</ul>
</nav>
<nav aria-label="<?= e('Empresa') ?>" class="footer__nav">
<h3><?= e('Empresa') ?></h3>
<ul>
<li><a href="#sobre"><?= e('Sobre') ?></a></li>
<li><a href="#contato"><?= e('Contato') ?></a></li>
<li><a href="#privacidade"><?= e('Política de Privacidade') ?></a></li>
<li><a href="#termos"><?= e('Termos de Uso') ?></a></li>
</ul>
</nav>
</div>
<p aria-hidden="true" class="footer__line"></p>
<div class="footer__bottom">
<p>© <span id="year">2026</span> <?= e('InterFi Soluções. Todos os direitos reservados.') ?></p>
<a class="btn btn--primary btn--sm" href="#contato"><?= e('Solicitar demonstração') ?></a>
</div>
</div>
</footer>
<!-- ==========================================
        ASSINATURA
        ========================================== -->
<style>
      .developer-credit {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin: 0;
        padding: 16px 20px;
        background-color: #090909;
        border-top: 1px solid #222;
        box-sizing: border-box;
        text-align: center;
      }
      .developer-credit,
      .developer-credit * {
        font-family: Arial, sans-serif;
        box-sizing: border-box;
      }
      .developer-credit span {
        color: #888;
        font-size: 15px;
        font-weight: 400;
        letter-spacing: .04em;
        line-height: 1.6;
      }
      .developer-credit a {
        display: inline;
        color: #bbb;
        font-size: inherit;
        text-decoration: none;
        transition: color .3s ease;
      }
      .developer-credit a:hover {
        color: #c9a227;
      }
    </style>
<div class="developer-credit">
<span>
            <?= e('Produzido por') ?>
            <a href="https://guilhermegregorio.com/" rel="noopener noreferrer" target="_blank">
                Guilherme Gregório
            </a>
            © 2026
        </span>
</div>
<a aria-label="<?= e('Voltar ao topo') ?>" class="totop" href="#inicio" id="toTop">
<svg aria-hidden="true" class="icon"><use href="#i-arrow"></use></svg>
</a>
<script defer="" src="js/animations.js"></script>
<script defer="" src="js/main.js"></script>
<script>window.interfiTranslations = <?= json_encode($lang === "en" ? $translations : [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script></body>
</html>

