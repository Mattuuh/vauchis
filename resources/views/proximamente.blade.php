<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#07378C">
    <meta name="robots" content="noindex, nofollow">
    <title>Próximamente... | Vauchis</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <meta property="og:title" content="Vauchis | El placer de regalar">
    <meta property="og:description" content="El placer de regalar, simplificado.">
    <meta property="og:image" content="{{ asset('images/logo-1.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/proximamente.css') }}">
</head>
<body>
    <main class="coming-soon">
        <div class="orb orb-one" aria-hidden="true"></div>
        <div class="orb orb-two" aria-hidden="true"></div>
        <section class="content" aria-labelledby="main-title">
            <img class="logo" src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
            <div class="accent" aria-hidden="true"></div>
            <p class="eyebrow">ALGO ESPECIAL ESTÁ EN CAMINO</p>
            <h1 id="main-title">Próximamente<span>...</span></h1>
            <p class="subtitle">Sitio en construcción</p>
            <p class="description">Estamos preparando una nueva forma de regalar momentos, experiencias y mucho más.</p>
        </section>
        <footer>© {{ date('Y') }} Vauchis. Todos los derechos reservados.</footer>
    </main>
</body>
</html>
