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

    public function get_media_name()
    {
        $entity = $this->get_media_entity();
        if ($entity == null) return null;

        return $entity->{MediaEntity::KEY_MEDIA_ORIGIN_NAME};
    }

    public function get_html_box()
    {
        $common_class = "d-block m-2 badge rounded-pill py-2 px-3 text-capitalize text-light";
        $box_color = 'red';
        
        switch (mb_strtolower($this->title)) {
            case 'danh từ':
                $box_color = '#42e3f5';
                break;
                
            case 'động từ':
                $box_color = '#51f542';
                break;

            case 'tính từ':
                $box_color = '#f58142';
                break;

            case 'giới từ':
                $box_color = '#42bff5';
                break;

            case 'phó từ':
                $box_color = '#e2a1f7';
                break;

            case 'liên từ':
                $box_color = '#f7cea1';
                break;

            case 'thán từ':
                $box_color = '#f7a1af';
                break;

            case 'đại từ':
                $box_color = '#9645ed';
                break;

            case 'thành ngữ':
                $box_color = '#45edc0';
                break;

            case 'viết tắt':
                $box_color = '#e0195f';
                break;

            case 'hậu tố':
                $box_color = '#177332';
                break;
                
            default:
                $box_color = '#cf3a75';
                break;
        }
        
        $style = "background-color: $box_color;";
        ?>
        <div class="<?= $common_class ?>" style="<?= $style ?>"><?= $this->title ?></div>
        <?php
    }
}
