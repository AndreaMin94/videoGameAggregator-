<div wire:init="loadRecentlyReviewedGames" class="recently-reviewd
            w-full lg:w-3/4
            mr-0 lg:mr-32">
    <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Recently Reviewed</h2>
    <div class="recently-reviewd-container space-y-12 mt-8">
        @forelse($recentlyReviewed as $game)
        <div class="game bg-gray-800 tounded-large shadow-md flex p-6">
            <!-- <div class="relative flex-none"></div> -->
            <div class="game mt-8">
                <div class="relative flex-none">
                    <a href="#">
                        <img src="{{isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) : ''}}" alt="game cover" class="w-48 hover:opacity-75 transition ease-in-out duration-150">
                    </a>
                    @if(isset($game['rating']))
                    <div class="absolute bottom-0 right-0 w-14 h-14 bg-gray-900 rounded-full"  style="right: -20px; bottom: -20px">
                        <div class="font-semibold text-xs flex justify-center items-center h-full">
                            {{ round($game['rating']) }}%
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="ml-12">
                    <a href="#" class="block text-large font-semibold leading-tight hover:text-gray-400 mt-8">{{ $game['name']}}</a>
                    <div class="text-gray-400 mt-1">
                        @foreach($game['platforms'] as $platform)
                            {{ $platform['abbreviation'] ?? '' }},
                        @endforeach
                    </div>
                    <p class="mt-6 text-gray-400 hidden lg:block hidden lg:block">{{ $game['summary'] ?? ''}}</p>
            </div>
        </div>
        @empty
        <x-utils.spinner/>
        @endforelse
    </div>
</div>