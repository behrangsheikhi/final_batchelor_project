<?php

namespace App\Http\Requests\Admin\Content;

use App\Constants\UserTypeValue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'body' =>  'required|max:1000|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&!! ؟?)(]+$/u',
        ];
    }

    public function attributes(): array
    {
        return [
            'body' => 'پاسخ نظر'
        ];
    }
}
