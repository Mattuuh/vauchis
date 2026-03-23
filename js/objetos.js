const rubros = [
  { icon: "💻", name: "Tecnología" },
  { icon: "🏠", name: "Hogar" },
  { icon: "👜", name: "Moda" },
  { icon: "⚽", name: "Deportes" },
  { icon: "💄", name: "Belleza" },
  { icon: "🧸", name: "Juguetes" },
  { icon: "☕", name: "Gourmet" },
  { icon: "🐾", name: "Mascotas" }
];

const brandsColumns = [
  [
    { name: "Samsung", src: "https://cdn.simpleicons.org/samsung/1428A0" },
    { name: "Sony", src: "https://cdn.simpleicons.org/sony/000000" },
    { name: "Adidas", src: "https://cdn.simpleicons.org/adidas/000000" },
    { name: "Nike", src: "https://cdn.simpleicons.org/nike/111111" }
  ],
  [
    { name: "Starbucks", src: "https://cdn.simpleicons.org/starbucks/006241" },
    { name: "Levi's", src: "https://cdn.simpleicons.org/levis/C41230" },
    { name: "Apple", src: "https://cdn.simpleicons.org/apple/000000" },
    { name: "Xiaomi", src: "https://cdn.simpleicons.org/xiaomi/FF6900" }
  ],
  [
    { name: "Puma", src: "https://cdn.simpleicons.org/puma/242B2F" },
    { name: "LG", src: "https://cdn.simpleicons.org/lg/A50034" },
    { name: "PlayStation", src: "https://cdn.simpleicons.org/playstation/003791" },
    { name: "HP", src: "https://cdn.simpleicons.org/hp/0096D6" }
  ]
];

const track = document.getElementById("track");
const brands = document.getElementById("brands");
const dots = document.getElementById("dots");
const prev = document.getElementById("prev");
const next = document.getElementById("next");

let currentPage = 0;

function renderRubros() {
  track.innerHTML = rubros.map(item => `
    <div class="rubro">
      <div class="rubro-icon">${item.icon}</div>
      <span>${item.name}</span>
    </div>
  `).join("");
}

function renderBrands() {
  brands.innerHTML = brandsColumns.map(column => `
    <div class="logo-column">
      ${column.map(brand => `
        <a class="logo-card logo-link"
           href="marca.html?brand=${encodeURIComponent(brand.name)}&category=objetos">
          <img src="${brand.src}" alt="${brand.name}" loading="lazy">
        </a>
      `).join("")}
    </div>
  `).join("");
}

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

renderRubros();
renderBrands();
updateSlider();