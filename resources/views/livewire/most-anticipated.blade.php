<div wire:init="loadMostAnticipated" class="most-anticipated
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
</div>