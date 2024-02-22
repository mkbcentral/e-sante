<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/css/main.css'])
    @livewireStyles
</head>

<body class="hold-transition py-4" style="background: url({{asset('bg-afia.svg')}});background-size:cover;background-repeat: no-repeat">
    <div class="d-flex justify-content-center align-items-center">
        @livewire('application.navigation.app-main-menu-link')
    </div>
</body>
</html>
