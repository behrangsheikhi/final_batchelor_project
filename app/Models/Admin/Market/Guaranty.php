<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guaranty extends Model
{
    use SoftDeletes;

    protected $table = 'guaranties';
    protected $fillable = [
        'name','product_id','price_increase','status'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }


}
