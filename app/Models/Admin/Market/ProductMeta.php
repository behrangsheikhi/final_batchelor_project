<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMeta extends Model
{
    use SoftDeletes;

    protected $table = 'product_metas';

    protected $fillable = [
        'meta_key','meta_value','product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
