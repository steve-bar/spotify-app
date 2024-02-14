<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FetchPlaylistsButton extends Component
{
    public function fetchPlaylists()
    {
        $this->emit('playlistsFetched');
    }

    public function render()
    {
        return view('livewire.fetch-playlists-button');
    }
}

