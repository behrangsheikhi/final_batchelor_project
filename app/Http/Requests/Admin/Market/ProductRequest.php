<?php

namespace App\Http\Requests\Admin\Market;

use App\Models\Admin\Market\Brand;
use App\Models\Admin\Market\ProductCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\Types\Nullable;

class ProductRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $this->merge([
            'price' => str_replace(',', '', $this->input('price')),
            'width' => empty($this->input('width')) ? null : str_replace(',', '', $this->input('width')),
            'height' => empty($this->input('height')) ? null : str_replace(',', '', $this->input('height')),
            'length' => empty($this->input('length')) ? null : str_replace(',', '', $this->input('length')),
            'weight' => empty($this->input('weight')) ? null : str_replace(',', '', $this->input('weight')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            $rules = [
                'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'marketable_number' => 'numeric|min:0|max:10000000',
                'introduction' => 'required|string|min:5|max:1000',
                'image' => 'required|image|mimetypes:image/jpeg,image/webp,image/png,image/jpg,image/gif,image/svg+xml|max:4096',
                'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'meta_key.*' => 'required',
                'meta_value.*' => 'required',
                'weight' => 'nullable|integer|min:0',
                'height' => 'nullable|integer|min:0',
                'width' => 'nullable|integer|min:0',
                'length' => 'nullable|integer|min:0',
                'price' => 'required|min:1',
                'status' => 'required|in:0,1',
                'marketable' => 'required|in:0,1',
                'brand_id' => 'required|string|exists:' . Brand::class . ',id',
                'product_category_id' => 'required|string|exists:' . ProductCategory::class . ',id',
                'published_at' => 'required',
            ];
        } else {
            $rules = [
                'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'marketable_number' => 'numeric|min:0|max:10000000',
                'introduction' => 'required|string|min:5|max:1000',
                'image' => 'required|image|mimetypes:image/jpeg,image/webp,image/png,image/jpg,image/gif,image/svg+xml|max:4096',
                'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'meta_key.*' => 'nullable',
                'meta_value.*' => 'nullable',
                'weight' => 'nullable',
                'height' => 'nullable',
                'width' => 'nullable',
                'length' => 'nullable',
                'price' => 'required',
                'status' => 'required|in:0,1',
                'marketable' => 'required|in:0,1',
                'brand_id' => 'required|string|exists:' . Brand::class . ',id',
                'product_category_id' => 'required|string|exists:' . ProductCategory::class . ',id',
                'published_at' => 'required',
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام محصول',
            'introduction' => 'توضیحات محصول',
            'meta_key.*' => 'ویژگی',
            'meta_value.*' => 'مقدار',
            'product_category_id' => 'دسته بندی کالا',
            'brand_id' => 'نام برند',
            'marketable' => 'قابلیت فروش',
            'published_at' => 'زمان انتشار روی سایت',
            'price' => 'قیمت',
            'weight' => 'وزن',
            'height' => 'ارتفاع',
            'width' => 'عرض',
            'length' => 'طول',
            'image' => 'تصویر کالا',
        ];
    }
}
