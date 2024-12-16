<?php

namespace App\Models\Admin\Market;

use App\Models\Comment;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorBranch extends Model
{
    use Sluggable, SoftDeletes;

    protected $table = 'vendor_branches';
    protected $primaryKey = 'id';
    protected $keyType = 'string';


    protected $fillable = [
        'name', 'vendor_id', 'status'
    ];


    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


}
