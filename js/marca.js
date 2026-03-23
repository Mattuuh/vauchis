const vouchersByBrand = {
  samsung: {
    brand: "Samsung",
    category: "objetos",
    subtitle: "Tecnología y productos destacados",
    description: "Elegí vouchers para regalar tecnología, audio y productos seleccionados.",
    vouchers: [
      {
        title: "Voucher Tecnología",
        area: "Electro • Productos",
        priceFrom: "$50.000",
        oldPrice: null,
        finalPrice: null,
        badge: "TOP",
        rating: null,
        delivery: "Envío digital",
        description: "Ideal para regalar gadgets, audio y pequeños electrodomésticos de marcas asociadas.",
        theme: "dark"
      },
      {
        title: "Voucher Smart TV",
        area: "Electro • Hogar",
        priceFrom: null,
        oldPrice: "$72.000",
        finalPrice: "$58.000",
        badge: "15%",
        rating: 4.7,
        delivery: null,
        description: "Una opción ideal para quienes buscan renovar entretenimiento y hogar.",
        theme: "blue"
      }
    ]
  },

  sony: {
    brand: "Sony",
    category: "objetos",
    subtitle: "Audio, gaming y entretenimiento",
    description: "Vouchers pensados para experiencias de audio, imagen y gaming.",
    vouchers: [
      {
        title: "Voucher Audio Premium",
        area: "Electro • Audio",
        priceFrom: "$45.000",
        oldPrice: null,
        finalPrice: null,
        badge: "TOP",
        rating: 4.8,
        delivery: "Envío digital",
        description: "Ideal para auriculares, parlantes y accesorios de audio seleccionados.",
        theme: "dark"
      }
    ]
  },

  adidas: {
    brand: "Adidas",
    category: "objetos",
    subtitle: "Moda deportiva y entrenamiento",
    description: "Vouchers para regalar zapatillas, indumentaria y accesorios deportivos.",
    vouchers: [
      {
        title: "Voucher Deportes",
        area: "Deportes • Moda",
        priceFrom: "$40.000",
        oldPrice: null,
        finalPrice: null,
        badge: "TOP",
        rating: 4.6,
        delivery: null,
        description: "Una propuesta ideal para quienes entrenan o aman el estilo deportivo.",
        theme: "dark"
      }
    ]
  },

  nike: {
    brand: "Nike",
    category: "objetos",
    subtitle: "Movimiento, estilo y rendimiento",
    description: "Encontrá vouchers pensados para deporte, running y lifestyle.",
    vouchers: [
      {
        title: "Voucher Running",
        area: "Deportes • Running",
        priceFrom: "$55.000",
        oldPrice: "$62.000",
        finalPrice: "$49.000",
        badge: "20%",
        rating: 4.9,
        delivery: null,
        description: "Para regalar indumentaria, calzado y productos de entrenamiento.",
        theme: "pink"
      }
    ]
  },

  airbnb: {
    brand: "Airbnb",
    category: "experiencias",
    subtitle: "Escapadas y estadías especiales",
    description: "Regalá experiencias de viaje y alojamiento en destinos únicos.",
    vouchers: [
      {
        title: "Voucher Estadía",
        area: "Turismo • Experiencias",
        priceFrom: "$80.000",
        oldPrice: null,
        finalPrice: null,
        badge: "TOP",
        rating: 4.8,
        delivery: "Envío digital",
        description: "Perfecto para escapadas cortas, fines de semana y viajes memorables.",
        theme: "dark"
      }
    ]
  },

  unicef: {
    brand: "UNICEF",
    category: "impacto-social",
    subtitle: "Regalá con impacto positivo",
    description: "Vouchers vinculados a acciones con propósito y apoyo social.",
    vouchers: [
      {
        title: "Voucher Impacto Solidario",
        area: "ONG • Impacto",
        priceFrom: "$25.000",
        oldPrice: null,
        finalPrice: null,
        badge: "TOP",
        rating: 4.8,
        delivery: null,
        description: "Una forma de regalar con sentido, apoyando iniciativas con impacto real.",
        theme: "blue"
      }
    ]
  },

  airbnb: {
  brand: "Airbnb",
  category: "experiencias",
  subtitle: "Escapadas y estadías especiales",
  description: "Regalá experiencias de viaje y alojamiento en destinos únicos.",
  vouchers: [
    {
      title: "Voucher Estadía",
      area: "Turismo • Experiencias",
      priceFrom: "$80.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.8,
      delivery: "Envío digital",
      description: "Perfecto para escapadas cortas, fines de semana y viajes memorables.",
      theme: "dark"
    }
  ]
},

"booking.com": {
  brand: "Booking.com",
  category: "experiencias",
  subtitle: "Reservas y escapadas para regalar",
  description: "Opciones de alojamiento, viajes y experiencias para cualquier ocasión.",
  vouchers: [
    {
      title: "Voucher Escapada",
      area: "Estadías • Turismo",
      priceFrom: "$65.000",
      oldPrice: "$78.000",
      finalPrice: "$59.000",
      badge: "15%",
      rating: 4.7,
      delivery: null,
      description: "Ideal para regalar una salida corta con reserva flexible y múltiples destinos.",
      theme: "blue"
    }
  ]
},

tripadvisor: {
  brand: "Tripadvisor",
  category: "experiencias",
  subtitle: "Actividades y turismo recomendado",
  description: "Vouchers vinculados a actividades, paseos y experiencias para descubrir.",
  vouchers: [
    {
      title: "Voucher Turismo",
      area: "Turismo • Actividades",
      priceFrom: "$42.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.6,
      delivery: "Envío digital",
      description: "Una opción ideal para paseos, recorridos y planes recomendados por viajeros.",
      theme: "dark"
    }
  ]
},

expedia: {
  brand: "Expedia",
  category: "experiencias",
  subtitle: "Vuelos, hoteles y más",
  description: "Regalá viajes y experiencias armadas para descansar o explorar.",
  vouchers: [
    {
      title: "Voucher Viaje",
      area: "Turismo • Viajes",
      priceFrom: "$95.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.8,
      delivery: null,
      description: "Pensado para regalar una experiencia de viaje completa, simple y flexible.",
      theme: "blue"
    }
  ]
},

hilton: {
  brand: "Hilton",
  category: "experiencias",
  subtitle: "Hoteles y estadías premium",
  description: "Vouchers para estadías cómodas, premium y memorables.",
  vouchers: [
    {
      title: "Voucher Hotel Premium",
      area: "Estadías • Premium",
      priceFrom: null,
      oldPrice: "$62.000",
      finalPrice: "$48.000",
      badge: "20%",
      rating: 4.9,
      delivery: null,
      description: "Perfecto para regalar descanso, bienestar y una experiencia hotelera de calidad.",
      theme: "pink"
    }
  ]
},

marriott: {
  brand: "Marriott",
  category: "experiencias",
  subtitle: "Escapadas con confort y estilo",
  description: "Regalá noches especiales, descanso y hospitalidad reconocida.",
  vouchers: [
    {
      title: "Voucher Estadía Premium",
      area: "Hotel • Experiencias",
      priceFrom: "$70.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.8,
      delivery: "Envío digital",
      description: "Ideal para regalar una experiencia premium en hoteles seleccionados.",
      theme: "dark"
    }
  ]
},

ibis: {
  brand: "Ibis",
  category: "experiencias",
  subtitle: "Estadías accesibles y prácticas",
  description: "Una opción simple y conveniente para regalar viajes y escapadas.",
  vouchers: [
    {
      title: "Voucher Estadía Urbana",
      area: "Hoteles • Ciudad",
      priceFrom: "$38.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.5,
      delivery: null,
      description: "Pensado para escapadas urbanas cómodas y bien ubicadas.",
      theme: "blue"
    }
  ]
},

"uber-eats": {
  brand: "Uber Eats",
  category: "experiencias",
  subtitle: "Sabores y momentos para compartir",
  description: "Regalá experiencias gastronómicas desde casa o donde quieras.",
  vouchers: [
    {
      title: "Voucher Gourmet",
      area: "Gastronomía • Delivery",
      priceFrom: "$25.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.7,
      delivery: "Envío digital",
      description: "Ideal para regalar una comida rica, simple y con entrega digital.",
      theme: "dark"
    }
  ]
},

skyscanner: {
  brand: "Skyscanner",
  category: "experiencias",
  subtitle: "Inspiración para viajar",
  description: "Vouchers orientados a vuelos, escapadas e ideas para regalar viajes.",
  vouchers: [
    {
      title: "Voucher Aventura",
      area: "Turismo • Aventura",
      priceFrom: "$85.000",
      oldPrice: "$99.000",
      finalPrice: "$76.000",
      badge: "20%",
      rating: 4.8,
      delivery: null,
      description: "Una propuesta ideal para quienes sueñan con su próximo viaje.",
      theme: "blue"
    }
  ]
},

kayak: {
  brand: "Kayak",
  category: "experiencias",
  subtitle: "Rutas, planes y escapadas",
  description: "Encontrá vouchers pensados para planear viajes de forma simple.",
  vouchers: [
    {
      title: "Voucher Turismo Flexible",
      area: "Viajes • Turismo",
      priceFrom: "$58.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.6,
      delivery: "Envío digital",
      description: "Ideal para regalar libertad de elección en escapadas y planes.",
      theme: "dark"
    }
  ]
},

getyourguide: {
  brand: "GetYourGuide",
  category: "experiencias",
  subtitle: "Paseos y actividades inolvidables",
  description: "Vouchers para tours, visitas y experiencias en destino.",
  vouchers: [
    {
      title: "Voucher Actividades",
      area: "Experiencias • Paseos",
      priceFrom: "$33.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.8,
      delivery: null,
      description: "Ideal para regalar recorridos, tours y actividades seleccionadas.",
      theme: "pink"
    }
  ]
},

"lonely-planet": {
  brand: "Lonely Planet",
  category: "experiencias",
  subtitle: "Inspiración para viajeros",
  description: "Experiencias pensadas para descubrir, explorar y viajar distinto.",
  vouchers: [
    {
      title: "Voucher Exploración",
      area: "Turismo • Cultura",
      priceFrom: "$45.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.7,
      delivery: null,
      description: "Regalá inspiración y experiencias para quienes aman conocer lugares nuevos.",
      theme: "blue"
    }
  ]
},

unicef: {
  brand: "UNICEF",
  category: "impacto-social",
  subtitle: "Regalá con impacto positivo",
  description: "Vouchers vinculados a acciones con propósito y apoyo social.",
  vouchers: [
    {
      title: "Voucher Impacto Solidario",
      area: "ONG • Impacto",
      priceFrom: "$25.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.8,
      delivery: null,
      description: "Una forma de regalar con sentido, apoyando iniciativas con impacto real.",
      theme: "blue"
    }
  ]
},

greenpeace: {
  brand: "Greenpeace",
  category: "impacto-social",
  subtitle: "Compromiso con el ambiente",
  description: "Opciones que acompañan causas ambientales y de conciencia colectiva.",
  vouchers: [
    {
      title: "Voucher Ambiente",
      area: "Impacto • Ambiente",
      priceFrom: "$30.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.7,
      delivery: "Envío digital",
      description: "Ideal para regalar con propósito y apoyar iniciativas de cuidado ambiental.",
      theme: "dark"
    }
  ]
},

wikipedia: {
  brand: "Wikipedia",
  category: "impacto-social",
  subtitle: "Conocimiento abierto y acceso libre",
  description: "Vouchers asociados a educación, acceso a información y valor social.",
  vouchers: [
    {
      title: "Voucher Educación Abierta",
      area: "Educación • Comunidad",
      priceFrom: "$18.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.6,
      delivery: null,
      description: "Una propuesta para regalar valor educativo y compromiso con el conocimiento abierto.",
      theme: "blue"
    }
  ]
},

"open-collective": {
  brand: "Open Collective",
  category: "impacto-social",
  subtitle: "Apoyo a proyectos y comunidades",
  description: "Vouchers pensados para fortalecer iniciativas, comunidades y proyectos independientes.",
  vouchers: [
    {
      title: "Voucher Proyecto Colectivo",
      area: "Proyectos • Comunidad",
      priceFrom: "$22.000",
      oldPrice: "$28.000",
      finalPrice: "$20.000",
      badge: "20%",
      rating: 4.7,
      delivery: null,
      description: "Una forma de regalar apoyo a proyectos con impacto y construcción comunitaria.",
      theme: "pink"
    }
  ]
},

patreon: {
  brand: "Patreon",
  category: "impacto-social",
  subtitle: "Apoyo a creadores y proyectos",
  description: "Vouchers orientados a impulsar comunidades creativas y sostenibles.",
  vouchers: [
    {
      title: "Voucher Creadores",
      area: "Proyectos • Creatividad",
      priceFrom: "$20.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.5,
      delivery: "Envío digital",
      description: "Ideal para apoyar proyectos creativos, educativos o culturales.",
      theme: "pink"
    }
  ]
},

"code-org": {
  brand: "Code.org",
  category: "impacto-social",
  subtitle: "Educación y tecnología con propósito",
  description: "Opciones vinculadas a formación, aprendizaje y acceso tecnológico.",
  vouchers: [
    {
      title: "Voucher Educación Tech",
      area: "Educación • Tecnología",
      priceFrom: "$24.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.8,
      delivery: null,
      description: "Una propuesta para apoyar educación tecnológica y oportunidades de aprendizaje.",
      theme: "blue"
    }
  ]
},

kindful: {
  brand: "Kindful",
  category: "impacto-social",
  subtitle: "Solidaridad y empatía",
  description: "Regalá acciones vinculadas a acompañamiento, inclusión y redes solidarias.",
  vouchers: [
    {
      title: "Voucher Inclusión",
      area: "Inclusión • Impacto",
      priceFrom: "$16.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.6,
      delivery: null,
      description: "Una forma de regalar con sentido, apoyando acciones inclusivas y humanas.",
      theme: "pink"
    }
  ]
},

globalgiving: {
  brand: "GlobalGiving",
  category: "impacto-social",
  subtitle: "Apoyo a causas globales",
  description: "Vouchers para acompañar iniciativas comunitarias y sociales de alcance amplio.",
  vouchers: [
    {
      title: "Voucher Comunidad",
      area: "Comunidad • Proyectos",
      priceFrom: "$28.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.7,
      delivery: "Envío digital",
      description: "Pensado para impulsar proyectos comunitarios y redes de apoyo social.",
      theme: "dark"
    }
  ]
},

notion: {
  brand: "Notion",
  category: "impacto-social",
  subtitle: "Organización para proyectos con propósito",
  description: "Vouchers asociados a gestión, organización y crecimiento de iniciativas sociales.",
  vouchers: [
    {
      title: "Voucher Gestión de Proyecto",
      area: "Proyectos • Organización",
      priceFrom: "$26.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.6,
      delivery: null,
      description: "Ideal para equipos, iniciativas o proyectos que buscan crecer con orden y foco.",
      theme: "dark"
    }
  ]
},

canva: {
  brand: "Canva",
  category: "impacto-social",
  subtitle: "Comunicación visual para causas",
  description: "Vouchers pensados para proyectos, campañas y comunicación con impacto.",
  vouchers: [
    {
      title: "Voucher Comunicación Visual",
      area: "Creatividad • Impacto",
      priceFrom: "$19.000",
      oldPrice: "$24.000",
      finalPrice: "$17.000",
      badge: "20%",
      rating: 4.8,
      delivery: null,
      description: "Ideal para potenciar campañas, iniciativas y comunicación de proyectos sociales.",
      theme: "pink"
    }
  ]
},

meetup: {
  brand: "Meetup",
  category: "impacto-social",
  subtitle: "Comunidades y encuentros",
  description: "Regalá experiencias ligadas a comunidad, vínculos y construcción colectiva.",
  vouchers: [
    {
      title: "Voucher Comunidad Activa",
      area: "Comunidad • Encuentros",
      priceFrom: "$21.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.5,
      delivery: null,
      description: "Ideal para proyectos que crecen a través de encuentros, redes y participación.",
      theme: "blue"
    }
  ]
},

figma: {
  brand: "Figma",
  category: "impacto-social",
  subtitle: "Diseño para ideas con valor",
  description: "Vouchers vinculados a creatividad, diseño y prototipado de proyectos con impacto.",
  vouchers: [
    {
      title: "Voucher Diseño de Proyecto",
      area: "Diseño • Innovación",
      priceFrom: "$27.000",
      oldPrice: null,
      finalPrice: null,
      badge: "TOP",
      rating: 4.7,
      delivery: "Envío digital",
      description: "Una opción para apoyar iniciativas innovadoras, educativas o de impacto social.",
      theme: "blue"
    }
  ]
},
};

