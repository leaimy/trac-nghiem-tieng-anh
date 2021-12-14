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
        // 1. Lấy danh sách toàn bộ người dùng từ CSDL
        $users = $this->user_model->get_all_user();
        
        // 2. Truyền danh sách này vào view
        $this->view_handler->render('admin/admin_account/index.html.php', [
            'users' => $users
        ]);
    }
    public function new_user () {
        $this->view_handler->render('admin/admin_account/create.html.php');
    }
    
    public function create_new_user() {
        
    }
}
