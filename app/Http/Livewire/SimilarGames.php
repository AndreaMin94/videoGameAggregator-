<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SimilarGames extends Component
{
    public $accessToken;
    public $slug;
    public $loading = true;

    public function loadSimilarGames(){
        $this->loading = true;
        $this->accessToken = Http::post(
            'https://id.twitch.tv/oauth2/token',
            config('services.igdb')
        )->json()['access_token'];

        $unformattedGames = Cache::remember(
            'similarGames', 10,
            function() {
                return Http::withHeaders([
                    'Client-ID' => env('IGDB_CLIENT_ID'),
                    'Authorization' => 'Bearer ' . $this->accessToken
                ])->withBody(
                    "fields similar_games.cover.url,
                    similar_games.name, similar_games.rating,
                    similar_games.platforms.abbreviation,
                    similar_games.slug,
                    similar_games.rating,
                    similar_games.rating_count,
                    similar_games.total_rating,
                    similar_games.total_rating_count;
                        where slug=\"{$this->slug}\";", "text/plain"
                )->post('https://api.igdb.com/v4/games')
                ->json()[0];
            }
        );
        $this->loading = false;

        if(array_key_exists('similar_games',$unformattedGames)){
            return $this->formatForView($unformattedGames['similar_games']);
        } else {
            return [];
        }
    }

    public function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => isset($game['cover']) ?
                    Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) :
                    'https://via.placeholder.com/264x352',
                'totalRating' => isset($game['total_rating']) ?
                    round($game['total_rating']) . '%'
                    : '0%',
                'platforms' => isset($game['platforms']) ?
                    collect($game['platforms'])->pluck('abbreviation')->implode(', ')
                    : null,
            ]);
        })->toArray();
    }

    public function mount($slug){
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.similar-games',
            [
                'similarGames' => $this->loadSimilarGames()
            ]
        );
    }
}
