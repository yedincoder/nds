<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ================================================================
// LANDING PAGE
// ================================================================
$routes->get('/', 'HomeController::index');
$routes->get('/about', 'HomeController::about');
$routes->get('/services', 'HomeController::services');
$routes->get('/products', 'HomeController::products');
$routes->get('/portfolio', 'HomeController::portfolio');
$routes->get('/blog', 'HomeController::blog');
$routes->get('/contact', 'HomeController::contact');

// ================================================================
// AUTHENTICATION
// ================================================================
$routes->group('auth', function ($routes) {
    $routes->get('login', '\App\Modules\Authentication\Controllers\AuthController::showLogin');
    $routes->post('login', '\App\Modules\Authentication\Controllers\AuthController::login');
    $routes->get('register', '\App\Modules\Authentication\Controllers\AuthController::showRegister');
    $routes->post('register', '\App\Modules\Authentication\Controllers\AuthController::register');
    $routes->get('logout', '\App\Modules\Authentication\Controllers\AuthController::logout');
});

// ================================================================
// CMS / BLOG / PORTFOLIO
// ================================================================
$routes->get('blog', '\App\Modules\Blog\Controllers\BlogController::index');
$routes->get('blog/search', '\App\Modules\Blog\Controllers\BlogController::search');
$routes->get('blog/(:any)', '\App\Modules\Blog\Controllers\BlogController::detail/$1');
$routes->get('articles', '\App\Modules\CMS\Controllers\ArticleController::index');
$routes->get('article/(:any)', '\App\Modules\CMS\Controllers\ArticleController::detail/$1');
$routes->get('page/(:any)', '\App\Modules\CMS\Controllers\PageController::page/$1');
$routes->get('portfolio', '\App\Modules\Portfolio\Controllers\PortfolioController::index');
$routes->get('portfolio/(:any)', '\App\Modules\Portfolio\Controllers\PortfolioController::detail/$1');

// ================================================================
// PRODUCTS & SERVICES
// ================================================================
$routes->get('products', '\App\Modules\Product\Controllers\ProductController::index');
$routes->get('products/(:any)', '\App\Modules\Product\Controllers\ProductController::detail/$1');
$routes->get('product/category/(:any)', '\App\Modules\Product\Controllers\ProductController::category/$1');
$routes->get('services', '\App\Modules\Service\Controllers\ServiceController::index');
$routes->get('services/(:any)', '\App\Modules\Service\Controllers\ServiceController::detail/$1');
$routes->post('services/(:any)/quote', '\App\Modules\Service\Controllers\ServiceController::requestQuote/$1');

// ================================================================
// ECOMMERCE
// ================================================================
$routes->get('cart', '\App\Modules\Cart\Controllers\CartController::index');
$routes->post('cart/add', '\App\Modules\Cart\Controllers\CartController::add');
$routes->post('cart/update', '\App\Modules\Cart\Controllers\CartController::update');
$routes->get('cart/remove/(:num)', '\App\Modules\Cart\Controllers\CartController::remove/$1');
$routes->get('cart/clear', '\App\Modules\Cart\Controllers\CartController::clear');
$routes->get('checkout', '\App\Modules\Checkout\Controllers\CheckoutController::index');
$routes->post('checkout/process', '\App\Modules\Checkout\Controllers\CheckoutController::process');
$routes->get('checkout/success/(:any)', '\App\Modules\Checkout\Controllers\CheckoutController::success/$1');

// ================================================================
// BILLING & INVOICE
// ================================================================
$routes->group('billing', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', '\App\Modules\Billing\Controllers\BillingController::index');
    $routes->get('(:any)', '\App\Modules\Billing\Controllers\BillingController::detail/$1');
});
$routes->group('invoice', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', '\App\Modules\Invoice\Controllers\InvoiceController::index');
    $routes->get('(:any)', '\App\Modules\Invoice\Controllers\InvoiceController::detail/$1');
    $routes->get('download/(:any)', '\App\Modules\Invoice\Controllers\InvoiceController::download/$1');
    $routes->get('print/(:any)', '\App\Modules\Invoice\Controllers\InvoiceController::print/$1');
});

