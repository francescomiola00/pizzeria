<?php
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/models/Category.php';
require_once APP_PATH . '/models/Product.php';

class MenuController extends Controller
{
    public function index(): void
    {
        $categoryModel = new Category();
        $productModel  = new Product();

        $categories = $categoryModel->getAll();
        $menuData   = [];

        foreach ($categories as $cat) {
            $products = $productModel->getByCategory($cat['id']);
            if (!empty($products)) {
                $menuData[] = [
                    'category' => $cat,
                    'products' => $products,
                ];
            }
        }

        $this->renderPartial('menu', [
            'title'    => 'Menu – ' . PIZZERIA_NAME,
            'menuData' => $menuData,
        ]);
    }
}