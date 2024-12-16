<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
{{--    @include('dashboard.layout.head-tag')--}}
    <tite>مهمان</tite>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
</div>


@include('dashboard.layout.scripts')
</body>
</html>
