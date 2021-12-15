<?php

namespace EStudy\Entity\Admin;


class VocabularyEntity
{
    const PRIMARY_KEY = 'id';
    const TABLE = 'vocabulary';
    const CLASS_NAME = '\\EStudy\\Entity\\Admin\\VocabularyEntity';

    const KEY_ID = 'id';
    const KEY_ENGLISH = 'english';
    const KEY_VIETNAMESE = 'vietnamese';
    const KEY_DESCRIPTION = 'description';
    const KEY_MEDIA_ID = 'media_id';
    const KEY_CREATED_AT = 'created_at';

    public $id;
    public $english;
    public $vietnamese;
    public $description;
    public $media_id;
    public $created_at;

   
}
