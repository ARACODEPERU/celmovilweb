<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('img/isotipo.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @php
        $parts = explode('::', $page['component']);
    @endphp
    @if (count($parts) > 1)
        @vite(['resources/js/app.js', "Modules/{$parts[0]}/Resources/assets/js/Pages/{$parts[1]}.vue"])
    @else
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @endif
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>
<script>
    window.assetUrl = @json(asset(''));
</script>

</html>
