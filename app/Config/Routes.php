<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ================================================================
// LANDING PAGE
// ================================================================
$routes->get('/', 'HomeController::index');
$routes->get('/about', '\App\Modules\FrontArea\Controllers\PageController::about');
$routes->get('/services', 'HomeController::services');
$routes->get('/products', '\App\Modules\FrontArea\Controllers\ProductsController::index');
$routes->get('/portfolio', 'HomeController::portfolio');
$routes->get('/blog', 'HomeController::blog');
$routes->get('/contact', 'HomeController::contact');
$routes->post('/contact', 'HomeController::contactStore');

// ================================================================
// AUTHENTICATION
// ================================================================
$routes->group('auth', function ($routes) {
    $routes->get('login', '\App\Modules\Auth\Controllers\AuthController::showLogin');
    $routes->post('login', '\App\Modules\Auth\Controllers\AuthController::login');
    $routes->get('register', '\App\Modules\Auth\Controllers\AuthController::showRegister');
    $routes->post('register', '\App\Modules\Auth\Controllers\AuthController::register');
    $routes->get('logout', '\App\Modules\Auth\Controllers\AuthController::logout');
});

// ================================================================
// CMS / BLOG / PORTFOLIO
// ================================================================
$routes->get('article/category/(:any)', '\App\Modules\FrontArea\Controllers\ArticleController::category/$1');
$routes->get('article/tag/(:any)', '\App\Modules\FrontArea\Controllers\ArticleController::tag/$1');
$routes->get('articles', '\App\Modules\FrontArea\Controllers\ArticleController::index');
$routes->get('article/(:any)', '\App\Modules\FrontArea\Controllers\ArticleController::detail/$1');
$routes->get('portfolio/(:any)', 'HomeController::portfolioDetail/$1');
$routes->get('portfolio', 'HomeController::portfolio');
$routes->get('page/(:any)', '\App\Modules\FrontArea\Controllers\PageController::page/$1');

// ================================================================
// ECOMMERCE
// ================================================================
$routes->get('cart', '\App\Modules\FrontArea\Controllers\CartController::index');
$routes->post('cart/add', '\App\Modules\FrontArea\Controllers\CartController::add');
$routes->post('cart/update', '\App\Modules\FrontArea\Controllers\CartController::update');
$routes->get('cart/remove/(:num)', '\App\Modules\FrontArea\Controllers\CartController::remove/$1');
$routes->get('cart/clear', '\App\Modules\FrontArea\Controllers\CartController::clear');
$routes->get('checkout', '\App\Modules\FrontArea\Controllers\CheckoutController::index');
$routes->post('checkout/process', '\App\Modules\FrontArea\Controllers\CheckoutController::process');
$routes->get('checkout/success/(:any)', '\App\Modules\FrontArea\Controllers\CheckoutController::success/$1');

// ================================================================
// BILLING & INVOICE
// ================================================================
$routes->group('billing', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', '\App\Modules\FrontArea\Controllers\BillingController::index');
    $routes->get('(:any)', '\App\Modules\FrontArea\Controllers\BillingController::detail/$1');
});
$routes->group('invoice', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', '\App\Modules\FrontArea\Controllers\InvoiceController::index');
    $routes->get('download/(:any)', '\App\Modules\FrontArea\Controllers\InvoiceController::download/$1');
    $routes->get('print/(:any)', '\App\Modules\FrontArea\Controllers\InvoiceController::print/$1');
    $routes->get('(:any)', '\App\Modules\FrontArea\Controllers\InvoiceController::detail/$1');
});

