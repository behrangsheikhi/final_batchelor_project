<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use SoftDeletes, Notifiable;

    protected $table = 'orders';
    protected $guarded = [
        'id'
    ];


    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function delivery_method(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_method_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function common_discount(): BelongsTo
    {
        return $this->belongsTo(CommonDiscount::class, 'common_discount_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPaymentStatusValueAttribute(): string
    {
        return match ($this->payment_status) {
            0 => 'مرجوع شده',
            1 => 'لغو شده',
            2 => 'پرداخت شده',
            default => 'در انتظار تایید'
        };
    }


    public function getDeliveryStatusValueAttribute(): string
    {
        return match ($this->delivery_status) {
            0 => 'ارسال نشده',
            1 => 'در حال ارسال',
            2 => 'ارسال شده',
            default => 'تحویل شده',
        };
    }


    public function getOrderStatusValueAttribute(): string
    {
        return match ($this->order_status) {
            1 => 'در انتظار تایید', // pending
            2 => 'تاییده نشده', // declined
            3 => 'تایید شده', // verified
            4 => 'لغو شده', // canceled
            5 => 'مرجوع شده', // returned
            default => 'بررسی نشده', // not checked
        };
    }

    public function getPaymentTypeValueAttribute(): string
    {
        return match ($this->payment_type) {
            1 => 'پرداخت آنلاین',
            2 => 'کارت به کارت',
            3 => 'پرداخت در محل',
            default => 'نامعتبر'
        };
    }


}
