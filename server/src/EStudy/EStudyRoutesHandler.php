<?php

namespace EStudy;

use EStudy\Controller\Admin\AdminAccountController;
use EStudy\Controller\Admin\AdminContactUsController;
use EStudy\Controller\Admin\AdminCustomerController;
use EStudy\Controller\Admin\AdminDashboardController;
use EStudy\Controller\Admin\AdminImportController;
use EStudy\Controller\Admin\AdminMediaController;
use EStudy\Controller\Admin\AdminQuestionController;
use EStudy\Controller\Admin\AdminQuizController;
use EStudy\Controller\Admin\AdminQuizHistoryController;
use EStudy\Controller\Admin\AdminSettingController;
use EStudy\Controller\Admin\AdminTopicController;
use EStudy\Controller\Admin\AdminVocabularyController;
use EStudy\Entity\Admin\MediaEntity;
use EStudy\Entity\Admin\UserEntity;
use EStudy\Model\Admin\QuestionModel;

use EStudy\Model\Admin\UserModel;
use Ninja\Authentication;
use Ninja\DatabaseTable;
use Ninja\NJInterface\IRoutes;

use EStudy\Entity\Admin\QuestionEntity;
use EStudy\Entity\Admin\TopicEntity;
use EStudy\Model\Admin\MediaModel;
use EStudy\Model\Admin\TopicModel;

class EStudyRoutesHandler implements IRoutes
{
    private $admin_question_table;
    private $admin_question_model;

    private $admin_topic_table;
    private $admin_topic_model;

    private $admin_media_table;
    private $admin_media_model;
    
    private $admin_user_table;
    private $admin_user_model;
    
    public function __construct()
    {
        $this->admin_question_table = new DatabaseTable(QuestionEntity::TABLE, QuestionEntity::PRIMARY_KEY, QuestionEntity::CLASS_NAME);
        $this->admin_question_model = new QuestionModel($this->admin_question_table);

        $this->admin_topic_table = new DatabaseTable(TopicEntity::TABLE, TopicEntity::PRIMARY_KEY, TopicEntity::CLASS_NAME, [
            &$this->admin_media_model
        ]);
        $this->admin_topic_model = new TopicModel($this->admin_topic_table);
        
        $this->admin_media_table = new DatabaseTable(MediaEntity::TABLE, MediaEntity::PRIMARY_KEY, MediaEntity::CLASS_NAME);
        $this->admin_media_model = new MediaModel($this->admin_media_table);
        
        $this->admin_user_table = new DatabaseTable(UserEntity::TABLE, UserEntity::PRIMARY_KEY, UserEntity::CLASS_NAME);
        $this->admin_user_model = new UserModel($this->admin_user_table);
    }

    public function getRoutes(): array
    {
        $controller_routes = $this->get_all_controller_routes();
        $api_routes = $this->get_all_api_routes();

        return $controller_routes + $api_routes;
    }

    public function get_all_controller_routes(): array
    {
        $admin_dashboard_routes = $this->get_admin_dashboard_routes();
        $admin_account_routes = $this->get_admin_account_routes();
        $admin_contact_us_routes = $this->get_admin_contact_us_routes();
        $admin_customer_routes = $this->get_admin_customer_routes();
        $admin_media_routes = $this->get_admin_media_routes();
        $admin_question_routes = $this->get_admin_question_routes();
        $admin_quiz_routes = $this->get_admin_quiz_routes();
        $admin_quiz_history_routes = $this->get_admin_quiz_history_routes();
        $admin_setting_routes = $this->get_admin_setting_routes();
        $admin_topic_routes = $this->get_admin_topic_routes();
        $admin_vocabulary_routes = $this->get_admin_vocabulary_routes();
        $admin_import_routes = $this->get_admin_import_routes();

        return $admin_dashboard_routes +
            $admin_account_routes +
            $admin_contact_us_routes +
            $admin_customer_routes +
            $admin_media_routes +
            $admin_question_routes +
            $admin_quiz_routes +
            $admin_quiz_history_routes +
            $admin_setting_routes +
            $admin_topic_routes +
            $admin_vocabulary_routes + 
            $admin_import_routes;
    }

    public function get_all_api_routes(): array
    {
        return [];
    }

    public function get_admin_dashboard_routes(): array
    {
        $controller = new AdminDashboardController();

        return [
            '/' => [
                'REDIRECT' => '/admin/dashboard'
            ],
            '/admin' => [
                'REDIRECT' => '/admin/dashboard'
            ],
            '/admin/dashboard' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_account_routes(): array
    {
        $controller = new AdminAccountController($this->admin_user_model);

        return [
            '/admin/accounts' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
            '/admin/accounts/new_user' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'new_user'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'create_new_user'
                ]
            ]
        ];
    }

    public function get_admin_contact_us_routes(): array
    {
        $controller = new AdminContactUsController();

        return [
            '/admin/contact-us' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_customer_routes(): array
    {
        $controller = new AdminCustomerController();

        return [
            '/admin/customers' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_media_routes(): array
    {
        $controller = new AdminMediaController($this->admin_media_model);

        return [
            '/admin/media' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_question_routes(): array
    {
        $controller = new AdminQuestionController($this->admin_question_model);

        return [
            '/admin/questions' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
            '/admin/questions/create' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'create'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'store'
                ],
            ],
            '/admin/questions/edit' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'edit'
                ]
            ]
        ];
    }

    public function get_admin_quiz_routes(): array
    {
        $controller = new AdminQuizController($this->admin_question_model);

        return [
            '/admin/quiz' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_quiz_history_routes(): array
    {
        $controller = new AdminQuizHistoryController();

        return [
            '/admin/quiz-history' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_setting_routes(): array
    {
        $controller = new AdminSettingController();

        return [
            '/admin/settings' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_topic_routes(): array
    {
        $controller = new AdminTopicController($this->admin_topic_model, $this->admin_media_model);

        return [
            '/admin/topics' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],

            '/admin/topics/create' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'create'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'store'
                ]
            ],

            '/admin/topics/edit' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'edit'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'update'
                ]
            ],

            '/admin/topics/delete' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'delete'
                ]
            ]
        ];
    }

    public function get_admin_vocabulary_routes(): array
    {
        $controller = new AdminVocabularyController();

        return [
            '/admin/vocabularies' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_import_routes(): array
    {
        $controller = new AdminImportController();

        return [
            '/admin/import-sample-data' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
            '/admin/import-sample-data/ict' => [
                'POST' => [
                    'controller' => $controller,
                    'action' => 'import_ict'
                ]
            ],
            '/admin/import-sample-data/quizlet' => [
                'POST' => [
                    'controller' => $controller,
                    'action' => 'import_quizlet'
                ]
            ]
        ];
    }

    public function getAuthentication(): ?Authentication
    {
        return null;
    }

    public function checkPermission($permission): ?bool
    {
        return null;
    }
}
