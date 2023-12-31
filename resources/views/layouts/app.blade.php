<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- link icone bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Usando Vite -->
    @vite(['resources/js/back.js'])
</head>

<body>
    <div>
        @include('layouts.partials.navbar')

        <main class="container">
            {{-- variabile flash per messaggio visivo all'utente(alert) --}}
            @if (session('message'))
                <div class="alert alert-{{ session('message_type') ? session('message_type') : 'success' }} my-3">
                    {{-- uso l'operatore ternario per definire il colore dell'alert in base al message_type --}}
                    {{ session('message') }}
                </div>
            @endif

            @yield('title')
            @yield('content')
        </main>
    </div>
    @yield('modals')
    @yield('script')
</body>

</html>
