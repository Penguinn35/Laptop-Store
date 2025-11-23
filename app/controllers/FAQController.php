<?php

class FAQController
{

    public function index()
    {
        require_once "../app/core/Database.php";
        require_once "../app/models/FAQ.php";
        require_once "../app/models/Setting.php";

        $db = (new Database())->getConnection();
        $settingModel = new Setting($db);
        $settings = $settingModel->all();
        $faqModel = new FAQ($db);
        $faqs = $faqModel->all();

        $view = "faq.php";
        include "../app/views/layouts/header.php";
        include "../app/views/$view";
        include "../app/views/layouts/footer.php";
    }
}