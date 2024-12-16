<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\GuarantyRequest;
use App\Models\Admin\Market\Guaranty;
use App\Models\Admin\Market\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class GuarantyController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {

        return view('admin.market.product.guaranty.index',compact(['product']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {

        return view('admin.market.product.guaranty.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuarantyRequest $request,Product $product)
    {

        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        Guaranty::create($inputs);
        return redirect()->route('admin.market.product.guaranty.index',$product->id)->with('swal-success','گارانتی مورد نظر برای محصول انتخابی با موفقیت ثبت شد.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Guaranty $guaranty)
    {

        return view('admin.market.product.guaranty.edit',compact(['product','guaranty']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuarantyRequest $request,Product $product, Guaranty $guaranty)
    {

        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        $guaranty->update($inputs);
        return redirect()->route('admin.market.product.guaranty.index',$product->id)->with('swal-success','گارانتی مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product,Guaranty $guaranty)
    {

        $guaranty->delete();
        return redirect()->route('admin.market.product.guaranty.index',$product->id)->with('swal-success', 'گارانتی مورد نظر با موفقیت حذف شد.');
    }

    public function status(Guaranty $guaranty)
    {

        $guaranty->status = $guaranty->status === 0 ? 1 : 0;
        $result = $guaranty->save();

        if ($result) {
            $message = $guaranty->status === 0 ? 'گارانتی غیرفعال شد' : 'گارانتی فعال شد';
            $alertType = $guaranty->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $guaranty->status,
                'message' => $message,
                'alertType' => $alertType
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'مشکلی پیش آمده است.',
                'alertType' => 'error'
            ]);
        }
    }


}
