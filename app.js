const app = document.getElementById("app");

const categories = {
  objetos: {
    id: "objetos",
    navTitle: "Objetos",
    navIcon: "🎁",
    heroTitle: "Vauchis Objetos",
    heroSubtitle: "Regalá productos y marcas increíbles",
    heroText: "Los mejores regalos en un solo lugar.",
    rubros: [
      { icon: "💻", name: "Tecnología" },
      { icon: "🏠", name: "Hogar" },
      { icon: "👜", name: "Moda" },
      { icon: "⚽", name: "Deportes" },
      { icon: "💄", name: "Belleza" },
      { icon: "🧸", name: "Jugueterías" },
      { icon: "☕", name: "Gourmet" },
      { icon: "🐾", name: "Mascotas" }
    ],
    logos: [
      [
        {
          name: "Samsung",
          src: "https://cdn.simpleicons.org/samsung/1428A0"
        },
        {
          name: "Sony",
          src: "https://cdn.simpleicons.org/sony/000000"
        },
        {
          name: "Adidas",
          src: "https://cdn.simpleicons.org/adidas/000000"
        },
        {
          name: "Nike",
          src: "https://cdn.simpleicons.org/nike/111111"
        }
      ],
      [
        {
          name: "Starbucks",
          src: "https://cdn.simpleicons.org/starbucks/006241"
        },
        {
          name: "Levi's",
          src: "https://cdn.simpleicons.org/levis/C41230"
        },
        {
          name: "Apple",
          src: "https://cdn.simpleicons.org/apple/000000"
        },
        {
          name: "Xiaomi",
          src: "https://cdn.simpleicons.org/xiaomi/FF6900"
        }
      ],
      [
        {
          name: "Puma",
          src: "https://cdn.simpleicons.org/puma/242B2F"
        },
        {
          name: "LG",
          src: "https://cdn.simpleicons.org/lg/A50034"
        },
        {
          name: "PlayStation",
          src: "https://cdn.simpleicons.org/playstation/003791"
        },
        {
          name: "HP",
          src: "https://cdn.simpleicons.org/hp/0096D6"
        }
      ]
    ],
    navDescription:
      "Tecnología, hogar, moda y más, con marcas reconocidas y opciones de regalo para todos."
  },

  experiencias: {
    id: "experiencias",
    navTitle: "Experiencias",
    navIcon: "✨",
    heroTitle: "Vauchis Experiencias",
    heroSubtitle: "Regalá momentos únicos para disfrutar",
    heroText: "Spa, estadías y turismo en un solo lugar.",
    rubros: [
      { icon: "🧖", name: "Spa" },
      { icon: "🏨", name: "Estadías" },
      { icon: "✈️", name: "Turismo" },
      { icon: "🍽️", name: "Gastronomía" },
      { icon: "🍷", name: "Catas" },
      { icon: "🎭", name: "Cultura" },
      { icon: "⛵", name: "Aventura" },
      { icon: "🌿", name: "Bienestar" }
    ],
    logos: [
      [
        {
          name: "Airbnb",
          src: "https://cdn.simpleicons.org/airbnb/FF5A5F"
        },
        {
          name: "Booking.com",
          src: "https://cdn.simpleicons.org/bookingdotcom/003580"
        },
        {
          name: "Tripadvisor",
          src: "https://cdn.simpleicons.org/tripadvisor/34E0A1"
        },
        {
          name: "Expedia",
          src: "https://cdn.simpleicons.org/expedia/1D63ED"
        }
      ],
      [
        {
          name: "Hilton",
          src: "https://cdn.simpleicons.org/hilton/124D97"
        },
        {
          name: "Marriott",
          src: "https://cdn.simpleicons.org/marriott/BF9D5E"
        },
        {
          name: "Ibis",
          src: "https://cdn.simpleicons.org/accor/000000"
        },
        {
          name: "Uber Eats",
          src: "https://cdn.simpleicons.org/ubereats/06C167"
        }
      ],
      [
        {
          name: "Skyscanner",
          src: "https://cdn.simpleicons.org/skyscanner/0770E3"
        },
        {
          name: "Kayak",
          src: "https://cdn.simpleicons.org/kayak/FF690F"
        },
        {
          name: "GetYourGuide",
          src: "https://cdn.simpleicons.org/getyourguide/FFCD00"
        },
        {
          name: "Lonely Planet",
          src: "https://cdn.simpleicons.org/lonelyplanet/005DAA"
        }
      ]
    ],
    navDescription:
      "Vouchers para spa, escapadas, turismo y experiencias memorables para regalar distinto."
  },

  impacto: {
    id: "impacto",
    navTitle: "Impacto social",
    navIcon: "🤝",
    heroTitle: "Vauchis Impacto Social",
    heroSubtitle: "Regalá con propósito y valor compartido",
    heroText: "Elegí vouchers de ONG, artesanos y proyectos con impacto.",
    rubros: [
      { icon: "🤝", name: "ONG" },
      { icon: "🧶", name: "Artesanos" },
      { icon: "🌱", name: "Proyectos" },
      { icon: "🎓", name: "Educación" },
      { icon: "🌍", name: "Ambiente" },
      { icon: "🏘️", name: "Comunidad" },
      { icon: "🫶", name: "Inclusión" },
      { icon: "👩‍🍳", name: "Emprendimientos" }
    ],
    logos: [
      [
        {
          name: "UNICEF",
          src: "https://cdn.simpleicons.org/unicef/1CABE2"
        },
        {
          name: "Greenpeace",
          src: "https://cdn.simpleicons.org/greenpeace/00B140"
        },
        {
          name: "Wikipedia",
          src: "https://cdn.simpleicons.org/wikipedia/000000"
        },
        {
          name: "Khan Academy",
          src: "https://cdn.simpleicons.org/khanacademy/14BF96"
        }
      ],
      [
        {
          name: "Patreon",
          src: "https://cdn.simpleicons.org/patreon/FF424D"
        },
        {
          name: "Open Collective",
          src: "https://cdn.simpleicons.org/opencollective/7FADF2"
        },
        {
          name: "GitHub Sponsors",
          src: "https://cdn.simpleicons.org/githubsponsors/EA4AAA"
        },
        {
          name: "Codeberg",
          src: "https://cdn.simpleicons.org/codeberg/2185D0"
        }
      ],
      [
        {
          name: "Notion",
          src: "https://cdn.simpleicons.org/notion/000000"
        },
        {
          name: "Canva",
          src: "https://cdn.simpleicons.org/canva/00C4CC"
        },
        {
          name: "Mastodon",
          src: "https://cdn.simpleicons.org/mastodon/6364FF"
        },
        {
          name: "Signal",
          src: "https://cdn.simpleicons.org/signal/3A76F0"
        }
      ]
    ],
    navDescription:
      "Opciones vinculadas a ONG, artesanos y proyectos que convierten el regalo en una acción con sentido."
  }
};

