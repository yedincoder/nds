<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use App\Modules\Product\Models\ProductModel;
use App\Modules\Order\Models\OrderModel;
use App\Modules\Customer\Models\UserProfileModel;
use App\Modules\Invoice\Models\InvoiceModel;
use App\Modules\Payment\Models\TransactionModel;
use App\Modules\CMS\Models\PageModel;
use App\Modules\CMS\Models\ArticleModel;
use App\Modules\CMS\Models\CategoryModel;
use App\Modules\CMS\Models\TagModel;
use App\Modules\Service\Models\ServiceModel;
use App\Modules\Portfolio\Models\PortfolioModel;
use App\Modules\Blog\Models\BlogModel;
use App\Modules\Support\Models\TicketModel;

class AdminDashboardController extends BaseController
{
    protected ProductModel $productModel;
    protected OrderModel $orderModel;
    protected UserProfileModel $userProfileModel;
    protected InvoiceModel $invoiceModel;
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
        $this->userProfileModel = new UserProfileModel();
        $this->invoiceModel = new InvoiceModel();
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

    public function index()
    {
        $stats = [
            'total_products' => $this->productModel->countAllResults(),
            'total_orders' => $this->orderModel->countAllResults(),
            'total_customers' => $this->userProfileModel->countAllResults(),
            'total_revenue' => $this->invoiceModel->selectSum('total')->where('status', 'paid')->get()->getRow()->total ?? 0,
            'pending_orders' => $this->orderModel->where('status', 'pending')->countAllResults(),
            'unpaid_invoices' => $this->invoiceModel->where('status', 'unpaid')->countAllResults(),
        ];

        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'recent_orders' => $this->orderModel->orderBy('created_at', 'DESC')->limit(10)->findAll(),
        ];

