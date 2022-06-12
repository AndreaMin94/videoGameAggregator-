<div wire:init="loadComingSoonGames" class="coming-soon-container space-y-10 mt-8">
    @forelse($comingSoonGames as $game)
    <div class="game flex">
        <a href="#">
            <img src="{{$game['coverImageUrl']}}"
                alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150">
        </a>
        <div class="ml-6">
            <a href="" class="hover:text-gray-300">{{ $game['name']}}</a>
            <p class="text-gray-400 text-sm mt-1">
            {{ $game['first_release_date'] }}
            </p>
        </div>
    </div>
    @empty
    <x-utils.spinner/>
    @endforelse
</div>