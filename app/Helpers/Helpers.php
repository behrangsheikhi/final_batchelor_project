<?php

use App\Constants\UserTypeValue;
use App\Models\Admin\Market\AmazingSale;
use Hekmatinasser\Verta\Verta;

//function jalaliDate($date, $format = '%A %d %B %Y - H:i:s'): string
//{
//    return Jalalian::forge($date)->format($format);
//}

function persianDateTime($date, $format = 'H:i:s - Y/m/d'): string
{
    return \verta($date)->format($format);
}

function persianDate($date, $format = 'Y/m/d'): string
{
    return \verta($date)->format($format);
}

function convertPersianToEnglish($number): array|string
{
    $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $englishNumbers = range(0, 9);

    return str_replace($persianNumbers, $englishNumbers, $number);
}

function convertArabicToEnglish($number): array|string
{
    $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    $englishNumbers = range(0, 9);

    return str_replace($arabicNumbers, $englishNumbers, $number);
}

function convertEnglishToPersian($number): string
{
    $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return str_replace($englishDigits, $persianDigits, $number);
}

function priceFormat($price): string
{
    // Format the number with commas as thousand separators and no decimal places
    $formattedPrice = number_format($price, 0, '', '،');
    // Convert the English digits to Persian digits
    return convertEnglishToPersian($formattedPrice);
}

function validateNationalCode($nationalCode): bool
{
    $nationalCode = trim($nationalCode, ' .');
    $nationalCode = convertArabicToEnglish($nationalCode);
    $nationalCode = convertPersianToEnglish($nationalCode);
    $bannedArray = ['0000000000', '1111111111', '2222222222', '3333333333', '4444444444', '5555555555', '6666666666', '7777777777', '8888888888', '9999999999'];

    if (empty($nationalCode)) {
        return false;
    } else if (count(str_split($nationalCode)) != 10) {
        return false;
    } else if (in_array($nationalCode, $bannedArray)) {
        return false;
    } else {

        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            // 1234567890
            $sum += (int)$nationalCode[$i] * (10 - $i);
        }

        $divideRemaining = $sum % 11;

        if ($divideRemaining < 2) {
            $lastDigit = $divideRemaining;
        } else {
            $lastDigit = 11 - ($divideRemaining);
        }

        if ((int)$nationalCode[9] == $lastDigit) {
            return true;
        } else {
            return false;
        }

    }
}

function calculateFinalPrice($product)
{
    // Leverage the active_amazing_sales relationship
    $activeSale = $product->active_amazing_sales->first();

    if ($activeSale) {
        $discount = $activeSale->percentage / 100;
        return floatval($product->price * (1 - $discount));
    } else {
        // Handle no active sale scenario (optional)
        return $product->price;  // Return original price if no sale
    }
}