// ================================================================
// PAYMENT
// ================================================================
$routes->group('payment', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', '\App\Modules\FrontArea\Controllers\PaymentController::index');
    $routes->get('invoice/(:any)', '\App\Modules\FrontArea\Controllers\PaymentController::process/$1');
    $routes->post('invoice/(:any)', '\App\Modules\FrontArea\Controllers\PaymentController::process/$1');
    $routes->get('(:any)', '\App\Modules\FrontArea\Controllers\PaymentController::process/$1');
    $routes->post('(:any)', '\App\Modules\FrontArea\Controllers\PaymentController::process/$1');
    $routes->get('success/(:any)', '\App\Modules\FrontArea\Controllers\PaymentController::success/$1');
    $routes->get('failed/(:any)', '\App\Modules\FrontArea\Controllers\PaymentController::failed/$1');
});

// ================================================================
// MIDTRANS PAYMENT
// ================================================================
$routes->group('midtrans', function ($routes) {
    $routes->get('initiate/(:any)', '\App\Modules\FrontArea\Controllers\MidtransController::initiate/$1', ['filter' => 'auth']);
    $routes->get('status/(:any)', '\App\Modules\FrontArea\Controllers\MidtransController::status/$1', ['filter' => 'auth']);
    $routes->get('success', '\App\Modules\FrontArea\Controllers\MidtransController::success', ['filter' => 'auth']);
    $routes->get('pending', '\App\Modules\FrontArea\Controllers\MidtransController::pending', ['filter' => 'auth']);
    $routes->get('error', '\App\Modules\FrontArea\Controllers\MidtransController::error', ['filter' => 'auth']);
    $routes->post('notification', '\App\Modules\FrontArea\Controllers\MidtransController::notification');
});

// ================================================================
// CLIENT AREA SUPPORT
// ================================================================
$routes->group('client/support', ['filter' => 'auth'], function ($routes) {
    $routes->get('tickets', '\App\Modules\ClientArea\Controllers\SupportController::index');
    $routes->get('ticket/create', '\App\Modules\ClientArea\Controllers\SupportController::create');
    $routes->post('ticket/create', '\App\Modules\ClientArea\Controllers\SupportController::store');
    $routes->get('ticket/(:any)/close', '\App\Modules\ClientArea\Controllers\SupportController::close/$1');
    $routes->get('ticket/(:any)', '\App\Modules\ClientArea\Controllers\SupportController::detail/$1');
    $routes->post('ticket/(:any)', '\App\Modules\ClientArea\Controllers\SupportController::reply/$1');
});

// ================================================================
// ADMIN SUPPORT
// ================================================================
$routes->group('support', ['filter' => 'auth'], function ($routes) {
    $routes->get('tickets', '\App\Modules\AdminArea\Controllers\TicketController::index');
    $routes->get('ticket/create', '\App\Modules\AdminArea\Controllers\TicketController::create');
    $routes->post('ticket/create', '\App\Modules\AdminArea\Controllers\TicketController::create');
    $routes->get('ticket/(:any)', '\App\Modules\AdminArea\Controllers\TicketController::detail/$1');
    $routes->post('ticket/(:any)', '\App\Modules\AdminArea\Controllers\TicketController::detail/$1');
    $routes->get('ticket/close/(:any)', '\App\Modules\AdminArea\Controllers\TicketController::close/$1');
});

