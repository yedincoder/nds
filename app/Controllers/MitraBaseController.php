<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * MitraBaseController
 * 
 * Base controller for MitraArea controllers (untuk pengembangan masa depan).
 * Handles partner/mitra authentication, authorization, and common functionality.
 */
abstract class MitraBaseController extends BaseController
{
    protected $user;
    protected $mitraProfile;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load helpers
        helper(['url', 'form', 'auth', 'mitra']);

        // Check authentication
        $this->checkAuthentication();

        // Load common mitra data
        $this->loadCommonData();
    }

    /**
     * Check if user is authenticated and is a mitra
     */
    protected function checkAuthentication(): void
    {
        if (!session()->get('isLoggedIn')) {
            return;
        }

        // Check if user has mitra role
        $userRole = session()->get('user_role');
        if ($userRole !== 'mitra' && $userRole !== 'partner') {
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
     * Load common mitra data
     */
    protected function loadCommonData(): void
    {
        $this->mitraData = [
            'appName' => config('App')->appName ?? 'Mitra Panel',
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
        $this->mitraData['menuActive'] = $menu;
    }

    /**
     * Set breadcrumb
     */
    protected function setBreadcrumb(array $breadcrumb): void
    {
        $this->mitraData['breadcrumb'] = $breadcrumb;
    }

    /**
     * Render mitra view
     */
    protected function render(string $view, array $data = []): string
    {
        $data = array_merge($this->mitraData, $data);
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