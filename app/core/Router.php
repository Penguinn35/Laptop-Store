<?php

class Router
{

    public static function handle()
    {
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'home':
                require_once "../app/controllers/HomeController.php";
                (new HomeController())->index();
                break;
            case 'logout':
                require "../app/controllers/AuthController.php";
                (new AuthController())->logout();
                break;
            case 'admin':
                require_once "../app/controllers/AdminController.php";
                (new AdminController())->index();
                break;
            case 'contact':
                include "../app/controllers/ContactController.php";
                (new ContactController())->index();
                break;
            case 'news':
                require_once "../app/controllers/NewsController.php";
                (new NewsController())->index();
                break;

            case 'admin_contacts':
                require_once "../app/controllers/AdminController.php";
                (new AdminController())->contacts();
                break;
            case 'contact_mark':
                require "../app/controllers/AdminController.php";
                (new AdminController())->markContact();
                break;

            case 'contact_delete':
                require "../app/controllers/AdminController.php";
                (new AdminController())->deleteContact();
                break;
            case 'admin_settings':
                require_once "../app/controllers/AdminController.php";
                (new AdminController())->settings();
                break;
            default:
                echo "404 - Page not found";
                break;
            case 'products':
                require_once "../app/controllers/ProductController.php";
                (new ProductController())->index();
                break;

            case 'product_detail':
                require_once "../app/controllers/ProductController.php";
                (new ProductController())->detail();
                break;

            case 'cart':
                require_once "../app/controllers/ProductController.php";
                (new ProductController())->cart();
                break;
           
            case 'cart_add':
                require_once "../app/controllers/ProductController.php";
                (new ProductController())->addToCart();
                break;

            case 'checkout':
                require_once "../app/controllers/ProductController.php";
                (new ProductController())->checkout();
                break;    

            // Admin quản lý sản phẩm
            case 'admin_products':
                require_once "../app/controllers/AdminProductController.php";
                (new AdminProductController())->index();
                break;
            case 'admin_product_create':
                require_once "../app/controllers/AdminProductController.php";
                (new AdminProductController())->create();
                break;
            case 'admin_product_edit':
                require_once "../app/controllers/AdminProductController.php";
                (new AdminProductController())->edit();
                break;
            case 'admin_product_delete':
                require_once "../app/controllers/AdminProductController.php";
                (new AdminProductController())->delete();
                break;

            // Admin quản lý đơn hàng
            case 'admin_orders':
                require_once "../app/controllers/AdminOrderController.php";
                (new AdminOrderController())->index();
                break;
            case 'admin_order_view':
                require_once "../app/controllers/AdminOrderController.php";
                (new AdminOrderController())->view();
                break;

        }
    }
}
