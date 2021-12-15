<?php

namespace EStudy\Entity\Admin;

class UserEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'user';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\UserEntity';
    
    const GUEST = "GUEST";
    const ADMIN = "ADMIN";
    
    const KEY_ID = 'id';
    const KEY_USERNAME = 'username';
    const KEY_PASSWORD = 'password';
    const KEY_FULL_NAME = 'fullname';
    const KEY_EMAIL = 'email';
    const KEY_USER_TYPE = 'type';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $username;
    public $password;
    public $fullname;
    public $email;
    public $user_type;
    public $created_at;
}
