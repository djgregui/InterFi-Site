# InterFi — site institucional

Site comercial de divulgação e captação de clientes para a plataforma InterFi.
Código estático: abre diretamente no navegador com duplo clique em `index.html`.

## Estrutura

```
interfi-site/
├── index.html                 página única, HTML semântico + SEO + schema.org
├── css/
│   ├── style.css              tokens, componentes, secções
│   └── responsive.css         desktop → notebook → tablet → telemóvel
├── js/
│   ├── animations.js          reveals, contadores, tilt 3D, parallax
│   └── main.js                navbar, menu mobile, progresso, formulário
└── assets/
    └── screenshots/
        ├── interfi-modulos.webp / .png    ecrã de módulos (real)
        ├── interfi-mecanica.webp / .png   recorte do grupo Mecânica (real)
        └── interfi-login.webp / .png      ecrã de login (real, reserva)
```

## Decisões técnicas

- **Sem frameworks.** Só HTML5, CSS3 e JavaScript ES5. Não há Bootstrap, GSAP nem
  Three.js: tudo o que era pedido (glassmorphism, parallax, tilt, contadores,
  linhas animadas) cabe em CSS + IntersectionObserver, e o site fica bem mais leve.
- **Ícones em SVG inline** (sprite `<symbol>` no topo do HTML) em vez de Font Awesome:
  zero pedidos de rede, herdam a cor da marca.
- **Tipografia:** Space Grotesk (títulos, carácter técnico) + Inter (texto).
- **Imagens:** WebP com fallback PNG via `<picture>`, `loading="lazy"` em tudo
  abaixo da dobra, `width`/`height` declarados para evitar reflow.
- **Performance:** scripts `defer`, scroll com `requestAnimationFrame` e listeners
  passivos, animações reduzidas automaticamente em dispositivos fracos
  (`hardwareConcurrency`/`deviceMemory`) e com `prefers-reduced-motion`.

## Screenshots

Os ecrãs reais do InterFi não foram redesenhados nem editados. Só receberam
moldura, perspetiva, sombra e reflexo através de CSS. `interfi-mecanica` é um
recorte ampliado do mesmo ecrã de módulos, sem alteração de interface.

## Formulário

A validação de frontend está completa (nome, empresa, e-mail, telefone, número de
veículos). O envio está simulado em `js/main.js`, no bloco marcado com comentário —
basta trocar por um `fetch` para o endpoint real ou para um serviço de formulários.

## Imagens a substituir

O hero usa uma composição gerada em CSS (halo, grelha, marcas de estrada). Quando
existirem fotografias/renders próprios de frota — noturnos ou golden hour, azul
escuro com detalhes laranja — podem entrar como camada de fundo em `.hero__bg`,
em `assets/images/`.
