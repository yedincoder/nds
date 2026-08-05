<?php

namespace App\Modules\ClientArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\FrontArea\Services\OrderService;

class OrderController extends BaseController
{
    protected OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    /**
     * Show order detail with product-specific info
     */
    public function detail(string $uuid)
    {
        $userId = session()->get('user_id');
        $result = $this->orderService->getOrderByUuid($uuid);

        if (!$result['success']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $order = $result['data']['order'];

        // Ensure order belongs to current user
        if ($order->user_id != $userId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get order items
        $items = $result['data']['items'] ?? [];

        // Enrich items with product details (files, type, etc)
        $enrichedItems = [];
        foreach ($items as $item) {
            $productInfo = null;
            $files = [];

            if (!empty($item->product_id)) {
                $db = \Config\Database::connect();

                $productInfo = $db->table('products p')
                    ->select('p.id, p.name, p.slug, p.description, p.category_id, pc.name as category_name, pc.slug as category_slug')
                    ->join('product_categories pc', 'pc.id = p.category_id', 'left')
                    ->where('p.id', $item->product_id)
                    ->get()
                    ->getRow();

                // Get downloadable files for this product
                $files = $db->table('product_files')
                    ->where('product_id', $item->product_id)
                    ->where('status', 'active')
                    ->get()
                    ->getResult();
            }

            $enrichedItems[] = [
                'item' => $item,
                'product' => $productInfo,
                'files' => $files,
            ];
        }

        $data = [
            'title' => 'Order ' . $order->order_number,
            'order' => $order,
            'items' => $enrichedItems,
        ];

        return view('ClientArea/order_detail', $data);
    }
}
