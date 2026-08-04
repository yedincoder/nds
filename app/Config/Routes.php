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
$routes->get('articles', '\App\Modules\CMS\Controllers\ArticleController::index');
$routes->get('article/(:any)', '\App\Modules\CMS\Controllers\ArticleController::detail/$1');
$routes->get('page/(:any)', '\App\Modules\CMS\Controllers\PageController::page/$1');

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
    $routes->get('invoice/(:any)', '\App\Modules\Payment\Controllers\PaymentController::process/$1');
    $routes->post('invoice/(:any)', '\App\Modules\Payment\Controllers\PaymentController::process/$1');
    $routes->get('(:any)', '\App\Modules\Payment\Controllers\PaymentController::process/$1');
    $routes->post('(:any)', '\App\Modules\Payment\Controllers\PaymentController::process/$1');
    $routes->get('success/(:any)', '\App\Modules\Payment\Controllers\PaymentController::success/$1');
    $routes->get('failed/(:any)', '\App\Modules\Payment\Controllers\PaymentController::failed/$1');
});

// ================================================================
// MIDTRANS PAYMENT
// ================================================================
$routes->group('midtrans', function ($routes) {
    $routes->get('initiate/(:any)', '\App\Modules\Midtrans\Controllers\MidtransController::initiate/$1', ['filter' => 'auth']);
    $routes->get('status/(:any)', '\App\Modules\Midtrans\Controllers\MidtransController::status/$1', ['filter' => 'auth']);
    $routes->get('success', '\App\Modules\Midtrans\Controllers\MidtransController::success', ['filter' => 'auth']);
    $routes->get('pending', '\App\Modules\Midtrans\Controllers\MidtransController::pending', ['filter' => 'auth']);
    $routes->get('error', '\App\Modules\Midtrans\Controllers\MidtransController::error', ['filter' => 'auth']);
    $routes->post('notification', '\App\Modules\Midtrans\Controllers\MidtransController::notification');
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
    $routes->get('portfolio', '\App\Modules\Dashboard\Controllers\AdminDashboardController::portfolio');
    $routes->get('services', '\App\Modules\Dashboard\Controllers\AdminDashboardController::services');
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
    
    // Testimonials
    $routes->get('testimonials', '\App\Modules\Testimonial\Controllers\Admin\TestimonialController::index');
    $routes->get('testimonials/create', '\App\Modules\Testimonial\Controllers\Admin\TestimonialController::create');
    $routes->post('testimonials/create', '\App\Modules\Testimonial\Controllers\Admin\TestimonialController::store');
    $routes->get('testimonials/edit/(:num)', '\App\Modules\Testimonial\Controllers\Admin\TestimonialController::edit/$1');
    $routes->post('testimonials/update/(:num)', '\App\Modules\Testimonial\Controllers\Admin\TestimonialController::update/$1');
    $routes->get('testimonials/status/(:num)', '\App\Modules\Testimonial\Controllers\Admin\TestimonialController::toggleStatus/$1');
    $routes->get('testimonials/delete/(:num)', '\App\Modules\Testimonial\Controllers\Admin\TestimonialController::delete/$1');
    
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

// Load rute modular dari app/Modules/Routes.php
$modularRoutes = APPPATH . 'Modules/Routes.php';
if (file_exists($modularRoutes)) {
    require $modularRoutes;
}