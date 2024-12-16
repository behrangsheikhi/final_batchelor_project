<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'province_id',
        'city_id',
        'address',
        'no',
        'unit',
        'postal_code',
        'recipient_first_name',
        'recipient_last_name',
        'mobile',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->recipient_first_name . " " . $this->recipient_last_name;
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function province() : BelongsTo
    {
        return $this->belongsTo(Province::class,'province_id');
    }


}
