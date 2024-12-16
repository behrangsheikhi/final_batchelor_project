<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashPayment extends Model
{
    use SoftDeletes;

    protected $table = 'cash_payments';
    protected $fillable = [
        'amount','user_id','cash_receiver','pay_date','status'
    ];

    public function payments() : MorphMany
    {
        return $this->morphMany(Payment::class,'paymentable');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
