<?php
// ─────────────────────────────────────────
//  app/core/Controller.php
//  Controller base – metodi helper comuni
// ─────────────────────────────────────────

abstract class Controller
{
    /**
     * Carica una view passandole i dati.
     *
     * Uso: $this->render('home', ['title' => 'Home'])
     *      $this->render('admin/dashboard', ['products' => $list])
     *
     * @param string $view   Percorso relativo alla cartella views/ (senza .php)
     * @param array  $data   Variabili da rendere disponibili nella view
     */
    protected function render(string $view, array $data = []): void
    {
        // Espone ogni elemento dell'array come variabile nella view
        extract($data, EXTR_SKIP);

        $viewFile = APP_PATH . '/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            if (APP_DEBUG) {
                die("View non trovata: {$viewFile}");
            }
            http_response_code(404);
            exit('Pagina non trovata.');
        }

        // Header e footer sono inclusi automaticamente
        include APP_PATH . '/views/layouts/header.php';
        include $viewFile;
        include APP_PATH . '/views/layouts/footer.php';
    }

    /**
     * Carica una view SENZA layout (utile per AJAX o pagine speciali).
     */
    protected function renderPartial(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewFile = APP_PATH . '/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            if (APP_DEBUG) {
                die("View non trovata: {$viewFile}");
            }
            http_response_code(404);
            exit('Pagina non trovata.');
        }

        include $viewFile;
    }

    /**
     * Reindirizza a un URL relativo a BASE_URL.
     * Esempio: $this->redirect('/menu') → BASE_URL/menu
     */
    protected function redirect(string $path = ''): void
    {
        $url = rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
        header('Location: ' . $url);
        exit;
    }

    /**
     * Risponde con un JSON (utile per future chiamate AJAX).
     */
    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Restituisce true se la richiesta è POST.
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Sanifica un valore stringa in input.
     */
    protected function clean(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
