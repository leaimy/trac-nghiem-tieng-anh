<?php

namespace EStudy\API;

use Ninja\NinjaException;
use Ninja\NJTrait\Jsonable;
use Ninja\Authentication;
use EStudy\Entity\Admin\UserEntity;
use EStudy\Model\Admin\UserModel;


class AuthAPI
{
    use Jsonable;

    private $authentication_helper;
    private $user_model;

    public function __construct(Authentication $authentication, UserModel $user_model)
    {
        $this->authentication_helper = $authentication;
        $this->user_model = $user_model;
    }

    public function login()
    {
        try {
            $json = $this->parse_json_from_request();

            $username = $json['username'] ?? null;
            if (!$username)
                throw new NinjaException('Vui lòng điền tên đăng nhập');

            $password = $json['password'] ?? null;
            if (!$password)
                throw new NinjaException('Vui lòng điền mật khẩu');

            $is_success = $this->authentication_helper->login($username, $password);

            if (!$is_success)
                throw new NinjaException('Thông tin đăng nhập không hợp lệ, vui lòng kiểm tra lại');

            $user = $this->authentication_helper->getUser();

            $response_json = [];
            $response_json[UserEntity::KEY_ID] = $user->{UserEntity::KEY_ID};
            $response_json[UserEntity::KEY_USERNAME] = $user->{UserEntity::KEY_USERNAME};
            $response_json[UserEntity::KEY_FULL_NAME] = $user->{UserEntity::KEY_FULL_NAME};

            $this->response_json([
                'status' => 'success',
                'data' => [
                    'user' => $response_json
                ]
            ]);
        } catch (NinjaException $exception) {
            $this->response_json([
                'status' => 'fail',
                'data' => null,
                'message' => $exception->getMessage()
            ], 401);
        }
    }

    public function register()
    {
        try {
            $json = $this->parse_json_from_request();

            $username = $json['username'] ?? null;
            if (!$username)
                throw new NinjaException('Vui lòng điền tên đăng nhập');

            $password = $json['password'] ?? null;
            if (!$password)
                throw new NinjaException('Vui lòng điền mật khẩu');

            $fullname = $json['fullname'] ?? null;
            if (!$fullname)
                throw new NinjaException('Vui lòng điền họ tên');

            $user = $this->user_model->create_new_user([
                'username' => $username,
                'password' => $password,
                'fullname' => $fullname
            ]);

            $response_json = [];
            $response_json[UserEntity::KEY_ID] = $user->{UserEntity::KEY_ID};
            $response_json[UserEntity::KEY_USERNAME] = $user->{UserEntity::KEY_USERNAME};
            $response_json[UserEntity::KEY_FULL_NAME] = $user->{UserEntity::KEY_FULL_NAME};

            $this->response_json([
                'status' => 'success',
                'data' => [
                    'user' => $response_json
                ]
            ]);
        } catch (Exception $exception) {
            $this->response_json([
                'status' => 'fail',
                'data' => null,
                'message' => $exception->getMessage()
            ], 401);
        }
    }
}
