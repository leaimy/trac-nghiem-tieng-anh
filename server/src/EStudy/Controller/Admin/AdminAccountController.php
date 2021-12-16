<?php

namespace EStudy\Controller\Admin;

use EStudy\Model\Admin\UserModel;
use Ninja\NJBaseController\NJBaseController;

class AdminAccountController extends NJBaseController
{
    private $user_model;
    
    public function __construct(UserModel $user_model)
    {
        parent::__construct();
        
        $this->user_model = $user_model;
    }
    
    public function index()
    {
        $page_number = $_GET['page'] ?? 1;
        $page_limit = $_GET['limit'] ?? 50;
        
        $all_users = $this->user_model->get_all_user(null, null, $page_limit, ($page_number - 1) * $page_limit);
        $total = $this->user_model->count();

        $number_of_page = intval(floor($total / $page_limit));

        $this->view_handler->render('admin/admin_account/index.html.php', [
            'all_users' => $all_users,
            'total' => $total,
            'number_of_page' => $number_of_page,
            'current_page' => $page_number,
            'limit' => $page_limit
        ]);
    }
    public function new_user () {
        $this->view_handler->render('admin/admin_account/create.html.php');
    }
    
    public function create_new_user() {
        
    }
}