// ================================================================
// PAYMENT
// ================================================================
$routes->group('payment', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', '\App\Modules\Payment\Controllers\PaymentController::index');
    $routes->get('(:any)', '\App\Modules\Payment\Controllers\PaymentController::process/$1');
    $routes->get('success/(:any)', '\App\Modules\Payment\Controllers\PaymentController::success/$1');
    $routes->get('failed/(:any)', '\App\Modules\Payment\Controllers\PaymentController::failed/$1');
});

// ================================================================
// SUPPORT / TICKET
// ================================================================
$routes->group('support', ['filter' => 'auth'], function ($routes) {
    $routes->get('tickets', '\App\Modules\Support\Controllers\TicketController::index');
    $routes->get('ticket/create', '\App\Modules\Support\Controllers\TicketController::create');
    $routes->post('ticket/create', '\App\Modules\Support\Controllers\TicketController::create');
    $routes->get('ticket/(:any)', '\App\Modules\Support\Controllers\TicketController::detail/$1');
    $routes->post('ticket/(:any)', '\App\Modules\Support\Controllers\TicketController::detail/$1');
    $routes->get('ticket/close/(:any)', '\App\Modules\Support\Controllers\TicketController::close/$1');
});

// ================================================================
// CLIENT AREA
// ================================================================
$routes->group('client', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', '\App\Modules\ClientArea\Controllers\DashboardController::index');
    $routes->get('orders', '\App\Modules\ClientArea\Controllers\DashboardController::orders');
    $routes->get('invoices', '\App\Modules\ClientArea\Controllers\DashboardController::invoices');
    $routes->get('downloads', '\App\Modules\ClientArea\Controllers\DashboardController::downloads');
    $routes->get('download/(:any)', '\App\Modules\ClientArea\Controllers\DownloadController::download/$1');
    $routes->get('tickets', '\App\Modules\ClientArea\Controllers\DashboardController::tickets');
    $routes->get('profile', '\App\Modules\ClientArea\Controllers\ProfileController::index');
    $routes->post('profile/update', '\App\Modules\ClientArea\Controllers\ProfileController::update');
    $routes->post('profile/change-password', '\App\Modules\ClientArea\Controllers\ProfileController::changePassword');
    $routes->get('addresses', '\App\Modules\ClientArea\Controllers\ProfileController::addresses');
    $routes->post('address/add', '\App\Modules\ClientArea\Controllers\ProfileController::addAddress');
    $routes->get('address/delete/(:any)', '\App\Modules\ClientArea\Controllers\ProfileController::deleteAddress/$1');
});

