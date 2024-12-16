<?php

namespace App\Models\Admin\Notify;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SMS extends Model
{
    use SoftDeletes;

    protected $table = 'public_sms';
    protected $fillable = [
        'title', 'body', 'status', 'published_at'
    ];
}
