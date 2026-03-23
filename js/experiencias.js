const rubros = [
  { icon: "🧖", name: "Spa" },
  { icon: "🏨", name: "Estadías" },
  { icon: "✈️", name: "Turismo" },
  { icon: "🍽️", name: "Gastronomía" },
  { icon: "🍷", name: "Catas" },
  { icon: "🎭", name: "Cultura" },
  { icon: "⛵", name: "Aventura" },
  { icon: "🌿", name: "Bienestar" }
];

const brandsColumns = [
  [
    { name: "Airbnb", src: "https://cdn.simpleicons.org/airbnb/FF5A5F" },
    { name: "Booking.com", src: "https://cdn.simpleicons.org/bookingdotcom/003580" },
    { name: "Tripadvisor", src: "https://cdn.simpleicons.org/tripadvisor/34E0A1" },
    { name: "Expedia", src: "https://cdn.simpleicons.org/expedia/1D63ED" }
  ],
  [
    { name: "Hilton", src: "https://cdn.simpleicons.org/hilton/124D97" },
    { name: "Marriott", src: "https://cdn.simpleicons.org/marriott/BF9D5E" },
    { name: "Ibis", src: "https://cdn.simpleicons.org/accor/000000" },
    { name: "Uber Eats", src: "https://cdn.simpleicons.org/ubereats/06C167" }
  ],
  [
    { name: "Skyscanner", src: "https://cdn.simpleicons.org/skyscanner/0770E3" },
    { name: "Kayak", src: "https://cdn.simpleicons.org/kayak/FF690F" },
    { name: "GetYourGuide", src: "https://cdn.simpleicons.org/getyourguide/FFCD00" },
    { name: "Lonely Planet", src: "https://cdn.simpleicons.org/lonelyplanet/005DAA" }
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
           href="marca.html?brand=${encodeURIComponent(brand.name)}&category=experiencias">
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