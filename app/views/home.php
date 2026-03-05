<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? PIZZERIA_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --orange: #E8820C; --orange-dk: #C46A00;
            --dark: #1A1A1A; --dark-2: #242424; --dark-3: #2E2E2E;
            --text: #F0EDE8; --text-muted: #9A9080;
            --border: rgba(255,255,255,.07);
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Jost', sans-serif; background: var(--dark); color: var(--text); overflow-x: hidden; }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }

        /* ── TOPBAR ── */
        .topbar { background: #111; padding: 9px 0; border-bottom: 1px solid var(--border); }
        .topbar-inner { max-width: 1200px; margin: auto; padding: 0 24px; display: flex; gap: 28px; flex-wrap: wrap; align-items: center; }
        .topbar-inner span { font-size: .78rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }

        /* ── NAVBAR ── */
        .navbar { background: rgba(26,26,26,.95); backdrop-filter: blur(8px); padding: 0; position: sticky; top: 0; z-index: 100; border-bottom: 1px solid var(--border); }
        .navbar-inner { max-width: 1200px; margin: auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; height: 68px; }
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: var(--text); }
        .navbar-brand span { color: var(--orange); }
        .navbar-menu { list-style: none; display: flex; gap: 8px; align-items: center; }
        .navbar-menu a { padding: 8px 16px; font-size: .82rem; letter-spacing: .08em; text-transform: uppercase; color: var(--text-muted); transition: color .2s; border-radius: 4px; }
        .navbar-menu a:hover { color: var(--text); }
        .navbar-menu .btn-nav { background: var(--orange); color: #fff; padding: 8px 20px; border-radius: 4px; }
        .navbar-menu .btn-nav:hover { background: var(--orange-dk); }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 4px; }
        .hamburger span { display: block; width: 24px; height: 2px; background: var(--text); transition: all .3s; }

        /* ── HERO ── */
        .hero { position: relative; height: 100vh; min-height: 600px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .hero-bg { position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1513104890138-7c749659a591?w=1600&q=80') center/cover no-repeat; }
        .hero-bg::after { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(0,0,0,.75) 0%, rgba(0,0,0,.45) 100%); }
        .hero-content { position: relative; z-index: 2; text-align: center; padding: 0 24px; max-width: 780px; }
        .hero-eyebrow { font-size: .75rem; letter-spacing: .25em; text-transform: uppercase; color: var(--orange); margin-bottom: 20px; display: flex; align-items: center; justify-content: center; gap: 12px; }
        .hero-eyebrow::before, .hero-eyebrow::after { content: ''; display: block; width: 32px; height: 1px; background: var(--orange); }
        .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(3rem, 8vw, 6rem); font-weight: 700; line-height: 1.05; margin-bottom: 12px; color: #fff; }
        .hero-title em { font-style: italic; color: var(--orange); }
        .hero-sub { font-size: clamp(1rem, 2vw, 1.2rem); font-weight: 300; color: rgba(255,255,255,.7); margin-bottom: 40px; line-height: 1.6; }
        .hero-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .btn-primary { background: var(--orange); color: #fff; padding: 14px 32px; border-radius: 4px; font-size: .85rem; font-weight: 500; letter-spacing: .1em; text-transform: uppercase; transition: all .2s; display: inline-block; }
        .btn-primary:hover { background: var(--orange-dk); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(232,130,12,.35); }
        .btn-outline { border: 1px solid rgba(255,255,255,.4); color: #fff; padding: 14px 32px; border-radius: 4px; font-size: .85rem; font-weight: 500; letter-spacing: .1em; text-transform: uppercase; transition: all .2s; display: inline-block; }
        .btn-outline:hover { border-color: #fff; background: rgba(255,255,255,.08); }
        .hero-scroll { position: absolute; bottom: 32px; left: 50%; transform: translateX(-50%); z-index: 2; display: flex; flex-direction: column; align-items: center; gap: 8px; color: rgba(255,255,255,.4); font-size: .7rem; letter-spacing: .15em; text-transform: uppercase; }
        .hero-scroll-line { width: 1px; height: 40px; background: linear-gradient(to bottom, rgba(255,255,255,.4), transparent); animation: scrollLine 2s ease-in-out infinite; }
        @keyframes scrollLine { 0%,100%{opacity:.4;transform:scaleY(1)} 50%{opacity:1;transform:scaleY(.6)} }

        /* ── SEZIONI COMUNI ── */
        section { padding: 96px 24px; }
        .container { max-width: 1200px; margin: auto; }
        .section-label { font-size: .72rem; letter-spacing: .22em; text-transform: uppercase; color: var(--orange); margin-bottom: 12px; }
        .section-title { font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 700; line-height: 1.15; margin-bottom: 20px; }
        .section-line { width: 40px; height: 2px; background: var(--orange); margin-bottom: 24px; }
        .section-text { color: var(--text-muted); line-height: 1.8; font-size: .95rem; max-width: 560px; }

        /* ── CHI SIAMO ── */
        .about { background: var(--dark-2); }
        .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
        .about-img-wrap { position: relative; }
        .about-img { width: 100%; height: 480px; object-fit: cover; border-radius: 4px; }
        .about-img-badge { position: absolute; bottom: -24px; right: -24px; background: var(--orange); color: #fff; padding: 24px; border-radius: 4px; text-align: center; }
        .about-img-badge strong { display: block; font-family: 'Playfair Display', serif; font-size: 2rem; line-height: 1; }
        .about-img-badge span { font-size: .72rem; letter-spacing: .12em; text-transform: uppercase; opacity: .85; }
        .about-features { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 32px; }
        .about-feature { display: flex; align-items: flex-start; gap: 12px; }
        .about-feature-icon { color: var(--orange); font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
        .about-feature p { font-size: .85rem; color: var(--text-muted); line-height: 1.5; }
        .about-feature strong { display: block; color: var(--text); font-size: .9rem; margin-bottom: 2px; }

        /* ── MENU PREVIEW ── */
        .menu-preview { background: var(--dark); }
        .menu-preview-head { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 48px; flex-wrap: wrap; gap: 16px; }
        .categories-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; }
        .cat-card { position: relative; overflow: hidden; aspect-ratio: 4/3; cursor: pointer; }
        .cat-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; filter: brightness(.7) saturate(1.1); }
        .cat-card:hover img { transform: scale(1.06); }
        .cat-card-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.7) 0%, transparent 60%); }
        .cat-card-label { position: absolute; bottom: 0; left: 0; right: 0; padding: 20px; background: var(--orange); text-align: center; font-size: .78rem; font-weight: 600; letter-spacing: .15em; text-transform: uppercase; transform: translateY(0); transition: background .2s; }
        .cat-card:hover .cat-card-label { background: var(--orange-dk); }

        /* ── GALLERIA ── */
        .gallery { background: var(--dark-2); padding-bottom: 0; }
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: 280px 280px; gap: 3px; margin-top: 48px; }
        .gallery-item { overflow: hidden; position: relative; }
        .gallery-item:first-child { grid-row: span 2; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease, filter .3s; filter: brightness(.85) saturate(1.1); }
        .gallery-item:hover img { transform: scale(1.05); filter: brightness(1) saturate(1.2); }

        /* ── RECENSIONI ── */
        .reviews { background: var(--dark); }
        .reviews-head { text-align: center; margin-bottom: 56px; }
        .reviews-head .section-line { margin: 0 auto 24px; }
        .reviews-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
        .review-card { background: var(--dark-2); border: 1px solid var(--border); border-radius: 8px; padding: 32px; }
        .review-quote { color: var(--orange); font-size: 1.8rem; line-height: 1; margin-bottom: 16px; font-family: Georgia, serif; }
        .review-text { color: var(--text-muted); font-size: .875rem; line-height: 1.8; margin-bottom: 24px; }
        .review-author { display: flex; align-items: center; gap: 12px; }
        .review-avatar { width: 42px; height: 42px; border-radius: 50%; background: var(--dark-3); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .review-name { font-size: .875rem; font-weight: 500; }
        .review-source { font-size: .75rem; color: var(--text-muted); }
        .review-stars { color: var(--orange); font-size: .75rem; margin-top: 2px; }

        /* ── CONTATTI ── */
        .contacts { background: var(--dark-2); }
        .contacts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: start; }
        .contact-info { display: flex; flex-direction: column; gap: 24px; margin-top: 32px; }
        .contact-item { display: flex; align-items: flex-start; gap: 16px; }
        .contact-icon { width: 44px; height: 44px; background: rgba(232,130,12,.1); border: 1px solid rgba(232,130,12,.2); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .contact-item h4 { font-size: .75rem; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px; }
        .contact-item p { font-size: .9rem; line-height: 1.6; }
        .contact-item a { color: var(--orange); }
        .map-wrap { margin-top: 28px; border-radius: 6px; overflow: hidden; border: 1px solid var(--border); }
        .map-wrap iframe { display: block; }

        /* ── FORM CONTATTI ── */
        .form-side { }
        .contact-form { margin-top: 32px; display: flex; flex-direction: column; gap: 16px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group label { display: block; font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 7px; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 12px 14px; background: var(--dark-3);
            border: 1px solid var(--border); border-radius: 5px; color: var(--text);
            font-family: 'Jost', sans-serif; font-size: .9rem; outline: none; transition: border-color .2s;
        }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--orange); }
        .form-group textarea { resize: vertical; min-height: 120px; }
        .form-privacy { display: flex; align-items: flex-start; gap: 10px; font-size: .8rem; color: var(--text-muted); line-height: 1.5; }
        .form-privacy input { width: 16px; height: 16px; accent-color: var(--orange); flex-shrink: 0; margin-top: 2px; cursor: pointer; }
        .form-flash { padding: 12px 16px; border-radius: 5px; font-size: .875rem; border: 1px solid; margin-bottom: 8px; }
        .form-flash-success { background: rgba(76,175,125,.1); border-color: rgba(76,175,125,.3); color: #7DCEA0; }
        .form-flash-error   { background: rgba(224,85,85,.1);  border-color: rgba(224,85,85,.3);  color: #F08080; }

        /* ── FOOTER ── */
        .footer { background: #111; padding: 48px 24px; border-top: 1px solid var(--border); }
        .footer-inner { max-width: 1200px; margin: auto; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 40px; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--orange); margin-bottom: 12px; }
        .footer-text { font-size: .82rem; color: var(--text-muted); line-height: 1.7; }
        .footer-title { font-size: .72rem; letter-spacing: .15em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 14px; }
        .footer-list { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .footer-list li { font-size: .82rem; color: var(--text-muted); }
        .footer-list a { color: var(--text-muted); transition: color .2s; }
        .footer-list a:hover { color: var(--orange); }
        .footer-bottom { max-width: 1200px; margin: 32px auto 0; padding-top: 24px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
        .footer-bottom p { font-size: .75rem; color: var(--text-muted); }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .about-grid, .contacts-grid { grid-template-columns: 1fr; gap: 40px; }
            .about-img-badge { right: 0; }
            .categories-grid { grid-template-columns: 1fr 1fr; }
            .reviews-grid { grid-template-columns: 1fr; }
            .footer-inner { grid-template-columns: 1fr; gap: 28px; }
            .gallery-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; }
            .gallery-item:first-child { grid-row: span 1; }
        }
        @media (max-width: 600px) {
            section { padding: 64px 20px; }
            .categories-grid { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .navbar-menu { display: none; flex-direction: column; position: absolute; top: 68px; left: 0; right: 0; background: var(--dark-2); padding: 16px 0; border-bottom: 1px solid var(--border); }
            .navbar-menu.open { display: flex; }
            .hamburger { display: flex; }
            .hero-title { font-size: 2.8rem; }
        }

        /* ── ANIMAZIONI ── */
        .fade-up { opacity: 0; transform: translateY(24px); transition: opacity .6s ease, transform .6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="topbar-inner">
        <span>📍 <?= PIZZERIA_ADDRESS ?></span>
        <span>📞 <a href="tel:<?= PIZZERIA_PHONE ?>" style="color:var(--orange)"><?= PIZZERIA_PHONE ?></a></span>
        <span>🕐 <?= PIZZERIA_HOURS ?></span>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="<?= BASE_URL ?>/" class="navbar-brand">Pizzeria <span>Dal Tano</span></a>
        <ul class="navbar-menu" id="navMenu">
            <li><a href="#about">Chi Siamo</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#gallery">Galleria</a></li>
            <li><a href="#reviews">Recensioni</a></li>
            <li><a href="#contacts" class="btn-nav">Contatti</a></li>
        </ul>
        <div class="hamburger" id="hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">Caldogno, Vicenza</div>
        <h1 class="hero-title">La pizza<br>che <em>racconta</em><br>una storia.</h1>
        <p class="hero-sub">Impasto a lenta lievitazione 48 ore, ingredienti selezionati,<br>la tradizione napoletana nel cuore del Veneto.</p>
        <div class="hero-actions">
            <a href="#menu" class="btn-primary">Scopri il Menu</a>
            <a href="#contacts" class="btn-outline">Contattaci</a>
        </div>
    </div>
    <div class="hero-scroll">
        <div class="hero-scroll-line"></div>
        Scorri
    </div>
</section>

<!-- CHI SIAMO -->
<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-img-wrap fade-up">
                <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80" alt="La nostra pizzeria" class="about-img">
                <div class="about-img-badge">
                    <strong>Dal Tano</strong>
                    <span>Autentica pizza</span>
                </div>
            </div>
            <div class="fade-up">
                <div class="section-label">Chi Siamo</div>
                <h2 class="section-title">Una passione<br>diventata arte.</h2>
                <div class="section-line"></div>
                <p class="section-text">Pizzeria Dal Tano nasce dalla passione per la vera pizza napoletana. Ogni giorno prepariamo i nostri impasti con farine selezionate, lasciandoli maturare per 48 ore per ottenere una pizza leggera, digeribile e piena di sapore.</p>
                <p class="section-text" style="margin-top:16px;">Situati nel cuore di Caldogno, vi aspettiamo dal lunedì al domenica (escluso il martedì) per farvi vivere un'esperienza autentica.</p>
                <div class="about-features">
                    <div class="about-feature">
                        <div class="about-feature-icon">🌾</div>
                        <div>
                            <strong>Farine selezionate</strong>
                            <p>Solo farine di alta qualità per un impasto perfetto</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">⏱</div>
                        <div>
                            <strong>Lievitazione 48h</strong>
                            <p>Lunga maturazione per una pizza leggera e digeribile</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">🍅</div>
                        <div>
                            <strong>Ingredienti freschi</strong>
                            <p>Prodotti locali e di stagione ogni giorno</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">🔥</div>
                        <div>
                            <strong>Forno a legna</strong>
                            <p>Cottura tradizionale per il sapore autentico</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ANTEPRIMA MENU -->
<section class="menu-preview" id="menu">
    <div class="container">
        <div class="menu-preview-head fade-up">
            <div>
                <div class="section-label">Cosa Offriamo</div>
                <h2 class="section-title">Il Nostro Menu</h2>
                <div class="section-line"></div>
            </div>
            <a href="<?= BASE_URL ?>/menu" class="btn-primary">Vedi Menu Completo</a>
        </div>
        <div class="categories-grid fade-up">
            <?php
            $catImages = [
                'Pizze Rosse'    => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=600&q=80',
                'Pizze Bianche'  => 'https://images.unsplash.com/photo-1571997478779-2adcbbe9ab2f?w=600&q=80',
                'Pizze Speciali' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&q=80',
                'Antipasti'      => 'https://images.unsplash.com/photo-1555992336-03a23c7b20ee?w=600&q=80',
                'Fritti'         => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=600&q=80',
                'Dolci'          => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=600&q=80',
            ];
            $defaultImg = 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=600&q=80';
            foreach ($categories as $cat):
                $img = $catImages[$cat['name']] ?? $defaultImg;
            ?>
            <a href="<?= BASE_URL ?>/menu#cat-<?= $cat['id'] ?>" class="cat-card">
                <img src="<?= $img ?>" alt="<?= htmlspecialchars($cat['name']) ?>" loading="lazy">
                <div class="cat-card-overlay"></div>
                <div class="cat-card-label"><?= htmlspecialchars($cat['name']) ?></div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- GALLERIA -->
<section class="gallery" id="gallery">
    <div class="container">
        <div class="fade-up">
            <div class="section-label">I Nostri Scatti</div>
            <h2 class="section-title">Galleria</h2>
            <div class="section-line"></div>
        </div>
    </div>
    <div class="gallery-grid fade-up" style="margin-top:48px;">
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1544982503-9f984c14501a?w=800&q=80" alt="Pizza artigianale" loading="lazy">
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1593560708920-61dd98c46a4e?w=600&q=80" alt="Ingredienti freschi" loading="lazy">
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&q=80" alt="Il locale" loading="lazy">
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=600&q=80" alt="Pizza speciale" loading="lazy">
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1571997478779-2adcbbe9ab2f?w=600&q=80" alt="Pizza bianca" loading="lazy">
        </div>
    </div>
</section>

<!-- RECENSIONI -->
<section class="reviews" id="reviews">
    <div class="container">
        <div class="reviews-head fade-up">
            <div class="section-label">Cosa Dicono di Noi</div>
            <h2 class="section-title">Recensioni</h2>
            <div class="section-line"></div>
            <p class="section-text" style="margin: 0 auto;">Le parole dei nostri clienti sono il premio più bello.</p>
        </div>
        <div class="reviews-grid fade-up">
            <div class="review-card">
                <div class="review-quote">"</div>
                <p class="review-text">Che dire, la pizza è il top della zona. Servizio delle ragazze molto professionali e gentili, il sorriso è sempre un bel biglietto da visita. Il titolare Cristiano è come un cinema all'aperto, sempre imprevedibile, ma di una simpatia unica. Merita davvero di essere visitata, ma soprattutto assaggiare il loro repertorio, ne vale la pena.</p>
                <div class="review-author">
                    <div class="review-avatar">👤</div>
                    <div>
                        <div class="review-name">Moreno</div>
                        <div class="review-stars">★★★★★</div>
                        <div class="review-source">Google Reviews</div>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-quote">"</div>
                <p class="review-text">Pizza ottima e ingredienti di qualità. Consiglio Pizzeria Dal Tano a tutte quelle persone che come me si accontentano solo del meglio.</p>
                <div class="review-author">
                    <div class="review-avatar">👤</div>
                    <div>
                        <div class="review-name">Massimo</div>
                        <div class="review-stars">★★★★★</div>
                        <div class="review-source">Google Reviews</div>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-quote">"</div>
                <p class="review-text">Pizza d'asporto ottima, impasto sottile, personale gentile.</p>
                <div class="review-author">
                    <div class="review-avatar">👤</div>
                    <div>
                        <div class="review-name">Alessandro</div>
                        <div class="review-stars">★★★★★</div>
                        <div class="review-source">Google Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTATTI -->
<section class="contacts" id="contacts">
    <div class="container">
        <div class="contacts-grid">
            <div class="fade-up">
                <div class="section-label">Dove Siamo</div>
                <h2 class="section-title">Vieni a<br>trovarci.</h2>
                <div class="section-line"></div>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div>
                            <h4>Indirizzo</h4>
                            <p><?= PIZZERIA_ADDRESS ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div>
                            <h4>Telefono</h4>
                            <p><a href="tel:<?= PIZZERIA_PHONE ?>"><?= PIZZERIA_PHONE ?></a></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">🕐</div>
                        <div>
                            <h4>Orari</h4>
                            <p><?= PIZZERIA_HOURS ?></p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div>
                            <h4>Email</h4>
                            <p><a href="mailto:<?= PIZZERIA_EMAIL ?>"><?= PIZZERIA_EMAIL ?></a></p>
                        </div>
                    </div>
                </div>
                <div class="map-wrap" style="margin-top:32px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.2!2d11.508611!3d45.617778!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477f5a6b3e8b3a0d%3A0x0!2sVia+Capovilla%2C+90%2C+36030+Caldogno+VI!5e0!3m2!1sit!2sit!4v1"
                        width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
            <div class="form-side fade-up">
                <div class="section-label">Scrivici</div>
                <h2 class="section-title">Hai una<br>domanda?</h2>
                <div class="section-line"></div>

                <?php if (!empty($flashMsg)): ?>
                    <div class="form-flash form-flash-<?= $flashMsg['type'] ?>">
                        <?= $flashMsg['type'] === 'success' ? '✓' : '⚠' ?> <?= htmlspecialchars($flashMsg['msg']) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>/contatti" class="contact-form" novalidate>
                    <?= $csrf ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nome *</label>
                            <input type="text" name="name" required placeholder="Il tuo nome">
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" required placeholder="email@esempio.it">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Oggetto</label>
                        <input type="text" name="subject" placeholder="Di cosa vuoi parlarci?">
                    </div>
                    <div class="form-group">
                        <label>Messaggio *</label>
                        <textarea name="message" required placeholder="Scrivi il tuo messaggio..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-privacy">
                            <input type="checkbox" name="privacy_accepted" required>
                            Ho letto e accetto la <a href="#" style="color:var(--orange)">Privacy Policy</a>. I dati inviati saranno usati esclusivamente per rispondere alla tua richiesta.
                        </label>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;padding:14px;text-align:center;border:none;cursor:pointer;font-family:'Jost',sans-serif;">Invia Messaggio</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand"><?= PIZZERIA_NAME ?></div>
            <p class="footer-text">Autentica pizza napoletana a Caldogno, Vicenza. Impasto a lenta lievitazione, ingredienti selezionati ogni giorno.</p>
        </div>
        <div>
            <div class="footer-title">Navigazione</div>
            <ul class="footer-list">
                <li><a href="#about">Chi Siamo</a></li>
                <li><a href="<?= BASE_URL ?>/menu">Menu</a></li>
                <li><a href="#gallery">Galleria</a></li>
                <li><a href="#contacts">Contatti</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-title">Informazioni</div>
            <ul class="footer-list">
                <li>📍 <?= PIZZERIA_ADDRESS ?></li>
                <li>📞 <?= PIZZERIA_PHONE ?></li>
                <li>🕐 Lun, Mer-Dom: 17:00–22:00</li>
                <li>❌ Martedì: Chiuso</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= PIZZERIA_NAME ?>. Tutti i diritti riservati.</p>
        <p>Realizzato con ❤ a Caldogno</p>
    </div>
</footer>

<script>
// Hamburger menu
function toggleMenu() {
    document.getElementById('navMenu').classList.toggle('open');
}

// Scroll animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
}, { threshold: 0.1 });
document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>
</body>
</html>