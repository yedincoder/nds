<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Modules\Product\Models\ProductModel;
use App\Modules\Order\Models\OrderModel;
use App\Modules\Invoice\Models\InvoiceModel;
use App\Modules\Customer\Models\UserProfileModel;
use App\Modules\Payment\Models\TransactionModel;
use App\Modules\CMS\Models\PageModel;
use App\Modules\CMS\Models\ArticleModel;
use App\Modules\CMS\Models\CategoryModel;
use App\Modules\CMS\Models\TagModel;
use App\Modules\Service\Models\ServiceModel;
use App\Modules\Portfolio\Models\PortfolioModel;
use App\Modules\Blog\Models\BlogModel;
use App\Modules\Support\Models\TicketModel;

class AdminPanel extends BaseController
{
    protected ProductModel $productModel;
    protected OrderModel $orderModel;
    protected InvoiceModel $invoiceModel;
    protected UserProfileModel $userProfileModel;
    protected TransactionModel $transactionModel;
    protected PageModel $pageModel;
    protected ArticleModel $articleModel;
    protected CategoryModel $categoryModel;
    protected TagModel $tagModel;
    protected ServiceModel $serviceModel;
    protected PortfolioModel $portfolioModel;
    protected BlogModel $blogModel;
    protected TicketModel $ticketModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->invoiceModel = new InvoiceModel();
        $this->userProfileModel = new UserProfileModel();
        $this->transactionModel = new TransactionModel();
        $this->pageModel = new PageModel();
        $this->articleModel = new ArticleModel();
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
        $this->serviceModel = new ServiceModel();
        $this->portfolioModel = new PortfolioModel();
        $this->blogModel = new BlogModel();
        $this->ticketModel = new TicketModel();
    }

    public function index(): string
    {
        $stats = [
            'products' => $this->productModel->countAllResults(),
            'orders' => $this->orderModel->countAllResults(),
            'invoices' => $this->invoiceModel->countAllResults(),
            'customers' => $this->userProfileModel->countAllResults(),
            'payments' => $this->transactionModel->countAllResults(),
            'pages' => $this->pageModel->countAllResults(),
            'articles' => $this->articleModel->countAllResults(),
            'categories' => $this->categoryModel->countAllResults(),
            'tags' => $this->tagModel->countAllResults(),
            'services' => $this->serviceModel->countAllResults(),
            'portfolios' => $this->portfolioModel->countAllResults(),
            'blogs' => $this->blogModel->countAllResults(),
            'tickets' => $this->ticketModel->countAllResults(),
        ];

        $recent = [
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'invoices' => $this->invoiceModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'products' => $this->productModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'tickets' => $this->ticketModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
        ];

        $modules = [
            [
                'name' => 'Products',
                'icon' => 'fas fa-box',
                'color' => 'primary',
                'count' => $stats['products'],
                'route' => 'adminpanel/products',
                'description' => 'Manage products and inventory',
            ],
            [
                'name' => 'Orders',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success',
                'count' => $stats['orders'],
                'route' => 'adminpanel/orders',
                'description' => 'Manage customer orders',
            ],
            [
                'name' => 'Invoices',
                'icon' => 'fas fa-file-invoice',
                'color' => 'info',
                'count' => $stats['invoices'],
                'route' => 'adminpanel/invoices',
                'description' => 'Manage invoices and billing',
            ],
            [
                'name' => 'Customers',
                'icon' => 'fas fa-users',
                'color' => 'warning',
                'count' => $stats['customers'],
                'route' => 'adminpanel/customers',
                'description' => 'Manage customer accounts',
            ],
            [
                'name' => 'Payments',
                'icon' => 'fas fa-credit-card',
                'color' => 'danger',
                'count' => $stats['payments'],
                'route' => 'adminpanel/payments',
                'description' => 'Manage payment transactions',
            ],
            [
                'name' => 'CMS Pages',
                'icon' => 'fas fa-file-alt',
                'color' => 'secondary',
                'count' => $stats['pages'],
                'route' => 'adminpanel/pages',
                'description' => 'Manage website pages',
            ],
            [
                'name' => 'Articles',
                'icon' => 'fas fa-newspaper',
                'color' => 'primary',
                'count' => $stats['articles'],
                'route' => 'adminpanel/articles',
                'description' => 'Manage blog articles',
            ],
            [
                'name' => 'Categories',
                'icon' => 'fas fa-folder',
                'color' => 'success',
                'count' => $stats['categories'],
                'route' => 'adminpanel/categories',
                'description' => 'Manage categories & tags',
            ],
            [
                'name' => 'Services',
                'icon' => 'fas fa-cogs',
                'color' => 'info',
                'count' => $stats['services'],
                'route' => 'adminpanel/services',
                'description' => 'Manage services',
            ],
            [
                'name' => 'Portfolio',
                'icon' => 'fas fa-briefcase',
                'color' => 'warning',
                'count' => $stats['portfolios'],
                'route' => 'adminpanel/portfolio',
                'description' => 'Manage portfolio items',
            ],
            [
                'name' => 'Blog',
                'icon' => 'fas fa-blog',
                'color' => 'danger',
                'count' => $stats['blogs'],
                'route' => 'adminpanel/blogs',
                'description' => 'Manage blog posts',
            ],
            [
                'name' => 'Support Tickets',
                'icon' => 'fas fa-headset',
                'color' => 'secondary',
                'count' => $stats['tickets'],
                'route' => 'adminpanel/tickets',
                'description' => 'Manage support tickets',
            ],
        ];

        $data = [
            'title' => 'Admin Panel - Module Management',
            'stats' => $stats,
            'recent' => $recent,
            'modules' => $modules,
        ];

        return view('AdminPanel/index', $data);
    }

    // =====================================================
    // PRODUCTS
    // =====================================================
    public function products(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $products = $this->productModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Products',
            'products' => $products,
            'pager' => $this->productModel->pager,
        ];

        return view('AdminPanel/products', $data);
    }

    public function createProduct(): string
    {
        $data = [
            'title' => 'Create Product',
        ];
        return view('AdminPanel/product_form', $data);
    }

    public function storeProduct(): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost([
            'name', 'slug', 'description', 'short_description',
            'price', 'sale_price', 'stock', 'sku', 'status',
            'featured', 'meta_title', 'meta_description'
        ]);

        $this->productModel->save($data);

        return redirect()->to('/adminpanel/products')
            ->with('success', 'Product created successfully');
    }

    public function editProduct($id = null): string
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/adminpanel/products')
                ->with('error', 'Product not found');
        }

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
        ];
        return view('AdminPanel/product_form', $data);
    }

    public function updateProduct($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost([
            'name', 'slug', 'description', 'short_description',
            'price', 'sale_price', 'stock', 'sku', 'status',
            'featured', 'meta_title', 'meta_description'
        ]);

        $this->productModel->update($id, $data);

        return redirect()->to('/adminpanel/products')
            ->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->productModel->delete($id);
        return redirect()->to('/adminpanel/products')
            ->with('success', 'Product deleted successfully');
    }

    // =====================================================
    // ORDERS
    // =====================================================
    public function orders(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $orders = $this->orderModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Orders',
            'orders' => $orders,
            'pager' => $this->orderModel->pager,
        ];

        return view('AdminPanel/orders', $data);
    }

    public function viewOrder($id = null): string
    {
        $order = $this->orderModel->find($id);
        if (!$order) {
            return redirect()->to('/adminpanel/orders')
                ->with('error', 'Order not found');
        }

        $data = [
            'title' => 'Order Details',
            'order' => $order,
        ];
        return view('AdminPanel/order_detail', $data);
    }

    public function updateOrderStatus($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $status = $this->request->getPost('status');
        $this->orderModel->update($id, ['status' => $status]);

        return redirect()->back()
            ->with('success', 'Order status updated');
    }

    // =====================================================
    // INVOICES
    // =====================================================
    public function invoices(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $invoices = $this->invoiceModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Invoices',
            'invoices' => $invoices,
            'pager' => $this->invoiceModel->pager,
        ];

        return view('AdminPanel/invoices', $data);
    }

    // =====================================================
    // CUSTOMERS
    // =====================================================
    public function customers(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $customers = $this->userProfileModel->join('users', 'users.id = user_profiles.user_id')
            ->select('user_profiles.*, users.email, users.username, users.status')
            ->orderBy('user_profiles.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Customers',
            'customers' => $customers,
            'pager' => $this->userProfileModel->pager,
        ];

        return view('AdminPanel/customers', $data);
    }

    // =====================================================
    // PAYMENTS
    // =====================================================
    public function payments(): string
    {
        $db = \Config\Database::connect();
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $perPage;

        $payments = $db->table('transactions t')
            ->select('t.*, i.invoice_number, u.username, u.email')
            ->join('invoices i', 'i.id = t.invoice_id', 'left')
            ->join('users u', 'u.id = t.user_id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResult();

        $data = [
            'title' => 'Manage Payments',
            'payments' => $payments,
            'pager' => $db->pager,
        ];

        return view('AdminPanel/payments', $data);
    }

    // =====================================================
    // CMS PAGES
    // =====================================================
    public function pages(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $pages = $this->pageModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Pages',
            'pages' => $pages,
            'pager' => $this->pageModel->pager,
        ];

        return view('AdminPanel/pages', $data);
    }

    public function createPage(): string
    {
        $data = [
            'title' => 'Create Page',
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('AdminPanel/page_form', $data);
    }

    public function storePage(): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost([
            'title', 'slug', 'content', 'excerpt', 'category_id',
            'status', 'meta_title', 'meta_description'
        ]);

        $this->pageModel->save($data);

        return redirect()->to('/adminpanel/pages')
            ->with('success', 'Page created successfully');
    }

    public function editPage($id = null): string
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            return redirect()->to('/adminpanel/pages')
                ->with('error', 'Page not found');
        }

        $data = [
            'title' => 'Edit Page',
            'page' => $page,
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('AdminPanel/page_form', $data);
    }

    public function updatePage($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost([
            'title', 'slug', 'content', 'excerpt', 'category_id',
            'status', 'meta_title', 'meta_description'
        ]);

        $this->pageModel->update($id, $data);

        return redirect()->to('/adminpanel/pages')
            ->with('success', 'Page updated successfully');
    }

    public function deletePage($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->pageModel->delete($id);
        return redirect()->to('/adminpanel/pages')
            ->with('success', 'Page deleted successfully');
    }

    // =====================================================
    // ARTICLES
    // =====================================================
    public function articles(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $articles = $this->articleModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Articles',
            'articles' => $articles,
            'pager' => $this->articleModel->pager,
        ];

        return view('AdminPanel/articles', $data);
    }

    public function createArticle(): string
    {
        $data = [
            'title' => 'Create Article',
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];
        return view('AdminPanel/article_form', $data);
    }

    public function storeArticle(): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost([
            'title', 'slug', 'content', 'excerpt', 'category_id',
            'tags', 'status', 'author', 'published_at',
            'meta_title', 'meta_description'
        ]);

        $this->articleModel->save($data);

        return redirect()->to('/adminpanel/articles')
            ->with('success', 'Article created successfully');
    }

    public function editArticle($id = null): string
    {
        $article = $this->articleModel->find($id);
        if (!$article) {
            return redirect()->to('/adminpanel/articles')
                ->with('error', 'Article not found');
        }

        $data = [
            'title' => 'Edit Article',
            'article' => $article,
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];
        return view('AdminPanel/article_form', $data);
    }

    public function updateArticle($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost([
            'title', 'slug', 'content', 'excerpt', 'category_id',
            'tags', 'status', 'author', 'published_at',
            'meta_title', 'meta_description'
        ]);

        $this->articleModel->update($id, $data);

        return redirect()->to('/adminpanel/articles')
            ->with('success', 'Article updated successfully');
    }

    public function deleteArticle($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->articleModel->delete($id);
        return redirect()->to('/adminpanel/articles')
            ->with('success', 'Article deleted successfully');
    }

    // =====================================================
    // CATEGORIES
    // =====================================================
    public function categories(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $categories = $this->categoryModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Categories',
            'categories' => $categories,
            'pager' => $this->categoryModel->pager,
        ];

        return view('AdminPanel/categories', $data);
    }

    public function storeCategory(): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost(['name', 'slug', 'description']);
        $this->categoryModel->save($data);
        return redirect()->to('/adminpanel/categories')
            ->with('success', 'Category created successfully');
    }

    public function deleteCategory($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/adminpanel/categories')
            ->with('success', 'Category deleted successfully');
    }

    // =====================================================
    // TAGS
    // =====================================================
    public function tags(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $tags = $this->tagModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Tags',
            'tags' => $tags,
            'pager' => $this->tagModel->pager,
        ];

        return view('AdminPanel/tags', $data);
    }

    public function storeTag(): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = $this->request->getPost(['name', 'slug', 'description']);
        $this->tagModel->save($data);
        return redirect()->to('/adminpanel/tags')
            ->with('success', 'Tag created successfully');
    }

    public function deleteTag($id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->tagModel->delete($id);
        return redirect()->to('/adminpanel/tags')
            ->with('success', 'Tag deleted successfully');
    }

    // =====================================================
    // SERVICES
    // =====================================================
    public function services(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $services = $this->serviceModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Services',
            'services' => $services,
            'pager' => $this->serviceModel->pager,
        ];

        return view('AdminPanel/services', $data);
    }

    // =====================================================
    // PORTFOLIO
    // =====================================================
    public function portfolio(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $portfolios = $this->portfolioModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Portfolio',
            'portfolios' => $portfolios,
            'pager' => $this->portfolioModel->pager,
        ];

        return view('AdminPanel/portfolio', $data);
    }

    // =====================================================
    // BLOG
    // =====================================================
    public function blogs(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $blogs = $this->blogModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Blog Posts',
            'blogs' => $blogs,
            'pager' => $this->blogModel->pager,
        ];

        return view('AdminPanel/blogs', $data);
    }

    // =====================================================
    // TICKETS
    // =====================================================
    public function tickets(): string
    {
        $perPage = 20;
        $page = $this->request->getGet('page') ?? 1;

        $tickets = $this->ticketModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Manage Support Tickets',
            'tickets' => $tickets,
            'pager' => $this->ticketModel->pager,
        ];

        return view('AdminPanel/tickets', $data);
    }
}