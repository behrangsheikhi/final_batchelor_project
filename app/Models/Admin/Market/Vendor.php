<?php

namespace App\Models\Admin\Market;

use App\Models\Comment;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use Sluggable, SoftDeletes;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'commercial_name'
            ]
        ];
    }

    protected $table = 'vendors';

    protected $guarded = [
        'id',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->firstname . " " . $this->lastname;
    }


    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function branches() : HasMany
    {
        return $this->hasMany(Store::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class,'city_id');
    }

}
