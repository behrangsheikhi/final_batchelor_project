<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Admin\Ticket\Ticket;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class TicketFileController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Ticket $ticket)
    {

        return view('admin.ticket.ticket-file',compact('ticket'));
    }



}