function slugify(text) {
  return text
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/[^\w\s-]/g, "")
    .trim()
    .replace(/\s+/g, "-");
}

function getQueryParams() {
  const params = new URLSearchParams(window.location.search);
  return {
    brand: params.get("brand") || "",
    category: params.get("category") || "objetos"
  };
}

function getFallbackCategoryUrl(category) {
  if (category === "experiencias") return "experiencias.html";
  if (category === "impacto-social") return "impacto-social.html";
  return "objetos.html";
}

function renderVoucherCard(voucher, brandName) {
  const badge = voucher.badge
    ? `<div class="voucher-badge">${voucher.badge}</div>`
    : "";

  const rating = voucher.rating
    ? `<div class="voucher-rating">${voucher.rating} ★</div>`
    : "";

  const delivery = voucher.delivery
    ? `<div class="voucher-delivery">${voucher.delivery}</div>`
    : "";

  const oldPrice = voucher.oldPrice
    ? `<span class="voucher-old-price">${voucher.oldPrice}</span>`
    : "";

  const finalPrice = voucher.finalPrice
    ? `
      <div class="voucher-price-block">
        ${oldPrice}
        <span class="voucher-price-label">Precio final</span>
        <strong class="voucher-final-price">${voucher.finalPrice}</strong>
      </div>
    `
    : `
      <div class="voucher-price-block">
        <span class="voucher-price-label">Desde</span>
        <strong class="voucher-final-price">${voucher.priceFrom}</strong>
      </div>
    `;

  return `
    <article class="voucher-card voucher-theme-${voucher.theme || "dark"}">
      <div class="voucher-cover">
        <div class="voucher-brand">${brandName}</div>
        ${badge}
        <div class="voucher-cover-circle"></div>
      </div>

      <div class="voucher-body">
        <div class="voucher-meta-row">
          <span class="voucher-area">${voucher.area}</span>
          ${rating || delivery}
        </div>

        <h3>${voucher.title}</h3>
        <p>${voucher.description}</p>

        <div class="voucher-footer">
          ${finalPrice}
          <a href="#" class="voucher-buy-btn">Comprar</a>
        </div>
      </div>
    </article>
  `;
}

