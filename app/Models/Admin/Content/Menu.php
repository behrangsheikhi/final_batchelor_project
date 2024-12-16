<?php

namespace App\Models\Admin\Content;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;


    protected $table = 'menus';
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'status', 'parent_id', 'url'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this,'parent_id')->with('parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany($this,'parent_id')->with('children');
    }
}
