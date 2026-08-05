<?php

namespace App\Modules\CMS\Controllers;

use App\Controllers\BaseController;
use App\Modules\CMS\Services\CMSService;
use CodeIgniter\HTTP\ResponseInterface;

class ArticleController extends BaseController
{
    protected CMSService $cmsService;

    public function __construct()
    {
        $this->cmsService = new CMSService();
    }

    public function index()
    {
        $perPage = 10;
        $page = $this->request->getGet('page') ?? 1;
        $category = $this->request->getGet('category');
        $tag = $this->request->getGet('tag');

        $result = $this->cmsService->getArticles([
            'page' => $page,
            'perPage' => $perPage,
            'category' => $category,
            'tag' => $tag,
            'status' => 'published'
        ]);

        $data = [
            'title' => 'Articles',
            'articles' => $result['data']['articles'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'categories' => $this->cmsService->getCategories('article')['data'] ?? [],
            'tags' => $this->cmsService->getTags()['data'] ?? [],
        ];

        return view('CMS/articles', $data);
    }

    public function detail(string $slug)
    {
        $result = $this->cmsService->getArticleBySlug($slug);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['title'],
            'article' => (object) $result['data'],
        ];

        return view('CMS/article', $data);
    }

    public function category(string $slug)
    {
        $perPage = 10;
        $page = $this->request->getGet('page') ?? 1;

        $result = $this->cmsService->getArticlesByCategory($slug, [
            'page' => $page,
            'perPage' => $perPage,
        ]);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $result['data']['category']->name ?? 'Articles',
            'articles' => $result['data']['articles'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'category' => $result['data']['category'] ?? null,
        ];

        return view('CMS/articles', $data);
    }

    public function tag(string $slug)
    {
        $perPage = 10;
        $page = $this->request->getGet('page') ?? 1;

        $result = $this->cmsService->getArticlesByTag($slug, [
            'page' => $page,
            'perPage' => $perPage,
        ]);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Tag: ' . $result['data']['tag']->name ?? 'Articles',
            'articles' => $result['data']['articles'] ?? [],
            'pager' => $result['data']['pager'] ?? null,
            'tag' => $result['data']['tag'] ?? null,
        ];

        return view('CMS/articles', $data);
    }
}
