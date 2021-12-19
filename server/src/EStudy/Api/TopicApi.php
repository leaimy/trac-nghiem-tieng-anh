<?php

namespace EStudy\Api;

use EStudy\Entity\Admin\TopicEntity;
use EStudy\Model\Admin\TopicModel;
use Ninja\NinjaException;
use Ninja\NJTrait\Jsonable;

class TopicApi
{
    use Jsonable;
    
    private $topic_model;
    
    public function __construct(TopicModel $topicModel)
    {
        $this->topic_model = $topicModel;
    }

    public function get_all()
    {
        $topics = $this->topic_model->get_all_topic();
        
        $this->response_json([
            'status' => 'success',
            'data' => [
                'topics' => $topics
            ]
        ]);
    }
    
    public function create_new_topic()
    {
        try {
            $incoming_data = $this->parse_json_from_request();
            
            $title = $incoming_data['title'] ?? null;
            $description = $incoming_data['description'] ?? null;
            $media_id = $incoming_data['media_id'] ?? null;
            
            if (is_null($title))
                throw new NinjaException('Vui lòng nhập tên chủ đề');
            
            $new_topic = $this->topic_model->create_new_topic([
                TopicEntity::KEY_MEDIA_ID => $media_id,
                TopicEntity::KEY_DESCRIPTION => $description,
                TopicEntity::KEY_TITLE => $title
            ]);
            
            $this->response_json([
                'status' => 'success',
                'data' => [
                    'topic' => $new_topic
                ]
            ]);
        }
        catch (NinjaException $exception) {
            $this->response_json([
                'status' => 'fail',
                'data' => null,
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
