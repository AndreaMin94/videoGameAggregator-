<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ComingSoon extends Component
{
    public $accessToken;

    public function loadComingSoonGames()
    {
        $currentDate = Carbon::now()->timestamp;

         $unformattedGames = Cache::remember('comingSoonGames', 10, function()use($currentDate){
            return Http::withHeaders([
                'Client-ID' => env('IGDB_CLIENT_ID'),
                'Authorization' => 'Bearer ' . $this->accessToken
            ])->withBody(
                    "fields name, slug, cover.url, first_release_date, platforms.abbreviation, rating;
                    where platforms = (48, 49, 130, 6)
                    & (first_release_date >= {$currentDate});
                    limit 5;", "text/plain"
            )->post('https://api.igdb.com/v4/games')
            ->json();
        });
        return $this->formatForView($unformattedGames);
    }

    public function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => isset($game['cover']) ?
                    Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) :
                    'https://via.placeholder.com/264x352',
                'first_release_date' => Carbon::createFromTimestamp($game['first_release_date'])->format('d/m/y')
            ]);
        })->toArray();
    }

    public function mount($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function render()
    {
        return view('livewire.coming-soon',
            [
                'comingSoonGames' => $this->loadComingSoonGames()
            ]
        );
    }
}
