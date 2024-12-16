<?php

namespace App\Models\Admin\Market;

use App\Constants\CommentApproveValue;
use App\Constants\CommentTypeValue;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nagy\LaravelRating\Traits\Rateable;

class Product extends Model
{
    use  Sluggable, SoftDeletes, Rateable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $table = 'products';
    protected $fillable = [
        'name',
        'view',
        'introduction',
        'slug',
        'image',
        'status',
        'tags',
        'weight',
        'length',
        'width',
        'height',
        'price',
        'marketable',
        'sold_number',
        'frozen_number',
        'marketable_number',
        'brand_id',
        'product_category_id',
        'published_at'
    ];

    protected $casts = [
        'image' => 'array'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function comments(): MorphMany
    {
        // post has many comments
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function metas(): HasMany
    {
        return $this->hasMany(ProductMeta::class);
    }

    public function guaranties(): HasMany
    {
        return $this->hasMany(Guaranty::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(CategoryValue::class);
    }

    public function amazing_sales(): HasMany
    {
        return $this->hasMany(AmazingSale::class);
    }

    public function active_amazing_sales(): HasMany
    {
        return $this->amazing_sales()
            ->where('status', 1)
            ->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now());
    }


    public function approved_comments()
    {
        return $this->comments()->where('commentable_type', Product::class)->where('approved', CommentApproveValue::APPROVED)->whereParentId(null)->get();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function compare(): BelongsToMany
    {
        return $this->belongsToMany(Compare::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(ProductColor::class);
    }
}
