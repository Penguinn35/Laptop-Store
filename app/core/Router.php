<?php

class Router
{

    public static function handle()
    {
        $page = $_GET['page'] ?? 'home';  // mặc định

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

            default:
                echo "404 - Page not found";
                break;
        }
    }
}
