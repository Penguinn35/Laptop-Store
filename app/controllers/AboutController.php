<?php

class AboutController
{

    public function index()
    {
        require_once "../app/core/Database.php";
        require_once "../app/models/Setting.php";
        require_once "../app/models/Creator.php";

        $db = (new Database())->getConnection();
        $settingModel = new Setting($db);
        $settings = $settingModel->all();

        $creatorModel = new Creator($db);
        $creators = $creatorModel->all();

        $view = "about.php";
        include "../app/views/layouts/header.php";
        include "../app/views/$view";
        include "../app/views/layouts/footer.php";
    }
}