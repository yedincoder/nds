<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OrderApiController extends BaseController
{
    public function index(): ResponseInterface
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return $this->respond([
                'status'  => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $db = \Config\Database::connect();
        
        $orders = $db->table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        return $this->respond([
            'status'  => true,
            'message' => 'Orders retrieved successfully',
            'data'    => $orders,
        ]);
    }
}