<?php

namespace EStudy\Controller\Admin;

use EStudy\Controller\EStudyBaseController;
use EStudy\Model\Admin\MediaModel;

class AdminMediaController extends EStudyBaseController
{
    private $media_model;
    
    public function __construct(MediaModel $media_model)
    {
        parent::__construct();
        
        $this->media_model = $media_model;
    }

    public function index()
    {
        $media_all = $this->media_model->get_all_media();
        $this->view_handler->render('admin/media/index.html.php', [
            'media_all' => $media_all
        ]);
    }
}
