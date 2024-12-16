<?php

namespace App\Models;

use App\Constants\UserTypeValue;
use App\Models\Admin\Content\Post;
use App\Models\Admin\Market\Address;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\CashPayment;
use App\Models\Admin\Market\Compare;
use App\Models\Admin\Market\OfflinePayment;
use App\Models\Admin\Market\OnlinePayment;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\OrderItem;
use App\Models\Admin\Market\Payment;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Ticket\Ticket;
use App\Models\Admin\Ticket\TicketAdmin;
use App\Traits\Permissions\HasPermissionTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Nagy\LaravelRating\Traits\CanRate;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use Sluggable;
    use HasPermissionTrait;
    use CanRate;


    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'mobile',
        'password',
        'national_code',
        'firstname',
        'lastname',
        'profile_photo_path',
        'activation',
        'user_type',
        'status',
        'email_verified_at',
        'mobile_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */


    // here web make slug from user firstname and lastname combination (fullname)
    // which ahas been made in upper line here!
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'fullname'
            ]
        ];
    }

    public function is_super_admin(): bool
    {
        if ($this->user_type === UserTypeValue::SUPER_ADMIN)
            return true;

        return false;
    }

    public function is_admin(): bool
    {
        if ($this->user_type === UserTypeValue::ADMIN)
            return true;

        return false;
    }

    public function is_vendor(): bool
    {
        if ($this->user_type === UserTypeValue::VENDOR)
            return true;

        return false;
    }

    public function is_customer(): bool
    {
        if ($this->user_type === UserTypeValue::CUSTOMER)
            return true;

        return false;
    }

    public function before($ability): bool
    {
        if ($this->is_super_admin())
            return true;

        return false;
    }


    public function getFullNameAttribute(): string
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    // here we set a default address method for user for example his/her home address
    public function defaultAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'default_address_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }


    public function ticketAdmin(): HasOne
    {
        return $this->hasOne(TicketAdmin::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }


    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function online_payments(): HasMany
    {
        return $this->hasMany(OnlinePayment::class);
    }

    public function cash_payments(): HasMany
    {
        return $this->hasMany(CashPayment::class);
    }

    public function offline_payments(): HasMany
    {
        return $this->hasMany(OfflinePayment::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }

    public function cart_items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }



    public function is_user_purchased_this_product($product_id): Collection
    {
        $product_ids = collect();
        foreach ($this->items()->where('product_id', $product_id)->get() as $item) {
            $product_ids->push($item->product_id);
        }
        return $product_ids->unique();
    }

    public function compares(): HasMany
    {
        return $this->hasMany(Compare::class);
    }


}