// ================================================================
// ADMIN PANEL
// ================================================================
$routes->group('admin', ['filter' => 'permission:users.read'], function ($routes) {
    $routes->get('dashboard', '\App\Modules\Dashboard\Controllers\AdminDashboardController::index');
    $routes->get('customers', '\App\Modules\Dashboard\Controllers\AdminDashboardController::customers');
    $routes->get('products', '\App\Modules\Dashboard\Controllers\AdminDashboardController::products');
    $routes->get('orders', '\App\Modules\Dashboard\Controllers\AdminDashboardController::orders');
    $routes->get('invoices', '\App\Modules\Dashboard\Controllers\AdminDashboardController::invoices');
    $routes->get('reports', '\App\Modules\Dashboard\Controllers\AdminDashboardController::reports');
    $routes->get('settings', '\App\Modules\Dashboard\Controllers\AdminDashboardController::settings');
    $routes->get('payments', '\App\Modules\Dashboard\Controllers\AdminDashboardController::payments');
    $routes->get('media', '\App\Modules\MediaManager\Controllers\MediaController::index');
    $routes->get('support', '\App\Modules\Support\Controllers\TicketController::index');
    $routes->get('support/create', '\App\Modules\Support\Controllers\TicketController::create');
    $routes->post('support/create', '\App\Modules\Support\Controllers\TicketController::create');
    $routes->get('support/ticket/(:num)', '\App\Modules\Support\Controllers\TicketController::detail/$1');
    $routes->post('support/ticket/(:num)', '\App\Modules\Support\Controllers\TicketController::detail/$1');
    $routes->get('support/ticket/(:num)/close', '\App\Modules\Support\Controllers\TicketController::close/$1');
    $routes->get('billing', '\App\Modules\Billing\Controllers\BillingController::index');
    $routes->get('auth', '\App\Modules\Authentication\Controllers\AuthController::index');
    
    // CMS Management
    $routes->group('cms', function ($routes) {
        $routes->get('dashboard', '\App\Modules\CMS\Controllers\Admin\DashboardController::index');
        $routes->get('pages', '\App\Modules\CMS\Controllers\Admin\DashboardController::pages');
        $routes->get('pages/create', '\App\Modules\CMS\Controllers\Admin\DashboardController::createPage');
        $routes->post('pages/create', '\App\Modules\CMS\Controllers\Admin\DashboardController::storePage');
        $routes->get('pages/(:num)/edit', '\App\Modules\CMS\Controllers\Admin\DashboardController::editPage/$1');
        $routes->post('pages/(:num)/update', '\App\Modules\CMS\Controllers\Admin\DashboardController::updatePage/$1');
        $routes->get('pages/(:num)/delete', '\App\Modules\CMS\Controllers\Admin\DashboardController::deletePage/$1');
        
        $routes->get('articles', '\App\Modules\CMS\Controllers\Admin\DashboardController::articles');
        $routes->get('articles/create', '\App\Modules\CMS\Controllers\Admin\DashboardController::createArticle');
        $routes->post('articles/create', '\App\Modules\CMS\Controllers\Admin\DashboardController::storeArticle');
        $routes->get('articles/(:num)/edit', '\App\Modules\CMS\Controllers\Admin\DashboardController::editArticle/$1');
        $routes->post('articles/(:num)/update', '\App\Modules\CMS\Controllers\Admin\DashboardController::updateArticle/$1');
        $routes->get('articles/(:num)/delete', '\App\Modules\CMS\Controllers\Admin\DashboardController::deleteArticle/$1');
        
        $routes->get('categories', '\App\Modules\CMS\Controllers\Admin\DashboardController::categories');
        $routes->post('categories/create', '\App\Modules\CMS\Controllers\Admin\DashboardController::storeCategory');
        $routes->get('categories/(:num)/delete', '\App\Modules\CMS\Controllers\Admin\DashboardController::deleteCategory/$1');
        
        $routes->get('tags', '\App\Modules\CMS\Controllers\Admin\DashboardController::tags');
        $routes->post('tags/create', '\App\Modules\CMS\Controllers\Admin\DashboardController::storeTag');
        $routes->get('tags/(:num)/delete', '\App\Modules\CMS\Controllers\Admin\DashboardController::deleteTag/$1');
    });
    $routes->post('cms/upload-image', '\App\Modules\CMS\Controllers\Admin\DashboardController::uploadImage');
});

