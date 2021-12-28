<?php


namespace EStudy\Api;


use EStudy\Model\Admin\VocabularyModel;
use http\Exception\InvalidArgumentException;
use Ninja\NinjaException;
use Ninja\NJTrait\Jsonable;

class VocabularyApi
{
    use Jsonable;

    private $vocabulary_model;

    public function __construct(VocabularyModel $vocabulary_model)
    {
        $this->vocabulary_model = $vocabulary_model;
    }

    public function get_all()
    {
        $incoming_data = $this->parse_json_from_request();

        $page = $incoming_data['page'] ?? null;
        $limit = $incoming_data['limit'] ?? null;

        if (is_null($page))
            $page = $_GET['page'] ?? null;
        if (is_null($limit))
            $limit = $_GET['limit'] ?? null;

        if (is_null($page)) $page = 1;
        if (is_null($limit)) $limit = 10;

        $total = $this->vocabulary_model->count();
        $vocabularies = $this->vocabulary_model->get_all_vocabulary(null, null, $limit, ($page - 1) * $limit);

        $this->response_json([
            'status' => 'success',
            'data' => [
                'vocabularies' => $vocabularies,
                'paginate' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'page_number' => floor($total / $limit)
                ]
            ]
        ]);
    }
    
    public function get_detail()
    {
        try {
            $v_id = $_GET['id'] ?? null;
            
            if (is_null($v_id))
                throw new NinjaException('Vui lòng truyền mã định danh của từ vựng', 400);
            
            $vocabulary = $this->vocabulary_model->get_by_id($v_id) ?? null;
            
            if (!$vocabulary)
                throw new NinjaException('Không tìm thấy từ vựng' , 200);
            
            $this->response_json([
                'status' => 'success',
                'data' => [
                    'vocabulary' => $vocabulary,
                    'media' => $vocabulary->get_media_entity(),
                    'media_url' => $_SERVER['HTTP_HOST'] . $vocabulary->get_media_path(),
                    'topics' => $vocabulary->get_topics()
                ]
            ]);
        }
        catch (NinjaException $exception) {
            $this->response_json([
                    'status' => 'fail',
                    'data' => null,
                    'message' => $exception->getMessage()
                ], $exception->get_status_code()
            );
        }
    }

    public function search_by_english()
    {
        try {
            $keyword = $_GET['keyword'] ?? null;
            $limit = $_GET['limit'] ?? 10;
            $page = $_GET['page'] ?? 1;

            if (is_null($keyword))
                throw new NinjaException('Vui lòng nhập từ khóa tìm kiếm');

            $total = $this->vocabulary_model->search_english_get_total($keyword);
            $results = $this->vocabulary_model->search_english($keyword, $limit, ($page - 1) * $limit);

            $this->response_json([
                'status' => 'success',
                'data' => [
                    'results' => $results
                ],
                'paginate' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'page_number' => floor($total / $limit)
                ]
            ]);
        } catch (NinjaException $exception) {
            $this->response_json([
                    'status' => 'fail',
                    'data' => null,
                    'message' => $exception->getMessage()
                ]
            );
        }
    }

    public function search_by_vietnamese()
    {
        try {
            $keyword = $_GET['keyword'] ?? null;
            $limit = $_GET['limit'] ?? 10;
            $page = $_GET['page'] ?? 1;

            if (is_null($keyword))
                throw new NinjaException('Vui lòng nhập từ khóa tìm kiếm');

            $total = $this->vocabulary_model->fulltextsearch_vocabulary_get_total($keyword);
            $results = $this->vocabulary_model->fulltextsearch_vocabulary($keyword, $limit, ($page - 1) * $limit);
            
            foreach ($results as $item) {
                $item->media = $item->get_media_entity();
            }

            $this->response_json([
                'status' => 'success',
                'data' => [
                    'results' => $results
                ],
                'paginate' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'page_number' => floor($total / $limit)
                ]
            ]);
        } catch (NinjaException $exception) {
            $this->response_json([
                    'status' => 'fail',
                    'data' => null,
                    'message' => $exception->getMessage()
                ]
            );
        }
    }
}
