<?php

namespace SSF\Entity;

class SyncEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'sync';
    const CLASS_NAME = '\\SSF\\Entity\\SyncEntity';

    const KEY_ID = 'id';
    const KEY_USERID = 'user_id';
    const KEY_DATA = 'data';
    const KEY_MODIFIED_AT = 'modified_at';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $user_id;
    public $data;
    public $modified_at;
    public $created_at;
}
