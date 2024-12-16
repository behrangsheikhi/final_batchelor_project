<?php

namespace App\Models\Admin\Notify;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;

    protected $table = 'public_email';
    protected $fillable = [
        'subject', 'body', 'status', 'published_at'
    ];

    public function files() : HasMany
    {
        return $this->hasMany(EmailFile::class,'public_email_id');
    }

}
