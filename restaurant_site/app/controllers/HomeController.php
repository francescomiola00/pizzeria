<?php
// ─────────────────────────────────────────
//  app/controllers/HomeController.php
// ─────────────────────────────────────────

require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/models/Category.php';
require_once APP_PATH . '/models/Message.php';

class HomeController extends Controller
{
    private Category $categoryModel;
    private Message  $messageModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
        $this->messageModel  = new Message();
    }

    /** GET / */
    public function index(): void
    {
        $flashMsg = $_SESSION['flash_contact'] ?? null;
        unset($_SESSION['flash_contact']);

        $this->renderPartial('home', [
            'title'      => PIZZERIA_NAME . ' – Pizza Artigianale a Caldogno',
            'categories' => $this->categoryModel->getAll(),
            'flashMsg'   => $flashMsg,
        ]);
    }

    /** POST /contatti */
    public function sendMessage(): void
    {
        if (!$this->isPost()) {
            $this->redirect('/');
        }

        $name    = $this->clean($_POST['name']    ?? '');
        $email   = $this->clean($_POST['email']   ?? '');
        $subject = $this->clean($_POST['subject'] ?? '');
        $message = $this->clean($_POST['message'] ?? '');
        $privacy = isset($_POST['privacy_accepted']);

        // Validazione
        if (empty($name) || empty($email) || empty($message) || !$privacy) {
            $_SESSION['flash_contact'] = [
                'type' => 'error',
                'msg'  => 'Compila tutti i campi obbligatori e accetta la privacy policy.'
            ];
            $this->redirect('/#contacts');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_contact'] = [
                'type' => 'error',
                'msg'  => 'Inserisci un indirizzo email valido.'
            ];
            $this->redirect('/#contacts');
        }

        // Salva messaggio
        $this->messageModel->create([
            'name'             => $name,
            'email'            => $email,
            'subject'          => $subject,
            'message'          => $message,
            'privacy_accepted' => $privacy,
        ]);

        $_SESSION['flash_contact'] = [
            'type' => 'success',
            'msg'  => 'Messaggio inviato! Ti risponderemo al più presto.'
        ];
        $this->redirect('/#contacts');
    }
}