<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * FrontBaseController
 * 
 * Base controller for FrontArea controllers (public-facing pages).
 * Handles public pages, optional authentication, and common frontend functionality.
 */
abstract class FrontBaseController extends BaseController
{
    protected $user;
    protected $isLoggedIn = false;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load helpers
        helper(['url', 'form', 'text', 'html']);

        // Check authentication (optional for front area)
        $this->checkAuthentication();

        // Load common frontend data
        $this->loadCommonData();
    }

    /**
     * Check authentication (optional for front area)
     */
    protected function checkAuthentication(): void
    {
        $this->isLoggedIn = session()->get('isLoggedIn') ?? false;
        
        if ($this->isLoggedIn) {
            $this->user = [
                'id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'role' => session()->get('user_role'),
                'full_name' => session()->get('full_name'),
            ];
        }
    }

    /**
     * Load common frontend data
     */
    protected function loadCommonData(): void
    {
        $this->frontData = [
            'appName' => config('App')->appName ?? 'NgAppID',
            'appTagline' => 'Platform Digital Modern untuk Bisnis Anda',
            'isLoggedIn' => $this->isLoggedIn,
            'user' => $this->user ?? null,
            'currentYear' => date('Y'),
            'meta' => [
                'title' => config('App')->appName ?? 'NgAppID',
                'description' => 'Platform digital modern untuk pengembangan aplikasi, penjualan produk digital, sistem billing, dan dukungan pelanggan terintegrasi.',
                'keywords' => 'digital platform, software development, digital products, billing system',
                'og_image' => base_url('assets/images/og-image.jpg'),
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
        $this->frontData['menuActive'] = $menu;
    }

    /**
     * Set breadcrumb
     */
    protected function setBreadcrumb(array $breadcrumb): void
    {
        $this->frontData['breadcrumb'] = $breadcrumb;
    }

    /**
     * Set page meta
     */
    protected function setMeta(array $meta): void
    {
        $this->frontData['meta'] = array_merge($this->frontData['meta'] ?? [], $meta);
    }

    /**
     * Render frontend view
     */
    protected function render(string $view, array $data = []): string
    {
        $data = array_merge($this->frontData, $data);
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
     * Check if user is logged in
     */
    protected function isLoggedIn(): bool
    {
        return $this->isLoggedIn;
    }
}