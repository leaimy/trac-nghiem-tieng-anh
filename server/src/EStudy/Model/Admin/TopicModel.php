<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\TopicEntity;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class TopicModel
{
    private $topic_table;

    public function __construct(DatabaseTable $topic_table)
    {
        $this->topic_table = $topic_table;
    }

    public function get_all_topic()
    {
        return $this->topic_table->findAll();
    }

    public function get_by_id($id)
    {
        return $this->topic_table->findById($id);
    }

    /**
     * @throws NinjaException
     */
    public function create_new_topic($args)
    {
        if (empty($args[TopicEntity::KEY_TITLE]))
            throw new NinjaException('Vui lòng nhập tiêu đề câu hỏi');

        return $this->topic_table->save([
            TopicEntity::KEY_TITLE => $args[TopicEntity::KEY_TITLE],
            TopicEntity::KEY_DESCRIPTION => $args[TopicEntity::KEY_DESCRIPTION] ?? null,
            TopicEntity::KEY_MEDIA_ID => $args[TopicEntity::KEY_MEDIA_ID] ?? null,
        ]);
    }

    public function update_topic($id, $args)
    {
        if (isset($args[TopicEntity::KEY_MEDIA_ID])) {
            return $this->topic_table->save([
                TopicEntity::KEY_ID => $id,
                TopicEntity::KEY_TITLE => $args[TopicEntity::KEY_TITLE],
                TopicEntity::KEY_DESCRIPTION => $args[TopicEntity::KEY_DESCRIPTION] ?? null,
                TopicEntity::KEY_MEDIA_ID => $args[TopicEntity::KEY_MEDIA_ID] ?? null,
            ]);
        }

        return $this->topic_table->save([
            TopicEntity::KEY_ID => $id,
            TopicEntity::KEY_TITLE => $args[TopicEntity::KEY_TITLE],
            TopicEntity::KEY_DESCRIPTION => $args[TopicEntity::KEY_DESCRIPTION] ?? null,
        ]);
    }
    
    public function update_topic_with_custom_args($id, $args)
    {
        $args[TopicEntity::KEY_ID] = $id;
        $this->topic_table->save($args);
    }

    public function delete_topic($id)
    {
        $this->topic_table->delete($id);
    }

    public function clear()
    {
        $this->topic_table->deleteAll();
    }

    public function vocabulary_total($topic)
    {
        $sql = "
            SELECT
            COUNT(vocabulary.id) as sl,
            topic.title
            FROM
            (
                (
                    topic_vocabulary
                INNER JOIN topic ON topic_vocabulary.topic_id = $topic
                )
            INNER JOIN vocabulary ON topic_vocabulary.vocabulary_id = vocabulary.id
            )
            GROUP BY topic.title 
        ";

        $results = $this->topic_table->raw($sql, DatabaseTable::FETCH_ASSOC_SINGLE);
        if (!is_array($results)) return 0;

        return count($results) > 0 ? $results[0] : 0;
       
    }
}
