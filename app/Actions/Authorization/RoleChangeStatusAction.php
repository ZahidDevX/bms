<?php

namespace App\Actions\Authorization;

use Spatie\Permission\Models\Role;
use App\Services\Authorization\RoleService;

class RoleChangeStatusAction
{
    public function __construct(private RoleService $service)
    {
    }

    public function handle(Role $role, bool $status): Role
    {

    }

}
