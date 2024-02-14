<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Tracks</th>
        </tr>
    </thead>
    <tbody>
        @if ($playlists)
            @foreach ($playlists as $playlist)
                <tr>
                    <td>{{ $playlist->name }}</td>
                    <td>{{ $playlist->description ?? 'No description' }}</td>
                    <td>{{ $playlist->tracks_count }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3">No playlists found.</td>
            </tr>
        @endif
    </tbody>
</table>

