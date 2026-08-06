<?php

namespace App\Modules\MitraArea\Services;

class MitraService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getMitraByUser(int $userId): ?object
    {
        return $this->db->table('mitra')
            ->where('user_id', $userId)
            ->get()
            ->getRow();
    }

    public function getDashboardStats(?object $mitra): array
    {
        if (!$mitra) {
            return [
                'total_orders' => 0,
                'success_orders' => 0,
                'cancelled_orders' => 0,
                'total_commission' => 0,
                'pending_commission' => 0,
                'balance' => 0,
            ];
        }

        $mitraOrders = $this->db->table('mitra_orders')
            ->where('mitra_id', $mitra->id)
            ->get()
            ->getResult();

        $totalCommission = 0;
        $pendingCommission = 0;
        $successCount = 0;
        $cancelledCount = 0;

        foreach ($mitraOrders as $mo) {
            if (in_array($mo->status, ['paid', 'completed'])) {
                $totalCommission += $mo->commission;
                $successCount++;
            } elseif ($mo->status === 'cancelled') {
                $cancelledCount++;
            } elseif ($mo->status === 'pending') {
                $pendingCommission += $mo->commission;
            }
        }

        $wallet = $this->getWallet($mitra);

        return [
            'total_orders' => count($mitraOrders),
            'success_orders' => $successCount,
            'cancelled_orders' => $cancelledCount,
            'total_commission' => $totalCommission,
            'pending_commission' => $pendingCommission,
            'balance' => $wallet->balance ?? 0,
        ];
    }

    public function getRecentOrders(?object $mitra, int $limit = 5): array
    {
        if (!$mitra) {
            return [];
        }

        return $this->db->table('mitra_orders mo')
            ->select('mo.*, o.order_number, o.total, o.created_at as order_created_at, u.username')
            ->join('orders o', 'o.id = mo.order_id', 'left')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->where('mo.mitra_id', $mitra->id)
            ->orderBy('mo.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }

    public function getAllOrders(?object $mitra): array
    {
        if (!$mitra) {
            return [];
        }

        return $this->db->table('mitra_orders mo')
            ->select('mo.*, o.order_number, o.total, o.created_at as order_created_at, u.username')
            ->join('orders o', 'o.id = mo.order_id', 'left')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->where('mo.mitra_id', $mitra->id)
            ->orderBy('mo.created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getOrdersByStatus(?object $mitra, array $statuses): array
    {
        if (!$mitra) {
            return [];
        }

        return $this->db->table('mitra_orders mo')
            ->select('mo.*, o.order_number, o.total, o.created_at as order_created_at, u.username')
            ->join('orders o', 'o.id = mo.order_id', 'left')
            ->join('users u', 'u.id = o.user_id', 'left')
            ->where('mo.mitra_id', $mitra->id)
            ->whereIn('mo.status', $statuses)
            ->orderBy('mo.created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getProducts(): array
    {
        return $this->db->table('products p')
            ->select('p.id, p.name, p.slug, p.short_description, p.thumbnail, p.status, pp.price')
            ->join('product_prices pp', 'pp.product_id = p.id', 'left')
            ->where('p.status', 'active')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getWallet(?object $mitra): ?object
    {
        if (!$mitra) {
            return null;
        }

        $wallet = $this->db->table('mitra_wallets')
            ->where('mitra_id', $mitra->id)
            ->get()
            ->getRow();

        if (!$wallet) {
            $this->db->table('mitra_wallets')->insert([
                'uuid' => $this->generateUuid(),
                'mitra_id' => $mitra->id,
                'balance' => 0,
                'pending_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]);
            $wallet = $this->db->table('mitra_wallets')
                ->where('mitra_id', $mitra->id)
                ->get()
                ->getRow();
        }

        return $wallet;
    }

    public function getWalletTransactions(?object $mitra): array
    {
        if (!$mitra) {
            return [];
        }

        return $this->db->table('mitra_orders')
            ->select('id, commission as amount, status, created_at, "commission" as type')
            ->where('mitra_id', $mitra->id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getWithdrawals(?object $mitra): array
    {
        if (!$mitra) {
            return [];
        }

        return $this->db->table('mitra_withdrawals')
            ->where('mitra_id', $mitra->id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function createWithdrawal(?object $mitra, array $data): array
    {
        if (!$mitra) {
            return ['success' => false, 'message' => 'Mitra tidak ditemukan.'];
        }

        $wallet = $this->getWallet($mitra);
        $amount = (float) ($data['amount'] ?? 0);

        if ($amount <= 0) {
            return ['success' => false, 'message' => 'Jumlah penarikan harus lebih dari 0.'];
        }

        if ($amount > ($wallet->balance ?? 0)) {
            return ['success' => false, 'message' => 'Saldo tidak mencukupi.'];
        }

        $this->db->table('mitra_withdrawals')->insert([
            'uuid' => $this->generateUuid(),
            'mitra_id' => $mitra->id,
            'amount' => $amount,
            'bank_name' => $data['bank_name'] ?? null,
            'account_number' => $data['account_number'] ?? null,
            'account_name' => $data['account_name'] ?? null,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Deduct from balance
        $this->db->table('mitra_wallets')
            ->where('mitra_id', $mitra->id)
            ->update([
                'balance' => ($wallet->balance ?? 0) - $amount,
                'total_withdrawn' => ($wallet->total_withdrawn ?? 0) + $amount,
            ]);

        return ['success' => true, 'message' => 'Penarikan berhasil diajukan.'];
    }

    private function generateUuid(): string
    {
        return date('YmdHis') . substr(md5(uniqid('', true) . mt_rand(1000, 9999)), 0, 8);
    }
}
