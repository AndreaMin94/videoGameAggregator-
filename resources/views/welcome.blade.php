<x-layout>

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-blue-500 uppercase tracking-wider font-semibold">
            Popular games
        </h2>

        <livewire:popular-games :accessToken="$accessToken"/>

        <div class="flex flex-col lg:flex-row my-10">
            <livewire:recently-reviewed :accessToken="$accessToken"/>
            {{--<div class="most-anticipated
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
                <div class="coming-soon-container space-y-10 mt-8">
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
        </div>--}}
    </div> <!-- End CONTAINER -->


</x-layout>