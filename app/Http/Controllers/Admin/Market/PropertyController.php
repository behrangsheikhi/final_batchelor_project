<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryAttributeRequest;
use App\Models\Admin\Market\CategoryAttribute;
use App\Models\Admin\Market\ProductCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PropertyController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $category_attributes = CategoryAttribute::orderByDesc('created_at')->get();
        return view('admin.market.property.index', compact('category_attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = ProductCategory::all();
        return view('admin.market.property.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryAttributeRequest $request, CategoryAttribute $attribute)
    {

        $inputs = $request->all();

        $result = CategoryAttribute::create($inputs);
        if ($result) {
            return redirect()->route('admin.market.property.index')->with('swal-success', 'فرم انتخابی با موفقیت ذخیره شد.');
        }

        return redirect()->route('admin.market.property.index')->with('swal-error', 'مشکل در ذخیره اطلاعات بوجود آمد.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryAttribute $attribute)
    {

        $categories = ProductCategory::all();
        return view('admin.market.property.edit', compact(['attribute', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryAttributeRequest $request, CategoryAttribute $attribute)
    {

        $inputs = $request->all();
        $attribute->update($inputs);

        return redirect()->route('admin.market.property.index')->with('swal-success', 'فرم انتخابی با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryAttribute $attribute)
    {

        $attribute->delete();

        return redirect()->route('admin.market.property.index')->with('swal-success', 'فرم انتخابی با موفقیت حذف شد.');
    }
}
