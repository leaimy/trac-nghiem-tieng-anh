<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\TopicVocabulary;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class TopicVocabularyModel
{
    private $topic_vocabulary_table;

    public function __construct(DatabaseTable $topic_vocabulary_table)
    {
        $this->topic_vocabulary_table = $topic_vocabulary_table;
    }

    /**
     * Thêm 1 liên kết mới giữa từ vựng và chủ đề
     */
    public function add_connection($topic_id, $vocabulary_id)
    {
        $this->topic_vocabulary_table->save([
            TopicVocabulary::KEY_VOCABULARY_ID => $vocabulary_id,
            TopicVocabulary::KEY_TOPIC_ID => $topic_id
        ]);
    }
    
    /**
     * Thêm 1 lúc nhiều liên kết giữa từ vựng và chủ đề
     * @param $args: mảng gồm mỗi phần tử là 1 cặp $topic_id - $vocabulary_id
     */
    public function add_connections($args)
    {
        foreach ($args as $item) {
            $this->topic_vocabulary_table->save([
                TopicVocabulary::KEY_VOCABULARY_ID => $item[1],
                TopicVocabulary::KEY_TOPIC_ID => $item[0]
            ]);
        }
    }
    
    /**
     * Xóa tất cả liên kết giữa từ vựng và chủ đề
     */
    /**
     * Xóa tất cả liên kết giữa 1 từ vựng và các chủ đề của nó
     * @param $vocabulary_id
     */
    public function clear_all_connections($vocabulary_id)
    {
        $this->topic_vocabulary_table->deleteWhere(TopicVocabulary::KEY_VOCABULARY_ID, $vocabulary_id);
    }
    
    /**
     * Tìm tất cả chủ đề của một từ vựng
     * @param $vocabulary_id
     */
    public function get_topics_by_vocabulary($vocabulary_id)
    {
      return $this->topic_vocabulary_table->find(TopicVocabulary::KEY_VOCABULARY_ID, $vocabulary_id);
    }
    
}
