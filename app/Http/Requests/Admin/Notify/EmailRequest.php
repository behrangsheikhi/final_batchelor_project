<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
        return [
            'subject' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟!! ]+$/u',
            'body' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&!! ]+$/u',
            'status' => 'numeric|in:0,1',
            'published_at' => 'required|numeric'
        ];
    }

    public function attributes(): array
    {
        return [
            'subject' => 'عنوان ایمیل',
            'body' => 'بدنه ایمیل'
        ];
    }
}
