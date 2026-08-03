<?php
namespace App\Modules\CMS\Controllers\Admin;

use App\Modules\CMS\Models\PageModel;
use App\Modules\CMS\Models\ArticleModel;
use App\Modules\CMS\Models\CategoryModel;
use App\Modules\CMS\Models\TagModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends \App\Controllers\BaseController
{
    protected PageModel $pageModel;
    protected ArticleModel $articleModel;
    protected CategoryModel $categoryModel;
    protected TagModel $tagModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'CMS Dashboard',
            'stats' => [
                'pages' => $this->pageModel->countAllResults(),
                'articles' => $this->articleModel->countAllResults(),
                'categories' => $this->categoryModel->countAllResults(),
                'tags' => $this->tagModel->countAllResults(),
            ],
            'recent_pages' => $this->pageModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recent_articles' => $this->articleModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
        ];

        return view('Dashboard/cms_dashboard', $data);
    }

    // ==============================
    // PAGES
    // =====================================================
    public function pages(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Manage Pages',
            'pages' => $this->pageModel->orderBy('created_at', 'DESC')
                ->limit($perPage, ($page - 1) * $perPage)
                ->findAll(),
            'pager' => $this->pageModel->pager,
        ];

        return view('Dashboard/cms_pages', $data);
    }

    public function createPage(): string
    {
        $data = [
            'title' => 'Create Page',
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('Dashboard/cms_page_form', $data);
    }

    public function storePage(): RedirectResponse
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'slug' => 'required|max_length[255]|is_unique[pages.slug,id,{id}]',
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->pageModel->save([
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status') ?? 'draft',
            'excerpt' => $this->request->getPost('excerpt'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ]);

        return redirect()->to('/admin/cms/pages')
            ->with('success', 'Page created successfully.');
    }

    public function editPage($id = null): string
    {
        $page = $this->pageModel->find($id);
        if (! $page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Page',
            'page' => $page,
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('Dashboard/cms_page_form', $data);
    }

    public function updatePage($id = null): RedirectResponse
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        $this->pageModel->save($data);

        return redirect()->to('/admin/cms/pages')
            ->with('success', 'Page updated successfully.');
    }

    public function deletePage($id = null): RedirectResponse
    {
        $this->pageModel->delete($id, true);

        return redirect()->to('/admin/cms/pages')
            ->with('success', 'Page deleted successfully.');
    }

    // =====================================================
    // ARTICLES
    // =====================================================
    public function articles(): string
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Manage Articles',
            'articles' => $this->articleModel
                ->orderBy('created_at', 'DESC')
                ->paginate($perPage),
            'pager' => $this->articleModel->pager,
        ];

        return view('Dashboard/cms_articles', $data);
    }

    public function createArticle(): string
    {
        $data = [
            'title' => 'Create Article',
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];

        return view('Dashboard/cms_article_form', $data);
    }

    public function storeArticle(): RedirectResponse
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required|min_length[3]|max_length[255]|is_unique[articles.slug,id,{id}]',
            'content' => 'required',
            'category_id' => 'required|integer',
            'status' => 'required|in_list[pending,approved,archived]',
            'excerpt' => 'required',
            'author' => 'required',
            'published_at' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->articleModel->save([
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status'),
            'excerpt' => $this->request->getPost('excerpt'),
            'author' => $this->request->getPost('author'),
            'published_at' => $this->request->getPost('published_at'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ]);

        return redirect()->to('/admin/cms/articles')
            ->with('success', 'Article created successfully');
    }

    public function editArticle($id = null): string
    {
        $article = $this->articleModel->find($id);

        if (! $article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Article',
            'article' => $article,
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];

        return view('Dashboard/cms_article_form', $data);
    }

    public function updateArticle($id = null): RedirectResponse
    {
        $article = $this->articleModel->find($id);

        if (! $article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        $this->articleModel->save($data);

        return redirect()->to('/admin/cms/articles')
            ->with('success', 'Article updated successfully');
    }

    public function deleteArticle($id = null): RedirectResponse
    {
        $this->articleModel->delete($id, true);

        return redirect()->to('/admin/cms/articles')
            ->with('success', 'Article deleted successfully');
    }

    // =====================================================
    // CATEGORIES
    // =====================================================
    public function categories(): string
    {
        $data = [
            'title' => 'Manage Categories',
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('Dashboard/cms_categories', $data);
    }

    public function createCategory(): RedirectResponse
    {
        $this->categoryModel->save([
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/cms/categories')
            ->with('success', 'Category created successfully');
    }

    public function deleteCategory($id = null): RedirectResponse
    {
        $this->categoryModel->delete($id, true);

        return redirect()->to('/admin/cms/categories')
            ->with('success', 'Category deleted successfully');
    }

    // =====================================================
    // TAGS
    // =====================================================
    public function tags(): string
    {
        $data = [
            'title' => 'Manage Tags',
            'tags' => $this->tagModel->findAll(),
        ];

        return view('Dashboard/cms_tags', $data);
    }

    public function createTag(): RedirectResponse
    {
        $this->tagModel->save([
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/cms/tags')
            ->with('success', 'Tag created successfully');
    }

    public function deleteTag($id = null): RedirectResponse
    {
        $this->tagModel->delete($id, true);

        return redirect()->to('/admin/cms/tags')
            ->with('success', 'Tag deleted successfully');
    }
}