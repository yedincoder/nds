<?php

namespace App\Helpers;

use CodeIgniter\Database\BaseConnection;

if (!function_exists('format_price')) {
    function format_price($amount, $currency = 'IDR')
    {
        if ($currency === 'IDR') {
            return 'Rp ' . number_format($amount, 0, ',', '.');
        }
        return '$' . number_format($amount, 2);
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd M Y')
    {
        if (empty($date)) return '-';
        return date($format, strtotime($date));
    }
}

if (!function_exists('generate_uuid')) {
    function generate_uuid()
    {
        // Generate UUID v4 dengan uniqid yang lebih reliable
        $data = uniqid('', true) . uniqid('', true) . mt_rand(0, 999999);
        $hash = md5($data);
        
        return sprintf('%s-%s-%s-%s-%s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            substr($hash, 12, 4),
            substr($hash, 16, 4),
            substr($hash, 20, 12)
        );
    }
}

if (!function_exists('generate_order_number')) {
    function generate_order_number()
    {
        return 'ORD-' . date('YmdHis') . '-' . strtoupper(substr(md5(rand()), 0, 6));
    }
}

if (!function_exists('generate_invoice_number')) {
    function generate_invoice_number()
    {
        return 'INV-' . date('YmdHis') . '-' . strtoupper(substr(md5(rand()), 0, 6));
    }
}

if (!function_exists('generate_ticket_number')) {
    function generate_ticket_number()
    {
        return 'TKT-' . date('YmdHis') . '-' . strtoupper(substr(md5(rand()), 0, 4));
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $db = \Config\Database::connect();
        $result = $db->table('settings')
            ->where('key', $key)
            ->get()
            ->getRow();

        return $result ? $result->value : $default;
    }
}

if (!function_exists('set_setting')) {
    function set_setting($key, $value, $group = 'general')
    {
        $db = \Config\Database::connect();
        $existing = $db->table('settings')
            ->where('key', $key)
            ->where('group', $group)
            ->get()
            ->getRow();

        if ($existing) {
            $db->table('settings')
                ->where('key', $key)
                ->where('group', $group)
                ->update(['value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
        } else {
            $db->table('settings')
                ->insert([
                    'uuid' => generate_uuid(),
                    'group' => $group,
                    'key' => $key,
                    'value' => $value,
                    'type' => 'string',
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
        }

        return true;
    }
}
