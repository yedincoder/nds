<?php

namespace App\Modules\Blog\Controllers;

use App\Controllers\BaseController;
use App\Modules\CMS\Services\CMSService;
use CodeIgniter\HTTP\ResponseInterface;

class BlogController extends BaseController
{
    protected CMSService $cmsService;

    public function __construct()
    {
        $this->cmsService = new CMSService();
    }

    public function index()
    {
        $perPage = 6;
        $page = $this->request->getGet('page') ?? 1;
        $category = $this->request->getGet('category');
        $tag = $this->request->getGet('tag');

        $result = $this->cmsService->getArticles([
            'page' => $page,
            'perPage' => $perPage,
            'category' => $category,
            'tag' => $tag,
            'status' => 'published',
            'orderBy' => 'published_at',
            'orderDir' => 'DESC'
        ]);

        $data = [
            'title' => 'Blog',
            'articles' => $result['data']['articles'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'featured' => $this->cmsService->getFeaturedArticles(3)['data'] ?? [],
            'categories' => $this->cmsService->getCategories('article')['data'] ?? [],
            'recent' => $this->cmsService->getRecentArticles(5)['data'] ?? [],
        ];

        return view('Blog/index', $data);
    }

    public function detail(string $slug)
    {
        $result = $this->cmsService->getArticleBySlug($slug);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['title'],
            'article' => $result['data'],
        ];

        return view('Blog/detail', $data);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        $perPage = 6;
        $page = $this->request->getGet('page') ?? 1;

        $result = $this->cmsService->searchArticles($keyword, [
            'page' => $page,
            'perPage' => $perPage,
        ]);

        $data = [
            'title' => 'Search: ' . $keyword,
            'articles' => $result['data']['articles'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'keyword' => $keyword,
        ];

        return view('Blog/search', $data);
    }
}
