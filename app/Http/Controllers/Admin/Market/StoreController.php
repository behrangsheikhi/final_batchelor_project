<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\StoreRequest;
use App\Models\Admin\Market\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::orderByDesc('created_at')->get();
        return view('admin.market.store.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addToStore(Product $product)
    {

        return view('admin.market.store.add_to_store', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Product $product)
    {

        $product->marketable_number += $request->marketable_number;
        $product->save();
        Log::info("receiver =>{$request->receiver}, deliverer => {$request->deliverer}, details => {$request->details}, add => {$request->marketable_number}");

        return redirect()->route('admin.market.store.index', $product->id)->with('swal-success', 'افزایش موجودی با موفقیت انجام شد.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        return view('admin.market.store.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $inputs = $request->validate([
            'marketable_number' => 'required|numeric',
            'sold_number' => 'required|numeric',
            'frozen_number' => 'required|numeric',
        ], [
            'marketable_number.required' => 'مقدار قابل فروش الزامی است',
            'marketable_number.numeric' => 'مقدار قابل فروش باید عدد باشد',
            'sold_number.required' => 'مقدار فروخته شده الزامی است',
            'sold_number.numeric' => 'مقدار فروخته شده باید عدد باشد',
            'frozen_number.required' => 'مقدار رزورو شده الزامی است',
            'frozen_number.numeric' => 'مقدار رزرو شده باید عدد باشد',
        ]);
        if ($inputs) {
            $product->update($inputs);
            return redirect()->route('admin.market.store.index', $product->id)->with('swal-success')->with('swal-success', 'جزئیات موجودی با موفقیت ویرایش شد.');
        }
        return redirect()->route('admin.market.store.index', $product->id)->with('swal-error', 'عملیات ویرایش با خطا مواجه شد.');


    }

}
