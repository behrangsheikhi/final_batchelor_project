<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketPriorityRequest;
use App\Models\Admin\Ticket\TicketPriority;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketPriorityController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $priorities = TicketPriority::orderByDesc('created_at')->get();
        return view('admin.ticket.priority.index', compact('priorities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.ticket.priority.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketPriorityRequest $request, TicketPriority $priority)
    {

        $inputs = $request->all();
        $priority = TicketPriority::create($inputs);

        return redirect()->route('admin.ticket.priority.index')->with('swal-success','اولویت بندی جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketPriority $priority)
    {

        return view('admin.ticket.priority.edit',compact('priority'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketPriorityRequest $request, TicketPriority $priority)
    {

        $inputs = $request->all();
        $priority->update($inputs);

        return redirect()->route('admin.ticket.priority.index')->with('swal-success','اولویت بندی مورد نظر با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketPriority $priority)
    {

        $priority->delete();

        return redirect()->route('admin.ticket.priority.index')->with('swal-success','اولویت بندی مود نظر ب موفقیت حذف شد');
    }

    public function status(TicketPriority $priority)
    {

        $priority->status = $priority->status == 0 ? 1 : 0;
        $result = $priority->save();

        if ($result) {
            $message = $priority->status == 0 ? 'اولویت تیکت غیرفعال شد' : 'اولویت تیکت فعال شد';
            $alertType = $priority->status == 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $priority->status,
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
