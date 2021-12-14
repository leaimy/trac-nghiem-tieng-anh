<?php

namespace EStudy\Entity\Admin;

class MediaEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'media';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\MediaEntity';
    

    const KEY_ID = 'id';
    const KEY_MEDIA_ORIGIN_NAME = 'media_origin_name';
    const KEY_MEDIA_PATH = 'media_path';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $media_origin_name;
    public $media_path;
    public $created_at;
    
}
