<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand"><?= PIZZERIA_NAME ?></div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/admin/dashboard" class="active">📊 Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/categories">📂 Categorie</a>
        <a href="<?= BASE_URL ?>/admin/products">🍕 Prodotti</a>
        <a href="<?= BASE_URL ?>/admin/messages">✉️ Messaggi <?php if (!empty($unreadMessages)): ?><span class="card-badge"><?= $unreadMessages ?></span><?php endif; ?></a>
        <a href="<?= BASE_URL ?>/" target="_blank">🌐 Vedi sito</a>
    </nav>
    <div class="sidebar-footer"><a href="<?= BASE_URL ?>/admin/logout">← Esci</a></div>
</aside>
<div class="main">
    <div class="topbar">
        <span class="topbar-title">Dashboard</span>
        <span class="topbar-user">Benvenuto, <span><?= htmlspecialchars($username ?? '') ?></span></span>
    </div>
    <div class="content">
        <div class="cards">
            <div class="card">
                <div class="card-label">Categorie</div>
                <div class="card-value"><?= $totalCategories ?? 0 ?></div>
                <a href="<?= BASE_URL ?>/admin/categories" class="card-link">Gestisci →</a>
            </div>
            <div class="card">
                <div class="card-label">Prodotti</div>
                <div class="card-value"><?= $totalProducts ?? 0 ?></div>
                <a href="<?= BASE_URL ?>/admin/products" class="card-link">Gestisci →</a>
            </div>
            <div class="card">
                <div class="card-label">Messaggi</div>
                <div class="card-value"><?= $totalMessages ?? 0 ?></div>
                <?php if (!empty($unreadMessages)): ?>
                    <a href="<?= BASE_URL ?>/admin/messages" class="card-link"><?= $unreadMessages ?> non letti →</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/admin/messages" class="card-link">Vedi tutti →</a>
                <?php endif; ?>
            </div>
        </div>
        <div style="background:var(--dark-2);border:1px solid rgba(232,130,12,.15);border-radius:8px;padding:24px;">
            <h2 style="font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:8px;">Pannello di amministrazione</h2>
            <p style="color:var(--text-muted);font-size:.875rem;line-height:1.6;">Gestisci menu, categorie e messaggi di <?= PIZZERIA_NAME ?>. Usa il menu laterale per navigare tra le sezioni.</p>
        </div>
    </div>
</div>
</body>
</html>