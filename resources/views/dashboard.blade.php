<x-app-layout>

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Good evening, {{ Auth::user()->name }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">What do you want to listen to today?</p>
        </div>
        <!-- Search bar — redirects to Discover -->
        <form method="GET" action="/discover">
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Search songs, artists..."
                    class="pl-9 pr-4 py-2 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-100 w-64 transition">
            </div>
        </form>
    </div>

    <!-- Mood Selector -->
    <section class="mb-10">
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Pick your mood</h2>
        <div class="grid grid-cols-5 gap-3">
            @foreach([
                ['label' => 'Happy',     'slug' => 'happy',     'bg' => 'bg-amber-100',  'text' => 'text-amber-700',  'border' => 'border-amber-200',  'dot' => 'bg-amber-400'],
                ['label' => 'Sad',       'slug' => 'sad',       'bg' => 'bg-blue-100',   'text' => 'text-blue-700',   'border' => 'border-blue-200',   'dot' => 'bg-blue-400'],
                ['label' => 'Energetic', 'slug' => 'energetic', 'bg' => 'bg-red-100',    'text' => 'text-red-700',    'border' => 'border-red-200',    'dot' => 'bg-red-400'],
                ['label' => 'Chill',     'slug' => 'chill',     'bg' => 'bg-teal-100',   'text' => 'text-teal-700',   'border' => 'border-teal-200',   'dot' => 'bg-teal-400'],
                ['label' => 'Focused',   'slug' => 'focused',   'bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'dot' => 'bg-purple-400'],
            ] as $mood)
            <a href="/mood?mood={{ $mood['slug'] }}"
               class="{{ $mood['bg'] }} {{ $mood['text'] }} border {{ $mood['border'] }} rounded-2xl px-4 py-4 text-sm font-bold hover:scale-105 active:scale-95 transition-transform text-left block">
                <div class="w-2 h-2 rounded-full {{ $mood['dot'] }} mb-3"></div>
                {{ $mood['label'] }}
            </a>
            @endforeach
        </div>
    </section>

    <!-- Recently Played -->
    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Recently played</h2>
            <a href="/discover" class="text-xs font-semibold text-purple-600 hover:text-purple-700">See all</a>
        </div>

        @if($recentSongs->count())
        <div class="grid grid-cols-4 gap-4">
            @foreach($recentSongs as $song)
            <div class="bg-white border border-gray-100 rounded-2xl p-3 hover:border-gray-200 hover:shadow-sm transition cursor-pointer group"
                 onclick="playSong('{{ $song->preview_url }}', '{{ addslashes($song->title) }}', '{{ addslashes($song->artist) }}', '{{ $song->artwork_url }}')">

                <!-- Album Art -->
                <div class="w-full aspect-square rounded-xl mb-3 relative overflow-hidden bg-gray-100">
                    @if($song->artwork_url)
                        <img src="{{ $song->artwork_url }}" alt="{{ $song->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                    @endif
                    <!-- Hover play overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 text-gray-900 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <p class="text-sm font-bold text-gray-900 truncate">{{ $song->title }}</p>
                <p class="text-xs text-gray-400 truncate mt-0.5">{{ $song->artist }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center">
            <p class="text-sm text-gray-400 mb-3">No listening history yet</p>
            <a href="/discover" class="inline-block text-sm font-semibold text-purple-600 hover:text-purple-700">
                Browse songs to get started →
            </a>
        </div>
        @endif
    </section>

    <!-- Quick Stats -->
    <section>
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Your stats</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-400 mb-1">Songs played</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $totalPlayed }}</p>
                <p class="text-xs text-green-500 font-semibold mt-1">↑ {{ $playedThisWeek }} this week</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-400 mb-1">Playlists created</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $playlistCount }}</p>
                <p class="text-xs text-purple-500 font-semibold mt-1">{{ $moodPlaylistCount }} mood-based</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-5">
                <p class="text-xs font-semibold text-gray-400 mb-1">Top mood</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $topMood ?? 'None yet' }}</p>
                <p class="text-xs text-teal-500 font-semibold mt-1">based on your history</p>
            </div>
        </div>
    </section>

    <!-- Mini Player (same as Discover page) -->
    <div id="player" class="hidden fixed bottom-0 left-60 right-0 bg-white border-t border-gray-100 px-8 py-3 z-50">
        <div class="flex items-center gap-4 max-w-5xl mx-auto">
            <img id="player-art" src="" class="w-12 h-12 rounded-xl object-cover bg-gray-100 flex-shrink-0">
            <div class="flex-1 min-w-0">
                <p id="player-title" class="text-sm font-bold text-gray-900 truncate"></p>
                <p id="player-artist" class="text-xs text-gray-400 truncate"></p>
            </div>
            <div class="flex-1 max-w-xs">
                <div class="w-full bg-gray-100 rounded-full h-1 cursor-pointer" onclick="seekAudio(event, this)">
                    <div id="progress-bar" class="bg-purple-600 h-1 rounded-full transition-all" style="width:0%"></div>
                </div>
                <div class="flex justify-between mt-1">
                    <span id="current-time" class="text-xs text-gray-400">0:00</span>
                    <span id="duration" class="text-xs text-gray-400">0:30</span>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button onclick="togglePlay()"
                    class="w-10 h-10 bg-purple-600 hover:bg-purple-700 rounded-full flex items-center justify-center transition">
                    <svg id="play-icon" class="w-4 h-4 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <svg id="pause-icon" class="w-4 h-4 text-white hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </button>
                <button onclick="stopPlayer()" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        let audio = new Audio();
        let progressInterval;

        function formatTime(s) {
            return Math.floor(s/60) + ':' + String(Math.floor(s%60)).padStart(2,'0');
        }

        function playSong(url, title, artist, art) {
            if (!url) { alert('No preview available for this song.'); return; }
            audio.pause();
            audio.src = url;
            audio.play();
            document.getElementById('player').classList.remove('hidden');
            document.getElementById('player-title').textContent = title;
            document.getElementById('player-artist').textContent = artist;
            document.getElementById('player-art').src = art || '';
            document.getElementById('play-icon').classList.add('hidden');
            document.getElementById('pause-icon').classList.remove('hidden');
            clearInterval(progressInterval);
            progressInterval = setInterval(() => {
                if (!audio.duration) return;
                const pct = (audio.currentTime / audio.duration) * 100;
                document.getElementById('progress-bar').style.width = pct + '%';
                document.getElementById('current-time').textContent = formatTime(audio.currentTime);
                document.getElementById('duration').textContent = formatTime(audio.duration);
            }, 300);
            audio.onended = () => {
                document.getElementById('play-icon').classList.remove('hidden');
                document.getElementById('pause-icon').classList.add('hidden');
                document.getElementById('progress-bar').style.width = '0%';
            };
        }

        function togglePlay() {
            if (audio.paused) { audio.play(); document.getElementById('play-icon').classList.add('hidden'); document.getElementById('pause-icon').classList.remove('hidden'); }
            else { audio.pause(); document.getElementById('play-icon').classList.remove('hidden'); document.getElementById('pause-icon').classList.add('hidden'); }
        }

        function stopPlayer() {
            audio.pause(); audio.src = '';
            document.getElementById('player').classList.add('hidden');
            clearInterval(progressInterval);
        }

        function seekAudio(e, bar) {
            const rect = bar.getBoundingClientRect();
            audio.currentTime = ((e.clientX - rect.left) / rect.width) * audio.duration;
        }
    </script>

</x-app-layout>