<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> {{ config('app.name') }} </title>
    <link rel="stylesheet" href="{{ public_path('bootstrap-4.6.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('print-receipt-format.css') }}">
</head>

<body>
    {{ $slot }}
</body>

</html>
