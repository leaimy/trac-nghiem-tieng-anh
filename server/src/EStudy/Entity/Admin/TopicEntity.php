<?php

namespace EStudy\Entity\Admin;

use EStudy\Model\Admin\MediaModel;

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

    // Tạo biến private lưu trữ tham chiếu đến media_model
    private $media_model;

    // Truyền media_model thông qua constructor
    public function __construct(MediaModel $media_model)
    {
        $this->media_model = $media_model;
    }

    // Viết hàm getter để lấy đối tượng media
    public function get_media_entity()
    {
        if (!$this->media_id) return null;

        return $this->media_model->get_by_id($this->media_id);
    }

    // Viết hàm để lấy media_path nhanh
    public function get_media_path()
    {
        $entity = $this->get_media_entity();
        if ($entity == null) return null;

        return $entity->{MediaEntity::KEY_MEDIA_PATH};
    }
}
