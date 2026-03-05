<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Menu – ' . PIZZERIA_NAME) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --orange: #E8820C; --orange-dk: #C46A00; --dark: #1A1A1A; --dark-2: #242424; --dark-3: #2E2E2E; --text: #F0EDE8; --text-muted: #9A9080; --border: rgba(255,255,255,.07); }
        html { scroll-behavior: smooth; }
        body { font-family: 'Jost', sans-serif; background: var(--dark); color: var(--text); }

        /* Topbar + Navbar (same as home) */
        .topbar { background: #111; padding: 9px 0; border-bottom: 1px solid var(--border); }
        .topbar-inner { max-width: 1200px; margin: auto; padding: 0 24px; display: flex; gap: 28px; flex-wrap: wrap; }
        .topbar-inner span { font-size: .78rem; color: var(--text-muted); }
        .navbar { background: var(--dark-2); padding: 0; position: sticky; top: 0; z-index: 100; border-bottom: 1px solid var(--border); }
        .navbar-inner { max-width: 1200px; margin: auto; padding: 0 24px; display: flex; justify-content: space-between; align-items: center; height: 68px; }
        .navbar-brand { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: var(--text); text-decoration: none; }
        .navbar-brand span { color: var(--orange); }
        .navbar-menu { list-style: none; display: flex; gap: 8px; }
        .navbar-menu a { padding: 8px 16px; font-size: .82rem; letter-spacing: .08em; text-transform: uppercase; color: var(--text-muted); text-decoration: none; transition: color .2s; }
        .navbar-menu a:hover { color: var(--text); }
        .navbar-menu .btn-nav { background: var(--orange); color: #fff; border-radius: 4px; }
        .navbar-menu .btn-nav:hover { background: var(--orange-dk); }

        /* Hero menu */
        .menu-hero { position: relative; height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .menu-hero-bg { position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=1400&q=80') center/cover; }
        .menu-hero-bg::after { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,.65); }
        .menu-hero-content { position: relative; z-index: 2; text-align: center; }
        .menu-hero-content p { font-size: .75rem; letter-spacing: .22em; text-transform: uppercase; color: var(--orange); margin-bottom: 12px; }
        .menu-hero-content h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.2rem, 5vw, 3.5rem); color: #fff; }

        /* Sticky category nav */
        .cat-nav { background: var(--dark-2); border-bottom: 1px solid var(--border); position: sticky; top: 68px; z-index: 90; }
        .cat-nav-inner { max-width: 1200px; margin: auto; padding: 0 24px; display: flex; gap: 0; overflow-x: auto; scrollbar-width: none; }
        .cat-nav-inner::-webkit-scrollbar { display: none; }
        .cat-nav-inner a { padding: 16px 20px; font-size: .78rem; letter-spacing: .08em; text-transform: uppercase; color: var(--text-muted); text-decoration: none; white-space: nowrap; border-bottom: 2px solid transparent; transition: all .2s; }
        .cat-nav-inner a:hover { color: var(--text); }
        .cat-nav-inner a.active { color: var(--orange); border-bottom-color: var(--orange); }

        /* Menu content */
        .menu-content { max-width: 1200px; margin: auto; padding: 56px 24px; }
        .cat-section { margin-bottom: 64px; }
        .cat-section:last-child { margin-bottom: 0; }
        .cat-title { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 8px; }
        .cat-divider { width: 40px; height: 2px; background: var(--orange); margin-bottom: 32px; }
        .products-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 6px; overflow: hidden; }
        .product-item { background: var(--dark-2); padding: 18px 20px; display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; transition: background .2s; }
        .product-item:hover { background: var(--dark-3); }
        .product-info { flex: 1; }
        .product-name { font-size: .95rem; font-weight: 500; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
        .product-desc { font-size: .8rem; color: var(--text-muted); line-height: 1.5; }
        .product-price { font-size: 1rem; font-weight: 600; color: var(--orange); white-space: nowrap; flex-shrink: 0; }
        .product-dots { flex: 1; border-bottom: 1px dotted rgba(255,255,255,.1); margin: 0 8px; align-self: flex-end; margin-bottom: 6px; }

        /* Footer */
        .footer { background: #111; padding: 40px 24px; border-top: 1px solid var(--border); text-align: center; }
        .footer p { font-size: .8rem; color: var(--text-muted); line-height: 2; }
        .footer a { color: var(--orange); }

        @media (max-width: 700px) {
            .products-grid { grid-template-columns: 1fr; }
            .navbar-menu { display: none; }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-inner">
        <span>📍 <?= PIZZERIA_ADDRESS ?></span>
        <span>📞 <?= PIZZERIA_PHONE ?></span>
        <span>🕐 <?= PIZZERIA_HOURS ?></span>
    </div>
</div>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="<?= BASE_URL ?>/" class="navbar-brand">Pizzeria <span>Dal Tano</span></a>
        <ul class="navbar-menu">
            <li><a href="<?= BASE_URL ?>/#about">Chi Siamo</a></li>
            <li><a href="<?= BASE_URL ?>/menu" style="color:var(--orange)">Menu</a></li>
            <li><a href="<?= BASE_URL ?>/#gallery">Galleria</a></li>
            <li><a href="<?= BASE_URL ?>/#contacts" class="btn-nav">Contatti</a></li>
        </ul>
    </div>
</nav>

<div class="menu-hero">
    <div class="menu-hero-bg"></div>
    <div class="menu-hero-content">
        <p>Pizzeria Dal Tano</p>
        <h1>Il Nostro Menu</h1>
    </div>
</div>

<?php if (!empty($menuData)): ?>
<nav class="cat-nav">
    <div class="cat-nav-inner">
        <?php foreach ($menuData as $section): ?>
            <a href="#cat-<?= $section['category']['id'] ?>"><?= htmlspecialchars($section['category']['name']) ?></a>
        <?php endforeach; ?>
    </div>
</nav>
<?php endif; ?>

<div class="menu-content">
    <?php if (empty($menuData)): ?>
        <div style="text-align:center;padding:80px 0;color:var(--text-muted);">
            <p style="font-size:2rem;margin-bottom:16px;">🍕</p>
            <p>Menu in aggiornamento, torna presto!</p>
        </div>
    <?php else: ?>
        <?php foreach ($menuData as $section): ?>
        <div class="cat-section" id="cat-<?= $section['category']['id'] ?>">
            <h2 class="cat-title"><?= htmlspecialchars($section['category']['name']) ?></h2>
            <div class="cat-divider"></div>
            <div class="products-grid">
                <?php foreach ($section['products'] as $product): ?>
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                        <?php if (!empty($product['description'])): ?>
                            <div class="product-desc"><?= htmlspecialchars($product['description']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="product-dots"></div>
                    <div class="product-price">€ <?= number_format($product['price'], 2, ',', '.') ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<footer class="footer">
    <p><?= PIZZERIA_NAME ?> &nbsp;|&nbsp; <?= PIZZERIA_ADDRESS ?></p>
    <p><?= PIZZERIA_PHONE ?> &nbsp;|&nbsp; <?= PIZZERIA_HOURS ?></p>
    <p style="margin-top:12px;">&copy; <?= date('Y') ?> <?= PIZZERIA_NAME ?>. Tutti i diritti riservati.</p>
</footer>

<script>
// Highlight active category in nav on scroll
const sections = document.querySelectorAll('.cat-section');
const navLinks = document.querySelectorAll('.cat-nav-inner a');
window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(s => { if (window.scrollY >= s.offsetTop - 150) current = s.id; });
    navLinks.forEach(a => {
        a.classList.toggle('active', a.getAttribute('href') === '#' + current);
    });
});
</script>
</body>
</html>