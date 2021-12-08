<?php

namespace EStudy;

use EStudy\Controller\Admin\AdminDashboardController;
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

        return $admin_dashboard_routes;
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

    public function getAuthentication(): ?Authentication
    {
        return null;
    }

    public function checkPermission($permission): ?bool
    {
        return null;
    }
}