let currentCategoryKey = "objetos";

function renderPage(categoryKey) {
  currentCategoryKey = categoryKey;
  const data = categories[categoryKey];

  app.innerHTML = `
    ${HeroSection(data)}
    ${SliderSection(data)}
    ${BrandsSection(data)}
    ${CategoryNavigation(categoryKey)}
    <div id="contacto" class="footer-anchor"></div>
  `;

  initRubrosSlider(data.rubros);
  initCategoryTiles();
}

function HeroSection(data) {
  return `
    <section class="hero section" id="hero">
      <div class="container hero-content">
        <h1>${data.heroTitle}</h1>
        <h3>${data.heroSubtitle}</h3>
        <p>${data.heroText}</p>
      </div>

      <div class="hero-art" aria-hidden="true">
        <div class="wave left"></div>
        <div class="wave right"></div>

        <div class="cloud blue c1"></div>
        <div class="cloud c2"></div>
        <div class="cloud c3"></div>
        <div class="cloud c4"></div>

        <div class="hero-illustration">
          <div class="loop-left"></div>
          <div class="loop-right"></div>
          <div class="gift"></div>
          <div class="hero-shadow"></div>

          <div class="confetti pink"></div>
          <div class="confetti blue"></div>
          <div class="confetti yellow-a"></div>
          <div class="confetti yellow-b"></div>
          <div class="confetti gray"></div>
        </div>
      </div>
    </section>
  `;
}

function SliderSection(data) {
  return `
    <section class="section slider-section" id="rubros">
      <div class="container">
        <div class="section-title">
          <h2>Rubros destacados</h2>
        </div>

        <div class="slider-shell">
          <div class="slider-controls">
            <button class="arrow-btn" id="rubrosPrev" aria-label="Anterior">‹</button>

            <div class="slider-viewport">
              <div class="slider-track" id="rubrosTrack">
                ${data.rubros.map(RubroCard).join("")}
              </div>
            </div>

            <button class="arrow-btn" id="rubrosNext" aria-label="Siguiente">›</button>
          </div>

          <div class="slider-dots" id="rubrosDots"></div>
        </div>
      </div>
    </section>
  `;
}

