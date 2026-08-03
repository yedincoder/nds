<?php

namespace App\Modules\Portfolio\Controllers;

use App\Controllers\BaseController;
use App\Modules\Portfolio\Services\PortfolioService;
use CodeIgniter\HTTP\ResponseInterface;

class PortfolioController extends BaseController
{
    protected PortfolioService $portfolioService;

    public function __construct()
    {
        $this->portfolioService = new PortfolioService();
    }

    public function index()
    {
        $perPage = 9;
        $page = $this->request->getGet('page') ?? 1;
        $category = $this->request->getGet('category');

        $result = $this->portfolioService->getPortfolios([
            'page' => $page,
            'perPage' => $perPage,
            'category' => $category,
            'status' => 'published'
        ]);

        $data = [
            'title' => 'Portfolio',
            'portfolios' => $result['data']['portfolios'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'categories' => $this->portfolioService->getCategories()['data'] ?? [],
        ];

        return view('Portfolio/index', $data);
    }

    public function detail(string $slug)
    {
        $result = $this->portfolioService->getPortfolioBySlug($slug);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['title'],
            'portfolio' => $result['data'],
        ];

        return view('Portfolio/detail', $data);
    }

    public function category(string $slug)
    {
        $perPage = 9;
        $page = $this->request->getGet('page') ?? 1;

        $result = $this->portfolioService->getPortfoliosByCategory($slug, [
            'page' => $page,
            'perPage' => $perPage,
        ]);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['category']->name ?? 'Portfolio',
            'portfolios' => $result['data']['portfolios'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'category' => $result['data']['category'] ?? null,
        ];

        return view('Portfolio/index', $data);
    }
}
