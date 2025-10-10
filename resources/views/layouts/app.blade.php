<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart School</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div id="app">
        <nav class="bg-white shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <a class="text-xl font-bold text-blue-600" href="{{ url('/') }}">
                        <i class="fas fa-school mr-2"></i>SmartSchool
                    </a>
                    <div>
                        @guest
                            @if (Route::has('login'))
                                <a class="text-gray-600 hover:text-blue-600"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif
                            @if (Route::has('register'))
                                <a class="ml-4 text-gray-600 hover:text-blue-600"
                                    href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-12">
            @yield('content')
        </main>
    </div>
</body>

</html>
