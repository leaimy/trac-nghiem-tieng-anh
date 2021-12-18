<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\UserEntity;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class UserModel
{
    private $user_table;

    public function __construct(DatabaseTable $user_table)
    {
        $this->user_table = $user_table;
    }

    public function count()
    {
        return $this->user_table->total();
    }

    public function get_all_user($orderBy = null, $orderDirection = null, $limit = null, $offset = null)
    {
        return $this->user_table->findAll($orderBy, $orderDirection, $limit, $offset);
    }

    public function get_user_by_id($user_id)
    {
        return $this->user_table->findById($user_id);
    }

    /**
     * @throws NinjaException
     */
    public function create_new_user($args)
    {
        if (empty($args[UserEntity::KEY_USERNAME]))
            throw new NinjaException('Vui lòng nhập đủ tên người dùng');
        
        if (empty($args[UserEntity::KEY_PASSWORD]))
            throw new NinjaException('Vui lòng nhập đủ mật khẩu');
        
        if (empty($args[UserEntity::KEY_FULL_NAME]))
            throw new NinjaException('Vui lòng nhập đủ tên');

        return $this->user_table->save([
            UserEntity::KEY_USERNAME => $args[UserEntity::KEY_USERNAME],
            UserEntity::KEY_PASSWORD => password_hash($args[UserEntity::KEY_PASSWORD], PASSWORD_DEFAULT),
            UserEntity::KEY_FULL_NAME => $args[UserEntity::KEY_FULL_NAME],
            UserEntity::KEY_EMAIL => $args[UserEntity::KEY_EMAIL] ?? null,
        ]);
    }

    public function update_user($user_id, $args)
    {
        if (empty($args[UserEntity::KEY_USERNAME]))
            throw new NinjaException('Vui lòng nhập đủ tên người dùng');
        if (empty($args[UserEntity::KEY_PASSWORD]))
            throw new NinjaException('Vui lòng nhập đủ mật khẩu');
        if (empty($args[UserEntity::KEY_FULL_NAME]))
            throw new NinjaException('Vui lòng nhập đủ tên');


        return $this->user_table->save([
            UserEntity::KEY_ID => $user_id,
            UserEntity::KEY_USERNAME => $args[UserEntity::KEY_USERNAME],
            UserEntity::KEY_PASSWORD => $args[UserEntity::KEY_PASSWORD],
            UserEntity::KEY_FULL_NAME => $args[UserEntity::KEY_FULL_NAME],
            UserEntity::KEY_EMAIL => $args[UserEntity::KEY_EMAIL] ?? null,
        ]);
    }

    public function delete($user_id)
    {
        $this->user_table->delete($user_id);
    }

    public function get_user_by_username($username)
    {
        return $this->user_table->find(UserEntity::KEY_USERNAME, $username)[0] ?? null;
    }
}
