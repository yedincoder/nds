<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceApiController extends BaseController
{
    public function index(): ResponseInterface
    {
        $db = \Config\Database::connect();
        
        $services = $db->table('services')
            ->where('status', 'active')
            ->get()
            ->getResult();

        return $this->respond([
            'status'  => true,
            'message' => 'Services retrieved successfully',
            'data'    => $services,
        ]);
    }
}