<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazingSale extends Model
{
    use SoftDeletes;

    protected $table = 'amazing_sales';
    protected $fillable = [
        'product_id','percentage','status','start_date','end_date'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }


}
