<div wire:init="loadComingSoonGames" class="coming-soon-container space-y-10 mt-8">
    @forelse($comingSoonGames as $game)
        <x-small-game-card :game="$game"/>
    @empty
    <x-utils.spinner/>
    @endforelse
</div>