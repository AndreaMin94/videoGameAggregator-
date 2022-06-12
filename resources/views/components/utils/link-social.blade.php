<div class="w-8 h-8 bg-gray-800 flex rounded-full items-center justify-center">
    <a href="{{$link}}" class="hover:text-gray-400">
        @switch($link)
            @case(str_contains($link, 'facebook'))
                <i class="fa-brands fa-facebook"></i>
                @break

            @case(str_contains($link, 'youtube'))
                <i class="fa-brands fa-youtube"></i>
                @break

            @case(str_contains($link, 'instagram'))
                <i class="fa-brands fa-instagram"></i>
                @break

            @case(str_contains($link, 'twitter'))
                <i class="fa-brands fa-twitter"></i>
                @break

            @case(str_contains($link, 'discord'))
                <i class="fa-brands fa-discord"></i>
                @break

            @default
                <i class="fa-solid fa-earth-europe"></i>
                @break

        @endswitch
    </a>
</div>
<!--  -->

<!-- <div class="w-8 h-8 bg-gray-800 flex rounded-full items-center justify-center">
        <a class="hover:text-gray-400">
        <i class="fa-brands fa-facebook"></i>
    </a>
</div>
<div class="w-8 h-8 bg-gray-800 flex rounded-full items-center justify-center">
        <a class="hover:text-gray-400">
        <i class="fa-brands fa-instagram"></i>
    </a>
</div>
<div class="w-8 h-8 bg-gray-800 flex rounded-full items-center justify-center">
        <a class="hover:text-gray-400">
        <i class="fa-brands fa-twitter"></i>
    </a>
</div> -->