<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItemSelectedAttribute extends Model
{
    use SoftDeletes;

    protected $table = 'order_item_selected_attributes';
    protected $fillable = [
       'order_item_id','category_attribute_id','category_value_id','value'
    ];

    public function category_attribute(): BelongsTo
    {
        return $this->belongsTo(CategoryAttribute::class,'category_attribute_id');
    }

    public function category_attribute_value(): BelongsTo
    {
        return $this->belongsTo(CategoryValue::class,'category_value_id');
    }

}
