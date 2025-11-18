<?php

class HomeController
{

    public function index()
    {
        $view = "home.php";                   
        include "../app/views/layouts/header.php";
        include "../app/views/$view";
        include "../app/views/layouts/footer.php";
    }
}
