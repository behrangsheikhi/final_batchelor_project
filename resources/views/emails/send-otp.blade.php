<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Add your custom styles here */
        .email-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .email-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .email-body {
            padding: 20px;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn:hover {
            color: #fff;
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body style="text-align: right;">
<div class="email-container">
    <div class="email-header">
        <h1>{{ $details['title'] }}</h1>
    </div>
    <div class="email-body">
        <p>مشتری گرامی,</p>
        <p>{!! $details['body'] !!}</p>
        <p><a href="#" class="btn">تماس با ما</a></p>
        <p>با تشکر,<br>پشتیبانی راسته فرش</p>
    </div>
</div>
@include('emails.layouts.footer')
</body>
</html>
