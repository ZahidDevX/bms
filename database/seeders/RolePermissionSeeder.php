<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = config('user.roles');
        $permissionGroups = config('user.permissions');
        foreach ($permissionGroups as $groupName => $permissions) {
            foreach ($permissions as $permissionItem) {
                $permission = new Permission();
                $permission->group_name = $groupName;
                $permission->name = $permissionItem;
                $permission->save();
            }
        }
        $permissions = Permission::all();
        foreach ($roles as $roleItem) {
            $role = new Role();
            $role->name = $roleItem['name'];
            $role->is_system = $roleItem['isSystem'];
            $role->is_assignable = $roleItem['isAssignable'];
            $role->status = $roleItem['status'];
            $role->save();
            $role->syncPermissions($permissions);
        }
    }
}
