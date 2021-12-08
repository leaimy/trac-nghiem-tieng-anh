<?php

namespace EStudy;

use EStudy\Controller\Admin\AdminAccountController;
use EStudy\Controller\Admin\AdminContactUsController;
use EStudy\Controller\Admin\AdminCustomerController;
use EStudy\Controller\Admin\AdminDashboardController;
use EStudy\Controller\Admin\AdminMediaController;
use EStudy\Controller\Admin\AdminQuestionController;
use EStudy\Controller\Admin\AdminQuizController;
use EStudy\Controller\Admin\AdminQuizHistoryController;
use EStudy\Controller\Admin\AdminSettingController;
use EStudy\Controller\Admin\AdminTopicController;
use EStudy\Controller\Admin\AdminVocabularyController;
use Ninja\Authentication;
use Ninja\NJInterface\IRoutes;

class EStudyRoutesHandler implements IRoutes
{
    public function __construct()
    {
    }

    public function getRoutes(): array
    {
        $controller_routes = $this->get_all_controller_routes();
        $api_routes = $this->get_all_api_routes();

        return $controller_routes + $api_routes;
    }

    public function get_all_controller_routes()
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
            $admin_vocabulary_routes;
    }

    public function get_all_api_routes()
    {
        return [];
    }

    public function get_admin_dashboard_routes()
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
                ]
            ]
        ];
    }

    public function get_admin_account_routes()
    {
        $controller = new AdminAccountController();

        return [
            '/admin/accounts' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_contact_us_routes()
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

    public function get_admin_customer_routes()
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

    public function get_admin_media_routes()
    {
        $controller = new AdminMediaController();

        return [
            '/admin/media' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_question_routes()
    {
        $controller = new AdminQuestionController();

        return [
            '/admin/questions' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_quiz_routes()
    {
        $controller = new AdminQuizController();

        return [
            '/admin/quiz' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_quiz_history_routes()
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

    public function get_admin_setting_routes()
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

    public function get_admin_topic_routes()
    {
        $controller = new AdminTopicController();

        return [
            '/admin/topics' => [
                'GET' => [
                    'controller' => $controller,
                    'action' => 'index'
                ]
            ]
        ];
    }

    public function get_admin_vocabulary_routes()
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

    public function getAuthentication(): ?Authentication
    {
        return null;
    }

    public function checkPermission($permission): ?bool
    {
        return null;
    }
}
