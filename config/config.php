<?php
// ─────────────────────────────────────────
//  config/config.php
//  Configurazione globale dell'applicazione
// ─────────────────────────────────────────

// ── Percorsi ──────────────────────────────
define('ROOT_PATH',   dirname(__DIR__));
define('APP_PATH',    ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// ── Database ──────────────────────────────
// Carica configurazione locale se esiste (non committata)
$configLocal = ROOT_PATH . '/config/config.local.php';
if (file_exists($configLocal)) {
    require_once $configLocal;
} else {
    define('DB_HOST',    'localhost');
    define('DB_NAME',    'restaurant_site');
    define('DB_USER',    'root');
    define('DB_PASS',    'root');
}
define('DB_CHARSET', 'utf8mb4');

// ── URL Base ──────────────────────────────
define('BASE_URL', 'http://localhost');

// ── Upload ────────────────────────────────
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads/products');
define('UPLOAD_URL',  BASE_URL   . '/uploads/products');

// ── Sicurezza ─────────────────────────────
define('SESSION_NAME',     'rs_session');
define('SESSION_LIFETIME', 3600);

// ── Pizzeria ──────────────────────────────
define('PIZZERIA_NAME',    'Pizzeria Dal Tano');
define('PIZZERIA_ADDRESS', 'Via Capovilla, 90, 36030 Caldogno (VI)');
define('PIZZERIA_PHONE',   '+39 0444 043168');
define('PIZZERIA_EMAIL',   'info@pizzeriadaltano.it');
define('PIZZERIA_HOURS',   'Lun, Mer-Dom: 17:00-22:00 | Martedi: Chiuso');

// ── Ambiente ──────────────────────────────
define('APP_ENV',   'development');
define('APP_DEBUG', true);

if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}