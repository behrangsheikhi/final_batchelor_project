<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Jobs\sendEmailToUsers;
use App\Models\Admin\Notify\Email;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class EmailController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $emails = Email::orderBy('created_at', 'desc')->simplePaginate(20);
        return view('admin.notify.email.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.notify.email.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailRequest $request, Email $email): RedirectResponse
    {

        $inputs = $request->all();
        // fix date
        $realTimeStampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);
        Email::create($inputs);

        return redirect()->route('admin.notify.email.index')->with('swal-success', 'ایمیل شما با موفقیت ایجاد شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Email $email)
    {

        return view('admin.notify.email.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmailRequest $request, Email $email)
    {

        $inputs = $request->all();
        // fix date
        $realTimeStampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);

        $email->update($inputs);
        return redirect()->route('admin.notify.email.index')->with('swal-success', 'ایمیل شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email): RedirectResponse
    {

        $email->delete();

        return redirect()->route('admin.notify.email.index')->with('swal-success', 'ایمیل شما با موفقیت حذف شد');
    }

    public function status(Email $email)
    {

        $email->status = $email->status === 0 ? 1 : 0;
        $result = $email->save();

        if ($result) {
            $message = $email->status === 0 ? 'ایمیل غیرفعال شد' : 'ایمیل فعال شد';
            $alertType = $email->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $email->status,
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

    public function sendEmail(Email $email)
    {
        try {
            sendEmailToUsers::dispatch($email);
            return redirect()->back()->with('swal-success','ایمیل شما در زمان تعیین شده ارسال خواهد شد.');
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }


}
