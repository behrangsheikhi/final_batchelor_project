<?php

namespace App\Models\Admin\Ticket;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketPriority extends Model
{
    use SoftDeletes;

    protected $table = 'ticket_priorities';

    protected $fillable = [
        'name','status'
    ];

    public function tickets() : HasMany
    {
        return $this->hasMany(Ticket::class,'ticket_priority_id');
    }
}
