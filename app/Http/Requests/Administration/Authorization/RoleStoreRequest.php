<?php

namespace App\Http\Requests\Administration\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'max:255', 'unique:roles,name'],
            'assignPermission' => ['required', 'boolean']
        ];
    }
}
