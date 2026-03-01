<?php

namespace App\Http\Resources\Authorization;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'order' => $this->order,
            'status' => $this->status ? true : false,
            'isSystem' => $this->is_system ? true : false,
            'isAssignable' => $this->is_assignable ? true : false,
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->permissions->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'groupName' => $permission->group_name,
                        'name' => $permission->name,
                    ];
                });
            }),
        ];
    }
}
