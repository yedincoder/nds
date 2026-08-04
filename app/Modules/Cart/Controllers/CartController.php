<?php

namespace App\Modules\Cart\Controllers;

use App\Controllers\BaseController;
use App\Modules\Cart\Services\CartService;
use CodeIgniter\HTTP\ResponseInterface;

class CartController extends BaseController
{
    protected CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    public function index()
    {
        $result = $this->cartService->getCart();

        $data = [
            'title' => 'Shopping Cart',
            'cart' => $result['data']['cart'] ?? null,
            'items' => $result['data']['items'] ?? [],
            'summary' => $result['data']['totals'] ?? [],
            'userId' => session()->get('user_id'),
        ];

        return view('cart/index', $data);
    }

    public function add(): ResponseInterface
    {
        $productId = $this->request->getPost('product_id');
        $serviceId = $this->request->getPost('service_id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        $result = $this->cartService->addToCart([
            'product_id' => $productId,
            'service_id' => $serviceId,
            'quantity' => $quantity,
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($result);
        }

        if ($result['success']) {
            return redirect()->to('cart')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }

    public function update(): ResponseInterface
    {
        $itemId = $this->request->getPost('item_id');
        $quantity = $this->request->getPost('quantity');

        $result = $this->cartService->updateCartItem($itemId, $quantity);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($result);
        }

        if ($result['success']) {
            return redirect()->to('cart')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }

    public function remove(string $itemId): ResponseInterface
    {
        $result = $this->cartService->removeFromCart($itemId);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($result);
        }

        if ($result['success']) {
            return redirect()->to('cart')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }

    public function clear(): ResponseInterface
    {
        $result = $this->cartService->clearCart();

        return redirect()->to('cart')
            ->with('success', $result['message']);
    }
}
