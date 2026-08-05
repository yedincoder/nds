<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * AdminBaseController
 * 
 * Base controller for AdminArea controllers.
 * Handles admin authentication, authorization, and common admin functionality.
 */
abstract class AdminBaseController extends BaseController
{
    protected $user;
    protected $isAdmin = false;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load helpers
        helper(['url', 'form']);

        // Check authentication
        $this->checkAuthentication();

        // Load common admin data
        $this->loadCommonData();
    }

    /**
     * Check if user is authenticated and is admin
     * (Redirect dilakukan oleh filter auth/permission di routes)
     */
    protected function checkAuthentication(): void
    {
        if (!session()->get('isLoggedIn')) {
            $this->isAdmin = false;
            return;
        }

        // Check if user has admin role
        $userRole = session()->get('user_role');
        $this->isAdmin = in_array($userRole, ['admin', 'super_admin'], true);

        $this->user = [
            'id' => session()->get('user_id'),
            'username' => session()->get('username'),
            'email' => session()->get('email'),
            'role' => session()->get('user_role'),
            'full_name' => session()->get('full_name'),
        ];
    }

    /**
     * Load common admin data
     */
    protected function loadCommonData(): void
    {
        $this->adminData = [
            'appName' => config('App')->appName ?? 'Admin Panel',
            'user' => $this->user,
            'menuActive' => '',
            'breadcrumb' => [],
        ];
    }

    /**
     * Set active menu
     */
    protected function setActiveMenu(string $menu): void
    {
        $this->adminData['menuActive'] = $menu;
    }

    /**
     * Set breadcrumb
     */
    protected function setBreadcrumb(array $breadcrumb): void
    {
        $this->adminData['breadcrumb'] = $breadcrumb;
    }

    /**
     * Render admin view
     */
    protected function render(string $view, array $data = []): string
    {
        $data = array_merge($this->adminData, $data);
        return view($view, $data);
    }

    /**
     * Success redirect with message
     */
    protected function redirectSuccess(string $route, string $message): \CodeIgniter\HTTP\RedirectResponse
    {
        return redirect()->to($route)->with('success', $message);
    }

    /**
     * Error redirect with message
     */
    protected function redirectError(string $route, string $message): \CodeIgniter\HTTP\RedirectResponse
    {
        return redirect()->back()->with('error', $message);
    }

    /**
     * Validation error redirect
     */
    protected function redirectValidationError(): \CodeIgniter\HTTP\RedirectResponse
    {
        return redirect()->back()
            ->with('errors', $this->validator->getErrors())
            ->withInput();
    }

    /**
     * Get current user
     */
    protected function getCurrentUser(): ?array
    {
        return $this->user ?? null;
    }

    /**
     * Check permission
     */
    protected function hasPermission(string $permission): bool
    {
        // Implement permission check logic here
        // For now, return true for super_admin
        return session()->get('user_role') === 'super_admin';
    }
}