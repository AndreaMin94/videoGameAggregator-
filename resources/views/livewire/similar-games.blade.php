<div wire:init="loadSimilarGames" class="popular-games
        text-sm
        grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6
        gap-12 border-b border-gray-800 pb-8">
        @forelse($similarGames as $game)
        <div class="game mt-8">
            <div class="relative inline-block">
                <a href="#">
                    @if(isset($game['cover']))
                    <img src="{{isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) : '/img/tlou.jpg'}}" alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150">
                    @endif
                </a>
                @if(isset($game['total_rating']))
                <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full"  style="right: -20px; bottom: -20px">
                    <div class="font-semibold text-xs flex justify-center items-center h-full">
                        {{ round($game['total_rating']) . '%' }}
                    </div>
                </div>
                @endif
            </div>
            <a href="#" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">{{ $game['name']}}</a>
            @if(isset($game['platforms']))
            <div class="text-gray-400 mt-1">
                @foreach($game['platforms'] as $platform)
                    {{$platform['abbreviation'] ?? ''}}
                @endforeach
            </div>
            @endif
        </div>
        @empty
            @if($loading)
            <x-utils.spinner/>
            @else
                <div class="text-gray-400 mt-4 font-semibold leading-tight">No similar games for this game</div>
            @endif
        @endforelse
</div>