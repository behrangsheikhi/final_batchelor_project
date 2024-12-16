<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\DeliveryRequest;
use App\Models\Admin\Market\Delivery;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $delivery_methods = Delivery::all();
        return view('admin.market.delivery-method.index', compact('delivery_methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.market.delivery-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryRequest $request, Delivery $delivery)
    {

        $inputs = $request->all();
        Delivery::create($inputs);

        return redirect()->route('admin.market.delivery-method.index')->with('swal-success','روش ارسال مورد نظر با موفقیت ذخیره شد');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {

        return view('admin.market.delivery-method.edit',compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliveryRequest $request,Delivery $delivery)
    {

        $inputs = $request->all();
        $delivery->update($inputs);

        return redirect()->route('admin.market.delivery-method.index')->with('swal-success','روش ارسال مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {

        $delivery->delete();

        return redirect()->route('admin.market.delivery-method.index')->with('swal-success', 'روش ارسالی مورد نظر با موفقیت حذف شد');
    }

    public function status(Delivery $delivery): JsonResponse
    {

        $delivery->status = $delivery->status === 0 ? 1 : 0;
        $result = $delivery->save();

        if ($result) {
            $message = $delivery->status === 0 ? 'روش ارسال غیرفعال شد' : 'روش ارسال فعال شد';
            $alertType = $delivery->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $delivery->status,
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
