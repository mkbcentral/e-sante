<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('components.layouts.patials.navbar')
        @include('components.layouts.patials.sidebar')
        <div class="content-wrapper">
            {{ $slot }}
        </div>
        @include('components.layouts.patials.footer')
    </div>
    <script src="{{ asset('moment/moment.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
    @stack('js')
</body>

</html>
