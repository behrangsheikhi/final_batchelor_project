<?php

namespace App\Constants;

use App\Models\Admin\Content\Post;
use App\Models\Admin\Market\Product;

class CommentTypeValue
{
    public const CONTENT_COMMENT = Post::class; // belongs to blog section
    public const PRODUCT_COMMENT = Product::class; // belongs to product section
}
