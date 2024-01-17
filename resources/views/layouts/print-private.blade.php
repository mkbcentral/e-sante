<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> {{ config('app.name') }} </title>

    <!-- Favicon -->
    <link rel="icon" href="./images/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('print.css') }}">
</head>

<body>
    <div class="invoice-box">
        {{ $slot }}
    </div>
</body>

</html>
