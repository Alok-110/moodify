<x-app-layout>

<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900">My Playlists</h1>
        <p class="text-sm text-gray-400 mt-0.5">All your playlists in one place</p>
    </div>
    <button onclick="document.getElementById('create-modal').classList.remove('hidden')"
        class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition">
        + New Playlist
    </button>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-4 py-3 rounded-xl mb-6">
    {{ session('success') }}
</div>
@endif

@if($playlists->count())
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
    @foreach($playlists as $playlist)
    <div class="group bg-white border border-gray-100 rounded-2xl p-3 hover:border-gray-200 hover:shadow-md transition cursor-pointer relative"
         onclick="window.location='/playlists/{{ $playlist->id }}'">

        <!-- Cover -->
        <div class="w-full aspect-square rounded-xl bg-gradient-to-br {{ $playlist->cover_color }} mb-3 flex items-center justify-center relative overflow-hidden">
            <svg class="w-10 h-10 text-white opacity-70" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
            <!-- Hover play -->
            <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-4 h-4 text-gray-900 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
            </div>
        </div>

        <p class="text-sm font-bold text-gray-900 truncate">{{ $playlist->name }}</p>
        <p class="text-xs text-gray-400 mt-0.5">{{ $playlist->songs_count }} songs</p>

        <!-- Delete button -->
        <form method="POST" action="/playlists/{{ $playlist->id }}"
              onsubmit="return confirm('Delete this playlist?')"
              onclick="event.stopPropagation()">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 w-7 h-7 bg-white rounded-full shadow flex items-center justify-center text-gray-400 hover:text-red-500 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </form>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-32">
    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
        </svg>
    </div>
    <p class="text-gray-700 font-bold text-lg">No playlists yet</p>
    <p class="text-sm text-gray-400 mt-1 mb-6">Create your first playlist to get started</p>
    <button onclick="document.getElementById('create-modal').classList.remove('hidden')"
        class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold px-6 py-3 rounded-xl transition">
        + Create Playlist
    </button>
</div>
@endif

<!-- Create Playlist Modal -->
<div id="create-modal" class="hidden fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-extrabold text-gray-900">New Playlist</h2>
            <button onclick="document.getElementById('create-modal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="/playlists" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Playlist name</label>
                <input type="text" name="name" required placeholder="My awesome playlist"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="text" name="description" placeholder="What's this playlist about?"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-purple-400 focus:ring-2 focus:ring-purple-100 outline-none text-sm transition">
            </div>
            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition text-sm">
                Create Playlist
            </button>
        </form>
    </div>
</div>

</x-app-layout>