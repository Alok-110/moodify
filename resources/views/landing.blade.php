<x-guest-layout>

  <!-- Navbar -->
  <nav class="flex items-center justify-between px-8 py-4 border-b border-gray-100">
    <div class="text-xl font-extrabold text-purple-600">🎵 Moodify</div>
    <div class="flex items-center gap-3">
      <a href="/login" class="text-sm text-gray-500 hover:text-gray-800 px-4 py-2 rounded-full border border-gray-200 hover:border-gray-300 transition">Login</a>
      <a href="/register" class="text-sm font-semibold bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full transition">Get started free</a>
    </div>
  </nav>

  <!-- Hero -->
  <section class="text-center px-6 pt-20 pb-12">
    <div class="inline-flex items-center gap-2 bg-purple-50 text-purple-700 text-xs font-semibold px-4 py-2 rounded-full border border-purple-100 mb-6">
      ✨ Music that understands you
    </div>
    <h1 class="text-5xl font-extrabold text-gray-900 leading-tight mb-5">
      The right music for<br>
      <span class="text-purple-600">every mood</span>
    </h1>
    <p class="text-gray-500 text-lg max-w-lg mx-auto mb-10 leading-relaxed">
      Moodify curates playlists based on how you feel right now. Pick your mood and let the music flow.
    </p>
    <div class="flex items-center justify-center gap-4 mb-14">
      <a href="/register" class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-8 py-4 rounded-full text-base transition">
        Start listening free
      </a>
      <a href="#features" class="bg-purple-50 hover:bg-purple-100 text-purple-700 font-semibold px-8 py-4 rounded-full text-base border border-purple-100 transition">
        See how it works
      </a>
    </div>

    <!-- Mood Pills -->
    <div class="flex justify-center gap-3 flex-wrap">
      <span class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-yellow-50 text-yellow-800 border-2 border-yellow-200 text-sm font-semibold">😊 Happy</span>
      <span class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-50 text-blue-800 border-2 border-blue-200 text-sm font-semibold">😌 Chill</span>
      <span class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-pink-50 text-pink-800 border-2 border-pink-200 text-sm font-semibold">😢 Sad</span>
      <span class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-green-50 text-green-800 border-2 border-green-200 text-sm font-semibold">⚡ Energetic</span>
      <span class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-purple-50 text-purple-800 border-2 border-purple-200 text-sm font-semibold">🎯 Focused</span>
    </div>
  </section>

  <!-- Features -->
  <section id="features" class="max-w-5xl mx-auto px-6 pb-24 pt-8">
    <h2 class="text-center text-3xl font-extrabold text-gray-900 mb-12">Everything you need to vibe</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-gray-50 border border-gray-100 rounded-2xl p-7 hover:border-purple-200 hover:bg-purple-50 transition">
        <div class="text-4xl mb-4">🎭</div>
        <h3 class="text-base font-bold text-gray-900 mb-2">Mood-based playlists</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Tell us how you feel and we'll build the perfect playlist instantly.</p>
      </div>
      <div class="bg-gray-50 border border-gray-100 rounded-2xl p-7 hover:border-purple-200 hover:bg-purple-50 transition">
        <div class="text-4xl mb-4">🧠</div>
        <h3 class="text-base font-bold text-gray-900 mb-2">Learns your taste</h3>
        <p class="text-sm text-gray-500 leading-relaxed">The more you listen, the smarter your recommendations become.</p>
      </div>
      <div class="bg-gray-50 border border-gray-100 rounded-2xl p-7 hover:border-purple-200 hover:bg-purple-50 transition">
        <div class="text-4xl mb-4">🔍</div>
        <h3 class="text-base font-bold text-gray-900 mb-2">Discover new music</h3>
        <p class="text-sm text-gray-500 leading-relaxed">Browse by genre, mood, or artist and find your next favourite song.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="border-t border-gray-100 text-center py-6 text-sm text-gray-400">
    © 2025 Moodify — Built with Laravel
  </footer>

</x-guest-layout>