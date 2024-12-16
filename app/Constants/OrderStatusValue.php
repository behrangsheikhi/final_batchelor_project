<?php

namespace App\Constants;

class   OrderStatusValue
{
    public const NOT_CHECKED = 0; // بررسی نشده
    public const PENDING_FOR_VERIFY = 1; // در انتظار تایید
    public const DECLINED = 2; // تایید نشده
    public const VERIFIED = 3; // تایید شده
    public const CANCELED = 4; // باظل شده
    public const RETURNED = 5; // مرجوع شده
}
