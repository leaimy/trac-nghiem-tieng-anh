<?php

namespace EStudy\Model\Admin;

use EStudy\Entity\Admin\MediaEntity;
use Ninja\DatabaseTable;
use Ninja\NinjaException;

class MediaModel
{
    private $media_table;

    public function __construct(DatabaseTable $media_table)
    {
        $this->media_table = $media_table;
    }

    public function get_all_media()
    {
        return $this->media_table->findAll();
    }

    public function get_by_id($id)
    {
        return $this->media_table->findById($id);
    }

    public function create_new_media($args)
    {
        // 1. Kiểm tra thông tin ảnh
        $valid_types = ['image'];

        $type = $args['file_upload']['type'];

        foreach ($valid_types as $valid_type) {
            if (strpos($type, $valid_type) < 0)
                throw new NinjaException('Tập tin không hợp lệ');
        }

        if ($args['file_upload']['error'] != 0)
            throw new NinjaException('Lỗi xảy ra khi tải tập tin lên server');

        // 2. Di chuyển ảnh vào thư mục lưu trữ lâu dài
        $ten_anh_goc = $args['file_upload']['name'];

        $duong_dan_tam_thoi = $args['file_upload']['tmp_name'];

        $ten_anh_random = uniqid() . $ten_anh_goc;

        $duong_dan_uploads = ROOT_DIR . '/public/uploads/' . $ten_anh_random;

        $success = move_uploaded_file($duong_dan_tam_thoi, $duong_dan_uploads);

        if (!$success)
            throw new NinjaException('Lỗi xảy ra khi tải tập tin lên server');

        $ten_duong_dan_csdl = '/uploads/' . $ten_anh_random;

        $ten_goc = $ten_anh_goc;

        $duong_dan = $ten_duong_dan_csdl;

        // 3. Cập nhật thông tin ảnh vào bảng Media 
        $new_media = $this->media_table->save([
            MediaEntity::KEY_MEDIA_ORIGIN_NAME => $ten_goc,
            MediaEntity::KEY_MEDIA_PATH => $duong_dan,
        ]);
        
        return $new_media;
    }

    public function delete_media($id)
    {
        return $this->media_table->delete($id);
    }
}
