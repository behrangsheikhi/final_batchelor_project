<?php

namespace App\Constants;

use App\Notifications\NewAdminCreated;
use App\Notifications\NewOrderCreated;
use App\Notifications\NewProductCreated;
use App\Notifications\NewUserRegistered;

class NotificationTypeValue
{
    public const NEW_USER_REGISTERED = NewUserRegistered::class; // اطلاعیه ثبت نام مشتری جدید در سایت
    public const NEW_ADMIN_CREATED = NewAdminCreated::class; // اطلاعیه ایجاد ادمین جدید
    public const NEW_PRODUCT_CREATED = NewProductCreated::class; // اعلان ثبت محصول جدید
    public const NEW_ORDER_CREATED = NewOrderCreated::class; // اعلان ثبت سفارش جدید





}
