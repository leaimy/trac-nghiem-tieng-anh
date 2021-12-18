<?php

namespace EStudy\Controller\Client;

use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\UserEntity;
use EStudy\Model\Admin\UserModel;
use Ninja\Authentication;
use Ninja\NinjaException;

class AuthController extends EStudyBaseController
{
    private $authentication_helper;
    private $user_model;

    public function __construct(Authentication $authentication_helper, UserModel $user_model)
    {
        parent::__construct();

        $this->authentication_helper = $authentication_helper;
        $this->user_model = $user_model;
    }

    public function sign_in()
    {
        $this->view_handler->render('client/auth/sign_in.html.php');
    }

    public function sign_up()
    {
        $this->view_handler->render('client/auth/sign_up.html.php');
    }

    public function process_sign_in()
    {
        try {
            $user_name = $_POST['user_name'] ?? null;
            $password = $_POST['password'] ?? null;

            if (is_null($user_name))
                throw new NinjaException('Vui lòng nhập thông tin đăng nhập');

            if (is_null($password))
                throw new NinjaException('Vui lòng nhập mật khẩu');

            $succeed = $this->authentication_helper->login($user_name, $password);

            if (!$succeed)
                throw new NinjaException('Thông tin đăng nhập không hợp lệ');

            $this->route_redirect('/');
        } catch (\Exception $e) {
            // TODO: Handle login error
            die($e->getMessage());
        }
    }

    public function process_register()
    {
        try {
            $first_name = $_POST['first_name'] ?? null;
            $last_name = $_POST['last_name'] ?? null;
            $user_name = $_POST['user_name'] ?? null;
            $password = $_POST['password'] ?? null;
            $repassword = $_POST['re_password'] ?? null;
            
            if (is_null($first_name) || is_null($last_name) || is_null($user_name) || is_null($password) || is_null($repassword))
                throw new NinjaException('Vui lòng điền đầy đủ thông tin');
            
            $existing = $this->user_model->get_user_by_username($user_name);
            if (!is_null($existing))
                throw new NinjaException('Tên người dùng đã tồn tại');
                
            if ($password != $repassword)
                throw new NinjaException('Mật khẩu không khớp');
            
            $this->user_model->create_new_user([
                UserEntity::KEY_USERNAME => $user_name,
                UserEntity::KEY_FULL_NAME => $last_name . ' ' . $first_name,
                UserEntity::KEY_PASSWORD => $password
            ]);
            
            $this->route_redirect('/auth/sign-in');
        }
        catch (NinjaException $exception) {
            // TODO: Handle register user error
            die($exception->getMessage());
        }
    }
    
    public function log_user_out()
    {
        $this->authentication_helper->logout();
        $this->route_redirect('/');
    }
}
