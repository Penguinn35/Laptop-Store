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
        }
    }
}
