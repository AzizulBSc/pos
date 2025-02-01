<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create admin role
        $adminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Manager']);
        $userRole = Role::create(['name' => 'User']);

        // Assign admin role to user id 1
        $admin = User::find(1);
        $admin->syncRoles($adminRole);

        // Define permissions by groups
        $permissions = [
            // User management
            'view_users',
            'create_user',
            'update_user',
            'delete_user',
            // Role management
            'view_roles',
            'create_role',
            'update_role',
            'delete_role',
            'role_permissions',
            // Permission management
            'view_permissions',
            'create_permission',
            'update_permission',
            'delete_permission',
            // Settings
            'view_settings',
            'update_settings',
            // Products
            'view_products',
            'create_product',
            'update_product',
            'delete_product',
            // Purchase
            'view_purchases',
            'create_purchase',
            'update_purchase',
            'delete_purchase',
            // Sales
            'view_sales',
            'create_sale',
            'update_sale',
            'delete_sale',
            //category
            'view_category',
            'create_category',
            'update_category',
            'delete_category',
            //brand
            'view_brands',
            'create_brand',
            'update_brand',
            'delete_brand',
            //unit
            'view_units',
            'create_unit',
            'update_unit',
            'delete_unit',
            //supplier
            'view_suppliers',
            'create_supplier',
            'update_supplier',
            'delete_supplier',
            //customer
            'view_customers',
            'create_customer',
            'update_customer',
            'delete_customer',
            // Products
            'view_reports',
        ];

        // Create permissions
        $permissions = collect($permissions)->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        Permission::insert($permissions->toArray());

        // Assign all permissions to admin role
        $adminRole->syncPermissions(Permission::all());

        // Assign limited permissions to manager role
        $managerRole->syncPermissions(Permission::whereIn('name', [
            'view_products',
            'create_product',
            'update_product',
            'view_orders',
            'update_order',
            'view_categories'
        ])->get());

        // Assign basic permissions to user role
        $userRole->syncPermissions(Permission::whereIn('name', [
            'view_products',
            'view_categories',
            'create_order'
        ])->get());
    }
}
