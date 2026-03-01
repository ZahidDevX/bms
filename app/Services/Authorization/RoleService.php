<?php

namespace App\Services\Authorization;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(private Role $role)
    {
    }
}
