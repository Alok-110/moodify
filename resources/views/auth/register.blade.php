<x-guest-layout>
    <div class="text-center mb-8">
        <a href="/" class="text-2xl font-extrabold text-purple-600">🎵 Moodify</a>
        <p class="text-sm text-gray-500 mt-1">Create your free account</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" id="register-form">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                minlength="2" maxlength="50"
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="Alok Dash">
            @error('name')
                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠ {{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="you@example.com">
            @error('email')
                <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠ {{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Password</label>
            <div class="relative">
                <input id="password" type="password" name="password" required minlength="8"
                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition pr-12"
                    placeholder="Min. 8 characters"
                    oninput="checkPasswordStrength(this.value)">
                <button type="button" onclick="togglePassword('password')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs font-semibold">
                    SHOW
                </button>
            </div>
            <!-- Password strength -->
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div id="strength-bar" class="h-full rounded-full transition-all duration-300" style="width:0%"></div>
            </div>
            <p id="strength-text" class="text-xs mt-1 text-gray-400"></p>
            @error('password')
                <p class="text-red-500 text-xs mt-1">⚠ {{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition"
                placeholder="Repeat password"
                oninput="checkPasswordMatch()">
            <p id="match-msg" class="text-xs mt-1 hidden"></p>
        </div>

        <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition text-sm">
            Create my account
        </button>

        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:text-purple-700">Sign in</a>
        </p>
    </form>

    <script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function checkPasswordStrength(val) {
        const bar = document.getElementById('strength-bar');
        const text = document.getElementById('strength-text');
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { pct: '25%', color: 'bg-red-400',    label: 'Weak',      textColor: 'text-red-500' },
            { pct: '50%', color: 'bg-orange-400',  label: 'Fair',      textColor: 'text-orange-500' },
            { pct: '75%', color: 'bg-yellow-400',  label: 'Good',      textColor: 'text-yellow-600' },
            { pct: '100%',color: 'bg-green-400',   label: 'Strong',    textColor: 'text-green-500' },
        ];
        if (val.length === 0) { bar.style.width = '0%'; text.textContent = ''; return; }
        const lvl = levels[Math.min(score - 1, 3)] || levels[0];
        bar.style.width = lvl.pct;
        bar.className = `h-full rounded-full transition-all duration-300 ${lvl.color}`;
        text.textContent = lvl.label;
        text.className = `text-xs mt-1 ${lvl.textColor}`;
    }

    function checkPasswordMatch() {
        const pw = document.getElementById('password').value;
        const cp = document.getElementById('password_confirmation').value;
        const msg = document.getElementById('match-msg');
        if (cp.length === 0) { msg.classList.add('hidden'); return; }
        msg.classList.remove('hidden');
        if (pw === cp) {
            msg.textContent = '✓ Passwords match';
            msg.className = 'text-xs mt-1 text-green-500';
        } else {
            msg.textContent = '✗ Passwords do not match';
            msg.className = 'text-xs mt-1 text-red-500';
        }
    }
    </script>
</x-guest-layout>