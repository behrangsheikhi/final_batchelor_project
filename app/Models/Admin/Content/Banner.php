<?php

namespace App\Models\Admin\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes,Sluggable;

    protected $table = 'banners';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'url',
        'position',
        'status'
    ];
    protected $keyType = 'integer';

    protected $casts = ['image' => 'array'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static array $position = [
        '1' => 'اسلاید شو (صفحه اصلی)',
        '2' => 'کنار اسلاید شو (صفحه اصلی)',
        '3' => 'دو بنر تبلیغی بین دو اسلایدر(صفحه اصلی)',
        '4' => 'بنر تبلیغی بزرگ مابین دو اسلایدر(صفحه اصلی)',
    ];

}
