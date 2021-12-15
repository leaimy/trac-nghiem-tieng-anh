<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\VocabularyEntity;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class VocabularyModel
{
    private $vocabulary_table;

    public function __construct(DatabaseTable $vocabulary_table)
    {
        $this->vocabulary_table = $vocabulary_table;
    }

    public function get_all_vocabulary()
    {
        return $this->vocabulary_table->findAll();
    }

    public function get_by_id($id)
    {
        return $this->vocabulary_table->findById($id);
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
        return $this->vocabulary_table->save([
            VocabularyEntity::KEY_ID => $id,
            VocabularyEntity::KEY_ENGLISH => $args[VocabularyEntity::KEY_ENGLISH],
            VocabularyEntity::KEY_VIETNAMESE => $args[VocabularyEntity::KEY_VIETNAMESE],
            VocabularyEntity::KEY_DESCRIPTION => $args[VocabularyEntity::KEY_DESCRIPTION],
            VocabularyEntity::KEY_MEDIA_ID => $args[VocabularyEntity::KEY_MEDIA_ID] ?? null,
        ]);
    }

    public function delete_vocabulary($id)
    {
       return $this->vocabulary_table->delete($id);

    }
}
