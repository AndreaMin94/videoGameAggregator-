<x-layout>

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-blue-500 uppercase tracking-wider font-semibold">
            Popular games
        </h2>
        <div class="popular-games
                    text-sm
                    grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6
                    gap-12 border-b border-gray-800 pb-8">
            @foreach($popularGames as $game)
            <div class="game mt-8">
                <div class="relative inline-block">
                    <a href="#">
                        <img src="{{Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])}}" alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>
                    @if(isset($game['rating']))
                    <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full"  style="right: -20px; bottom: -20px">
                        <div class="font-semibold text-xs flex justify-center items-center h-full">
                            {{ round($game['rating']) }}%
                        </div>
                    </div>
                    @endif
                </div>
                <a href="#" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">{{$game['name']}}</a>
                <div class="text-gray-400 mt-1">
                    @foreach($game['platforms'] as $platform)
                        {{ $platform['abbreviation'] ?? '' }},
                    @endforeach
                </div>
            </div>
            @endforeach
        </div> <!-- end popular games-->

        <div class="flex flex-col lg:flex-row my-10">
            <div class="recently-reviewd
                        w-full lg:w-3/4
                        mr-0 lg:mr-32">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Recently Reviewed</h2>
                <div class="recently-reviewd-container space-y-12 mt-8">
                    @foreach($recentlyReviewed as $game)
                    <div class="game bg-gray-800 tounded-large shadow-md flex p-6">
                        <!-- <div class="relative flex-none"></div> -->
                        <div class="game mt-8">
                            <div class="relative flex-none">
                                <a href="#">
                                    <img src="{{Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])}}" alt="game cover" class="w-48 hover:opacity-75 transition ease-in-out duration-150">
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
                    @endforeach

                </div>
            </div>
            <div class="recently-reviewd
                        lg:w-1/4
                        sm:mt-8"
                        >
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Most Anticipated</h2>
                <div class="most-anticipated-container space-y-10 mt-8">
                    @foreach($mostAnticipated as $game)
                    <div class="game flex">
                       <a href="#">
                           <img src="{{Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])}}" alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                        <div class="ml-6">
                            <a href="" class="hover:text-gray-300">{{ $game['name']}}</a>
                            <p class="text-gray-400 text-sm mt-1">
                                {{ Illuminate\Support\Carbon::createFromTimestamp($game['first_release_date'])->format('d/m/y')}}
                            </p>
                        </div>
                    </div>
                    @endforeach
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-14">Coming Soon</h2>
                <div class="most-anticipated-container space-y-10 mt-8">
                    @foreach($comingSoon as $game)
                    <div class="game flex">
                       <a href="#">
                           <img src="{{Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])}}"
                                alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                        <div class="ml-6">
                            <a href="" class="hover:text-gray-300">{{ $game['name']}}</a>
                            <p class="text-gray-400 text-sm mt-1">
                            {{ Illuminate\Support\Carbon::createFromTimestamp($game['first_release_date'])->format('M d, y')}}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> <!-- End CONTAINER -->


</x-layout>