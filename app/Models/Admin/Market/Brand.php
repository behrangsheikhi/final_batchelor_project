<?php

namespace App\Models\Admin\Market;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use Sluggable, SoftDeletes;

    protected $table = 'brands';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'persian_name', 'original_name', 'slug', 'logo', 'status', 'tags'
    ];

    protected $casts = [
        'logo' => 'array'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'original_name'
            ]
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
