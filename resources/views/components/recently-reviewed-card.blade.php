<div class="game bg-gray-800 tounded-large shadow-md flex p-6">
            <!-- <div class="relative flex-none"></div> -->
            <div class="game mt-8">
                <div class="relative flex-none">
                    <a href="{{route('games.show', $game['slug'])}}">
                        <img src="{{$game['coverImageUrl']}}" alt="game cover" class="w-48 hover:opacity-75 transition ease-in-out duration-150">
                    </a>
                    <div class="absolute bottom-0 right-0 w-14 h-14 bg-gray-900 rounded-full"  style="right: -20px; bottom: -20px">
                        <div class="font-semibold text-xs flex justify-center items-center h-full">
                            {{ $game['rating'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="ml-12">
                    <a href="{{route('games.show', $game['slug'])}}" class="block text-large font-semibold leading-tight hover:text-gray-400 mt-8">{{ $game['name']}}</a>
                    <div class="text-gray-400 mt-1">
                       {{ $game['platforms']}}
                    </div>
                    <p class="mt-6 text-gray-400 hidden lg:block hidden lg:block">{{ $game['summary'] ?? ''}}</p>
            </div>
        </div>