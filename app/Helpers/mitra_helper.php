<?php

if (!function_exists('is_mitra')) {
    /**
     * Check if current user is a mitra/partner
     */
    function is_mitra(): bool
    {
        $role = session()->get('user_role') ?? session()->get('role');
        return in_array($role, ['mitra', 'partner'], true);
    }
}

if (!function_exists('mitra_code')) {
    /**
     * Get current mitra code
     */
    function mitra_code(): ?string
    {
        $db = \Config\Database::connect();
        $mitra = $db->table('mitra')
            ->where('user_id', session()->get('user_id'))
            ->get()
            ->getRow();

        return $mitra->mitra_code ?? null;
    }
}

if (!function_exists('mitra_balance')) {
    /**
     * Get current mitra wallet balance
     */
    function mitra_balance(): float
    {
        $db = \Config\Database::connect();
        $wallet = $db->table('mitra_wallets')
            ->join('mitra', 'mitra.id = mitra_wallets.mitra_id')
            ->where('mitra.user_id', session()->get('user_id'))
            ->get()
            ->getRow();

        return (float) ($wallet->balance ?? 0);
    }
}
