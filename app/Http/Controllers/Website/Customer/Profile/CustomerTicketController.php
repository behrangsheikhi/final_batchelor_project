<?php

namespace App\Http\Controllers\Website\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Customer\TicketRequest;
use App\Http\Services\File\FileService;
use App\Models\Admin\Ticket\Ticket;
use App\Models\Admin\Ticket\TicketCategory;
use App\Models\Admin\Ticket\TicketFile;
use App\Models\Admin\Ticket\TicketPriority;
use App\Rules\ForbiddenFileTypes;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerTicketController extends Controller
{

    public function index()
    {
        $tickets = Auth::user()->tickets()->whereTicketId(null)->get();
        return view('app.customer.dashboard.ticket.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('app.customer.dashboard.ticket.show', compact('ticket'));
    }

    public function create()
    {
        $categories = TicketCategory::orderby('name')->whereStatus(1)->get();
        $priorities = TicketPriority::orderBy('name')->whereStatus(1)->get();
        return view('app.customer.dashboard.ticket.create', compact(['categories', 'priorities']));
    }

    public function store(TicketRequest $request, FileService $service)
    {

        DB::transaction(function () use ($request,$service) {

            // ticket store
            $inputs = $request->all();
            $inputs['status'] = 1;
            $inputs['user_id'] = Auth::id();

            $ticket = Ticket::create($inputs);


            // ticket file store action
            if ($request->hasFile('file')) {
                $request->validate([
                    'file' => 'sometimes|mimes:jpg,jpeg,png,doc,docs,pdf,svg,zip,rar', new ForbiddenFileTypes,
                ], [
                    'file.mimes' => 'فرمت فایل معتبر نیست.'
                ]);
                $service->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-file');
                $service->setFileSize($request->file('file'));
                $fileSize = $service->getFileSize();
                $file_location = $request->input('store_to'); // get the user's choice ( where the file must be saved )

                $result = $service->moveToPublic($request->file('file'));
                if (!$result) {
                    return redirect()->back()->with('swal-error', 'بارگزاری فایل با شکست مواجه شد');
                }
                $fileFormat = $service->getFileFormat();

                $inputs['file_path'] = $result;
                $inputs['file_size'] = $fileSize;
                $inputs['file_type'] = $fileFormat;
                $inputs['status'] = 1;
                $inputs['ticket_id'] = $ticket->id;
                $inputs['user_id'] = Auth::id();
                $file = TicketFile::create($inputs);
            }
        });


        return redirect()->route('customer.dashboard.ticket-customer')->with('swal-success', 'تیکت شما با موفقیت ثبت شد');

    }

    public function answer(Ticket $ticket, Request $request)
    {
        // TODO : handle this part with transactions to save file if the answer has to have an attachment
        $request->validate([
            'description' => 'required|min:2|max:1000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,?!!؟ ]+$/u',
        ], [
            'description.required' => 'پاسخ الزامی است'
        ]);

        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['seen'] = 0;
        $inputs['reference_id'] = $ticket->reference_id;
        $inputs['user_id'] = Auth::id();
        $inputs['ticket_category_id'] = $ticket->ticket_category_id;
        $inputs['ticket_priority_id'] = $ticket->ticket_priority_id;
        $inputs['ticket_id'] = $ticket->id;
        $ticket = Ticket::create($inputs);

        return redirect()->route('customer.dashboard.ticket-customer')->with('swal-success', 'تیکت شما با موفقیت ارسال شد.');
    }

}
