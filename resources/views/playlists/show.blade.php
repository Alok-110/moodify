<x-app-layout>

<!-- Back -->
<a href="/playlists" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 mb-6 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    Back to playlists
</a>

<!-- Playlist Header -->
<div class="flex items-center gap-6 mb-8">
    <div class="w-32 h-32 rounded-2xl bg-gradient-to-br {{ $playlist->cover_color }} flex items-center justify-center flex-shrink-0 shadow-md">
        <svg class="w-12 h-12 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
        </svg>
    </div>
    <div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Playlist</p>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $playlist->name }}</h1>
        @if($playlist->description)
        <p class="text-sm text-gray-400 mb-2">{{ $playlist->description }}</p>
        @endif
        <p class="text-sm text-gray-400">{{ $songs->count() }} songs</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl mb-6">
    {{ session('success') }}
</div>
@endif

<!-- Songs List -->
@if($songs->count())
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden mb-8">
    @foreach($songs as $i => $song)
    <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50 transition group
                {{ !$loop->last ? 'border-b border-gray-50' : '' }}">

        <!-- Index / Play -->
        <div class="w-6 text-center flex-shrink-0">
            <span class="text-xs text-gray-400 font-semibold group-hover:hidden">{{ $i + 1 }}</span>
            <button class="hidden group-hover:block text-purple-600"
                onclick="playSong('{{ $song->preview_url }}', '{{ addslashes($song->title) }}', '{{ addslashes($song->artist) }}', '{{ $song->artwork_url }}', {{ $song->id }})">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </button>
        </div>

        <!-- Artwork -->
        <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
            @if($song->artwork_url)
                <img src="{{ $song->artwork_url }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-purple-400 to-indigo-600"></div>
            @endif
        </div>

        <!-- Info -->
        <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-gray-900 truncate">{{ $song->title }}</p>
            <p class="text-xs text-gray-400 truncate">{{ $song->artist }}</p>
        </div>

        <!-- Album -->
        <p class="text-xs text-gray-400 hidden sm:block truncate max-w-32">{{ $song->album }}</p>

        <!-- Remove -->
        <form method="POST" action="/playlists/{{ $playlist->id }}/songs/{{ $song->id }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="opacity-0 group-hover:opacity-100 text-gray-300 hover:text-red-500 transition ml-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </form>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-20 bg-white border border-gray-100 rounded-2xl mb-8">
    <p class="text-gray-500 font-semibold mb-1">This playlist is empty</p>
    <p class="text-sm text-gray-400 mb-4">Go to Discover and add songs to this playlist</p>
    <a href="/discover" class="inline-block text-sm font-bold text-purple-600 hover:text-purple-700">
        Browse songs →
    </a>
</div>
@endif

<!-- Mini Player -->
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
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
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

    function playSong(url, title, artist, art, songId) {
        if (!url) { alert('No preview available.'); return; }
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
        if (songId) {
            fetch(`/play/${songId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
        }
    }

    function togglePlay() {
        if (audio.paused) {
            audio.play();
            document.getElementById('play-icon').classList.add('hidden');
            document.getElementById('pause-icon').classList.remove('hidden');
        } else {
            audio.pause();
            document.getElementById('play-icon').classList.remove('hidden');
            document.getElementById('pause-icon').classList.add('hidden');
        }
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