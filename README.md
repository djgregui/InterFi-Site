# InterFi — Site Institucional

Site comercial de divulgação e captação de clientes para a plataforma InterFi.
Código estático: abre diretamente no navegador com duplo clique em `index.html`.

🌐 **Site:** https://www.interfi.net/

📦 **Repositório:** https://github.com/djgregui/InterFi-Site


## Prévia do site

<img width="1898" height="833" alt="print site" src="https://github.com/user-attachments/assets/be780cdd-f104-4a17-adcc-b7271553d019" />

<img width="1917" height="906" alt="print site2" src="https://github.com/user-attachments/assets/c9ab5781-ccf1-4bd5-9d18-0afe9a82786d" />

<img width="1918" height="906" alt="print site5" src="https://github.com/user-attachments/assets/1d5cd63c-9911-4a1c-9687-2d170528cc5f" />

<img width="1919" height="909" alt="print site4" src="https://github.com/user-attachments/assets/6bf57b7c-d998-459c-b9f7-917420ebba5e" />

<img width="1918" height="905" alt="print site3" src="https://github.com/user-attachments/assets/a48864c7-95a2-40fc-b8b9-5462a723457a" />


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
