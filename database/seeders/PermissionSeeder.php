<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     *   If You added Any New Permission
     *   Run Command : php artisan db:seed --class=PermissionSeeder
     */

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Dashboard Management' => ['view-dashboard'],
            'User Management' => ['users-list', 'add-user', 'edit-user', 'view-user', 'delete-user'],
            'Role Management' => ['roles-list', 'add-role', 'edit-role', 'view-role', 'delete-role'],
            'Permission Management' => ['permissions-list'],
            'Transaction Management' => ['transactions-list', 'add-transaction', 'edit-transaction', 'view-transaction', 'delete-transaction'],
            'Payment Management' => ['payments-list', 'add-payment', 'edit-payment', 'view-payment', 'delete-payment'],
            'Report Management' => ['generate-report'],
        ];
        $data = [];
        foreach ($permissions as $parent => $permission) {
            foreach ($permission as $value) {
                $display_name = ucwords(str_replace('-', ' ', $value));
                if (!Permission::where('parent_name', $parent)->where('display_name', $display_name)->where('name', $value)->where('guard_name', 'web')->exists()) {
                    $data[] = [
                        'parent_name' => $parent,
                        'display_name' => $display_name,
                        'name' => $value,
                        'guard_name' => 'web',
                        'created_at' => now(),
                    ];
                }
            }
        }
        Permission::insert($data);
    }
}
