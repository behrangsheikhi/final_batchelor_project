<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ticket\TicketRequest;
use App\Models\Admin\Ticket\Ticket;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{


    public function newTickets()
    {

        $tickets = Ticket::where('seen', 0)->get();
        foreach ($tickets as $item) {
            $item->seen = 1;
            $result = $item->save();
        }
        return view('admin.ticket.index', compact('tickets'));
    }


    public function openTickets()
    {

        $tickets = Ticket::where('status', 0)->get();

        return view('admin.ticket.index', compact('tickets'));
    }

    public function closedTickets()
    {

        $tickets = Ticket::where('status', 1)->get();
        return view('admin.ticket.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {

        return view('admin.ticket.show', compact('ticket'));
    }

    public function index()
    {

        $tickets = Ticket::whereTicketId(null)->orderByDesc('created_at')->get();

        return view('admin.ticket.index', compact('tickets'));
    }

    public function change(Ticket $ticket)
    {

        $ticket->status = $ticket->status == 0 ? 1 : 0;
        $ticket->save();

        return redirect()->route('admin.ticket.index')->with('swal-success', $ticket->status === 0 ? 'تیکت با موفقیت بسته شد' : 'تیکت با موفقیت باز شد');
    }

    public function answer(TicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticketAdmin = Auth::user()->ticketAdmin;
        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['seen'] = 1;
        $inputs['reference_id'] = $ticketAdmin->id;
        $inputs['user_id'] = $ticket->user_id;
        $inputs['ticket_category_id'] = $ticket->ticket_category_id;
        $inputs['ticket_priority_id'] = $ticket->ticket_priority_id;
        $inputs['ticket_id'] = $ticket->id;
        $ticket = Ticket::create($inputs);

        return redirect()->route('admin.ticket.index')->with('swal-success', 'پاسخ شما با موفقیت ثبت شد');
    }


}
