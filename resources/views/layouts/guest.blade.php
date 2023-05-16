<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container mx-auto">
            <div class="grid grid-cols-4 gap-6">
                <div class="col-span-4">
                    <h1>Labdarúgó bajnokság</h1>
                    <nav>
                        @auth
                            <nav class="bg-white px-8 pt-2 shadow-md">
                            <div class="-mb-px flex justify-center">
                            <a class="hover:underline text-teal-dark border-b-2 border-teal-dark uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{ route('games.index')}}">Mérkőzések</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{route('teams.index')}}">Csapatok</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{route('tabella.index')}}">Tabella</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{route('kedvencek.index')}}">Kedvenceim</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8">Kijelentkezés</button>
                            </form>
                            </div>
                            </nav>
                        @endauth
                        @guest
                        <nav class="bg-white px-8 pt-2 shadow-md">
                            <div class="-mb-px flex justify-center">
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{ route('games.index')}}">Mérkőzések</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{route('teams.index')}}">Csapatok</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{route('tabella.index')}}">Tabella</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{ route('login') }}">Kedvenceim</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{ route('login') }}">Bejelentkezés</a>
                                <a class="hover:underline text-grey-dark border-b-2 border-transparent uppercase tracking-wide font-bold text-base py-3 mr-8" href="{{ route('register') }}">Regisztráció</a>
                            </div>
                        </nav>
                        @endguest
                </div>
                    </nav>
                <div class="col-span-4">
                    {{ $slot }}
                </div>
                                
                </div>
            </div>
        </div>
    </body>
</html>
