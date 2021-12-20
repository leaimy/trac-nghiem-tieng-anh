<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\TopicVocabulary;
use EStudy\Entity\Admin\VocabularyEntity;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class VocabularyModel
{
    private $vocabulary_table;
    private $topic_vocabulary_table;

    public function __construct(DatabaseTable $vocabulary_table, DatabaseTable $topic_vocabulary_table)
    {
        $this->vocabulary_table = $vocabulary_table;
        $this->topic_vocabulary_table = $topic_vocabulary_table;
    }

    public function get_all_vocabulary($orderBy = null, $orderDirection = null, $limit = null, $offset = null)
    {
        return $this->vocabulary_table->findAll($orderBy, $orderDirection, $limit, $offset);
    }

    public function get_by_id($id)
    {
        return $this->vocabulary_table->findById($id);
    }

    public function get_by_topic_id($topic_id)
    {
        $topic_vocabularies = $this->topic_vocabulary_table->find(TopicVocabulary::KEY_TOPIC_ID, $topic_id);

        $results = [];
        foreach ($topic_vocabularies as $item) {
            $results[] = $item->get_vocabulary();
        }

        return $results;
    }

    public function get_random_number_of_vocabularies($topic_ids, $number = 10)
    {
        $number = intval($number);
        $topics_string = implode(', ', $topic_ids);

        $sql = "
            SELECT vocabulary.* FROM vocabulary
            INNER JOIN topic_vocabulary
                ON vocabulary.id = topic_vocabulary.vocabulary_id
            WHERE topic_vocabulary.topic_id IN ($topics_string)
            ORDER BY RAND()
            LIMIT $number
        ";

        return $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_RAW_MULTIPLE);
    }

    private $vocabularies_cache;

    public function get_random_vocabulary_by_topic($topic_id)
    {
        if (!$this->vocabularies_cache[$topic_id])
            $this->vocabularies_cache[$topic_id] = $this->get_by_topic_id($topic_id) ?? [];

        if (count($this->vocabularies_cache[$topic_id]) > 0)
            return null;

        return array_rand($this->vocabularies_cache[$topic_id]);
    }

    public function count()
    {
        return $this->vocabulary_table->total();
    }

    /**
     * @throws NinjaException
     */
    public function create_new_vocabulary($args)
    {
        if (empty($args[VocabularyEntity::KEY_ENGLISH]))
            throw new NinjaException('Vui lòng nhập từ tiếng anh');
        if (empty($args[VocabularyEntity::KEY_VIETNAMESE]))
            throw new NinjaException('Vui lòng nhập từ tiếng việt');
        if (empty($args[VocabularyEntity::KEY_DESCRIPTION]))
            throw new NinjaException('Vui lòng nhập mô tả tử');

        return $this->vocabulary_table->save([
            VocabularyEntity::KEY_ENGLISH => $args[VocabularyEntity::KEY_ENGLISH],
            VocabularyEntity::KEY_VIETNAMESE => $args[VocabularyEntity::KEY_VIETNAMESE],
            VocabularyEntity::KEY_DESCRIPTION => $args[VocabularyEntity::KEY_DESCRIPTION],
            VocabularyEntity::KEY_MEDIA_ID => $args[VocabularyEntity::KEY_MEDIA_ID] ?? null,
        ]);
    }

    public function update_vocabulary($id, $args)
    {
        if (isset($args[VocabularyEntity::KEY_MEDIA_ID])) {
            return $this->vocabulary_table->save([
                VocabularyEntity::KEY_ID => $id,
                VocabularyEntity::KEY_ENGLISH => $args[VocabularyEntity::KEY_ENGLISH],
                VocabularyEntity::KEY_VIETNAMESE => $args[VocabularyEntity::KEY_VIETNAMESE],
                VocabularyEntity::KEY_DESCRIPTION => $args[VocabularyEntity::KEY_DESCRIPTION],
                VocabularyEntity::KEY_MEDIA_ID => $args[VocabularyEntity::KEY_MEDIA_ID] ?? null,
            ]);
        }

        return $this->vocabulary_table->save([
            VocabularyEntity::KEY_ID => $id,
            VocabularyEntity::KEY_ENGLISH => $args[VocabularyEntity::KEY_ENGLISH],
            VocabularyEntity::KEY_VIETNAMESE => $args[VocabularyEntity::KEY_VIETNAMESE],
            VocabularyEntity::KEY_DESCRIPTION => $args[VocabularyEntity::KEY_DESCRIPTION]
        ]);
    }

    public function update_vocabulary_with_custom_args($id, $args)
    {
        $args[VocabularyEntity::KEY_ID] = $id;
        return $this->vocabulary_table->save($args);
    }

    public function delete_vocabulary($id)
    {
        $this->vocabulary_table->delete($id);
    }
    
    public function show_vocabulary($id)
    {
       return $this->vocabulary_table->findById($id);
    }

    public function filter_by_topic_get_total($topic_id)
    {
        $sql = "
            SELECT
                COUNT(*)
            FROM
                (
                    (
                        topic_vocabulary
                    INNER JOIN topic ON topic_vocabulary.topic_id = topic.id
                    )
                INNER JOIN vocabulary ON topic_vocabulary.vocabulary_id = vocabulary.id
                )
            WHERE
                topic.id = $topic_id
        ";

        $results = $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_ASSOC_SINGLE);
        if (!is_array($results)) return 0;

        return count($results) > 0 ? $results[0] : 0;
    }

    public function filter_by_topic($topic_id, $limit, $offset)
    {
        $sql = "
            SELECT
                vocabulary.*
            FROM
                (
                    (
                        topic_vocabulary
                    INNER JOIN topic ON topic_vocabulary.topic_id = topic.id
                    )
                INNER JOIN vocabulary ON topic_vocabulary.vocabulary_id = vocabulary.id
                )
            WHERE
                topic.id = $topic_id
            LIMIT $limit
            OFFSET $offset
        ";

        return $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_RAW_MULTIPLE);
    }

    public function fulltextsearch_vocabulary($string, $limit, $offset)
    {
        $sql = "  
            SELECT
            *
            FROM
                    vocabulary
                WHERE
                    MATCH (vocabulary.description) AGAINST('\"$string\"' IN BOOLEAN MODE)
                LIMIT $limit
                OFFSET $offset
        ";

        return $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_RAW_MULTIPLE);
    }

    public function fulltextsearch_vocabulary_get_total($string)
    {
        $sql = "  
            SELECT
            COUNT(*)
            FROM
                    vocabulary
                WHERE
                    MATCH (vocabulary.description) AGAINST('\"$string\"' IN BOOLEAN MODE)
                
        ";

        $results = $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_ASSOC_SINGLE);
        if (!is_array($results)) return 0;

        return count($results) > 0 ? $results[0] : 0;
    }

    public function filter_by_first_character_get_total($char)
    {
        $sql = "
            SELECT
                COUNT(*)
            FROM
                vocabulary
            WHERE
                vocabulary.english LIKE '$char%'    
        ";

        $results = $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_ASSOC_SINGLE);
        if (!is_array($results)) return 0;

        return count($results) > 0 ? $results[0] : 0;
    }

    public function filter_by_first_character($char, $limit, $offset)
    {
        $sql = "
            SELECT
                *
            FROM
                vocabulary
            WHERE
                vocabulary.english LIKE '$char%'   
            LIMIT $limit
            OFFSET $offset
        ";

        return $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_RAW_MULTIPLE);
    }

    public function search_english_get_total($string)
    {
        $sql = "
            SELECT
                COUNT(*)
            FROM
                vocabulary
            WHERE
                vocabulary.english LIKE '$string'    
        ";

        $results = $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_ASSOC_SINGLE);
        if (!is_array($results)) return 0;

        return count($results) > 0 ? $results[0] : 0;
    }

    public function search_english($string, $limit, $offset)
    {
        $sql = "
            SELECT
                *
            FROM
                vocabulary
            WHERE
                vocabulary.english LIKE '$string'   
            LIMIT $limit
            OFFSET $offset
        ";

        return $this->vocabulary_table->raw($sql, DatabaseTable::FETCH_RAW_MULTIPLE);
    }

    public function clear()
    {
        $this->vocabulary_table->deleteAll();
    }
}
