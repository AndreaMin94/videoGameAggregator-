<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PopularGames extends Component
{
    public $popularGames = [];
    public $accessToken;

    public function loadPopularGames(){
        $before = Carbon::now()->subMonths(6)->timestamp;
        $after = Carbon::now()->addMonths(4)->timestamp;

        // $before = Carbon::create(2018, 1, 31, 0)->timestamp;
        // $after = Carbon::create(2018, 12, 31, 0)->timestamp;

        $popularGamesUnformatted = Cache::remember('popularGames', 10, function()use($before, $after){
            return Http::withHeaders([
                'Client-ID' => env('IGDB_CLIENT_ID'),
                'Authorization' => 'Bearer ' . $this->accessToken
            ])->withBody(
                    "fields name, slug, cover.url, first_release_date, platforms.abbreviation, rating, slug, total_rating_count;
                    where platforms = (48, 49, 130, 6)
                    & (first_release_date >= {$before}
                    & first_release_date < {$after}
                );
                sort total_rating_count desc;
                limit 12;", "text/plain"
            )->post('https://api.igdb.com/v4/games')
            ->json();
        });

        // dump($this->formatForView($popularGamesUnformatted));

        // dd($this->popularGames);
        $this->popularGames = $this->formatForView($popularGamesUnformatted);
    }

    public function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => isset($game['cover']) ?
                    Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])
                    : 'https://via.placeholder.com/264x352',
                'rating' => isset($game['rating']) ? round($game['rating']) . "%" : "0%",
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', ')
            ]);
        })->toArray();
    }

    public function mount($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    public function render()
    {
        return view('livewire.popular-games');
    }
}
