<?php

namespace App\Models\Admin\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class   Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'subject',
        'description',
        'status',
        'reference_id',
        'user_id',
        'ticket_category_id',
        'ticket_priority_id',
        'ticket_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function admin(): BelongsTo
    {
        return $this->belongsTo(TicketAdmin::class, 'reference_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'ticket_id')->with('parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany($this, 'ticket_id')->with('children');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class,'ticket_category_id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(TicketPriority::class,'ticket_priority_id');
    }


    public function file(): HasOne
    {
        return $this->hasOne(TicketFile::class);
    }


}
