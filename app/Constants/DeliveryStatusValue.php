<?php

namespace App\Constants;

class DeliveryStatusValue
{
    public const NOT_SENT = 0; // ارسال نشده
    public const SENDING = 1; // در حال ارسال
    public const SENT = 2; // ارسال شده
    public const DELIVERED = 3; // تحویل داده شده
}
