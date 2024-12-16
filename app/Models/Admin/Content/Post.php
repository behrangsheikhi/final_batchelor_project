<?php

namespace App\Models\Admin\Content;

use App\Models\Comment;
use App\Models\Admin\Content\PostCategory;
use App\Models\Admin\Content\PostImage;
use App\Models\Tag;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nagy\LaravelRating\Traits\Rateable;

class Post extends Model
{
    use Sluggable, SoftDeletes, Rateable;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'image',
        'status',
        'commentable',
        'tags',
        'user_id',
        'post_category_id',
        'published_at', ''
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $casts = [
        'image' => 'array'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
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

    public function postImages(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
