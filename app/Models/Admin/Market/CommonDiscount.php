<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonDiscount extends Model
{
    use SoftDeletes;

    protected $table = 'common_discounts';
    protected $fillable = [
        'title',
        'percentage',
        'discount_ceiling',
        'minimum_order_amount',
        'status',
        'start_date',
        'end_date'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}
