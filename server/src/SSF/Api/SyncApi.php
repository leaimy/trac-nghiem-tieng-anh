<?php

namespace SSF\Api;

use Ninja\NinjaException;
use Ninja\NJTrait\Jsonable;
use SSF\Model\SyncModel;

class SyncApi
{
    use Jsonable;
    
    private $sync_model;
    
    public function __construct(SyncModel $sync_model)
    {
        $this->sync_model = $sync_model;
    }
    
    public function upload()
    {
        try {
            $json = $this->parse_json_from_request();
            if (!isset($json['user_id']))
                throw new NinjaException('Vui lòng truyền vào mã người dùng');
            
            if (!isset($json['data']))
                throw new NinjaException('Vui lòng truyền dữ liệu hợp lệ');
            
            $is_success = $this->sync_model->upload($json['user_id'], $json['data']);
            
            if ($is_success)
                $this->response_json([
                    'status' => 'success',
                    'data' => null,
                ]);
            else 
                $this->response_json([
                    'status' => 'error',
                    'data' => null,
                    'message' => 'Có lỗi xảy ra trong quá trình đồng bộ'
                ], 500);
        }
        catch (NinjaException $e) {
           $this->response_json([
               'status' => 'fail',
               'data' => null,
               'message' => $e->getMessage()
           ], 400); 
        }
    }
    
    public function download()
    {
        try {
            if (!isset($_GET['user_id']))
                throw new NinjaException('Vui lòng chọn tài khoản hợp lệ');
            
            $result  = $this->sync_model->download($_GET['user_id']);
            
            $this->response_json([
                'status' => 'success',
                'data' => $result
            ]);
        }
        catch (NinjaException $e) {
            $this->response_json([
                'status' => 'fail',
                'data' => null,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
