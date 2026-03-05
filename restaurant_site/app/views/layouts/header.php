<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? PIZZERIA_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <div class="topbar-inner">
        <span>📍 <?= PIZZERIA_ADDRESS ?></span>
        <span>📞 <?= PIZZERIA_PHONE ?></span>
        <span>🕐 <?= PIZZERIA_HOURS ?></span>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="<?= BASE_URL ?>/" class="navbar-brand"><?= PIZZERIA_NAME ?></a>
        <ul class="navbar-menu">
            <li><a href="<?= BASE_URL ?>/">Home</a></li>
            <li><a href="<?= BASE_URL ?>/menu">Menu</a></li>
            <li><a href="<?= BASE_URL ?>/#contatti">Contatti</a></li>
        </ul>
    </div>
</nav>