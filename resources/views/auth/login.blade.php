<x-guest-layout>
    <div class="text-center mb-8">
        <a href="/" class="text-2xl font-extrabold text-purple-600">🎵 Moodify</a>
        <p class="text-sm text-gray-500 mt-1">Welcome back! Sign in to continue</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-4 py-3 rounded-xl mb-5 flex items-center gap-2">
        ⚠ These credentials don't match our records.
        <a href="{{ route('register') }}" class="underline ml-auto text-red-600 hover:text-red-700">Register instead?</a>
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="you@example.com">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Password</label>
            <div class="relative">
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition pr-12"
                    placeholder="••••••••">
                <button type="button" onclick="togglePw()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs font-semibold">
                    SHOW
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-purple-600">
                Remember me
            </label>
        </div>

        <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition text-sm">
            Sign in to Moodify
        </button>

        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:text-purple-700">Sign up free</a>
        </p>
    </form>

    <script>
    function togglePw() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</x-guest-layout>