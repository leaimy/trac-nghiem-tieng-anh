<?php

namespace EStudy\Controller;

use Ninja\NJBaseController\NJBaseController;

class EStudyBaseController extends NJBaseController
{
    public function handle_on_invalid_authentication(array $args)
    {
        $this->view_handler->render('client/auth/sign_in.html.php');
    }
}