        return view('Dashboard/dashboard', $data);
    }

    public function customers()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $customers = $this->userProfileModel->join('users', 'users.id = user_profiles.user_id')
            ->select('user_profiles.*, users.email, users.status')
            ->orderBy('user_profiles.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Customers',
            'customers' => $customers,
            'pager' => $this->userProfileModel->pager,
        ];

        return view('Dashboard/customers', $data);
    }

    public function products()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Products',
            'products' => $this->productModel->orderBy('created_at', 'DESC')->paginate($perPage),
            'pager' => $this->productModel->pager,
        ];

        return view('Dashboard/products', $data);
    }

    public function orders()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Orders',
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->paginate($perPage),
            'pager' => $this->orderModel->pager,
        ];

        return view('Dashboard/orders', $data);
    }

    public function invoices()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $data = [
            'title' => 'Invoices',
            'invoices' => $this->invoiceModel->orderBy('created_at', 'DESC')->paginate($perPage),
            'pager' => $this->invoiceModel->pager,
        ];

        return view('Dashboard/invoices', $data);
    }

    public function reports()
    {
        $data = [
            'title' => 'Reports',
            'stats' => [
            'total_revenue' => $this->invoiceModel->selectSum('total')->where('status', 'paid')->get()->getRow()->total ?? 0,
                'total_orders' => $this->orderModel->countAllResults(),
                'total_customers' => $this->userProfileModel->countAllResults(),
                'total_products' => $this->productModel->countAllResults(),
            ],
        ];

        return view('Dashboard/reports', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'Settings',
        ];

        return view('Dashboard/settings', $data);
}

    // =====================================================
    // DASHBOARD
    // =====================================================
    public function index()
    {
        $stats = [
            'total_products' => $this->productModel->countAllResults(),
            'total_orders' => $this->orderModel->countAllResults(),
            'total_customers' => $this->userProfileModel->countAllResults(),
            'total_revenue' => $this->invoiceModel->selectSum('total')->where('status', 'paid')->get()->getRow()->total ?? 0,
            'pending_orders' => $this->orderModel->where('status', 'pending')->countAllResults(),
            'unpaid_invoices' => $this->invoiceModel->where('status', 'unpaid')->countAllResults(),
            'total_payments' => $this->transactionModel->countAllResults(),
            'total_pages' => $this->pageModel->countAllResults(),
            'total_articles' => $this->articleModel->countAllResults(),
            'total_categories' => $this->categoryModel->countAllResults(),
            'total_tags' => $this->tagModel->countAllResults(),
            'total_services' => $this->serviceModel->countAllResults(),
            'total_portfolios' => $this->portfolioModel->countAllResults(),
            'total_blogs' => $this->blogModel->countAllResults(),
            'total_tickets' => $this->ticketModel->countAllResults(),
        ];

        $recent = [
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'invoices' => $this->invoiceModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'products' => $this->productModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'tickets' => $this->ticketModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
        ];

        $data = [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'recent_orders' => $this->orderModel->orderBy('created_at', 'DESC')->limit(10)->findAll(),
            'recent' => $recent,
        ];

        return view('Dashboard/dashboard', $data);
    }

    // =====================================================
    // PRODUCTS
    // =====================================================
    public function products()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $products = $this->productModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Products',
            'products' => $products,
            'pager' => $this->productModel->pager,
        ];

        return view('Dashboard/products', $data);
    }

    public function createProduct()
    {
        $data = [
            'title' => 'Create Product',
        ];
        return view('Dashboard/product_form', $data);
    }

    public function storeProduct()
    {
        $rules = [
            'name' => 'required|max_length[255]',
            'slug' => 'required|max_length[255]|is_unique[products.slug]',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'short_description' => $this->request->getPost('short_description'),
            'price' => $this->request->getPost('price'),
            'sale_price' => $this->request->getPost('sale_price'),
            'stock' => $this->request->getPost('stock'),
            'sku' => $this->request->getPost('sku'),
            'status' => $this->request->getPost('status') ?? 'active',
            'featured' => $this->request->getPost('featured') ?? 0,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        $this->productModel->save($data);

        return redirect()->to('/admin/products')
            ->with('success', 'Product created successfully');
    }

    public function editProduct($id = null)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product not found');
        }

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
        ];
        return view('Dashboard/product_form', $data);
    }

    public function updateProduct($id = null)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Product not found');
        }

        $rules = [
            'name' => 'required|max_length[255]',
            'slug' => 'required|max_length[255]|is_unique[products.slug,id,'.$id.']',
            'price' => 'required|decimal',
            'stock' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' => $this->request->getPost('description'),
            'short_description' => $this->request->getPost('short_description'),
            'price' => $this->request->getPost('price'),
            'sale_price' => $this->request->getPost('sale_price'),
            'stock' => $this->request->getPost('stock'),
            'sku' => $this->request->getPost('sku'),
            'status' => $this->request->getPost('status') ?? 'active',
            'featured' => $this->request->getPost('featured') ?? 0,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        $this->productModel->update($id, $data);

        return redirect()->to('/admin/products')
            ->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id = null)
    {
        $this->productModel->delete($id);
        return redirect()->to('/admin/products')
            ->with('success', 'Product deleted successfully');
    }

    // =====================================================
    // ORDERS
    // =====================================================
    public function orders()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $orders = $this->orderModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Orders',
            'orders' => $orders,
            'pager' => $this->orderModel->pager,
        ];

        return view('Dashboard/orders', $data);
    }

    public function viewOrder($id = null)
    {
        $order = $this->orderModel->find($id);
        if (!$order) {
            return redirect()->to('/admin/orders')
                ->with('error', 'Order not found');
        }

        $data = [
            'title' => 'Order Details',
            'order' => $order,
        ];
        return view('Dashboard/order_detail', $data);
    }

    public function updateOrderStatus($id = null)
    {
        $status = $this->request->getPost('status');
        $this->orderModel->update($id, ['status' => $status]);

        return redirect()->back()
            ->with('success', 'Order status updated');
    }

    // =====================================================
    // INVOICES
    // =====================================================
    public function invoices()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $invoices = $this->invoiceModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Invoices',
            'invoices' => $invoices,
            'pager' => $this->invoiceModel->pager,
        ];

        return view('Dashboard/invoices', $data);
    }

    public function viewInvoice($id = null)
    {
        $invoice = $this->invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/admin/invoices')
                ->with('error', 'Invoice not found');
        }

        $data = [
            'title' => 'Invoice Details',
            'invoice' => $invoice,
        ];
        return view('Dashboard/invoice_detail', $data);
    }

    // =====================================================
    // CUSTOMERS
    // =====================================================
    public function customers()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $customers = $this->userProfileModel->join('users', 'users.id = user_profiles.user_id')
            ->select('user_profiles.*, users.email, users.username, users.status')
            ->orderBy('user_profiles.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Customers',
            'customers' => $customers,
            'pager' => $this->userProfileModel->pager,
        ];

        return view('Dashboard/customers', $data);
    }

    public function viewCustomer($id = null)
    {
        $profile = $this->userProfileModel->find($id);
        if (!$profile) {
            return redirect()->to('/admin/customers')
                ->with('error', 'Customer not found');
        }

        $data = [
            'title' => 'Customer Details',
            'profile' => $profile,
        ];
        return view('Dashboard/customer_detail', $data);
    }

    // =====================================================
    // PAYMENTS
    // =====================================================
    public function payments()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;
        $offset = ($page - 1) * $perPage;

        $db = \Config\Database::connect();
        $payments = $db->table('transactions t')
            ->select('t.*, i.invoice_number, u.username, u.email')
            ->join('invoices i', 'i.id = t.invoice_id', 'left')
            ->join('users u', 'u.id = t.user_id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResult();

        $data = [
            'title' => 'Payments',
            'payments' => $payments,
            'pager' => $db->pager,
        ];

        return view('Dashboard/payments', $data);
    }

    // =====================================================
    // PAGES (CMS)
    // =====================================================
    public function pages()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $pages = $this->pageModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Pages',
            'pages' => $pages,
            'pager' => $this->pageModel->pager,
        ];

        return view('Dashboard/pages', $data);
    }

    public function createPage()
    {
        $data = [
            'title' => 'Create Page',
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('Dashboard/page_form', $data);
    }

    public function storePage()
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'slug' => 'required|max_length[255]|is_unique[pages.slug]',
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status') ?? 'draft',
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        $this->pageModel->save($data);

        return redirect()->to('/admin/pages')
            ->with('success', 'Page created successfully');
    }

    public function editPage($id = null)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            return redirect()->to('/admin/pages')
                ->with('error', 'Page not found');
        }

        $data = [
            'title' => 'Edit Page',
            'page' => $page,
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('Dashboard/page_form', $data);
    }

    public function updatePage($id = null)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            return redirect()->to('/admin/pages')
                ->with('error', 'Page not found');
        }

        $rules = [
            'title' => 'required|max_length[255]',
            'slug' => 'required|max_length[255]|is_unique[pages.slug,id,'.$id.']',
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status') ?? 'draft',
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        $this->pageModel->update($id, $data);

        return redirect()->to('/admin/pages')
            ->with('success', 'Page updated successfully');
    }

    public function deletePage($id = null)
    {
        $this->pageModel->delete($id);
        return redirect()->to('/admin/pages')
            ->with('success', 'Page deleted successfully');
    }

    // =====================================================
    // ARTICLES
    // =====================================================
    public function articles()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $articles = $this->articleModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Articles',
            'articles' => $articles,
            'pager' => $this->articleModel->pager,
        ];

        return view('Dashboard/articles', $data);
    }

    public function createArticle()
    {
        $data = [
            'title' => 'Create Article',
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];
        return view('Dashboard/article_form', $data);
    }

    public function storeArticle()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required|min_length[3]|max_length[255]|is_unique[articles.slug]',
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

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'excerpt' => $this->request->getPost('excerpt'),
            'category_id' => $this->request->getPost('category_id'),
            'tags' => $this->request->getPost('tags'),
            'status' => $this->request->getPost('status'),
            'excerpt' => $this->request->getPost('excerpt'),
            'author' => $this->request->getPost('author'),
            'published_at' => $this->request->getPost('published_at'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];

        $this->articleModel->save($data);

        return redirect()->to('/admin/articles')
            ->with('success', 'Article created successfully');
    }

    public function editArticle($id = null)
    {
        $article = $this->articleModel->find($id);
        if (!$article) {
            return redirect()->to('/admin/articles')
                ->with('error', 'Article not found');
        }

        $data = [
            'title' => 'Edit Article',
            'article' => $article,
            'categories' => $this->categoryModel->findAll(),
            'tags' => $this->tagModel->findAll(),
        ];
        return view('Dashboard/article_form', $data);
    }

    public function updateArticle($id = null)
    {
        $article = $this->articleModel->find($id);
        if (!$article) {
            return redirect()->to('/admin/articles')
                ->with('error', 'Article not found');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'required|min_length[3]|max_length[255]|is_unique[articles.slug,id,'.$id.']',
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

        $data = [
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content' = $this->request->getPost('content'),
            'excerpt' = $this->request->getPost('excerpt'),
            'category_id' = $this->request->getPost('category_id'),
            'tags' = $this->request->getPost('tags'),
            'status' = $this->request->getPost('status'),
            'excerpt' = $this->request->getPost('excerpt'),
            'author' = $this->request->getPost('author'),
            'published_at' = $this->request->getPost('published_at'),
            'meta_title' = $this->request->getPost('meta_title'),
            'meta_description' = $this->request->getPost('meta_description'),
        ];

        $this->articleModel->update($id, $data);

        return redirect()->to('/admin/articles')
            ->with('success', 'Article updated successfully');
    }

    public function deleteArticle($id = null)
    {
        $this->articleModel->delete($id);
        return redirect()->to('/admin/articles')
            ->with('success', 'Article deleted successfully');
    }

    // =====================================================
    // CATEGORIES
    // =====================================================
    public function categories()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $categories = $this->categoryModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Categories',
            'categories' => $categories,
            'pager' => $this->categoryModel->pager,
        ];

        return view('Dashboard/categories', $data);
    }

    public function createCategory()
    {
        $data = [
            'title' => 'Create Category',
        ];
        return view('Dashboard/category_form', $data);
    }

    public function storeCategory()
    {
        $rules = [
            'name' => 'required|max_length[255]',
            'slug' => 'required|max_length[255]|is_unique[categories.slug]',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'description' = $this->request->getPost('description'),
        ];

        $this->categoryModel->save($data);

        return redirect()->to('/admin/categories')
            ->with('success', 'Category created successfully');
    }

    public function editCategory($id = null)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')
                ->with('error', 'Category not found');
        }

        $data = [
            'title' => 'Edit Category',
            'category' => $category,
        ];
        return view('Dashboard/category_form', $data);
    }

    public function updateCategory($id = null)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories')
                ->with('error', 'Category not found');
        }

        $rules = [
            'name' => 'required|max_length[255]',
            'slug' => 'required|max_length[255]|is_unique[categories.slug,id,'.$id.']',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'name' = $this->request->getPost('name'),
            'slug' = $this->request->getPost('slug'),
            'description' = $this->request->getPost('description'),
        ];

        $this->categoryModel->update($id, $data);

        return redirect()->to('/admin/categories')
            ->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id = null)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/admin/categories')
            ->with('success', 'Category deleted successfully');
    }

    // =====================================================
    // TAGS
    // =====================================================
    public function tags()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $tags = $this->tagModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Tags',
            'tags' => $tags,
            'pager' => $this->tagModel->pager,
        ];

        return view('Dashboard/tags', $data);
    }

    public function createTag()
    {
        $data = [
            'title' => 'Create Tag',
        ];
        return view('Dashboard/tag_form', $data);
    }

    public function storeTag()
    {
        $rules = [
            'name' => 'required|max_length[255]',
            'slug' = 'required|max_length[255]|is_unique[tags.slug]',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'name' = $this->request->getPost('name'),
            'slug' = $this->request->getPost('slug'),
            'description' = $this->request->getPost('description'),
        ];

        $this->tagModel->save($data);

        return redirect()->to('/admin/tags')
            ->with('success', 'Tag created successfully');
    }

    public function editTag($id = null)
    {
        $tag = $this->tagModel->find($id);
        if (!$tag) {
            return redirect()->to('/admin/tags')
                ->with('error', 'Tag not found');
        }

        $data = [
            'title' => 'Edit Tag',
            'tag' = $tag,
        ];
        return view('Dashboard/tag_form', $data);
    }

    public function updateTag($id = null)
    {
        $tag = $this->tagModel->find($id);
        if (!$tag) {
            return redirect()->to('/admin/tags')
                ->with('error', 'Tag not found');
        }

        $rules = [
            'name' = 'required|max_length[255]',
            'slug' = 'required|max_length[255]|is_unique[tags.slug,id,'.$id.']',
            'description' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'name' = $this->request->getPost('name'),
            'slug' = $this->request->getPost('slug'),
            'description' = $this->request->getPost('description'),
        ];

        $this->tagModel->update($id, $data);

        return redirect()->to('/admin/tags')
            ->with('success', 'Tag updated successfully');
    }

    public function deleteTag($id = null)
    {
        $this->tagModel->delete($id);
        return redirect()->to('/admin/tags')
            ->with('success', 'Tag deleted successfully');
    }

    // =====================================================
    // SERVICES
    // =====================================================
    public function services()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $services = $this->serviceModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Services',
            'services' = $services,
            'pager' = $this->serviceModel->pager,
        ];

        return view('Dashboard/services', $data);
    }

    // =====================================================
    // PORTFOLIO
    // =====================================================
    public function portfolio()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $portfolios = $this->portfolioModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Portfolio',
            'portfolios' = $portfolios,
            'pager' = $this->portfolioModel->pager,
        ];

        return view('Dashboard/portfolio', $data);
    }

    // =====================================================
    // BLOG
    // =====================================================
    public function blogs()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $blogs = $this->blogModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Blogs',
            'blogs' = $blogs,
            'pager' = $this->blogModel->pager,
        ];

        return view('Dashboard/blogs', $data);
    }

    // =====================================================
    // TICKETS (Support)
    // =====================================================
    public function tickets()
    {
        $perPage = 15;
        $page = $this->request->getGet('page') ?? 1;

        $tickets = $this->ticketModel->orderBy('created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        $data = [
            'title' => 'Tickets',
            'tickets' = $tickets,
            'pager' = $this->ticketModel->pager,
        ];

        return view('Dashboard/tickets', $data);
    }

    public function viewTicket($id = null)
    {
        $ticket = $this->ticketModel->find($id);
        if (!$ticket) {
            return redirect()->to('/admin/tickets')
                ->with('error', 'Ticket not found');
        }

        $data = [
            'title' => 'Ticket Details',
            'ticket' = $ticket,
        ];
        return view('Dashboard/ticket_detail', $data);
    }

    public function replyTicket($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $message = $this->request->getPost('message');
            $attachment = $this->request->getFile('attachment');

            $db = \Config\Database::connect();
            $db->table('ticket_replies')->insert([
                'ticket_id' => $id,
                'user_id' => session()->get('user_id') ?? 1,
                'message' => $message,
                'attachment' => $attachment ? $attachment->getName() : null,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->back()
                ->with('success', 'Reply added');
        }

        return redirect()->back();
    }

    public function closeTicket($id = null)
    {
        $this->ticketModel->update($id, ['status' => 'closed']);
        return redirect()->back()
            ->with('success', 'Ticket closed');
    }

    // =====================================================
    // REPORTS (keep existing)
    // =====================================================
    public function reports()
    {
        $data = [
            'title' => 'Reports',
            'stats' => [
                'total_revenue' => $this->invoiceModel->selectSum('total')->where('status', 'paid')->get()->getRow()->total ?? 0,
                'total_orders' => $this->orderModel->countAllResults(),
                'total_customers' => $this->userProfileModel->countAllResults(),
                'total_products' => $this->productModel->countAllResults(),
            ],
        ];

        return view('Dashboard/reports', $data);
    }

    // =====================================================
    // SETTINGS (keep existing)
    // =====================================================
    public function settings()
    {
        $data = [
            'title' => 'Settings',
        ];

        return view('Dashboard/settings', $data);
    }
}
}
