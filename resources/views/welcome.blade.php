<x-layout>

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-blue-500 uppercase tracking-wider font-semibold">
            Popular games
        </h2>

        <livewire:popular-games :accessToken="$accessToken"/>

        <div class="flex flex-col lg:flex-row my-10">
            <livewire:recently-reviewed :accessToken="$accessToken"/>
            <div class="most-anticipated
                lg:w-1/4
                sm:mt-8"
                >
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Most Anticipated</h2>
                <livewire:most-anticipated :accessToken="$accessToken"/>

                <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-14">Coming Soon</h2>
                <livewire:coming-soon :accessToken="$accessToken"/>

            </div>
        </div>
    </div>
</div> <!-- End CONTAINER -->


</x-layout>