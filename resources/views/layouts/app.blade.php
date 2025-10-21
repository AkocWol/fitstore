<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'FitStore'))</title>

    {{-- Bootstrap CSS + Bootstrap Icons via CDN (snel en direct werkend) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    {{-- Navigatie (optioneel) --}}
    @includeIf('layouts.navigation')

    {{-- Optionele page header --}}
    @hasSection('header')
        <header class="bg-white border-bottom py-3">
            <div class="container">
                @yield('header')
            </div>
        </header>
    @endif

    {{-- Inhoud vult de resterende hoogte; footer zakt naar onderen --}}
    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')

            {{-- Test-icoon (mag je verwijderen): --}}
            {{-- <i class="bi bi-bag-heart fs-3 text-primary"></i> --}}
        </div>
    </main>

    {{-- Sticky footer (onderaan) --}}
    @includeIf('layouts.footer')

    {{-- Bootstrap JS (bundle met Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
