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
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return sprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $data[0], $data[1], $data[2], $data[3],
            $data[4], $data[5], $data[6], $data[7],
            $data[8], $data[9], $data[10], $data[11],
            $data[12], $data[13], $data[14], $data[15]
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
