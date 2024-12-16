<?php

namespace App\Http\Requests\Admin\Content;

use App\Constants\UserTypeValue;
use App\Models\Admin\Content\BannerPosition;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user() && (auth()->user()->user_type == UserTypeValue::ADMIN || auth()->user()->user_type == UserTypeValue::SUPER_ADMIN)) {
            return true;
        }
        return false;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')){
            return [
                'title' => 'required|min:5|max:255|string',
                'description' => 'nullable|min:5|max:255|string',
                'url' => 'required|min:5|max:255|url',
                'position' => 'required|numeric',
                'status' => 'required|in:0,1',
                'image' => 'required|image|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:4096',
            ];
        }
        return [
            'title' => 'required|min:5|max:255|string',
            'description' => 'nullable|min:5|max:255|string',
            'url' => 'required|min:5|max:255|url',
            'position' => 'required|numeric',
            'status' => 'required|in:0,1',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'description' => 'توضیحات',
            'url' => 'آدرس',
            'banner_position_id' => 'موقعیت',
            'status' => 'وضعیت',
            'image' => 'تصویر',
        ];
    }
}
