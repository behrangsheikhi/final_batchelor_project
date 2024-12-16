<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    protected $table = 'order_items';
    protected $guarded = [
        'id'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function single_product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function amazing_sale(): BelongsTo
    {
        return $this->belongsTo(AmazingSale::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class,'color_id');
    }

    public function guaranty(): BelongsTo
    {
        return $this->belongsTo(Guaranty::class,'guaranty_id');
    }

    public function order_item_attributes(): HasMany
    {
        return $this->hasMany(OrderItemSelectedAttribute::class);
    }


}
