<?php

namespace EStudy\Entity\Admin;

class TopicEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'topic';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\TopicEntity';
    

    const KEY_ID = 'id';
    const KEY_TITLE = 'title';
    const KEY_DESCRIPTION = 'description';
    const KEY_MEDIA_ID = 'media_id';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $title;
    public $description;
    public $media_id;
    public $created_at;
}
