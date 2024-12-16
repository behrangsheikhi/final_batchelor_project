<?php

namespace App\Http\Requests\Admin\User;

use App\Constants\UserTypeValue;
use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::check() && Auth::user()->user_type === UserTypeValue::SUPER_ADMIN)
            return true;

       abort(403);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'regex:/^[a-zA-Z\s\-]+$/u',
                Rule::unique('permissions', 'name')
                    ->ignore($this->route('permission'), 'id')
                    ->where('deleted_at')
            ],
            'status' => 'required|in:0,1',
            'description' => 'required|persian_alpha|max:100'
        ];
    }

    public function attributes() : array
    {
        return [
            'name' => 'عنوان نقش',
            'description' => 'توضیحات نقش'
        ];
    }
}
