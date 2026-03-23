const rubros = [
  { icon: "🤝", name: "ONGs" },
  { icon: "🧶", name: "Artesanos" },
  { icon: "🌱", name: "Proyectos" },
  { icon: "🎓", name: "Educación" },
  { icon: "🌍", name: "Ambiente" },
  { icon: "🏡", name: "Comunidad" },
  { icon: "♿", name: "Inclusión" },
  { icon: "🚀", name: "Emprendimiento" }
];

const brandsColumns = [
  [
    { name: "UNICEF", src: "https://cdn.simpleicons.org/unicef/1CABE2" },
    { name: "Greenpeace", src: "https://cdn.simpleicons.org/greenpeace/66CC00" },
    { name: "Wikipedia", src: "https://cdn.simpleicons.org/wikipedia/000000" },
    { name: "Open Collective", src: "https://cdn.simpleicons.org/opencollective/7FADF2" }
  ],
  [
    { name: "Patreon", src: "https://cdn.simpleicons.org/patreon/FF424D" },
    { name: "Code.org", src: "https://cdn.simpleicons.org/codeorg/2C3E50" },
    { name: "Kindful", src: "https://cdn.simpleicons.org/heart/EC2F8C" },
    { name: "GlobalGiving", src: "https://cdn.simpleicons.org/globe/0B3F91" }
  ],
  [
    { name: "Notion", src: "https://cdn.simpleicons.org/notion/000000" },
    { name: "Canva", src: "https://cdn.simpleicons.org/canva/00C4CC" },
    { name: "Meetup", src: "https://cdn.simpleicons.org/meetup/ED1C40" },
    { name: "Figma", src: "https://cdn.simpleicons.org/figma/F24E1E" }
  ]
];

const track = document.getElementById("track");
const brands = document.getElementById("brands");
const dots = document.getElementById("dots");
const prev = document.getElementById("prev");
const next = document.getElementById("next");

let currentPage = 0;

/* =========================
   RENDER RUBROS
========================= */
function renderRubros() {
  track.innerHTML = rubros.map(item => `
    <div class="rubro">
      <div class="rubro-icon">${item.icon}</div>
      <span>${item.name}</span>
    </div>
  `).join("");
}

/* =========================
   RENDER MARCAS (IMPORTANTE)
   → estructura correcta para el CSS
========================= */
function renderBrands() {
  brands.innerHTML = brandsColumns.map(column => `
    <div class="logo-column">
      ${column.map(brand => `
        <a class="logo-card logo-link"
           href="marca.html?brand=${encodeURIComponent(brand.name)}&category=impacto-social">
          <img src="${brand.src}" alt="${brand.name}" loading="lazy">
        </a>
      `).join("")}
    </div>
  `).join("");
}

/* =========================
   SLIDER
========================= */
function perPage() {
  if (window.innerWidth <= 640) return 2;
  if (window.innerWidth <= 900) return 4;
  return 8;
}

function totalPages() {
  return Math.ceil(rubros.length / perPage());
}

function renderDots() {
  dots.innerHTML = "";
  for (let i = 0; i < totalPages(); i++) {
    const btn = document.createElement("button");
    btn.className = `slider-dot ${i === currentPage ? "active" : ""}`;
    btn.addEventListener("click", () => {
      currentPage = i;
      updateSlider();
    });
    dots.appendChild(btn);
  }
}

function updateSlider() {
  const viewport = track.parentElement;
  const pageWidth = viewport.clientWidth;

  track.style.transform = `translateX(-${currentPage * pageWidth}px)`;

  if (prev) prev.disabled = currentPage === 0;
  if (next) next.disabled = currentPage >= totalPages() - 1;

  renderDots();
}

/* =========================
   EVENTS
========================= */
if (prev) {
  prev.addEventListener("click", () => {
    if (currentPage > 0) {
      currentPage--;
      updateSlider();
    }
  });
}

if (next) {
  next.addEventListener("click", () => {
    if (currentPage < totalPages() - 1) {
      currentPage++;
      updateSlider();
    }
  });
}

window.addEventListener("resize", () => {
  currentPage = 0;
  updateSlider();
});

/* =========================
   INIT
========================= */
renderRubros();
renderBrands();
updateSlider();