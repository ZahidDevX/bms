<?php

namespace App\Actions\Authorization;

use Spatie\Permission\Models\Role;
use App\Services\Authorization\RoleService;

class RoleStoreAction
{
    public function __construct(private RoleService $service)
    {
    }

    public function handle(array $data): Role
    {
        $role = new Role();
        $role->name = strtolower($data['name']);
        $role->save();
        return $role;
    }
}