function RubroCard(item) {
  return `
    <article class="rubro-card">
      <div class="rubro-circle">${item.icon}</div>
      <div class="rubro-name">${item.name}</div>
    </article>
  `;
}

function BrandsSection(data) {
  return `
    <section class="brands-area section-spaced">
      <div class="container">
        <div class="section-title">
          <h2 class="blue">Nuestras Marcas</h2>
        </div>

        <div class="logo-grid">
          ${data.logos.map(LogoColumn).join("")}
        </div>
      </div>

      <div class="bottom-deco" aria-hidden="true">
        <div class="bottom-cloud a"></div>
        <div class="bottom-cloud b"></div>
        <div class="bottom-cloud c"></div>
        <div class="bottom-cloud d"></div>
        <div class="bottom-cloud e"></div>
      </div>
    </section>
  `;
}

function LogoColumn(column) {
  return `
    <div class="logo-column">
      ${column.map(LogoCard).join("")}
    </div>
  `;
}

function LogoCard(brand) {
  return `
    <div class="logo-card">
      <img src="${brand.src}" alt="${brand.name}" loading="lazy" />
    </div>
  `;
}

function CategoryNavigation(activeKey) {
  const keys = Object.keys(categories);

  return `
    <section class="category-nav section-spaced" id="categorias">
      <div class="container">
        <div class="section-title">
          <h2>Explorá nuestras categorías</h2>
        </div>

        <div class="category-grid">
          ${keys.map((key) => CategoryTile(categories[key], key === activeKey)).join("")}
        </div>
      </div>
    </section>
  `;
}

function CategoryTile(data, isActive) {
  return `
    <article
      class="category-tile ${isActive ? "active" : ""}"
      data-category="${data.id}"
      tabindex="0"
      role="button"
      aria-label="Ver categoría ${data.navTitle}"
    >
      <div class="category-tile-head">
        <div class="category-icon">${data.navIcon}</div>
        <h3>${data.navTitle}</h3>
      </div>
      <p>${data.navDescription}</p>
      <span class="category-link">
        Ver categoría
        <span aria-hidden="true">→</span>
      </span>
    </article>
  `;
}

function initCategoryTiles() {
  const tiles = document.querySelectorAll(".category-tile");

  tiles.forEach((tile) => {
    const categoryId = tile.dataset.category;

    const goToCategory = () => {
      renderPage(categoryId);
      window.scrollTo({ top: 0, behavior: "smooth" });
    };

    tile.addEventListener("click", goToCategory);
    tile.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        goToCategory();
      }
    });
  });
}

function initRubrosSlider(items) {
  const track = document.getElementById("rubrosTrack");
  const prev = document.getElementById("rubrosPrev");
  const next = document.getElementById("rubrosNext");
  const dotsWrap = document.getElementById("rubrosDots");

  if (!track || !prev || !next || !dotsWrap) return;

  let currentPage = 0;

  function getPerPage() {
    if (window.innerWidth <= 860) return 2;
    if (window.innerWidth <= 1050) return 4;
    return 8;
  }

  function getTotalPages() {
    return Math.max(1, Math.ceil(items.length / getPerPage()));
  }

  function renderDots() {
    const total = getTotalPages();
    dotsWrap.innerHTML = Array.from({ length: total })
      .map((_, index) => {
        return `<button class="slider-dot ${index === currentPage ? "active" : ""}" data-index="${index}" aria-label="Ir a grupo ${index + 1}"></button>`;
      })
      .join("");

    dotsWrap.querySelectorAll(".slider-dot").forEach((dot) => {
      dot.addEventListener("click", () => {
        currentPage = Number(dot.dataset.index);
        updateSlider();
      });
    });
  }

  function updateSlider() {
    const perPage = getPerPage();
    const totalPages = getTotalPages();

    if (currentPage > totalPages - 1) {
      currentPage = totalPages - 1;
    }

    const viewport = track.parentElement;
    const offset = currentPage * viewport.clientWidth;
    track.style.transform = `translateX(-${offset}px)`;

    prev.disabled = currentPage === 0;
    next.disabled = currentPage === totalPages - 1;

    renderDots();
  }

  prev.addEventListener("click", () => {
    currentPage = Math.max(0, currentPage - 1);
    updateSlider();
  });

  next.addEventListener("click", () => {
    currentPage = Math.min(getTotalPages() - 1, currentPage + 1);
    updateSlider();
  });

  window.addEventListener("resize", updateSlider);

  updateSlider();
}

/* init */
renderPage(currentCategoryKey);