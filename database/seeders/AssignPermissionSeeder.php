<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionSeeder extends Seeder
{
    /**
    *   If You added Any New Permission
    *   Run Command : php artisan db:seed --class=AssignPermissionSeeder
    */
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Giving Admin Permissions
        $admin_permissions = Permission::get();

        $admin_role = Role::where('name', 'Admin')->first();

        $admin_role->permissions()->sync($admin_permissions);

        // Giving Customer Permissions
        $customerPermissions = ['view-dashboard', 'transactions-list', 'view-transaction'];
        $customer_permissions = Permission::whereIn('name', $customerPermissions)->get();

        $customer_role = Role::where('name', 'Customer')->first();

        $customer_role->permissions()->sync($customer_permissions);
    }
}
