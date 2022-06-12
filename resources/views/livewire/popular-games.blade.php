<div wire:init="loadPopularGames" class="popular-games
        text-sm
        grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6
        gap-12 border-b border-gray-800 pb-8">
    @forelse($popularGames as $game)
    <div class="game mt-8">
        <div class="relative inline-block">
            <a href="{{route('games.show', $game['slug'])}}">
                <img
                src="{{isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) : ''}}"
                alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150">
            </a>
            @if(isset($game['rating']))
            <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full"  style="right: -20px; bottom: -20px">
                <div class="font-semibold text-xs flex justify-center items-center h-full">
                    {{ round($game['rating']) }}%
                </div>
            </div>
            @endif
        </div>
        <a href="{{route('games.show', $game['slug'])}}" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">{{$game['name']}}</a>
        <div class="text-gray-400 mt-1">
            @foreach($game['platforms'] as $platform)
                {{ $platform['abbreviation'] ?? '' }},
            @endforeach
        </div>
    </div>
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