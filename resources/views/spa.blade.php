<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!-- TO-DO 
        <link rel="stylesheet" href="assetsjavi/bootstrap/css/bootstrap.min.css">
        --> 
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- TO-DO FIN -->
    </head>
    <body>
        <div id="app"></div>
        <script>
            window.config = @json([
                'appName' => config('app.name'),
                'deviceName' => 'spa'
            ])
        </script>
        <!-- TO-DO 
            <script src="assetsjavi/bootstrap/js/bootstrap.min.js"></script>
            <script src="assetsjavi/js/chart.min.js"></script>
            <script src="assetsjavi/js/bs-init.js"></script>
            <script src="assetsjavi/js/theme.js"></script>

        -->
        <script src="{{ asset("js/app.js") }}" charset="utf-8"></script>
        <!-- TO-DO FIN -->
    </body>
</html>
