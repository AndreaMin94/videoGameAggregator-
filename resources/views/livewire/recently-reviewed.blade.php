<div wire:init="loadRecentlyReviewedGames" class="recently-reviewd
            w-full lg:w-3/4
            mr-0 lg:mr-32">
    <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Recently Reviewed</h2>
    <div class="recently-reviewd-container space-y-12 mt-8">
        @forelse($recentlyReviewed as $game)
        <x-recently-reviewed-card :game="$game"/>
        @empty
        <!-- <x-utils.spinner/> -->
        <div class="game bg-gray-800 tounded-large shadow-md flex p-6">
            <!-- <div class="relative flex-none"></div> -->
            <div class="game mt-8">
                <div class="relative flex-none">
                    <div class="bg-gray-600 w-48 h-56">

                    </div>
                </div>
            </div>
            <div class="ml-12">
                    <a href="#" class="inline-block rounded text-large text-transparent font-semibold leading-tight bg-gray-600 mt-8">Title Goes Here</a>
                    <div class="text-gray-400 mt-1">

                    </div>
                    <p class="mt-6 text-transparent rounded bg-gray-600 hidden lg:block hidden lg:block">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Est sequi excepturi, cum iure quae velit delectus molestias cumque eligendi doloribus magni enim earum libero saepe iusto tenetur, blanditiis accusamus sed!</p>
            </div>
        </div>
        @endforelse
    </div>
</div>