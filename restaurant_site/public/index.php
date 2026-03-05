<?php
// ─────────────────────────────────────────
//  public/index.php
//  Front Controller – unico punto di ingresso
// ─────────────────────────────────────────

// ── Bootstrap ─────────────────────────────
require_once dirname(__DIR__) . '/config/config.php';
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Auth.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Router.php';

// ── Avvia la sessione ─────────────────────
Auth::start();

// ── Definizione Route ─────────────────────
$router = new Router();

// Pagine pubbliche
$router->get('/',         'HomeController', 'index');
$router->get('/menu',     'MenuController',  'index');
$router->post('/contatti', 'HomeController', 'sendMessage');

// Admin – autenticazione
$router->get('/admin/login',  'AuthController', 'loginForm');
$router->post('/admin/login', 'AuthController', 'login');
$router->get('/admin/logout', 'AuthController', 'logout');

// Admin – dashboard
$router->get('/admin',          'AdminController', 'index');
$router->get('/admin/dashboard','AdminController', 'index');

// Admin – categorie
$router->get('/admin/categories',         'AdminController', 'categories');
$router->post('/admin/categories/store',  'AdminController', 'storeCategory');
$router->post('/admin/categories/update', 'AdminController', 'updateCategory');
$router->post('/admin/categories/delete', 'AdminController', 'deleteCategory');

// Admin – prodotti
$router->get('/admin/products',         'AdminController', 'products');
$router->post('/admin/products/store',  'AdminController', 'storeProduct');
$router->post('/admin/products/update', 'AdminController', 'updateProduct');
$router->post('/admin/products/delete', 'AdminController', 'deleteProduct');

// Admin – messaggi
$router->get('/admin/messages',              'AdminController', 'messages');
$router->post('/admin/messages/read',        'AdminController', 'markRead');
$router->post('/admin/messages/delete',      'AdminController', 'deleteMessage');

// ── Dispatch ──────────────────────────────
$router->dispatch();
