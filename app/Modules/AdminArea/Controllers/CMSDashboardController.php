<?php
namespace App\Modules\AdminArea\Controllers;

use App\Modules\FrontArea\Models\PageModel;
use App\Modules\FrontArea\Models\ArticleModel;
use App\Modules\FrontArea\Models\CategoryModel;
use App\Modules\FrontArea\Models\TagModel;
use App\Controllers\AdminBaseController;

class CMSDashboardController extends \App\Controllers\AdminBaseController
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
            'page'  => 'admin/cms',
            'stats' => [
                'pages' => $this->pageModel->countAllResults(),
                'articles' => $this->articleModel->countAllResults(),
                'categories' => $this->categoryModel->countAllResults(),
                'tags' => $this->tagModel->countAllResults(),
            ],
            'recent_pages' => $this->pageModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recent_articles' => $this->articleModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
        ];

        return view('AdminArea/cms/index', $data);
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
            'page'  => 'admin/cms/pages',
            'pages' => $this->pageModel->orderBy('created_at', 'DESC')
                ->paginate($perPage, 'default', $page),
            'pager' => $this->pageModel->pager,
        ];

        return view('AdminArea/cms/pages', $data);
    }

    public function createPage(): string
    {
        $data = [
            'title' => 'Create Page',
            'page'  => 'admin/cms/pages',
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('AdminArea/cms/page_form', $data);
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
            'page'  => 'admin/cms/pages',
            'pageData' => $page,
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('AdminArea/cms/page_form', $data);
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
            'page'  => 'admin/cms/articles',
            'articles' => $this->articleModel
                ->orderBy('created_at', 'DESC')
                ->paginate($perPage),
            'pager' => $this->articleModel->pager,
        ];

        return view('AdminArea/cms/articles', $data);
    }

    public function createArticle(): string
    {
        $data = [
            'title' => 'Create Article',
            'page'  => 'admin/cms/articles',
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];

        return view('AdminArea/cms/article_form', $data);
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
            'page'  => 'admin/cms/articles',
            'article' => $article,
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];

        return view('AdminArea/cms/article_form', $data);
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
            'page'  => 'admin/cms/categories',
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('AdminArea/cms/categories', $data);
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

    public function editCategory(int $id): string|RedirectResponse
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/cms/categories')
                ->with('error', 'Category not found.');
        }

        $data = [
            'title' => 'Edit Category',
            'page'  => 'admin/cms/categories',
            'category' => $category,
        ];

        return view('AdminArea/cms/category_form', $data);
    }

    public function updateCategory(int $id): RedirectResponse
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/cms/categories')
                ->with('error', 'Category not found.');
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/cms/categories')
            ->with('success', 'Category updated successfully');
    }

    // =====================================================
    // TAGS
    // =====================================================
    public function tags(): string
    {
        $data = [
            'title' => 'Manage Tags',
            'page'  => 'admin/cms/tags',
            'tags' => $this->tagModel->findAll(),
        ];

        return view('AdminArea/cms/tags', $data);
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

    public function editTag(int $id): string|RedirectResponse
    {
        $tag = $this->tagModel->find($id);
        if (!$tag) {
            return redirect()->to('/admin/cms/tags')
                ->with('error', 'Tag not found.');
        }

        $data = [
            'title' => 'Edit Tag',
            'page'  => 'admin/cms/tags',
            'tag' => $tag,
        ];

        return view('AdminArea/cms/tag_form', $data);
    }

    public function updateTag(int $id): RedirectResponse
    {
        $tag = $this->tagModel->find($id);
        if (!$tag) {
            return redirect()->to('/admin/cms/tags')
                ->with('error', 'Tag not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'slug' => 'required|min_length[2]|max_length[100]|is_unique[tags.slug,id,{id}]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $this->tagModel->update($id, [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/cms/tags')
            ->with('success', 'Tag updated successfully');
    }

    // =====================================================
    // IMAGE UPLOAD (for WYSIWYG editor)
    // =====================================================
    public function uploadImage(): \CodeIgniter\HTTP\ResponseInterface
    {
        $file = $this->request->getFile('upload');
        $field = $this->request->getPost('CKEditorFuncNum');

        if (!$file || !$file->isValid()) {
            $message = 'Invalid file upload.';
            return $this->response->setBody("<script>window.parent.CKEDITOR.tools.callFunction($field, '', '" . esc($message) . "');</script>");
        }

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array(strtolower($file->getExtension()), $allowedTypes, true)) {
            $message = 'Only image files are allowed (jpg, png, gif, webp).';
            return $this->response->setBody("<script>window.parent.CKEDITOR.tools.callFunction($field, '', '" . esc($message) . "');</script>");
        }

        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/media', $newName);

        $db = \Config\Database::connect();
        $db->table('media')->insert([
            'uuid' => date('YmdHis') . substr(md5(uniqid('', true)), 0, 8),
            'filename' => $newName,
            'original_name' => $file->getClientName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'path' => 'uploads/media/' . $newName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $url = base_url('uploads/media/' . $newName);
        return $this->response->setBody("<script>window.parent.CKEDITOR.tools.callFunction($field, '$url');</script>");
    }
}