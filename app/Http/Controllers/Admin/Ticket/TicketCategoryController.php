<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketCategoryRequest;
use App\Models\Admin\Ticket\TicketCategory;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = TicketCategory::orderByDesc('created_at')->get();
        return view('admin.ticket.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.ticket.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketCategoryRequest $request, TicketCategory $category)
    {

        $inputs = $request->all();
        $category = TicketCategory::create($inputs);

        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته بندی تیکت با موفقیت ایجاد شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketCategory $category)
    {

        return view('admin.ticket.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketCategoryRequest $request, TicketCategory $category)
    {

        $inputs = $request->all();
        $category->update($inputs);

        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته بندی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketCategory $category)
    {

        $category->delete();
        return redirect()->route('admin.ticket.category.index')->with('swal-success', 'دسته بندی تیکت با موفقیت حذف شد');
    }

    public function status(TicketCategory $category)
    {

        $category->status = $category->status == 0 ? 1 : 0;
        $result = $category->save();

        if ($result) {
            $message = $category->status == 0 ? 'دسته بندی تیکت غیرفعال شد' : 'دسته بندی تیکت فعال شد';
            $alertType = $category->status == 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $category->status,
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
