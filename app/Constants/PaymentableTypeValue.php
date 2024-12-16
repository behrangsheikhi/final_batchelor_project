<?php

namespace App\Constants;

use App\Models\Admin\Market\CashPayment;
use App\Models\Admin\Market\OfflinePayment;
use App\Models\Admin\Market\OnlinePayment;

class PaymentableTypeValue
{
    public const ONLINE = OnlinePayment::class; // 1
    public const OFFLINE = OfflinePayment::class; // 2
    public const CASH = CashPayment::class; // 3
}
