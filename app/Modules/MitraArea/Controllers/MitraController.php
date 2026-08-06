<?php

namespace App\Modules\MitraArea\Controllers;

use App\Modules\MitraArea\Services\MitraService;
use CodeIgniter\HTTP\RedirectResponse;

class MitraController extends \App\Controllers\MitraBaseController
{
    protected MitraService $mitraService;

    public function __construct()
    {
        $this->mitraService = new MitraService();
    }

    public function dashboard()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Mitra Dashboard',
            'page'  => 'mitra/dashboard',
            'mitra' => $mitra,
            'stats' => $this->mitraService->getDashboardStats($mitra),
            'recentOrders' => $this->mitraService->getRecentOrders($mitra),
        ];

        return view('MitraArea/dashboard/index', $data);
    }

    // ===================== E-COMMERCE =====================
    public function products()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Mitra Products',
            'page'  => 'mitra/products',
            'products' => $this->mitraService->getProducts(),
        ];

        return view('MitraArea/ecommerce/products', $data);
    }

    public function orders()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Mitra Orders',
            'page'  => 'mitra/orders',
            'orders' => $this->mitraService->getAllOrders($mitra),
        ];

        return view('MitraArea/orders/index', $data);
    }

    // ===================== PESANAN =====================
    public function ordersAll()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Semua Pesanan',
            'page'  => 'mitra/orders',
            'orders' => $this->mitraService->getAllOrders($mitra),
        ];

        return view('MitraArea/orders/index', $data);
    }

    public function ordersSuccess()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Pesanan Berhasil',
            'page'  => 'mitra/orders',
            'orders' => $this->mitraService->getOrdersByStatus($mitra, ['paid', 'completed']),
        ];

        return view('MitraArea/orders/success', $data);
    }

    public function ordersCancelled()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Pesanan Dibatalkan',
            'page'  => 'mitra/orders',
            'orders' => $this->mitraService->getOrdersByStatus($mitra, ['cancelled', 'expired']),
        ];

        return view('MitraArea/orders/cancelled', $data);
    }

    // ===================== PENDAPATAN =====================
    public function balance()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);
        $wallet = $this->mitraService->getWallet($mitra);

        $data = [
            'title' => 'Saldo',
            'page'  => 'mitra/balance',
            'wallet' => $wallet,
            'transactions' => $this->mitraService->getWalletTransactions($mitra),
        ];

        return view('MitraArea/pendapatan/balance', $data);
    }

    public function withdrawals()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Penarikan',
            'page'  => 'mitra/withdrawals',
            'withdrawals' => $this->mitraService->getWithdrawals($mitra),
            'wallet' => $this->mitraService->getWallet($mitra),
        ];

        return view('MitraArea/pendapatan/withdrawals', $data);
    }

    public function requestWithdrawal(): RedirectResponse
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $amount = $this->request->getPost('amount');
        $bankName = $this->request->getPost('bank_name');
        $accountNumber = $this->request->getPost('account_number');
        $accountName = $this->request->getPost('account_name');

        $result = $this->mitraService->createWithdrawal($mitra, [
            'amount' => $amount,
            'bank_name' => $bankName,
            'account_number' => $accountNumber,
            'account_name' => $accountName,
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message']);
        }

        return redirect()->back()
            ->with('success', 'Permintaan penarikan berhasil diajukan.');
    }

    // ===================== AKUN =====================
    public function profile()
    {
        $userId = session()->get('user_id');
        $mitra = $this->mitraService->getMitraByUser($userId);

        $data = [
            'title' => 'Profil Mitra',
            'page'  => 'mitra/profile',
            'mitra' => $mitra,
            'user' => [
                'username' => session()->get('username'),
                'email' => session()->get('email'),
                'full_name' => session()->get('full_name'),
            ],
        ];

        return view('MitraArea/akun/profile', $data);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/auth/login')
            ->with('success', 'Anda telah logout dari Mitra Area.');
    }
}
