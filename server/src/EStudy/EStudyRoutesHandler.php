<?php

namespace EStudy;

use EStudy\Api\QuizApi;
use EStudy\Api\TopicApi;
use EStudy\Api\VocabularyApi;
use EStudy\Api\AuthAPI;
use EStudy\Controller\Admin\AdminAccountController;
use EStudy\Controller\Admin\AdminContactUsController;
use EStudy\Controller\Admin\AdminDashboardController;
use EStudy\Controller\Admin\AdminImportController;
use EStudy\Controller\Admin\AdminMediaController;
use EStudy\Controller\Admin\AdminQuestionController;
use EStudy\Controller\Admin\AdminQuizController;
use EStudy\Controller\Admin\AdminQuizHistoryController;
use EStudy\Controller\Admin\AdminSettingController;
use EStudy\Controller\Admin\AdminTopicController;
use EStudy\Controller\Admin\AdminVocabularyController;
use EStudy\Controller\Client\AuthController;
use EStudy\Controller\Client\HomeController;
use EStudy\Controller\Client\ProfileController;
use EStudy\Controller\Client\QuizController;
use EStudy\Controller\Client\VocabularyController;
use EStudy\Controller\EStudyBaseController;
use EStudy\Entity\Admin\MediaEntity;
use EStudy\Entity\Admin\Pivot\QuestionQuizEntity;
use EStudy\Entity\Admin\QuizEntity;
use EStudy\Entity\Admin\TopicVocabulary;
use EStudy\Entity\Admin\UserEntity;
use EStudy\Entity\Admin\VocabularyEntity;
use EStudy\Entity\Client\Pivot\UserQuizEntity;
use EStudy\Entity\Client\QuizHistoryEntity;
use EStudy\Model\Admin\Pivot\QuestionQuizModel;
use EStudy\Model\Admin\QuestionModel;

