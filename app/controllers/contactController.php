<?php

class ContactController
{

    public function index()
    {
        require_once "../app/core/Database.php";
        require_once "../app/models/Setting.php";
        $db = (new Database())->getConnection();
        $settingModel = new Setting($db);
        $settings = $settingModel->all();

        $pageCss = "contact";
        $pageJs  = "contact";
        include "../app/views/layouts/header.php";
        include "../app/views/contact.php";
        include "../app/views/layouts/footer.php";
    }
}
