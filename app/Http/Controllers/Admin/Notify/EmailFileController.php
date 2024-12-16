<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Constants\FileTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailRequest;
use App\Http\Requests\Admin\Notify\FileRequest;
use App\Http\Services\File\FileService;
use App\Models\Admin\Notify\Email;
use App\Models\Admin\Notify\EmailFile;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailFileController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Email $email)
    {

        $files = EmailFile::where('public_email_id', $email->id)->orderByDesc('created_at')->get();
        return view('admin.notify.email-file.index', compact(['files', 'email']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Email $email)
    {

        return view('admin.notify.email-file.create', compact('email'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $request, Email $email, FileService $service)
    {

        $inputs = $request->all();
        if ($request->hasFile('file')) {
            $service->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-file');
            $service->setFileSize($request->file('file'));
            $fileSize = $service->getFileSize();
            $file_location = $request->input('store_to'); // get the user's choice ( where the file must be saved )

            if ($file_location == FileTypeValue::PRIVATE_FILE) {
                $result = $service->moveToStorage($request->file('file'));
            } elseif ($file_location == FileTypeValue::PUBLIC_FILE) {
                $result = $service->moveToPublic($request->file('file'));
            }
            if ($result === false) {
                return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-error', 'بارگزاری فایل با شکست مواجه شد');
            }
            $fileFormat = $service->getFileFormat();
        }
        $inputs['public_email_id'] = $email->id;
        $inputs['file_path'] = $result;
        $inputs['file_size'] = $fileSize;
        $inputs['file_type'] = $fileFormat;
        $inputs['type'] = $file_location; // set the type field before creating the record
        $file = EmailFile::create($inputs);

        return redirect()->route('admin.notify.email-file.index', $email->id)->with('swal-success', 'فایل شما با موفقیت آپلود شد');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailFile $file)
    {

        $email = $file->email;
        return \view('admin.notify.email-file.edit', compact(['file','email']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileRequest $request, EmailFile $file, FileService $service)
    {

        $inputs = $request->all();
        $selected_file_location = ($request->input('store_to') === '1') ? FileTypeValue::PRIVATE_FILE : FileTypeValue::PUBLIC_FILE;
        if ($request->hasFile('file')) {
            if (!empty($file->file_path)) {
                $service->deleteFile($file->file_path, $file->store_to);
            }
            $service->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-file');
            $service->setFileSize($request->file('file'));
            $fileSize = $service->getFileSize();

            if ($selected_file_location == FileTypeValue::PRIVATE_FILE) {
                $result = $service->moveToStorage($request->file('file'));
            } else {
                $result = $service->moveToPublic($request->file('file'));
            }
            if ($result === false) {
                return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-error', 'فایل شما با  شکست مواجه شد');
            }
            $fileFormat = $service->getFileFormat();
            $inputs['file_path'] = $result;
            $inputs['file_size'] = $fileSize;
            $inputs['file_type'] = $fileFormat;
            $inputs['store_to'] = $selected_file_location; // set the store directory
        }else {
            // Code block when changing file location without uploading a new file
            if (!empty($file->file_path)) {
                // Move the file to the new location
                $result = $service->moveFileToNewLocation($file->file_path, $file->store_to, $selected_file_location);
                if ($result === false) {
                    return redirect()->route('admin.notify.email-file.index', $file->email->id)
                        ->with('swal-error', 'عملیات ناموفق بود');
                }
            }
            // Update other fields in the database
            $inputs['store_to'] = $selected_file_location;
        }
        $file->update($inputs);

        return redirect()->route('admin.notify.email-file.index', $file->email->id)->with('swal-success', 'فایل شما با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailFile $file, FileService $service)
    {

        $service->deleteFile($file->file_path,$file->store_to);
        $file->delete();
        return redirect()->route('admin.notify.email-file.index', $file->email->id)
            ->with('swal-success', 'فایل انتخابی با موفقیت حذف شد');
    }


    public function status(EmailFile $file)
    {

        $file->status = $file->status === 0 ? 1 : 0;
        $result = $file->save();

        if ($result) {
            $message = $file->status === 0 ? 'فایل ایمیل غیرفعال شد' : 'فایل ایمیل فعال شد';
            $alertType = $file->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $file->status,
                'message' => $message,
                'alertType' => $alertType
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'مشکلی پیش آمده است . ',
                'alertType' => 'error'
            ]);
        }
    }
}