use EStudy\Model\Admin\QuizModel;
use EStudy\Model\Admin\TopicVocabularyModel;
use EStudy\Model\Admin\UserModel;
use EStudy\Model\Admin\VocabularyModel;
use EStudy\Model\Client\Pivot\UserQuizModel;
use EStudy\Model\Client\QuizHistoryModel;
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

    private $admin_vocabulary_table;
    private $admin_vocabulary_model;

    private $admin_topic_vocabulary_table;
    private $admin_topic_vocabulary_model;

    private $admin_quiz_table;
    private $admin_quiz_model;

    private $admin_question_quiz_table;
    private $admin_question_quiz_model;

    private $admin_user_table;
    private $admin_user_model;

    private $user_quiz_table;
    private $user_quiz_model;

    private $quiz_history_table;
    private $quiz_history_model;

    private $authentication_helper;

    public function __construct()
    {
        $this->admin_user_table = new DatabaseTable(UserEntity::TABLE, UserEntity::PRIMARY_KEY, UserEntity::CLASS_NAME, [
            &$this->user_quiz_model
        ]);
        $this->admin_user_model = new UserModel($this->admin_user_table);

        $this->authentication_helper = new Authentication($this->admin_user_table, UserEntity::KEY_USERNAME, UserEntity::KEY_PASSWORD);

        $this->admin_topic_table = new DatabaseTable(TopicEntity::TABLE, TopicEntity::PRIMARY_KEY, TopicEntity::CLASS_NAME, [
            &$this->admin_media_model
        ]);
        $this->admin_topic_model = new TopicModel($this->admin_topic_table);

        $this->admin_question_table = new DatabaseTable(QuestionEntity::TABLE, QuestionEntity::PRIMARY_KEY, QuestionEntity::CLASS_NAME, [
            &$this->admin_topic_model,
            &$this->admin_media_model
        ]);
        $this->admin_question_model = new QuestionModel($this->admin_question_table);

        $this->admin_media_table = new DatabaseTable(MediaEntity::TABLE, MediaEntity::PRIMARY_KEY, MediaEntity::CLASS_NAME);
        $this->admin_media_model = new MediaModel($this->admin_media_table);

        $this->admin_topic_vocabulary_table = new DatabaseTable(TopicVocabulary::TABLE, TopicVocabulary::PRIMARY_KEY, TopicVocabulary::CLASS_NAME, [
            &$this->admin_topic_model,
            &$this->admin_vocabulary_model
        ]);
        $this->admin_topic_vocabulary_model = new TopicVocabularyModel($this->admin_topic_vocabulary_table);
        
        $this->admin_vocabulary_table = new DatabaseTable(VocabularyEntity::TABLE, VocabularyEntity::PRIMARY_KEY, VocabularyEntity::CLASS_NAME, [
            &$this->admin_media_model, 
            &$this->admin_topic_vocabulary_model
        ]);
        $this->admin_vocabulary_model = new VocabularyModel($this->admin_vocabulary_table, $this->admin_topic_vocabulary_table);

        $this->user_quiz_table = new DatabaseTable(UserQuizEntity::TABLE, UserQuizEntity::PRIMARY_KEY, UserQuizEntity::CLASS_NAME, [
            &$this->admin_user_model,
            &$this->admin_quiz_model,
            &$this->quiz_history_model,
            &$this->user_quiz_model
        ]);
        $this->user_quiz_model = new UserQuizModel($this->user_quiz_table, $this->authentication_helper);

        $this->admin_question_quiz_table = new DatabaseTable(QuestionQuizEntity::TABLE, QuestionQuizEntity::PRIMARY_KEY, QuestionQuizEntity::CLASS_NAME, [
            &$this->admin_question_model,
            &$this->admin_quiz_model
        ]);
        $this->admin_question_quiz_model = new QuestionQuizModel($this->admin_question_quiz_table);

        $this->admin_quiz_table = new DatabaseTable(QuizEntity::TABLE, QuizEntity::PRIMARY_KEY, QuizEntity::CLASS_NAME, [
            &$this->admin_question_quiz_model,
            &$this->admin_user_model,
            &$this->admin_media_model
        ]);
        $this->admin_quiz_model = new QuizModel($this->admin_quiz_table, $this->admin_question_model, $this->admin_question_quiz_model, $this->authentication_helper, $this->admin_vocabulary_model, $this->admin_media_model, $this->user_quiz_model);

        $this->quiz_history_table = new DatabaseTable(QuizHistoryEntity::TABLE, QuizHistoryEntity::PRIMARY_KEY, QuizHistoryEntity::CLASS_NAME);
        $this->quiz_history_model = new QuizHistoryModel($this->quiz_history_table);

    }

    public function required_login($routes): array
    {
        $results = [];

        foreach ($routes as $key => $route) {
            $item = $route;
            $item['login'] = true;

            $results[$key] = $item;
        }

        return $results;
    }

    public function restrict_admin($routes): array
    {
        $results = [];

        foreach ($routes as $key => $route) {
            $item = $route;
            $item['permissions'] = true;

            $results[$key] = $item;
        }

        return $results;
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

        $client_routes = $this->get_client_routes();
        $auth_routes = $this->get_auth_routes();

        /**
         * Login required
         */
        $admin_dashboard_routes = $this->required_login($admin_dashboard_routes);
        $admin_account_routes = $this->required_login($admin_account_routes);
        $admin_contact_us_routes = $this->required_login($admin_contact_us_routes);
        $admin_customer_routes = $this->required_login($admin_customer_routes);
        $admin_media_routes = $this->required_login($admin_media_routes);
        $admin_question_routes = $this->required_login($admin_question_routes);
        $admin_quiz_routes = $this->required_login($admin_quiz_routes);
        $admin_quiz_history_routes = $this->required_login($admin_quiz_history_routes);
        $admin_setting_routes = $this->required_login($admin_setting_routes);
        $admin_topic_routes = $this->required_login($admin_topic_routes);
        $admin_vocabulary_routes = $this->required_login($admin_vocabulary_routes);
        $admin_import_routes = $this->required_login($admin_import_routes);

        /**
         * Restrict only admin user
         */
        $admin_dashboard_routes = $this->restrict_admin($admin_dashboard_routes);
        $admin_account_routes = $this->restrict_admin($admin_account_routes);
        $admin_contact_us_routes = $this->restrict_admin($admin_contact_us_routes);
        $admin_customer_routes = $this->restrict_admin($admin_customer_routes);
        $admin_media_routes = $this->restrict_admin($admin_media_routes);
        $admin_question_routes = $this->restrict_admin($admin_question_routes);
        $admin_quiz_routes = $this->restrict_admin($admin_quiz_routes);
        $admin_quiz_history_routes = $this->restrict_admin($admin_quiz_history_routes);
        $admin_setting_routes = $this->restrict_admin($admin_setting_routes);
        $admin_topic_routes = $this->restrict_admin($admin_topic_routes);
        $admin_vocabulary_routes = $this->restrict_admin($admin_vocabulary_routes);
        $admin_import_routes = $this->restrict_admin($admin_import_routes);

        return $client_routes +
            $admin_dashboard_routes +
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
            $admin_import_routes +
            $auth_routes;
    }

    public function get_all_api_routes(): array
    {
        $topic_api = new TopicApi($this->admin_topic_model);
        $vocabulary_api = new VocabularyApi($this->admin_vocabulary_model);
        $auth_api = new AuthAPI($this->authentication_helper,$this->admin_user_model);
        $quiz_api = new QuizApi($this->admin_topic_model, $this->admin_quiz_model);
        
        return [
            '/api/v1/auth/login'=> [
                'POST' => [
                    'controller' => $auth_api,
                    'action' => 'login',
                ]
            ],
            '/api/v1/auth/register'=> [
                'POST' => [
                    'controller' => $auth_api,
                    'action' => 'register',
                ]
            ],
            '/api/v1/topics' => [
                'GET' => [
                    'controller' => $topic_api,
                    'action' => 'get_all'
                ],
                'POST' => [
                    'controller' => $topic_api,
                    'action' => 'create_new_topic'
                ]
            ],
            '/api/v1/vocabularies' => [
                'GET' => [
                    'controller' => $vocabulary_api,
                    'action' => 'get_all'
                ]
            ],
            '/api/v1/vocabularies/show' => [
                'GET' => [
                    'controller' => $vocabulary_api,
                    'action' => 'get_detail'
                ]
            ],
            '/api/v1/vocabularies/search/english' => [
                'GET' => [
                    'controller' => $vocabulary_api,
                    'action' => 'search_by_english'
                ]
            ],
            '/api/v1/vocabularies/search/vietnamese' => [
                'GET' => [
                    'controller' => $vocabulary_api,
                    'action' => 'search_by_vietnamese'
                ]
            ],
            '/api/v1/quizzes' => [
                'GET' => [
                    'controller' => $quiz_api,
                    'action' => 'get_all_quizzes_total'
                ]
            ]
        ];
    }

    public function get_client_routes(): array
    {
        $controller = new HomeController($this->admin_topic_model, $this->admin_quiz_model, $this->admin_question_model, $this->admin_vocabulary_model);
        $quiz_controller = new QuizController($this->admin_quiz_model, $this->admin_topic_model, $this->admin_question_model, $this->user_quiz_model, $this->quiz_history_model, $this->authentication_helper);
        $profile_controller = new ProfileController($this->admin_user_model);

        return [
            '/' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
            '/vocabulary/show' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'show_vocabulary'
                ]
            ],
            '/quizzes' => [
                'GET' => [
                    'controller' => $quiz_controller,
                    'action' => 'index'
                ]
            ],
            '/quizzes/by_topic' => [
                'GET' => [
                    'controller' => $quiz_controller,
                    'action' => 'show_quizzes_by_topic'
                ]
            ],
            '/quizzes/take-quiz' => [
                'GET' => [
                    'controller' => $quiz_controller,
                    'action' => 'take_quiz'
                ],
                'POST' => [
                    'controller' => $quiz_controller,
                    'action' => 'process_quiz'
                ]
            ],
            '/quizzes/random' => [
                'POST' => [
                    'controller' => $quiz_controller,
                    'action' => 'generate_random_quiz'
                ]
            ],
            '/quizzes/vocabulary_practice' => [
                'POST' => [
                    'controller' => $quiz_controller,
                    'action' => 'generate_practice_quiz'
                ]
            ],
            '/quizzes/histories/show' => [
                'GET' => [
                    'controller' => $quiz_controller,
                    'action' => 'show_history'
                ]
            ],
            '/me' => [
                'GET' => [
                    'controller' => $profile_controller,
                    'action' => 'show_dashboard'
                ],
                'POST' => [
                    'controller' => $profile_controller,
                    'action' => 'process_update'
                ],
                'login' => true,
            ],
            '/me/quizzes' => [
                'GET' => [
                    'controller' => $profile_controller,
                    'action' => 'show_quizzes'
                ],
                'login' => true
            ]
           
        ];
    }

    public function get_auth_routes(): array
    {
        $auth_controller = new AuthController($this->authentication_helper, $this->admin_user_model);

        return [
            '/auth/sign-in' => [
                'GET' => [
                    'controller' => $auth_controller,
                    'action' => 'sign_in'
                ],
                'POST' => [
                    'controller' => $auth_controller,
                    'action' => 'process_sign_in'
                ]
            ],
            '/auth/sign-up' => [
                'GET' => [
                    'controller' => $auth_controller,
                    'action' => 'sign_up'
                ],
                'POST' => [
                    'controller' => $auth_controller,
                    'action' => 'process_register'
                ]
            ],
            '/auth/logout' => [
                'GET' => [
                    'controller' => $auth_controller,
                    'action' => 'log_user_out'
                ]
            ]
        ];
    }

    public function get_admin_dashboard_routes(): array
    {
        $controller = new AdminDashboardController();

        return [
            '/admin' => [
                'REDIRECT' => '/admin/dashboard'
            ],
            '/admin/dashboard' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ],
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
                ],
                '/admin/accounts/statistics' => [
                    'GET' => [
                        'controller' => $controller,
                        'action' => 'statistics'
                    ],
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
        // $controller = new AdminCustomerController();

        // return [
        //     '/admin/customers' => [
        //         'GET' => [
        //             'controller' => $controller,
        //             'action' => 'index'
        //         ]
        //     ]
        // ];
        return [];
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
        $controller = new AdminQuestionController($this->admin_question_model, $this->admin_topic_model);

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
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'update'
                ]
            ],
            '/admin/questions/statistic' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'show_statistic'
                ]
            ]
        ];
    }

    public function get_admin_quiz_routes(): array
    {
        $controller = new AdminQuizController($this->admin_quiz_model, $this->admin_question_model, $this->admin_topic_model);

        return [
            '/admin/quiz' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
            '/admin/quiz/create' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'create'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'store'
                ]
            ],
            '/admin/quiz/edit' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'edit'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'update'
                ]
            ],
            '/admin/quiz/generate/from-question-bank' => [
                'POST' => [
                    'controller' => $controller,
                    'action' => 'generate_from_question_bank'
                ]
            ],
            '/admin/quiz/statistic' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'show_statistic'
                ]
            ]
        ];
    }

    public function get_admin_quiz_history_routes(): array
    {
        $controller = new AdminQuizHistoryController($this->user_quiz_model);

        return [
            '/admin/quiz-history' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
            '/admin/quiz-history/statistic' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'show_statistic'
                ]
            ],
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
        $controller = new AdminVocabularyController($this->admin_vocabulary_model, $this->admin_media_model, $this->admin_topic_vocabulary_model, $this->admin_topic_model);

        return [
            '/admin/vocabularies' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
            '/admin/vocabularies/create' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'create'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'store'
                ]
            ],
            '/admin/vocabularies/edit' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'edit'
                ],
                'POST' => [
                    'controller' => $controller,
                    'action' => 'update'
                ]
            ],
            '/admin/vocabularies/delete' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'delete'
                ]
            ],
            '/admin/vocabularies/show' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'show'
                ]
            ],
            '/admin/vocabularies/filter/topic' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'filter_by_topic'
                ]
            ],
            '/admin/vocabularies/statistic' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'show_statistic'
                ]
            ]
        ];
    }

    public function get_admin_import_routes(): array
    {
        $controller = new AdminImportController(
            $this->admin_media_model,
            $this->admin_question_model,
            $this->admin_quiz_model,
            $this->admin_topic_model,
            $this->admin_topic_vocabulary_model,
            $this->admin_user_model,
            $this->admin_vocabulary_model,
            $this->admin_question_quiz_model,
            $this->quiz_history_model,
            $this->user_quiz_model,
        );

        return [
            '/generate-sample-data' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'process_sample_data_request'
                ]
            ],
            '/admin/import-sample-data' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ],
        ];
    }

    public function getAuthentication(): ?Authentication
    {
        return $this->authentication_helper;
    }

    public function checkPermission($permission): ?bool
    {
        $user = $this->authentication_helper->getUser();

        if (!($user instanceof UserEntity))
            return false;

        return $user->{UserEntity::KEY_USER_TYPE} == UserEntity::ADMIN;
    }

    public function getBaseController()
    {
        return new EStudyBaseController();
    }
}
