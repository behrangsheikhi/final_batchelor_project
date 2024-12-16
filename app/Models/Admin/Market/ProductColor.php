<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{
    use SoftDeletes;

    protected $table = 'product_colors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'color_name',
        'color',
        'product_id',
        'price_increase',
        'status',
        'sold_number',
        'frozen_number',
        'marketable_number'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

}
