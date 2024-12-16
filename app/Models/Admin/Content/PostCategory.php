<?php

namespace App\Models\Admin\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Faker\Core\Uuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use Sluggable, SoftDeletes;

    protected $table = 'post_categories';
    protected $primaryKey = 'id';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name', 'description', 'slug', 'image', 'status', 'tags'
    ];


    protected $casts = [
        'image' => 'array'
    ];

    public function newUniqueId() : string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid4();
    }

    public function uniqueIds(): array
    {
        return ['id'];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
