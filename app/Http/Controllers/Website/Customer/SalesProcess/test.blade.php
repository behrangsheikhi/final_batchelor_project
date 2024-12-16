<?php

<td class="text-sm product-discount font-weight-bold align-middle text-{{ $item->product->active_amazing_sales ? 'danger': 'dark' }}">
    @if($item->product->active_amazing_sales->isNotEmpty())
    {{ priceFormat(calculateAmazingSaleDiscount($item->product)) }} ریال تخفیف شگفت انگیز
    @else
    -
    @endif
    <hr>
    @php
    $valid_common_discount = $item->cart_item_common_discount();
    @endphp
    @if($valid_common_discount)
    {{ priceFormat($valid_common_discount) }} ریال تخفیف عمومی
    @else
    -
    @endif
</td>