<x-app-layout>

<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-gray-900">Profile & Settings</h1>
    <p class="text-sm text-gray-400 mt-0.5">Manage your account details</p>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl mb-6">
    ✓ {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-3 gap-6 items-start">

    <!-- Left col -->
    <div class="col-span-1 flex flex-col gap-4">

        <!-- Avatar card -->
        <div class="bg-white border border-gray-100 rounded-2xl p-8 flex flex-col items-center text-center">
            <div class="w-24 h-24 rounded-full bg-purple-600 flex items-center justify-center mb-4 shadow-sm flex-shrink-0">
                <span class="text-3xl font-extrabold text-white leading-none">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
            <p class="text-lg font-extrabold text-gray-900 mt-1">{{ $user->name }}</p>
            <p class="text-sm text-gray-400 mt-1 break-all">{{ $user->email }}</p>
            <div class="mt-4 pt-4 border-t border-gray-50 w-full">
                <p class="text-xs text-gray-400">Member since {{ $memberSince }}</p>
            </div>
        </div>

        <!-- Stats card -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Your stats</h2>
            <div class="space-y-1">
                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Songs played</span>
                    <span class="text-sm font-extrabold text-gray-900">{{ $totalPlayed }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Playlists</span>
                    <span class="text-sm font-extrabold text-gray-900">{{ $playlistCount }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-500">Top mood</span>
                    <span class="text-sm font-extrabold text-purple-600">{{ $topMood ?? 'None yet' }}</span>
                </div>
            </div>
        </div>

        <!-- Quick links -->
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Quick links</h2>
            <div class="space-y-2">
                <a href="/discover" class="flex items-center gap-3 text-sm text-gray-600 hover:text-purple-600 py-2 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Discover music
                </a>
                <a href="/playlists" class="flex items-center gap-3 text-sm text-gray-600 hover:text-purple-600 py-2 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    My playlists
                </a>
                <a href="/dashboard" class="flex items-center gap-3 text-sm text-gray-600 hover:text-purple-600 py-2 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
            </div>
        </div>

    </div>

    <!-- Right col -->
    <div class="col-span-2 flex flex-col gap-6">

        <!-- Update profile -->
        <div class="bg-white border border-gray-100 rounded-2xl p-7">
            <h2 class="text-base font-extrabold text-gray-900 mb-1">Account details</h2>
            <p class="text-xs text-gray-400 mb-6">Update your name and email address</p>
            <form method="POST" action="/profile" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition bg-gray-50 focus:bg-white">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition bg-gray-50 focus:bg-white">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition">
                        Save changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Change password -->
        <div class="bg-white border border-gray-100 rounded-2xl p-7">
            <h2 class="text-base font-extrabold text-gray-900 mb-1">Change password</h2>
            <p class="text-xs text-gray-400 mb-6">Use a strong password with at least 8 characters</p>
            <form method="POST" action="/profile/password" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Current password</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition bg-gray-50 focus:bg-white"
                        placeholder="••••••••">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">New password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition bg-gray-50 focus:bg-white"
                            placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Confirm password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition bg-gray-50 focus:bg-white"
                            placeholder="••••••••">
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition">
                        Update password
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger zone -->
        <div class="bg-white border border-red-100 rounded-2xl p-7">
            <h2 class="text-base font-extrabold text-red-500 mb-1">Danger zone</h2>
            <p class="text-xs text-gray-400 mb-5">Permanently delete your account and all your data. This cannot be undone.</p>
            <button onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-bold px-5 py-2.5 rounded-xl border border-red-200 transition">
                Delete account
            </button>
        </div>

    </div>
</div>

<!-- Delete modal -->
<div id="delete-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
        <h2 class="text-lg font-extrabold text-gray-900 mb-2">Delete your account?</h2>
        <p class="text-sm text-gray-500 mb-6">All your playlists and listening history will be permanently deleted.</p>
        <form method="POST" action="/profile" class="space-y-4">
            @csrf
            @method('DELETE')
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Enter password to confirm</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-400 outline-none text-sm transition"
                    placeholder="••••••••">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3">
                <button type="button"
                    onclick="document.getElementById('delete-modal').classList.add('hidden')"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold py-3 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-3 rounded-xl transition">
                    Yes, delete
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>