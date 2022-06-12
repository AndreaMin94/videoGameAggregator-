<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SimilarGames extends Component
{
    public $similarGames = [];
    public $accessToken;
    public $slug;
    public $loading = true;

    public function loadSimilarGames(){
        $this->loading = true;
        $this->accessToken = Http::post(
            'https://id.twitch.tv/oauth2/token',
            config('services.igdb')
        )->json()['access_token'];

        $this->similarGames = Cache::remember('similarGames', 10, function(){
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
        });

        if(array_key_exists('similar_games',$this->similarGames)){
            $this->similarGames = $this->similarGames['similar_games'];
        } else {
            $this->similarGames = [];
        }
        $this->loading = false;

        // dump($this->similarGames);
    }

    public function mount($slug){
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.similar-games');
    }
}
