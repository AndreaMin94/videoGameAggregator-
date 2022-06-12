<div wire:init="loadMostAnticipated"  class="most-anticipated-container space-y-10 mt-8">
    @forelse($mostAnticipated as $game)
    <x-small-game-card :game="$game"/>
    @empty
    <x-utils.spinner/>
    @endforelse
</div>