// ================================================================
// ADMIN PANEL MANAGEMENT
// ================================================================
$routes->group('adminpanel', ['filter' => 'auth'], function ($routes) {
    $routes->get('', '\App\Modules\Dashboard\Controllers\AdminPanel::index');
    
    // Products
    $routes->get('products', '\App\Modules\Dashboard\Controllers\AdminPanel::products');
    $routes->get('products/create', '\App\Modules\Dashboard\Controllers\AdminPanel::createProduct');
    $routes->post('products/create', '\App\Modules\Dashboard\Controllers\AdminPanel::storeProduct');
    $routes->get('products/edit/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::editProduct/$1');
    $routes->post('products/update/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::updateProduct/$1');
    $routes->get('products/delete/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::deleteProduct/$1');
    
    // Orders
    $routes->get('orders', '\App\Modules\Dashboard\Controllers\AdminPanel::orders');
    $routes->get('orders/view/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::viewOrder/$1');
    $routes->post('orders/status/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::updateOrderStatus/$1');
    
    // Invoices
    $routes->get('invoices', '\App\Modules\Dashboard\Controllers\AdminPanel::invoices');
    
    // Customers
    $routes->get('customers', '\App\Modules\Dashboard\Controllers\AdminPanel::customers');
    
    // Payments
    $routes->get('payments', '\App\Modules\Dashboard\Controllers\AdminPanel::payments');
    
    // CMS Pages
    $routes->get('pages', '\App\Modules\Dashboard\Controllers\AdminPanel::pages');
    $routes->get('pages/create', '\App\Modules\Dashboard\Controllers\AdminPanel::createPage');
    $routes->post('pages/create', '\App\Modules\Dashboard\Controllers\AdminPanel::storePage');
    $routes->get('pages/edit/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::editPage/$1');
    $routes->post('pages/update/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::updatePage/$1');
    $routes->get('pages/delete/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::deletePage/$1');
    
    // Articles
    $routes->get('articles', '\App\Modules\Dashboard\Controllers\AdminPanel::articles');
    $routes->get('articles/create', '\App\Modules\Dashboard\Controllers\AdminPanel::createArticle');
    $routes->post('articles/create', '\App\Modules\Dashboard\Controllers\AdminPanel::storeArticle');
    $routes->get('articles/edit/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::editArticle/$1');
    $routes->post('articles/update/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::updateArticle/$1');
    $routes->get('articles/delete/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::deleteArticle/$1');
    
    // Categories
    $routes->get('categories', '\App\Modules\Dashboard\Controllers\AdminPanel::categories');
    $routes->post('categories/create', '\App\Modules\Dashboard\Controllers\AdminPanel::storeCategory');
    $routes->get('categories/delete/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::deleteCategory/$1');
    
    // Tags
    $routes->get('tags', '\App\Modules\Dashboard\Controllers\AdminPanel::tags');
    $routes->post('tags/create', '\App\Modules\Dashboard\Controllers\AdminPanel::storeTag');
    $routes->get('tags/delete/(:num)', '\App\Modules\Dashboard\Controllers\AdminPanel::deleteTag/$1');
    
    // Services
    $routes->get('services', '\App\Modules\Dashboard\Controllers\AdminPanel::services');
    
    // Portfolio  
    $routes->get('portfolio', '\App\Modules\Dashboard\Controllers\AdminPanel::portfolio');
    
    // Blog
    $routes->get('blogs', '\App\Modules\Dashboard\Controllers\AdminPanel::blogs');
    
    // Tickets
    $routes->get('tickets', '\App\Modules\Dashboard\Controllers\AdminPanel::tickets');
});

// ================================================================
// API V1
// ================================================================
$routes->group('api/v1', function ($routes) {
    $routes->post('auth/login', '\App\Controllers\Api\AuthApiController::login');
    $routes->post('auth/register', '\App\Controllers\Api\AuthApiController::register');

    $routes->group('', ['filter' => 'auth_api'], function ($routes) {
        $routes->get('products', '\App\Controllers\Api\ProductApiController::index');
        $routes->get('products/(:num)', '\App\Controllers\Api\ProductApiController::show/$1');
        $routes->get('services', '\App\Controllers\Api\ServiceApiController::index');
        $routes->post('cart/add', '\App\Controllers\Api\CartApiController::add');
        $routes->get('cart', '\App\Controllers\Api\CartApiController::index');
        $routes->get('orders', '\App\Controllers\Api\OrderApiController::index');
        $routes->get('orders/(:num)', '\App\Controllers\Api\OrderApiController::show/$1');
        $routes->get('profile', '\App\Controllers\Api\AuthApiController::profile');
        $routes->get('tickets', '\App\Controllers\Api\SupportApiController::index');
        $routes->post('tickets', '\App\Controllers\Api\SupportApiController::create');
        $routes->get('notifications', '\App\Controllers\Api\NotificationApiController::index');
    });
});
