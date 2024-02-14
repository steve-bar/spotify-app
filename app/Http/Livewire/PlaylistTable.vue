<?php

namespace App\Http\Livewire;

use App\Models\SpotifyPlaylist;
use Livewire\Component;

class PlaylistTable extends Component
{
    public $playlists;

    public function mount()
    {
        $this->listen('playlistsFetched', function () {
            $this->playlists = auth()->user()->spotifyPlaylists;
        });
    }

    public function render()
    {
        return view('livewire.playlist-table');
    }
}

