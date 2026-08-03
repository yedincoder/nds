<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;

        $roleMap = [];
        foreach ($db->table('roles')->get()->getResult() as $r) {
            $roleMap[$r->slug] = $r->id;
        }

        $permMap = [];
        foreach ($db->table('permissions')->get()->getResult() as $p) {
            $permMap[$p->name] = $p->id;
        }

        $rolePerms = [];
        $used = [];

        $assign = function (int $roleId, array $patterns) use ($permMap, &$rolePerms, &$used) {
            foreach ($permMap as $name => $pid) {
                foreach ($patterns as $pat) {
                    if (fnmatch($pat, $name)) {
                        $key = $roleId . '-' . $pid;
                        if (!isset($used[$key])) {
                            $used[$key] = true;
                            $rolePerms[] = [
                                'role_id' => $roleId,
                                'permission_id' => $pid,
                                'created_at' => date('Y-m-d H:i:s'),
                            ];
                        }
                        break;
                    }
                }
            }
        };

        // Super Admin: ALL
        $assign($roleMap['super-administrator'], ['*']);

        // Admin: Skip role/permission management
        $assign($roleMap['administrator'], ['*']);
        $adminSkip = ['roles.delete', 'permissions.delete', 'roles.manage', 'permissions.manage'];
        $rolePerms = array_filter($rolePerms, function ($r) use ($adminSkip) {
            foreach ($adminSkip as $skip) {
                // check by matching permission name
                return true;
            }
            return true;
        });
        // Re-build without admin-skip using the assign helper differently
        $rolePerms = [];
        $used = [];
        $assign($roleMap['super-administrator'], ['*']);
        $assign($roleMap['administrator'], [
            'dashboard.*', 'users.*', 'settings.*', 'cms.*', 'categories.*',
            'articles.*', 'pages.*', 'media.*', 'menus.*', 'products.*',
            'product_categories.*', 'product_files.*', 'product_images.*', 'product_prices.*',
            'services.*', 'service_packages.*', 'orders.*', 'invoices.*', 'payments.*',
            'billing.*', 'customers.*', 'reports.*', 'tickets.*', 'notifications.*',
            'portfolios.*', 'clients.*', 'midtrans.*', 'webhook.*',
        ]);

        $assign($roleMap['editor'], [
            'dashboard.read', 'cms.*', 'categories.*', 'articles.*', 'pages.*',
            'media.*', 'menus.*', 'portfolios.*', 'clients.*', 'reports.read',
        ]);

        $assign($roleMap['finance'], [
            'dashboard.read', 'billing.*', 'invoices.*', 'payments.*', 'orders.*',
            'transactions.*', 'payment_methods.*', 'reports.*', 'midtrans.*',
        ]);

        $assign($roleMap['customer'], [
            'dashboard.read', 'orders.read', 'orders.create', 'invoices.read',
            'payments.create', 'payments.read', 'downloads.*', 'tickets.*',
            'notifications.*', 'portfolios.read', 'services.read', 'products.read',
        ]);

        $db->table('role_permissions')->insertBatch($rolePerms);
    }
}