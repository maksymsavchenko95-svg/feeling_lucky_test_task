<x-layout title="History">
    <h1>History</h1>

    @forelse ($results as $result)
        <x-game-result :result="$result" />
    @empty
        <p>No games yet.</p>
    @endforelse

    <p><a href="{{ route('game.show', $user) }}">Back</a></p>
</x-layout>
