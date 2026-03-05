<?php
// ─────────────────────────────────────────
//  app/controllers/AuthController.php
// ─────────────────────────────────────────

require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/models/User.php';

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * GET /admin/login
     * Mostra il form di login
     */
    public function loginForm(): void
    {
        // Se già loggato, redirect diretto alla dashboard
        if (Auth::isLoggedIn()) {
            $this->redirect('/admin/dashboard');
        }

        $error   = $_GET['error']   ?? null;
        $expired = $_GET['expired'] ?? null;

        $this->renderPartial('login', [
            'title'   => 'Accesso Admin – ' . PIZZERIA_NAME,
            'error'   => $error,
            'expired' => $expired,
        ]);
    }

    /**
     * POST /admin/login
     * Processa il form di login
     */
    public function login(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/admin/login');
        }

        $username = $this->clean($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validazione base
        if (empty($username) || empty($password)) {
            $this->redirect('/admin/login?error=empty');
        }

        // Verifica credenziali tramite User model
        $admin = $this->userModel->findByUsername($username);

        if ($admin && $this->userModel->verifyPassword($password, $admin['password_hash'])) {
            // Rigenera sessione per prevenire session fixation
            session_regenerate_id(true);

            $_SESSION['admin_id']        = $admin['id'];
            $_SESSION['admin_username']  = $admin['username'];
            $_SESSION['admin_logged_at'] = time();

            $this->redirect('/admin/dashboard');
        } else {
            // Piccolo delay per rallentare brute force
            sleep(1);
            $this->redirect('/admin/login?error=invalid');
        }
    }

    /**
     * GET /admin/logout
     */
    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/admin/login');
    }
}






