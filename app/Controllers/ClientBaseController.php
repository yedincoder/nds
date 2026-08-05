<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * ClientBaseController
 * 
 * Base controller for ClientArea controllers.
 * Handles customer authentication, authorization, and common client functionality.
 */
abstract class ClientBaseController extends BaseController
{
    protected $user;
    protected $clientProfile;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load helpers
        helper(['url', 'form', 'auth', 'client']);

        // Check authentication
        $this->checkAuthentication();

        // Load common client data
        $this->loadCommonData();
    }

    /**
     * Check if user is authenticated and is a customer
     */
    protected function checkAuthentication(): void
    {
        if (!session()->get('isLoggedIn')) {
            return;
        }

        // Check if user has customer role
        $userRole = session()->get('user_role');
        if ($userRole !== 'customer' && $userRole !== 'client') {
            return;
        }

        $this->user = [
            'id' => session()->get('user_id'),
            'username' => session()->get('username'),
            'email' => session()->get('email'),
            'role' => session()->get('user_role'),
            'full_name' => session()->get('full_name'),
        ];
    }

    /**
     * Load common client data
     */
    protected function loadCommonData(): void
    {
        $userId = session()->get('user_id');
        
        $this->clientData = [
            'appName' => config('App')->appName ?? 'NgAppID',
            'user' => [
                'id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'full_name' => session()->get('full_name'),
            ],
            'menuActive' => '',
            'breadcrumb' => [],
        ];
    }

    /**
     * Set active menu
     */
    protected function setActiveMenu(string $menu): void
    {
        $this->clientData['menuActive'] = $menu;
    }

    /**
     * Set breadcrumb
     */
    protected function setBreadcrumb(array $breadcrumb): void
    {
        $this->clientData['breadcrumb'] = $breadcrumb;
    }

    /**
     * Render client view
     */
    protected function render(string $view, array $data = []): string
    {
        $data = array_merge($this->clientData, $data);
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
}