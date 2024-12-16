<?php

namespace App\Models;

use App\Models\Admin\Content\Post;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\Vendor;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nagy\LaravelRating\Traits\Rateable;

class Comment extends Model
{
    use SoftDeletes, Rateable;

    protected $table = 'comments';

    protected $fillable = [
        'body',
        'parent_id',
        'author_id',
        'vendor_id',
        'commentable_id',
        'commentable_type',
        'approved',
        'status'
    ];

    public function commentable(): MorphTo
    {
        // each comment belongs to something (posts and products)
        return $this->morphTo();
    }


    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'author_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
