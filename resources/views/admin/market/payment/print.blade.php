<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payment Details</title>
    <style>
        body {
            font-family: 'IRANSans', sans-serif;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 3px 6px;
            font-size: 12px;
        }

        /* Add more styles as needed */
    </style>
</head>
<body lang="fa">
<section class="header">
    <h3 class="text-center font-weight-bold">لیست کل تراکنش ها</h3>
</section>
<table class="display table table-striped table-bordered table-responsive-md table-hover">
    <thead>
    <tr>
        <th scope="col">شناسه</th>
        <th scope="col">مبلغ (ریال)</th>
        <th scope="col">تاریخ</th>
        <th scope="col">پرداخت کننده</th>
        <th scope="col">وضعیت</th>
        <th scope="col">نوع پرداخت</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ number_format($payment->amount) }}</td>
            <td>{{ persianDateTime($payment->created_at) }}</td>
            <td>{{ $payment->user->full_name }}</td>
            <td>
                @if($payment->status == \App\Constants\PaymentStatusType::RETURNED)
                    <button class="btn btn-danger">برگردانده شده</button>
                @elseif($payment->status === \App\Constants\PaymentStatusType::PAYED)
                    <button class="btn btn-success">پرداخت شده</button>
                @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                    <button class="btn btn-warning">در انتظار تایید</button>
                @elseif($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                    <button class="btn btn-info">لغو پرداخت شده</button>
                @endif
            </td>
            <td>
                @if($payment->paymentable_type == \App\Constants\PaymentTypeValue::OFFLINE_PAYMENT)
                    کارت به کارت
                @elseif($payment->paymentable_type == \App\Constants\PaymentTypeValue::CASH_PAYMENT)
                    پرداخت حضوری
                @elseif($payment->paymentable_type == \App\Constants\PaymentTypeValue::ONLINE_PAYMENT)
                    پرداخت آنلاین
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
