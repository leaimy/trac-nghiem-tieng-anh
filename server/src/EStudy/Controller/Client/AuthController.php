<?php

namespace EStudy\Controller\Client;

use Ninja\NJBaseController\NJBaseController;

class AuthController extends NJBaseController
{

    public function sign_in()
    {
        $this->view_handler->render('client/auth/sign_in.html.php');
    }
    
    public function sign_up()
    {
        $this->view_handler->render('client/auth/sign_up.html.php');
    }
    
    public function process_sign_in () {
        try {
            $user_name = $_POST['user_name'] ?? null;
            $password = $_POST['password'] ?? null;
            
            if (is_null($user_name) || is_null($password)) {
                return;
            }
            
            
        } catch (\Exception $e) {
            
        }
    }
}
