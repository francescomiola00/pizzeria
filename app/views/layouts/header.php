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

<div class="topbar">
    <div class="topbar-inner">
        <span>📍 <?= PIZZERIA_ADDRESS ?></span>
        <span>📞 <a href="tel:<?= PIZZERIA_PHONE ?>" style="color:var(--orange)"><?= PIZZERIA_PHONE ?></a></span>
        <span>🕐 <?= PIZZERIA_HOURS ?></span>
    </div>
</div>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="<?= BASE_URL ?>/" class="navbar-brand">Pizzeria <span style="color:var(--orange)">Dal Tano</span></a>
        <ul class="navbar-menu" id="navMenu">
            <li><a href="<?= BASE_URL ?>/#about">Chi Siamo</a></li>
            <li><a href="<?= BASE_URL ?>/menu">Menu</a></li>
            <li><a href="<?= BASE_URL ?>/#gallery">Galleria</a></li>
            <li><a href="<?= BASE_URL ?>/#reviews">Recensioni</a></li>
            <li><a href="<?= BASE_URL ?>/#contacts" class="btn-nav">Contatti</a></li>
        </ul>
        <div class="hamburger" id="hamburger" onclick="document.getElementById('navMenu').classList.toggle('open')">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>