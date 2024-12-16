<?php

namespace App\Models\Admin\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostImage extends Model
{
    use Sluggable;

    protected $table = 'post_images';
    protected $keyType = 'string';

    protected $fillable = [
        'image','post_id'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }


    public function sluggable(): array
    {
        // TODO: Implement sluggable() method.
    }
}
