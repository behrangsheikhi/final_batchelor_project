<?php

namespace App\Http\Requests\Admin\Notify;

use App\Rules\ForbiddenFileTypes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
//        dd($this->request);
        if ($this->isMethod('post')) {
            return [
                'file' => 'required|mimes:jpg,jpeg,png,doc,docs,pdf,svg,zip,rar', new ForbiddenFileTypes,
                'status' => 'required|numeric|in:0,1',
                'store_to' => 'required|numeric|in:0,1'
            ];
        } else {
            return [
                'file' => 'file|mimes:jpg,jpeg,png,doc,docs,pdf,svg,zip,rar', new ForbiddenFileTypes,
                'status' => 'numeric|in:0,1',
                'store_to' => 'numeric|in:0,1',
            ];
        }
    }

    public function attributes(): array
    {
        return [
            'store_to' => 'محل ذخیره سازی',
            'status' => 'وضعیت',
            'file' => 'فایل ایمیل'
        ];
    }
}