// ================================================================
// CLIENT AREA
// ================================================================
$routes->group('client', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', '\App\Modules\ClientArea\Controllers\DashboardController::index');
    $routes->get('orders', '\App\Modules\ClientArea\Controllers\DashboardController::orders');
    $routes->get('orders/(:any)', '\App\Modules\ClientArea\Controllers\OrderController::detail/$1');
    $routes->get('invoices', '\App\Modules\ClientArea\Controllers\DashboardController::invoices');
    $routes->get('downloads', '\App\Modules\ClientArea\Controllers\DashboardController::downloads');
    $routes->get('download/(:any)', '\App\Modules\ClientArea\Controllers\DownloadController::download/$1');
    $routes->get('tickets', '\App\Modules\ClientArea\Controllers\SupportController::index');
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
    $routes->get('dashboard', '\App\Modules\AdminArea\Controllers\AdminDashboardController::index');
    $routes->get('customers', '\App\Modules\AdminArea\Controllers\AdminDashboardController::customers');
    $routes->get('orders', '\App\Modules\AdminArea\Controllers\AdminDashboardController::orders');
    $routes->get('invoices', '\App\Modules\AdminArea\Controllers\AdminDashboardController::invoices');
    $routes->get('reports', '\App\Modules\AdminArea\Controllers\AdminDashboardController::reports');
    $routes->get('settings', '\App\Modules\AdminArea\Controllers\AdminDashboardController::settings');
    $routes->post('settings/update', '\App\Modules\AdminArea\Controllers\AdminDashboardController::updateSettings');
    $routes->post('settings/factory-reset', '\App\Modules\AdminArea\Controllers\AdminDashboardController::factoryReset');
    $routes->get('payments', '\App\Modules\AdminArea\Controllers\AdminDashboardController::payments');
    $routes->get('media', '\App\Modules\AdminArea\Controllers\MediaController::index');
    $routes->post('media/upload', '\App\Modules\AdminArea\Controllers\MediaController::upload');
    $routes->get('media/delete/(:num)', '\App\Modules\AdminArea\Controllers\MediaController::delete/$1');
    $routes->get('support', '\App\Modules\AdminArea\Controllers\TicketController::index');
    $routes->get('support/create', '\App\Modules\AdminArea\Controllers\TicketController::create');
    $routes->post('support/create', '\App\Modules\AdminArea\Controllers\TicketController::create');
    $routes->get('support/ticket/(:num)', '\App\Modules\AdminArea\Controllers\TicketController::detail/$1');
    $routes->post('support/ticket/(:num)', '\App\Modules\AdminArea\Controllers\TicketController::detail/$1');
    $routes->get('support/ticket/(:num)/close', '\App\Modules\AdminArea\Controllers\TicketController::close/$1');
    $routes->get('billing', '\App\Modules\AdminArea\Controllers\BillingController::index');
    $routes->get('billing/(:any)', '\App\Modules\AdminArea\Controllers\BillingController::detail/$1');
    $routes->get('auth', '\App\Modules\AdminArea\Controllers\UsersController::index');
    $routes->get('auth/create', '\App\Modules\AdminArea\Controllers\UsersController::create');
    $routes->post('auth/create', '\App\Modules\AdminArea\Controllers\UsersController::store');
    $routes->get('auth/edit/(:num)', '\App\Modules\AdminArea\Controllers\UsersController::edit/$1');
    $routes->post('auth/update/(:num)', '\App\Modules\AdminArea\Controllers\UsersController::update/$1');
    $routes->get('auth/status/(:num)', '\App\Modules\AdminArea\Controllers\UsersController::toggleStatus/$1');
    $routes->get('auth/delete/(:num)', '\App\Modules\AdminArea\Controllers\UsersController::delete/$1');
    
    // Products CRUD
    $routes->group('products', function ($routes) {
        $routes->get('/', '\App\Modules\AdminArea\Controllers\ProductController::index');
        $routes->get('create', '\App\Modules\AdminArea\Controllers\ProductController::create');
        $routes->post('create', '\App\Modules\AdminArea\Controllers\ProductController::store');
        $routes->get('edit/(:num)', '\App\Modules\AdminArea\Controllers\ProductController::edit/$1');
        $routes->post('update/(:num)', '\App\Modules\AdminArea\Controllers\ProductController::update/$1');
        $routes->get('delete/(:num)', '\App\Modules\AdminArea\Controllers\ProductController::delete/$1');
        $routes->get('file/delete/(:num)', '\App\Modules\AdminArea\Controllers\ProductController::deleteFile/$1');
        $routes->post('license/create/(:num)', '\App\Modules\AdminArea\Controllers\ProductController::createLicense/$1');
        $routes->get('license/delete/(:num)', '\App\Modules\AdminArea\Controllers\ProductController::deleteLicense/$1');
    });

    // Portfolio CRUD
    $routes->group('portfolio', function ($routes) {
        $routes->get('/', '\App\Modules\AdminArea\Controllers\PortfolioController::index');
        $routes->get('create', '\App\Modules\AdminArea\Controllers\PortfolioController::create');
        $routes->post('create', '\App\Modules\AdminArea\Controllers\PortfolioController::store');
        $routes->get('edit/(:num)', '\App\Modules\AdminArea\Controllers\PortfolioController::edit/$1');
        $routes->post('update/(:num)', '\App\Modules\AdminArea\Controllers\PortfolioController::update/$1');
        $routes->get('delete/(:num)', '\App\Modules\AdminArea\Controllers\PortfolioController::delete/$1');
    });

    // Services CRUD
    $routes->group('services', function ($routes) {
        $routes->get('/', '\App\Modules\AdminArea\Controllers\ServiceController::index');
        $routes->get('create', '\App\Modules\AdminArea\Controllers\ServiceController::create');
        $routes->post('create', '\App\Modules\AdminArea\Controllers\ServiceController::store');
        $routes->get('edit/(:num)', '\App\Modules\AdminArea\Controllers\ServiceController::edit/$1');
        $routes->post('update/(:num)', '\App\Modules\AdminArea\Controllers\ServiceController::update/$1');
        $routes->get('delete/(:num)', '\App\Modules\AdminArea\Controllers\ServiceController::delete/$1');
        $routes->get('(:num)/package/create', '\App\Modules\AdminArea\Controllers\ServiceController::packageCreate/$1');
        $routes->post('(:num)/package/create', '\App\Modules\AdminArea\Controllers\ServiceController::packageStore/$1');
        $routes->get('(:num)/package/edit/(:num)', '\App\Modules\AdminArea\Controllers\ServiceController::packageEdit/$1/$2');
        $routes->post('(:num)/package/update/(:num)', '\App\Modules\AdminArea\Controllers\ServiceController::packageUpdate/$1/$2');
        $routes->get('(:num)/package/delete/(:num)', '\App\Modules\AdminArea\Controllers\ServiceController::packageDelete/$1/$2');
    });
    
    // Testimonials
    $routes->get('testimonials', '\App\Modules\AdminArea\Controllers\TestimonialController::index');
    $routes->get('testimonials/create', '\App\Modules\AdminArea\Controllers\TestimonialController::create');
    $routes->post('testimonials/create', '\App\Modules\AdminArea\Controllers\TestimonialController::store');
    $routes->get('testimonials/edit/(:num)', '\App\Modules\AdminArea\Controllers\TestimonialController::edit/$1');
    $routes->post('testimonials/update/(:num)', '\App\Modules\AdminArea\Controllers\TestimonialController::update/$1');
    $routes->get('testimonials/status/(:num)', '\App\Modules\AdminArea\Controllers\TestimonialController::toggleStatus/$1');
    $routes->get('testimonials/delete/(:num)', '\App\Modules\AdminArea\Controllers\TestimonialController::delete/$1');
    
    // CMS Management
    $routes->group('cms', function ($routes) {
        $routes->get('dashboard', '\App\Modules\AdminArea\Controllers\CMSDashboardController::index');
        $routes->get('pages', '\App\Modules\AdminArea\Controllers\CMSDashboardController::pages');
        $routes->get('pages/create', '\App\Modules\AdminArea\Controllers\CMSDashboardController::createPage');
        $routes->post('pages/create', '\App\Modules\AdminArea\Controllers\CMSDashboardController::storePage');
        $routes->get('pages/(:num)/edit', '\App\Modules\AdminArea\Controllers\CMSDashboardController::editPage/$1');
        $routes->post('pages/(:num)/update', '\App\Modules\AdminArea\Controllers\CMSDashboardController::updatePage/$1');
        $routes->get('pages/(:num)/delete', '\App\Modules\AdminArea\Controllers\CMSDashboardController::deletePage/$1');
        
        $routes->get('articles', '\App\Modules\AdminArea\Controllers\CMSDashboardController::articles');
        $routes->get('articles/create', '\App\Modules\AdminArea\Controllers\CMSDashboardController::createArticle');
        $routes->post('articles/create', '\App\Modules\AdminArea\Controllers\CMSDashboardController::storeArticle');
        $routes->get('articles/(:num)/edit', '\App\Modules\AdminArea\Controllers\CMSDashboardController::editArticle/$1');
        $routes->post('articles/(:num)/update', '\App\Modules\AdminArea\Controllers\CMSDashboardController::updateArticle/$1');
        $routes->get('articles/(:num)/delete', '\App\Modules\AdminArea\Controllers\CMSDashboardController::deleteArticle/$1');
        
        $routes->get('categories', '\App\Modules\AdminArea\Controllers\CMSDashboardController::categories');
        $routes->post('categories/create', '\App\Modules\AdminArea\Controllers\CMSDashboardController::createCategory');
        $routes->get('categories/edit/(:num)', '\App\Modules\AdminArea\Controllers\CMSDashboardController::editCategory/$1');
        $routes->post('categories/update/(:num)', '\App\Modules\AdminArea\Controllers\CMSDashboardController::updateCategory/$1');
        $routes->get('categories/(:num)/delete', '\App\Modules\AdminArea\Controllers\CMSDashboardController::deleteCategory/$1');
        
        $routes->get('tags', '\App\Modules\AdminArea\Controllers\CMSDashboardController::tags');
        $routes->post('tags/create', '\App\Modules\AdminArea\Controllers\CMSDashboardController::createTag');
        $routes->get('tags/edit/(:num)', '\App\Modules\AdminArea\Controllers\CMSDashboardController::editTag/$1');
        $routes->post('tags/update/(:num)', '\App\Modules\AdminArea\Controllers\CMSDashboardController::updateTag/$1');
        $routes->get('tags/(:num)/delete', '\App\Modules\AdminArea\Controllers\CMSDashboardController::deleteTag/$1');
    });
    $routes->post('cms/upload-image', '\App\Modules\AdminArea\Controllers\CMSDashboardController::uploadImage');
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


// ================================================================
// PRODUCT (FrontArea)
// ================================================================
$routes->get('products', '\App\Modules\FrontArea\Controllers\ProductsController::index');
$routes->get('product/category/(:any)', '\App\Modules\FrontArea\Controllers\ProductsController::category/$1');
$routes->get('product/search', '\App\Modules\FrontArea\Controllers\ProductsController::search');
$routes->get('product/(:any)', '\App\Modules\FrontArea\Controllers\ProductsController::detail/$1');

// ================================================================
// SERVICE (FrontArea)
// ================================================================
$routes->group('service', function ($routes) {
    $routes->get('(:any)', '\App\Modules\FrontArea\Controllers\ServiceController::detail/$1');
    $routes->post('(:any)/quote', '\App\Modules\FrontArea\Controllers\ServiceController::requestQuote/$1');
});

// ================================================================
// BLOG (FrontArea)
// ================================================================
$routes->group('blog', function ($routes) {
    $routes->get('search', '\App\Modules\FrontArea\Controllers\BlogController::search');
    $routes->get('(:any)', '\App\Modules\FrontArea\Controllers\BlogController::detail/$1');
});

// ================================================================
// PORTFOLIO (FrontArea)
// ================================================================
$routes->group('portfolio', function ($routes) {
    $routes->get('category/(:any)', '\App\Modules\FrontArea\Controllers\PortfolioController::category/$1');
    $routes->get('(:any)', '\App\Modules\FrontArea\Controllers\PortfolioController::detail/$1');
});

// ================================================================
// Load rute modular dari app/Modules/Routes.php
// ================================================================
$modularRoutes = APPPATH . 'Modules/Routes.php';
if (file_exists($modularRoutes)) {
    require $modularRoutes;
}