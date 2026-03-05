<?php
// ─────────────────────────────────────────
//  app/core/Router.php
//  Router minimale – gestisce URL tipo:
//    /               → HomeController@index
//    /menu           → MenuController@index
//    /contatti       → HomeController@contatti
//    /admin          → AdminController@index
//    /admin/products → AdminController@products
//    /admin/login    → AuthController@login
// ─────────────────────────────────────────

class Router
{
    /** Mappa delle route: 'uri' => ['controller' => '...', 'action' => '...'] */
    private array $routes = [];

    /** Aggiunge una route GET */
    public function get(string $uri, string $controller, string $action = 'index'): void
    {
        $this->routes['GET'][$uri] = compact('controller', 'action');
    }

    /** Aggiunge una route POST */
    public function post(string $uri, string $controller, string $action = 'index'): void
    {
        $this->routes['POST'][$uri] = compact('controller', 'action');
    }

    /** Esegue il dispatch della richiesta corrente */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = $this->parseUri();

        // Cerca una route esatta
        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            $this->call($route['controller'], $route['action']);
            return;
        }

        // Route non trovata → 404
        http_response_code(404);
        if (APP_DEBUG) {
            die("404 – Route non trovata: [{$method}] {$uri}");
        }
        echo '<h1>404 – Pagina non trovata</h1>';
    }

    // ── Metodi privati ───────────────────

    /** Normalizza l'URI rimuovendo la BASE_URL e i parametri query */
    private function parseUri(): string
{
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';

    // Rimuove query string
    $uri = strtok($requestUri, '?');
    $uri = $uri ?: '/';

    // Rimuove il base path
    $basePath = parse_url(BASE_URL, PHP_URL_PATH) ?? '';
    $basePath = rtrim($basePath, '/');

    if ($basePath !== '' && strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }

    // Normalizza
    $uri = '/' . ltrim($uri, '/');
    if ($uri !== '/') {
        $uri = rtrim($uri, '/');
    }

    return $uri;
}

    /** Istanzia il controller e chiama l'action */
    private function call(string $controllerName, string $action): void
    {
        $file = APP_PATH . '/controllers/' . $controllerName . '.php';

        if (!file_exists($file)) {
            http_response_code(500);
            if (APP_DEBUG) {
                die("Controller non trovato: {$controllerName}");
            }
            exit('Errore interno del server.');
        }

        require_once $file;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            if (APP_DEBUG) {
                die("Classe non trovata: {$controllerName}");
            }
            exit('Errore interno del server.');
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(500);
            if (APP_DEBUG) {
                die("Action non trovata: {$controllerName}::{$action}");
            }
            exit('Errore interno del server.');
        }

        $controller->$action();
    }
}
