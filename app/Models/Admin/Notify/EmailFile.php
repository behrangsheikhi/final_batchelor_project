<?php

namespace App\Models\Admin\Notify;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailFile extends Model
{
    use SoftDeletes;

    protected $table = 'public_email_files';
    protected $fillable = [
        'public_email_id',
        'file_path',
        'file_size',
        'file_type',
        'status',
        'store_to'
    ];

    public function email() : BelongsTo
    {
        return $this->belongsTo(Email::class,'public_email_id');
    }
}
