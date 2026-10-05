<x-layout title="Game">
    Game page
    <br>
    <h1>Hello, {{ $user->username }}</h1>

    @if ($result)
        <x-game-result :result="$result" />
    @endif

    <form method="POST" action="{{ route('game.play', $user) }}">
        @csrf
        <button type="submit">Imfeelinglucky</button>
    </form>
    <p><a href="{{ route('game.history', $user) }}">History</a></p>

    <br>
    <p>Your link: <a href="{{ route('game.show', $user) }}">{{ route('game.show', $user) }}</a></p>
    <p>Valid until: {{ $user->link_expires_at }}</p>
    <form method="POST" action="{{ route('link.update', $user) }}">
        @csrf
        @method('PUT')
        <button type="submit">Regenerate link</button>
    </form>

    <form method="POST" action="{{ route('link.destroy', $user) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Deactivate link</button>
    </form>
</x-layout>
