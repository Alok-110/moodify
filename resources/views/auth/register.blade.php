<x-guest-layout>

    <div class="text-center mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900">Create your account 🎵</h1>
        <p class="text-sm text-gray-500 mt-1">Free forever. No credit card needed.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="Your name">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="Min. 8 characters">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="Repeat password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition text-sm">
            Create my account
        </button>

        <!-- Login link -->
        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-700">Sign in</a>
        </p>
    </form>

</x-guest-layout>