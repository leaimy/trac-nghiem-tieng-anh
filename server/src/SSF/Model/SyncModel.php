<?php

namespace SSF\Model;

use Ninja\DatabaseTable;
use Ninja\NinjaException;
use SSF\Entity\SyncEntity;

class SyncModel
{
    private $sync_table;
    
    public function __construct(DatabaseTable $sync_table)
    {
        $this->sync_table = $sync_table;
    }
    
    private function crete_new_record($user_id, $data) {
        $this->sync_table->save([
            SyncEntity::KEY_USERID => $user_id,
            SyncEntity::KEY_DATA => $data,
            SyncEntity::KEY_MODIFIED_AT => new \DateTime()
        ]);
    }

    /**
     * @throws NinjaException
     */
    public function upload($user_id, $data)
    {
        $result = $this->sync_table->find(SyncEntity::KEY_USERID, $user_id);
        if (count($result) == 0) {
            $this->crete_new_record($user_id, serialize($data));
            return true;
        }
        
        $sId = $result[0]->{SyncEntity::KEY_ID} ?? null;
        if (empty($sId))
            throw new NinjaException('Không tìm thấy dữ liệu người dùng');
        
        $this->sync_table->save([
            SyncEntity::KEY_ID => $sId,
            SyncEntity::KEY_DATA => serialize($data),
            SyncEntity::KEY_MODIFIED_AT => new \DateTime()
        ]);
        
        return true;
    }

    /**
     * @throws NinjaException
     */
    public function download($user_id)
    {
        $result = $this->sync_table->find(SyncEntity::KEY_USERID, $user_id);
        if (count($result) == 0) {
            throw new NinjaException('Không tìm thấy dữ liệu người dùng');
        }
        
        $data_encode = $result[0]->{SyncEntity::KEY_DATA};
        $json_decode = unserialize($data_encode);
        
        $result[0]->{SyncEntity::KEY_DATA} = $json_decode;
        
        return $result[0];
    }
}
