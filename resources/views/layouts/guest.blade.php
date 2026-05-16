<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Moodify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased">

    @if(request()->is('/'))
        {{ $slot }}
    @else
        <div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 flex flex-col items-center justify-center px-4">

            <!-- Back to home -->
            <a href="/" class="text-2xl font-extrabold text-purple-600 mb-8 hover:text-purple-700 transition">
                🎵 Moodify
            </a>

            <!-- Card -->
            <div class="w-full max-w-md bg-white border border-gray-100 rounded-3xl shadow-sm p-8">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="text-xs text-gray-400 mt-6">© 2025 Moodify</p>
        </div>
    @endif

</body>
</html>