function initBrandPage() {
  const { brand, category } = getQueryParams();
  const fallbackUrl = getFallbackCategoryUrl(category);
  const key = slugify(brand);

  const data = vouchersByBrand[key];

  const titleEl = document.getElementById("brandTitle");
  const subtitleEl = document.getElementById("brandSubtitle");
  const descEl = document.getElementById("brandDescription");
  const gridEl = document.getElementById("voucherGrid");
  const backEl = document.querySelector(".back-inline");

  if (backEl) {
    backEl.href = fallbackUrl;
  }

  if (!data) {
    titleEl.textContent = brand || "Marca";
    subtitleEl.textContent = "No encontramos vouchers activos";
    descEl.textContent = "Podés volver a la categoría para seguir explorando otras marcas.";
    gridEl.innerHTML = `
      <div class="empty-brand-state">
        <p>No hay vouchers cargados para esta marca todavía.</p>
        <a href="${fallbackUrl}" class="btn btn-primary">Volver</a>
      </div>
    `;
    return;
  }

  titleEl.textContent = data.brand;
  subtitleEl.textContent = data.subtitle;
  descEl.textContent = data.description;

  gridEl.innerHTML = data.vouchers
    .map(voucher => renderVoucherCard(voucher, data.brand))
    .join("");
}

initBrandPage();