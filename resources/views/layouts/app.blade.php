<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Moodify</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <!-- Sidebar + Content wrapper -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-60 bg-white border-r border-gray-100 flex flex-col py-6 px-4 fixed h-full">
            <div class="text-lg font-extrabold text-purple-600 mb-10 px-2">🎵 Moodify</div>
            <nav class="flex flex-col gap-1">
                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->is('dashboard') ? 'bg-purple-50 text-purple-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="/discover" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->is('discover') ? 'bg-purple-50 text-purple-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Discover
                </a>
                <a href="/playlists" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->is('playlists') ? 'bg-purple-50 text-purple-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    My Playlists
                </a>
                <a href="/profile" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->is('profile') ? 'bg-purple-50 text-purple-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </a>
            </nav>

            <!-- Logout at bottom -->
            <div class="mt-auto px-2">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-semibold text-gray-400 hover:text-red-500 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content -->
        <main class="ml-60 flex-1 px-10 py-8">
            {{ $slot }}
        </main>

    </div>

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