<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\FAQRequest;
use App\Models\Admin\Content\FAQ;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $faqs = FAQ::orderByDesc('created_at')->get();
        return view('admin.content.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.content.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FAQRequest $request)
    {

        $inputs = $request->all();
        FAQ::create($inputs);

        return redirect()->route('admin.content.faq.index')->with('swal-success', 'سوال متداول و پاسخ با موفقیت اضافه شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $faq)
    {

        return view('admin.content.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FAQ $faq, FAQRequest $faqRequest)
    {

        $inputs = $faqRequest->all();

        $faq->update($inputs);

        return redirect()->route('admin.content.faq.index')->with('swal-success', 'پرسش با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return redirect()->route('admin.content.faq.index')->with('swal-success', 'سوال متداول و پاسخ با موفقیت حذف شدند');
    }

    public function status(FAQ $faq): JsonResponse
    {

        $faq->status = $faq->status === 0 ? 1 : 0;
        $result = $faq->save();

        if ($result) {
            $message = $faq->status === 0 ? 'سوال متداول غیرفعال شد' : 'سوال متداول فعال شد';
            $alertType = $faq->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $faq->status,
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
