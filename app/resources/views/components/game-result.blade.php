@props(['result'])
<p class="game-result">
    Number <strong class="game-number">{{ $result->number }}</strong>
    <span @class(['game-badge', $result->is_win ? 'win' : 'lose'])>{{ $result->is_win ? 'Win' : 'Lose' }}</span>
    Amount <strong>{{ $result->amount }}</strong>
</p>
