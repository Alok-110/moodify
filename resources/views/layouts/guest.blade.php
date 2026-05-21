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
    <!-- Toast System -->
<div id="toast-container" class="fixed top-5 right-5 z-[100] flex flex-col gap-2"></div>
<script>
function showToast(message, type = 'success') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-amber-500'
    };
    const toast = document.createElement('div');
    toast.className = `${colors[type]} text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 transition-all duration-300 translate-x-0`;
    toast.innerHTML = `<span>${message}</span><button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100">✕</button>`;
    document.getElementById('toast-container').appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

// Auto-show Laravel session flash toasts
@if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
@if(session('error'))   showToast("{{ session('error') }}", 'error'); @endif
@if(session('info'))    showToast("{{ session('info') }}", 'info'); @endif
</script>
</body>
</html>