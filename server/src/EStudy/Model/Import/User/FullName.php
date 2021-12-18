<?php
//https://randomuser.me/api/?results=5000

namespace EStudy\Model\Import\User;

use EStudy\Entity\Admin\UserEntity;
use Ninja\DatabaseTable;

class FullName
{
    public function populate()
    {
        $myfile = fopen(__DIR__ . '/user.json', "r") or die("Unable to open json/ict.json file!");
        $json_raw = fread($myfile, filesize(__DIR__ . '/user.json'));

        fclose($myfile);

        $user_table = new DatabaseTable(UserEntity::TABLE, UserEntity::PRIMARY_KEY);

        $decoded = json_decode($json_raw);

        $data = $decoded->results;
        foreach ($data as $item) {
            $fullname = '' . $item->name->title . ' ' . $item->name->first . ' ' . $item->name->last . '';
            $email = $item->email;
            $username = $item->login->username;
            $password = $item->login->md5;
            $user_table->save ([
                UserEntity::KEY_USERNAME => $username,
                UserEntity::KEY_PASSWORD => $password,
                UserEntity::KEY_EMAIL => $email,
                UserEntity::KEY_FULL_NAME => $fullname
            ]);
        }
    }
}
