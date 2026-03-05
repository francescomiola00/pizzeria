<?php
// ─────────────────────────────────────────
//  app/controllers/AdminController.php
// ─────────────────────────────────────────

require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/models/Category.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/Message.php';

class AdminController extends Controller
{
    private Category $categoryModel;
    private Product  $productModel;
    private Message  $messageModel;

    public function __construct()
    {
        Auth::check();
        $this->categoryModel = new Category();
        $this->productModel  = new Product();
        $this->messageModel  = new Message();
    }

    // ── Dashboard ────────────────────────────────

    public function index(): void
    {
        $this->renderPartial('admin/dashboard', [
            'title'          => 'Dashboard – ' . PIZZERIA_NAME,
            'username'       => Auth::username(),
            'totalCategories'=> $this->categoryModel->count(),
            'totalProducts'  => $this->productModel->count(),
            'totalMessages'  => $this->messageModel->count(),
            'unreadMessages' => $this->messageModel->countUnread(),
        ]);
    }

    // ── Categorie ────────────────────────────────

    public function categories(): void
    {
        $this->renderPartial('admin/categories', [
            'title'      => 'Categorie – ' . PIZZERIA_NAME,
            'username'   => Auth::username(),
            'categories' => $this->categoryModel->getAll(),
            'flash'      => $_SESSION['flash'] ?? null,
        ]);
        unset($_SESSION['flash']);
    }

    public function storeCategory(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/categories'); }

        $name      = $this->clean($_POST['name'] ?? '');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if (empty($name)) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Il nome è obbligatorio.'];
        } elseif ($this->categoryModel->nameExists($name)) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Esiste già una categoria con questo nome.'];
        } else {
            $this->categoryModel->create($name, $sortOrder);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Categoria creata con successo.'];
        }
        $this->redirect('/admin/categories');
    }

    public function updateCategory(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/categories'); }

        $id        = (int) ($_POST['id'] ?? 0);
        $name      = $this->clean($_POST['name'] ?? '');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if (empty($name)) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Il nome è obbligatorio.'];
        } elseif ($this->categoryModel->nameExists($name, $id)) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Esiste già una categoria con questo nome.'];
        } else {
            $this->categoryModel->update($id, $name, $sortOrder);
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Categoria aggiornata.'];
        }
        $this->redirect('/admin/categories');
    }

    public function deleteCategory(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/categories'); }
        $id = (int) ($_POST['id'] ?? 0);
        $this->categoryModel->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Categoria eliminata.'];
        $this->redirect('/admin/categories');
    }

    // ── Prodotti ─────────────────────────────────

    public function products(): void
    {
        $this->renderPartial('admin/products', [
            'title'      => 'Prodotti – ' . PIZZERIA_NAME,
            'username'   => Auth::username(),
            'products'   => $this->productModel->getAll(),
            'categories' => $this->categoryModel->getAll(),
            'flash'      => $_SESSION['flash'] ?? null,
        ]);
        unset($_SESSION['flash']);
    }

    public function storeProduct(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/products'); }

        $name = $this->clean($_POST['name'] ?? '');
        if (empty($name) || empty($_POST['category_id']) || empty($_POST['price'])) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Nome, categoria e prezzo sono obbligatori.'];
            $this->redirect('/admin/products');
        }

        $this->productModel->create([
            'category_id'  => $_POST['category_id'],
            'name'         => $name,
            'description'  => $this->clean($_POST['description'] ?? ''),
            'price'        => $_POST['price'],
            'is_available' => $_POST['is_available'] ?? null,
            'sort_order'   => $_POST['sort_order'] ?? 0,
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Prodotto aggiunto.'];
        $this->redirect('/admin/products');
    }

    public function updateProduct(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/products'); }

        $id   = (int) ($_POST['id'] ?? 0);
        $name = $this->clean($_POST['name'] ?? '');

        if (empty($name) || empty($_POST['category_id']) || empty($_POST['price'])) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Nome, categoria e prezzo sono obbligatori.'];
            $this->redirect('/admin/products');
        }

        $this->productModel->update($id, [
            'category_id'  => $_POST['category_id'],
            'name'         => $name,
            'description'  => $this->clean($_POST['description'] ?? ''),
            'price'        => $_POST['price'],
            'is_available' => $_POST['is_available'] ?? null,
            'sort_order'   => $_POST['sort_order'] ?? 0,
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Prodotto aggiornato.'];
        $this->redirect('/admin/products');
    }

    public function deleteProduct(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/products'); }
        $id = (int) ($_POST['id'] ?? 0);
        $this->productModel->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Prodotto eliminato.'];
        $this->redirect('/admin/products');
    }

    // ── Messaggi ─────────────────────────────────

    public function messages(): void
    {
        $this->renderPartial('admin/messages', [
            'title'    => 'Messaggi – ' . PIZZERIA_NAME,
            'username' => Auth::username(),
            'messages' => $this->messageModel->getAll(),
            'flash'    => $_SESSION['flash'] ?? null,
        ]);
        unset($_SESSION['flash']);
    }

    public function markRead(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/messages'); }
        $id = (int) ($_POST['id'] ?? 0);
        $this->messageModel->markAsRead($id);
        $this->redirect('/admin/messages');
    }

    public function deleteMessage(): void
    {
        if (!$this->isPost()) { $this->redirect('/admin/messages'); }
        $id = (int) ($_POST['id'] ?? 0);
        $this->messageModel->delete($id);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Messaggio eliminato.'];
        $this->redirect('/admin/messages');
    }
}