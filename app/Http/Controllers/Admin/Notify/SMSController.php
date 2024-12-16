<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\SMSRequest;
use App\Jobs\SendSMSToUsers;
use App\Models\Admin\Notify\SMS;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class SMSController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $messages = SMS::orderByDesc('created_at')->get();
        return view('admin.notify.sms.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.notify.sms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SMSRequest $request, SMS $message)
    {

        $inputs = $request->all();
        // date fix
        $realTimeStampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);

        SMS::create($inputs);

        return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک با موفقیت ایجاد شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SMS $message)
    {

        return \view('admin.notify.sms.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SMSRequest $request, SMS $message): RedirectResponse
    {

        $inputs = $request->all();
        // date fix
        $realTimeStampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);
        $message->update($inputs);

        return redirect()->route('admin.notify.sms.index')->with('swal-success', 'اطلاعیه پیامکی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SMS $message): RedirectResponse
    {

        $message->delete();
        return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک مورد نظر با موفقیت حذف شد');
    }

    public function status(SMS $message)
    {

        $message->status = $message->status == 0 ? 1 : 0;
        $result = $message->save();

        if ($result) {
            $alert_message = $message->status == 0 ? 'پیامک غیرفعال شد' : 'پیامک فعال شد';
            $alertType = $message->status == 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $message->status,
                'message' => $alert_message,
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

    public function sendSMS(SMS $message)
    {
        try {
            SendSMSToUsers::dispatch($message);
            return redirect()->back()->with('swal-success', 'پیامک شما با موفقیت ارسال شد.');
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

}
