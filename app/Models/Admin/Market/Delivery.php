<?php

namespace App\Models\Admin\Market;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    protected $table = 'delivery_methods';
    protected $fillable = [
        'name',
        'amount',
        'delivery_time',
        'delivery_time_unit',
        'status',
        'description'
    ];


}
