<?php

namespace App\Actions\Authorization;

use Spatie\Permission\Models\Role;
use App\Services\Authorization\RoleService;

class RoleUpdateAction
{
    public function __construct(private RoleService $service)
    {
    }

    public function handle(Role $role, array $data): Role
    {
        $role->name = strtolower($data['name']);
        $role->save();
        return $role;
    }
}
