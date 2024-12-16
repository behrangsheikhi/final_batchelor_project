<?php

namespace App\Models\Admin\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use  SoftDeletes;

    protected $table = 'cart_items';
    protected $fillable = [
        'user_id',
        'product_id',
        'product_color_id',
        'guaranty_id',
        'number'
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function guaranty(): BelongsTo
    {
        return $this->belongsTo(Guaranty::class, 'guaranty_id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    // calculate total product price based on all features
    public function cart_item_product_price(): float|int
    {
        $guaranty_price_increase = empty($this->guaranty_id) ? 0 : $this->guaranty->price_increase;
        $color_price_increase = empty($this->product_color_id) ? 0 : $this->color->price_increase;

        return $this->product->price + $guaranty_price_increase + $color_price_increase;
    }

    // product_price * (discountPercentage / 100)
    public function cart_item_product_discount(): float
    {
        $cart_item_product_price = $this->cart_item_product_price();
        $activeSale = $this->product->active_amazing_sales()->first();
        if (!$activeSale) {
            return 0;
        }
        $percentage = $activeSale->percentage ?? 0; // Providing a default value if percentage is null
        return $cart_item_product_price * ($percentage / 100);
    }


    // calculate entity of the products
    public function cart_item_final_price(): float|int
    {
        $cart_item_product_price = $this->cart_item_product_price();
        $product_discount = $this->cart_item_product_discount();
        return $this->number * ($cart_item_product_price - $product_discount);
    }

    // number * $product_discount(sum of all discounts on this cart items)
    public function cart_final_discount(): float|int
    {
        $product_discount = $this->cart_item_product_discount();
        return $this->number * $product_discount;
    }


}
