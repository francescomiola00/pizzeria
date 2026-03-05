<?php
// ─────────────────────────────────────────
//  app/core/Auth.php
//  Gestione sessione admin
// ─────────────────────────────────────────

class Auth
{
    /** Avvia la sessione (se non già attiva) */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);

            session_set_cookie_params([
                'lifetime' => SESSION_LIFETIME,
                'path'     => '/',
                'secure'   => false,    // true in produzione con HTTPS
                'httponly' => true,
                'samesite' => 'Strict',
            ]);

            session_start();
        }
    }

    /**
     * Effettua il login dell'admin.
     * Usa il model User per verificare le credenziali.
     *
     * @return bool true se le credenziali sono corrette
     */
    public static function login(string $username, string $password): bool
    {
        // Carica il model User
        require_once APP_PATH . '/models/User.php';
        $userModel = new User();

        $admin = $userModel->findByUsername($username);

        if ($admin && $userModel->verifyPassword($password, $admin['password_hash'])) {
            // Rigenera l'ID di sessione per prevenire session fixation
            session_regenerate_id(true);

            $_SESSION['admin_id']        = $admin['id'];
            $_SESSION['admin_username']  = $admin['username'];
            $_SESSION['admin_logged_at'] = time();

            return true;
        }

        return false;
    }

    /** Distrugge la sessione e fa il logout */
    public static function logout(): void
    {
        self::start();
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Controlla se l'admin è autenticato.
     * Se non lo è, reindirizza al login.
     * Da chiamare all'inizio di ogni metodo protetto.
     */
    public static function check(): void
    {
        self::start();

        if (empty($_SESSION['admin_id'])) {
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }

        // Verifica scadenza sessione
        if (isset($_SESSION['admin_logged_at'])) {
            if (time() - $_SESSION['admin_logged_at'] > SESSION_LIFETIME) {
                self::logout();
                header('Location: ' . BASE_URL . '/admin/login?expired=1');
                exit;
            }
            // Rinnova il timestamp ad ogni richiesta
            $_SESSION['admin_logged_at'] = time();
        }
    }

    /** Restituisce true se l'admin è loggato (senza redirect) */
    public static function isLoggedIn(): bool
    {
        self::start();
        return !empty($_SESSION['admin_id']);
    }

    /** Restituisce lo username dell'admin corrente */
    public static function username(): string
    {
        return $_SESSION['admin_username'] ?? '';
    }

    /** Restituisce l'ID dell'admin corrente */
    public static function id(): int
    {
        return (int) ($_SESSION['admin_id'] ?? 0);
    }
}