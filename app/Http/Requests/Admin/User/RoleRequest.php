<?php

namespace App\Http\Requests\Admin\User;

use App\Models\Admin\User\Role;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user())
            return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $route = \Illuminate\Support\Facades\Route::current();
        if ($route->getName() === 'admin.user.role.store') {
            return [
                'name' => 'required|regex:/^[a-zA-Z\s]+$/u|unique:'.Role::class.',name',
                'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
                'status' => 'required|numeric|in:0,1',
                'permissions.*' => 'exists:permissions,id'
            ];
        } elseif ($route->getName() === 'admin.user.role.update') {
            return [
                'name' => [
                    'required',
                    'regex:/^[a-zA-Z\s]+$/u',
                    Rule::unique('roles', 'name')
                        ->ignore($this->route('role'), 'id')
                        ->where('deleted_at')
                ],
                'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
                'status' => 'required|numeric|in:0,1',
            ];
        } elseif ($route->getName() === 'admin.user.role.permissionUpdate') {
            return [
                'permissions.*' => 'exists:permissions,id'
            ];
        }


    }

    public function attributes(): array
    {
        return [
            'name' => 'عنوان نقش',
            'description' => 'توضیحات نقش',
            'permissions.*' => 'دسترسی'
        ];
    }
}
