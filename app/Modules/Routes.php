<?php

use CodeIgniter\Router\RouteCollection;

$routes = service('routes');

$routes->group('product', ['namespace' => 'App\Modules\Product\Controllers'], function ($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->get('(:any)', 'ProductController::detail/$1');
    $routes->get('category/(:any)', 'ProductController::category/$1');
    $routes->get('search', 'ProductController::search');
});

$routes->group('service', function ($routes) {
    $routes->get('/', 'Service\Controllers\ServiceController::index');
    $routes->get('(:any)', 'Service\Controllers\ServiceController::detail/$1');
    $routes->post('(:any)/quote', 'Service\Controllers\ServiceController::requestQuote/$1');
});

$routes->group('cart', function ($routes) {
    $routes->get('/', 'Cart\Controllers\CartController::index');
    $routes->post('add', 'Cart\Controllers\CartController::add');
    $routes->post('update', 'Cart\Controllers\CartController::update');
    $routes->get('remove/(:num)', 'Cart\Controllers\CartController::remove/$1');
    $routes->get('clear', 'Cart\Controllers\CartController::clear');
});

$routes->group('checkout', function ($routes) {
    $routes->get('/', 'Checkout\Controllers\CheckoutController::index');
    $routes->post('process', 'Checkout\Controllers\CheckoutController::process');
    $routes->get('success/(:any)', 'Checkout\Controllers\CheckoutController::success/$1');
});

$routes->group('payment', function ($routes) {
    $routes->get('/', 'Payment\Controllers\PaymentController::index');
    $routes->get('(:any)', 'Payment\Controllers\PaymentController::process/$1');
    $routes->get('success/(:any)', 'Payment\Controllers\PaymentController::success/$1');
    $routes->get('failed/(:any)', 'Payment\Controllers\PaymentController::failed/$1');
});

$routes->group('invoice', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Invoice\Controllers\InvoiceController::index');
    $routes->get('(:any)', 'Invoice\Controllers\InvoiceController::detail/$1');
    $routes->get('download/(:any)', 'Invoice\Controllers\InvoiceController::download/$1');
    $routes->get('print/(:any)', 'Invoice\Controllers\InvoiceController::print/$1');
});

$routes->group('billing', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Billing\Controllers\BillingController::index');
    $routes->get('(:any)', 'Billing\Controllers\BillingController::detail/$1');
});

$routes->group('cms', function ($routes) {
    $routes->get('page/(:any)', 'CMS\Controllers\PageController::page/$1');
    $routes->get('articles', 'CMS\Controllers\ArticleController::index');
    $routes->get('article/(:any)', 'CMS\Controllers\ArticleController::detail/$1');
    $routes->get('category/(:any)', 'CMS\Controllers\ArticleController::category/$1');
    $routes->get('tag/(:any)', 'CMS\Controllers\ArticleController::tag/$1');
});

$routes->group('blog', function ($routes) {
    $routes->get('/', 'Blog\Controllers\BlogController::index');
    $routes->get('(:any)', 'Blog\Controllers\BlogController::detail/$1');
    $routes->get('search', 'Blog\Controllers\BlogController::search');
});

$routes->group('portfolio', function ($routes) {
    $routes->get('/', 'Portfolio\Controllers\PortfolioController::index');
    $routes->get('(:any)', 'Portfolio\Controllers\PortfolioController::detail/$1');
    $routes->get('category/(:any)', 'Portfolio\Controllers\PortfolioController::category/$1');
});

$routes->group('support', ['filter' => 'auth'], function ($routes) {
    $routes->get('tickets', 'Support\Controllers\TicketController::index');
    $routes->get('ticket/create', 'Support\Controllers\TicketController::create');
    $routes->post('ticket/create', 'Support\Controllers\TicketController::create');
    $routes->get('ticket/(:any)', 'Support\Controllers\TicketController::detail/$1');
    $routes->post('ticket/(:any)', 'Support\Controllers\TicketController::detail/$1');
    $routes->get('ticket/close/(:any)', 'Support\Controllers\TicketController::close/$1');
});

$routes->group('client', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'ClientArea\Controllers\DashboardController::index');
    $routes->get('orders', 'ClientArea\Controllers\DashboardController::orders');
    $routes->get('invoices', 'ClientArea\Controllers\DashboardController::invoices');
    $routes->get('downloads', 'ClientArea\Controllers\DownloadController::index');
    $routes->get('download/(:any)', 'ClientArea\Controllers\DownloadController::download/$1');
    $routes->get('tickets', 'ClientArea\Controllers\DashboardController::tickets');
    $routes->get('profile', 'ClientArea\Controllers\ProfileController::index');
    $routes->post('profile', 'ClientArea\Controllers\ProfileController::update');
    $routes->post('profile/change-password', 'ClientArea\Controllers\ProfileController::changePassword');
    $routes->get('addresses', 'ClientArea\Controllers\ProfileController::addresses');
    $routes->post('address/add', 'ClientArea\Controllers\ProfileController::addAddress');
    $routes->get('address/delete/(:any)', 'ClientArea\Controllers\ProfileController::deleteAddress/$1');
});

$routes->group('admin', ['filter' => 'permission:users.read'], function ($routes) {
    $routes->get('dashboard', 'Dashboard\Controllers\AdminDashboardController::index');
    $routes->get('customers', 'Dashboard\Controllers\AdminDashboardController::customers');
    $routes->get('products', 'Dashboard\Controllers\AdminDashboardController::products');
    $routes->get('orders', 'Dashboard\Controllers\AdminDashboardController::orders');
    $routes->get('invoices', 'Dashboard\Controllers\AdminDashboardController::invoices');
    $routes->get('reports', 'Dashboard\Controllers\AdminDashboardController::reports');
    $routes->get('settings', 'Dashboard\Controllers\AdminDashboardController::settings');
});
