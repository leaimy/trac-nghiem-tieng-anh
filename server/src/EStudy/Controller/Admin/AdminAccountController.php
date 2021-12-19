<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Model\Admin\UserModel;

class AdminAccountController extends EStudyBaseController
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
    
    public function statistics() {
        $total_user = $this->user_model->get_total_users();
        $total_admin= $this->user_model->get_total_admin();
        $total_guest = $this->user_model->get_total_guest();
        $total_male = $this->user_model->get_total_male_user();
        $total_total_married_females = $this->user_model->get_total_married_females();
        $this->view_handler->render('admin/admin_account/statistics.html.php',[
            'total_user' => $total_user,
            'total_admin' => $total_admin,
            'total_guest' => $total_guest,
            'total_male' => $total_male,
            'total_total_married_females' => $total_total_married_females,
            
        ]);
    }
}
