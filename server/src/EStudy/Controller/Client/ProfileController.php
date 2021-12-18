<?php

namespace EStudy\Controller\Client;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\UserEntity;
use EStudy\Model\Admin\UserModel;
use Ninja\NinjaException;

class ProfileController extends EStudyBaseController
{
    private $user_model;
    
    public function __construct(UserModel $user_model)
    {
        parent::__construct();
        
        $this->user_model = $user_model;
    }
    
    public function show_dashboard()
    {
        $this->view_handler->render('client/profile/dashboard.html.php');
    }
    
    public function process_update()
    {
        try {
            $fullname = $_POST['fullname'] ?? null;
            $email = $_POST['email'] ?? null;
            $id = $_POST['id'] ?? null;
            
            if (is_null($id))
                throw new NinjaException('Tài khoản không hợp lệ');
            
            if (is_null($fullname))
                throw new NinjaException('Vui lòng nhập họ tên hợp lệ');
            
            $this->user_model->update_user($id, [
                UserEntity::KEY_FULL_NAME => $fullname,
                UserEntity::KEY_EMAIL => $email
            ]);
            
            $this->route_redirect('/profile');
        }
        catch (NinjaException $exception) {
            // TODO: Handle update profile update fail
            die($exception->getMessage());
        }
    }
}
