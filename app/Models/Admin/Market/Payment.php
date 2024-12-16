<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'payments';

    protected $fillable = [
        'amount', 'user_id', 'status', 'type','paymentable_type','paymentable_id'
    ];

    public function paymentable() : MorphTo
    {
        return $this->morphTo();
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getPaymentTypeValueAttribute(): string
    {
        return match ($this->paymentable_type) {
            OnlinePayment::class => 'پرداخت آنلاین',
            OfflinePayment::class => 'کارت به کارت',
            CashPayment::class => 'پرداخت در محل',
            default => 'پرداخت نامعتبر'
        };
    }

}
