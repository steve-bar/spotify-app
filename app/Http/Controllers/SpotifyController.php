<?php

namespace App\Http\Controllers;

use App\Models\SpotifyPlaylist;
use Aerni\Spotify\Spotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpotifyController extends Controller
{
    protected $spotify;

    public function __construct(Spotify $spotify)
    {
        $this->spotify = $spotify;
    }

    public function fetchData(Request $request, $playlistId)
    {
        $user = Auth::user();

        // Ensure playlist belongs to the user
        $playlist = SpotifyPlaylist::where('user_id', $user->id)->where('spotify_id', $playlistId)->firstOrFail();

        // Fetch details from Spotify API using playlist ID
        $apiPlaylist = $this->spotify->playlists($playlistId)->get();

        // Update playlist data in the database
        $playlist->update([
            'name' => $apiPlaylist->name,
            'description' => $apiPlaylist->description,
            'public' => $apiPlaylist->public,
            'tracks_count' => $apiPlaylist->tracks->total,
            'image_url' => $apiPlaylist->images[0]->url ?? null,
            'data' => json_encode($apiPlaylist->toArray()),
        ]);

        return response()->json([
            'message' => 'Playlist data updated successfully',
            'playlist' => $playlist,
        ]);
    }

    public function storeData(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'spotify_id' => 'required|string|unique:spotify_playlists,spotify_id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'public' => 'required|boolean',
        ]);

        // Fetch details from Spotify API using playlist ID
        $apiPlaylist = $this->spotify->playlists($data['spotify_id'])->get();

        // Create new playlist model and store data
        $playlist = new SpotifyPlaylist;
        $playlist->user_id = $user->id;
        $playlist->spotify_id = $data['spotify_id'];
        $playlist->name = $data['name'];
        $playlist->description = $data['description'];
        $playlist->public = $data['public'];
        $playlist->tracks_count = $apiPlaylist->tracks->total;
        $playlist->image_url = $apiPlaylist->images[0]->url ?? null;
        $playlist->data = json_encode($apiPlaylist->toArray());
        $playlist->save();

        return response()->json([
            'message' => 'Playlist saved successfully',
            'playlist' => $playlist,
        ]);
    }

    public function listPlaylists(Request $request)
    {
        $user = Auth::user();
        $playlists = SpotifyPlaylist::where('user_id', $user->id)->get();

        return response()->json($playlists);
    }

    public function updatePlaylist(Request $request, $playlistId)
    {
        $user = Auth::user();

        $playlist = SpotifyPlaylist::where('user_id', $user->id)->where('spotify_id', $playlistId)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'public' => 'required|boolean',
        ]);

        // Update playlist data in the database
        $playlist->update($data);

        return response()->json([
            'message' => 'Playlist updated successfully',
            'playlist' => $playlist,
        ]);
    }

    public function deletePlaylist(Request $request, $playlistId)
    {
        $user = Auth::user();

        $playlist = SpotifyPlaylist::where('user_id', $user->id)->where('spotify_id', $playlistId)->firstOrFail();

        // Optionally: Unlink playlist from Spotify using the API

        $playlist->delete();

        return response()->json([
            'message' => 'Playlist deleted successfully',
        ]);
    }
}
