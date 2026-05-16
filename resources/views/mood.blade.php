<x-app-layout>

<style>
    .song-card:hover .play-btn { opacity: 1; transform: translateY(0); }
    .play-btn { opacity: 0; transform: translateY(4px); transition: all 0.2s ease; }
</style>

<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Mood</p>
        <h1 class="text-3xl font-extrabold text-gray-900">{{ $mood->name }}</h1>
        <p class="text-sm text-gray-400 mt-1">{{ $songs->total() }} songs matching this mood</p>
    </div>
    <a href="/dashboard" class="text-sm text-gray-400 hover:text-gray-600 flex items-center gap-1 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back
    </a>
</div>

<!-- Mood switcher pills -->
<div class="flex gap-2 flex-wrap mb-8">
    @foreach($allMoods as $m)
    <a href="/mood?mood={{ $m->slug }}"
       class="text-xs font-bold px-4 py-2 rounded-full border transition
              {{ $m->slug === $mood->slug
                 ? 'bg-purple-600 text-white border-purple-600'
                 : 'bg-white text-gray-500 border-gray-200 hover:border-purple-300 hover:text-purple-600' }}">
        {{ $m->name }}
    </a>
    @endforeach
</div>

<!-- Songs Grid -->
@if($songs->count())
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-8">
    @foreach($songs as $song)
    <div class="song-card bg-white border border-gray-100 rounded-2xl p-3 hover:border-gray-200 hover:shadow-md transition cursor-pointer relative"
         onclick="playSong('{{ $song->preview_url }}', '{{ addslashes($song->title) }}', '{{ addslashes($song->artist) }}', '{{ $song->artwork_url }}', {{ $song->id }})">

        <div class="relative w-full aspect-square rounded-xl overflow-hidden mb-3 bg-gray-100">
            @if($song->artwork_url)
                <img src="{{ $song->artwork_url }}" alt="{{ $song->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-purple-400 to-indigo-600 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
            @endif
            <div class="play-btn absolute bottom-2 right-2">
                <div class="w-10 h-10 bg-purple-600 hover:bg-purple-700 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-4 h-4 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
            </div>
        </div>

        <p class="text-sm font-bold text-gray-900 truncate">{{ $song->title }}</p>
        <p class="text-xs text-gray-400 truncate mt-0.5">{{ $song->artist }}</p>

        <div class="flex items-center justify-between mt-2">
            @if($song->genre_name)
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full"
                  style="background:{{ $song->genre_color }}18; color:{{ $song->genre_color }}">
                {{ $song->genre_name }}
            </span>
            @else
            <span></span>
            @endif
            <button onclick="event.stopPropagation(); openAddToPlaylist({{ $song->id }}, '{{ addslashes($song->title) }}')"
                class="text-gray-300 hover:text-purple-600 transition" title="Add to playlist">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </div>
    </div>
    @endforeach
</div>
{{ $songs->withQueryString()->links() }}
@else
<div class="text-center py-32 bg-white border border-gray-100 rounded-2xl">
    <p class="text-gray-700 font-bold text-lg mb-2">No songs for this mood yet</p>
    <p class="text-sm text-gray-400">Try a different mood or check back later</p>
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

<!-- Add to Playlist Modal -->
<div id="playlist-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-900">Add to Playlist</h2>
                <p id="modal-song-name" class="text-xs text-gray-400 mt-0.5 truncate"></p>
            </div>
            <button onclick="closeAddToPlaylist()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div id="playlist-list" class="space-y-2 max-h-64 overflow-y-auto">
            <p class="text-sm text-gray-400 text-center py-4">Loading playlists...</p>
        </div>
        <a href="/playlists" class="block text-center text-xs font-semibold text-purple-600 hover:text-purple-700 mt-4">
            + Create new playlist
        </a>
    </div>
</div>

<script>
    let audio = new Audio();
    let progressInterval;
    let currentSongId = null;

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
                credentials: 'same-origin',
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

    function openAddToPlaylist(songId, songTitle) {
        currentSongId = songId;
        document.getElementById('modal-song-name').textContent = songTitle;
        document.getElementById('playlist-modal').classList.remove('hidden');
        fetch('/playlists/list', { credentials: 'same-origin' })
            .then(r => r.json())
            .then(playlists => {
                const list = document.getElementById('playlist-list');
                if (playlists.length === 0) {
                    list.innerHTML = '<p class="text-sm text-gray-400 text-center py-4">No playlists yet.</p>';
                    return;
                }
                list.innerHTML = playlists.map(p => `
                    <button onclick="addToPlaylist(${p.id})"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-purple-50 transition text-left group">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br ${p.cover_color} flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">${p.name}</p>
                            <p class="text-xs text-gray-400">${p.songs_count} songs</p>
                        </div>
                    </button>
                `).join('');
            });
    }

    function closeAddToPlaylist() {
        document.getElementById('playlist-modal').classList.add('hidden');
        currentSongId = null;
    }

    function addToPlaylist(playlistId) {
        fetch('/playlists/' + playlistId + '/songs', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'song_id=' + encodeURIComponent(currentSongId)
        })
        .then(r => r.json())
        .then(data => {
            closeAddToPlaylist();
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-24 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm font-semibold px-5 py-3 rounded-full shadow-lg z-50';
            toast.textContent = data.already ? 'Already in playlist!' : 'Added to playlist ✓';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        });
    }
</script>

</x-app-layout>