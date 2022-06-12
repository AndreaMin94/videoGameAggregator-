<x-layout>
    <div class="container mx-auto px-4 py-9
    ">
        <div class="game-details border-b border-gray-800 pb-12 flex flex-col lg:flex-row">
            <div class="flex-none">
                <img src="{{isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) : ''}}" alt="cover">
            </div>
            <div class="lg:ml-12 lg:mr-64">
                <h2 class="font-semi-bold text-4xl mt-2">
                    {{ $game['name'] }}
                </h2>
                <div class="text-gray-400">
                    @if(isset($game['genres']))
                        @foreach($game['genres'] as $genre)
                            <span>{{$genre['name']}} </span>
                        @endforeach
                    @endif
                    &middot;
                    @if(isset($game['involved_companies']))
                        @foreach($game['involved_companies'] as $company)
                            <span>{{$company['company']['name']}} </span>
                        @endforeach
                    @endif
                    &middot;
                    @if(isset($game['platforms']))
                        @foreach($game['platforms'] as $platform)
                            <span>{{$platform['abbreviation'] ?? ''}}</span>
                        @endforeach
                    @endif
                </div>
                <div class="flex flex-wrap items-center mt-8">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gray-800 rounded-full">
                            <div class="font-semibold text-xs flex justify-center items-center h-full">
                                @if(isset($game['rating']))
                                    {{ round($game['rating']) . '%' }}
                                @else
                                    0%
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 text-xs">Member Score</div>
                    </div>
                    <div class="flex items-center ml-12">
                        <div class="w-16 h-16 bg-gray-800 rounded-full">
                            <div class="font-semibold text-xs flex justify-center items-center h-full">
                                @if(isset($game['rating_count']))
                                    {{ $game['rating_count'] . '%' }}
                                @else
                                    0%
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 text-xs">Critic Score</div>
                    </div>
                    <div class="flex items-center space-x-4 mt-8 lg:mt-0 lg:ml-12">
                        @if(isset($game['websites']))
                            @foreach($game['websites'] as $website)
                                <x-utils.link-social :link="$website['url']" />
                            @endforeach
                        @endif
                    </div>
                </div>
                <p class="mt-12">
                    @if(isset($game['storyline']))
                    {{ $game['storyline'] }}
                    @elseif(isset($game['summary']))
                    {{ $game['summary'] }}
                    @endif
                </p>
                @if(isset($game['videos']))
                <div class="mt-12">
                    <a href="https://youtube.com/watch/{{ $game['videos'][0]['video_id'] }}" class="inline-flex justify-center items-center bg-blue-500 text-white font-semibold p-4 hover:bg-blue-600 rounded transition ease-in-out duration-1">
                        <i class="fa-solid fa-circle-play"></i>
                        <span class="ml-2"> Play Trailer</span>
                    </a>
                </div>
                @endif
            </div>
        </div> <!-- end came details-->
        <div class="images-container border-b border-gray-800 pb-12 mt-8">
            <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Images</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mt-8">
                @if(isset($game['screenshots']))
                    @foreach($game['screenshots'] as $img)
                    <div>
                        <a href="{{Str::replaceFirst('thumb', 'screenshot_big', $img['url'])}}">
                            <img src="{{Str::replaceFirst('thumb', 'screenshot_big', $img['url'])}}" alt="" class="hover:opacity-75 transition ease-in-out duration-1">
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="text-gray-400 mt-4 font-semibold leading-tight">No images for this game</div>
                @endif
            </div>
        </div> <!-- end images container-->
        <div class="similar-games-container border-b border-gray-800 pb-12 mt-8">
            <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Similar Games</h2>
            <livewire:similar-games :slug="$game['slug']"/>
        </div><!-- end similar games container-->
    </div>
</x-layout>