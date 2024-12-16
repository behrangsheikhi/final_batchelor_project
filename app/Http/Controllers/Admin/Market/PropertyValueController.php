<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryValueRequest;
use App\Models\Admin\Market\CategoryAttribute;
use App\Models\Admin\Market\CategoryValue;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PropertyValueController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(CategoryAttribute $attribute)
    {

        $values = CategoryValue::whereCategoryAttributeId( $attribute->id)->orderByDesc('created_at')->get();
        return view('admin.market.property.value.index', compact(['values', 'attribute']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryAttribute $attribute)
    {

        return view('admin.market.property.value.create', compact('attribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryValueRequest $request, CategoryAttribute $attribute)
    {

        $inputs = $request->all();
        $inputs['value'] = json_encode([
            'value' => $request->value,
            'price_increase' => $request->price_increase
        ]);
        $inputs['category_attribute_id'] = $attribute->id;
        CategoryValue::create($inputs);

        return redirect()->route('admin.market.property.value.index', $attribute->id)->with('swal-success', 'اطلاعات مورد نظر با موفقیت ثبت شد.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryAttribute $attribute, CategoryValue $value)
    {

        return view('admin.market.property.value.edit', compact(['attribute', 'value']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryValueRequest $request, CategoryAttribute $attribute, CategoryValue $value)
    {

        $inputs = $request->all();
        $inputs['category_attribute_id'] = $attribute->id;
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $value->update($inputs);

        return redirect()->route('admin.market.property.value.index', $attribute->id)->with('swal-success', 'اطلاعات مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryAttribute $attribute, CategoryValue $value)
    {

        $value->delete();
        return redirect()->route('admin.market.property.value.index', $attribute->id)->with('swal-success', 'رکورد مورد نظر با موفقیت حذف شد.');
    }
}
