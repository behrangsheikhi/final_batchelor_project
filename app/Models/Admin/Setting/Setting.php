<?php

namespace App\Models\Admin\Setting;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'title', 'description', 'keywords','logo', 'icon','phone',  'email', 'address'
    ];
    protected $casts = [
        'logo' => 'array',
        'icon' => 'array'
    ];
}
