<?php

namespace App\Modules\Checkout\Controllers;

use App\Controllers\BaseController;
use App\Modules\Cart\Services\CartService;
use App\Modules\Checkout\Services\CheckoutService;
use CodeIgniter\HTTP\ResponseInterface;

class CheckoutController extends BaseController
{
    protected CheckoutService $checkoutService;
    protected CartService $cartService;

    public function __construct()
    {
        $this->checkoutService = new CheckoutService();
        $this->cartService = new CartService();
    }

    public function index()
    {
        $cartResult = $this->cartService->getCart();

        if (empty($cartResult['data']['items'])) {
            return redirect()->to('cart')
                ->with('error', 'Your cart is empty.');
        }

        $data = [
            'title' => 'Checkout',
            'cart' => $cartResult['data']['cart'] ?? null,
            'items' => $cartResult['data']['items'] ?? [],
            'summary' => $cartResult['data']['summary'] ?? [],
        ];

        return view('checkout/index', $data);
    }

    public function process(): ResponseInterface
    {
        $validation = $this->validate([
            'billing_name' => 'required|min_length[3]',
            'billing_email' => 'required|valid_email',
            'billing_phone' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_province' => 'required',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $data = [
            'billing_name' => $this->request->getPost('billing_name'),
            'billing_email' => $this->request->getPost('billing_email'),
            'billing_phone' => $this->request->getPost('billing_phone'),
            'billing_address' => $this->request->getPost('billing_address'),
            'billing_city' => $this->request->getPost('billing_city'),
            'billing_province' => $this->request->getPost('billing_province'),
            'notes' => $this->request->getPost('notes'),
        ];

        $result = $this->checkoutService->processCheckout($data);

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput();
        }

        return redirect()->to('payment/' . $result['data']['order_id'])
            ->with('success', $result['message']);
    }

    public function success(string $orderId)
    {
        $data = [
            'title' => 'Order Success',
            'order_id' => $orderId,
        ];

        return view('checkout/success', $data);
    }
}
