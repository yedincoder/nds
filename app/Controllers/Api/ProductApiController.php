<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductApiController extends BaseController
{
    public function index(): ResponseInterface
    {
        $db = \Config\Database::connect();
        
        $products = $db->table('products')
            ->where('status', 'active')
            ->get()
            ->getResult();

        return $this->respond([
            'status'  => true,
            'message' => 'Products retrieved successfully',
            'data'    => $products,
        ]);
    }

    public function show(int $id = null): ResponseInterface
    {
        if (!$id) {
            return $this->respond([
                'status'  => false,
                'message' => 'Product ID is required',
            ], 400);
        }

        $db = \Config\Database::connect();
        $product = $db->table('products')
            ->where('id', $id)
            ->where('status', 'active')
            ->get()
            ->getRow();

        if (!$product) {
            return $this->respond([
                'status'  => false,
                'message' => 'Product not found',
            ], 404);
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Product retrieved successfully',
            'data'    => $product,
        ]);
    }
}