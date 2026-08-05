<?php

namespace App\Modules\FrontArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\FrontArea\Services\CartService;
use App\Modules\FrontArea\Services\CheckoutService;
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

        // Get logged in user data
        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        
        // Get user profile data
        $user = $db->table('users u')
            ->select('u.id, u.email, u.username, p.full_name, p.phone, p.address, p.city, p.province')
            ->join('user_profiles p', 'p.user_id = u.id', 'left')
            ->where('u.id', $userId)
            ->get()
            ->getRow();

        // Get default address if exists
        $defaultAddress = $db->table('customer_addresses')
            ->where('user_id', $userId)
            ->orderBy('is_default', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();

        $data = [
            'title' => 'Checkout',
            'cart' => $cartResult['data']['cart'] ?? null,
            'items' => $cartResult['data']['items'] ?? [],
            'summary' => $cartResult['data']['summary'] ?? [],
            'user' => $user,
            'defaultAddress' => $defaultAddress,
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

        log_message('error', 'CheckoutController::process() result: ' . json_encode($result));

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput();
        }

        // Redirect ke halaman payment menggunakan invoice number/uuid (bukan order_id)
        $invoiceRef = $result['data']['invoice_number'] ?? $result['data']['invoice_uuid'] ?? null;

        if (!$invoiceRef) {
            return redirect()->back()
                ->with('error', 'Invoice reference not found. Please try again.');
        }

        return redirect()->to('payment/' . $invoiceRef)
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
