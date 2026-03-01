<?php

namespace App\Actions\Authorization;

use Spatie\Permission\Models\Role;
use App\Services\Authorization\RoleService;

class RoleShowAction
{
    public function __construct(private RoleService $service) {}

    public function handle(Role $role): array
    {
        return [];
    }
}