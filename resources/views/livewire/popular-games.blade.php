<div wire:init="loadPopularGames" class="popular-games
        text-sm
        grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6
        gap-12 border-b border-gray-800 pb-8">
    @forelse($popularGames as $game)
        <x-game-card :game="$game"/>
    @empty
    <!-- <x-utils.spinner/> -->
        @foreach(range(1, 12) as $game)
        <div class="game mt-8">
            <div class="relative inline-block">
                <div class="bg-gray-800 w-48 h-56">

                </div>
            </div>
            <div class="block text-base rounded mt-4 text-transparent font-semibold leading-tight bg-gray-700">title goes</div>
            <div class="text-transparent rounded bg-gray-700 mt-2 inline-block">
                PS5, X-BOX
            </div>
        </div>
        @endforeach
    @endforelse
</div> <!-- end popular games-->