<?php

namespace EStudy\Controller\Client;

use Ninja\NJBaseController\NJBaseController;

class HomeController extends NJBaseController
{
    public function index()
    {
        $this->view_handler->render('client/home.html.php');
    }
}
