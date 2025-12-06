<?php

class HomeController
{

    public function index()
    {

        require_once "../app/core/Database.php";
        require_once "../app/models/Setting.php";
        require_once "../app/models/Laptop.php";
        require_once "../app/models/Posts.php";
        $db = (new Database())->getConnection();
        $settingModel = new Setting($db);
        $settings = $settingModel->all();

        $laptopModel = new Laptop();
        $postModel = new Posts($db);
        $settings = $settingModel->all();

        // Fetch 3 featured products
        $products = $laptopModel->getAll('', 3, 0);

        // Fetch 3 featured news
        $posts = $postModel->getPosts(3, 0, '');
        $pageCss = "home";
        include "../app/views/layouts/header.php";
        include "../app/views/home.php";
        include "../app/views/layouts/footer.php";
    }
}
