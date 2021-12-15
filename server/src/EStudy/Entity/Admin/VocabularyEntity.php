<?php

namespace EStudy\Entity\Admin;


use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\TopicVocabularyModel;

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

    // Tạo biến private lưu trữ tham chiếu đến media_model
    private $media_model;
    private $topic_vocabulary_model;

    // Truyền media_model thông qua constructor
    public function __construct(MediaModel $media_model, TopicVocabularyModel $topic_vocabulary_model)
    {
        $this->media_model = $media_model;
        $this->topic_vocabulary_model = $topic_vocabulary_model;
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

    /**
     * Lấy danh sách topic id thuộc về từ vựng hiện tại
     */
    public function get_topic_ids()
    {
        $all_topic_vocabulary_entities = $this->topic_vocabulary_model->find_all_topic($this->id);

        $results = [];
        foreach ($all_topic_vocabulary_entities as $item) {
            $results[] = $item->topic_id;
        }

        return $results;
    }

    /**
     * Lấy danh sách topic entity thuộc về từ vựng hiện tại
     */
    //TODO: Cần phải làm sớm để tập trung logic về 1 chỗ, tránh lặp code khi viết API
    public function get_topics()
    {
        $all_topic_vocabulary_entities = $this->topic_vocabulary_model->find_all_topic($this->id);

        $results = [];
        foreach ($all_topic_vocabulary_entities as $item) {
            $r = $item->get_topic();
            if ($r == false) continue;
            
            $results[] = $r;
        }

        return $results;
    }

}
