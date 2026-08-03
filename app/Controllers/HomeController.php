<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HomeController extends BaseController
{
    public function index(): string
    {
        return view('welcome_message', ['title' => 'Home', 'page' => 'home']);
    }

    public function about(): string
    {
        return view('about', ['title' => 'About Us', 'page' => 'about']);
    }

    public function services(): string
    {
        return view('services', ['title' => 'Our Services', 'page' => 'services']);
    }

    public function products(): string
    {
        return view('products', ['title' => 'Our Products', 'page' => 'products']);
    }

    public function portfolio(): string
    {
        return view('portfolio', ['title' => 'Our Portfolio', 'page' => 'portfolio']);
    }

    public function blog(): string
    {
        return view('blog', ['title' => 'Our Blog', 'page' => 'blog']);
    }

    public function contact(): string
    {
        return view('contact', ['title' => 'Contact Us', 'page' => 'contact']);
    }
}
