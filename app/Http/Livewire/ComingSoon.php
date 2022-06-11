<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ComingSoon extends Component
{
    public $comingSoonGames = [];
    public $accessToken;

    public function loadComingSoonGames()
    {
        $currentDate = Carbon::now()->timestamp;

        $this->comingSoonGames = Cache::remember('popularGames', 10, function()use($currentDate){
            Http::withHeaders([
                'Client-ID' => env('IGDB_CLIENT_ID'),
                'Authorization' => 'Bearer ' . $this->accessToken
            ])->withBody(
                    "fields name, cover.url, first_release_date, platforms.abbreviation, rating;
                    where platforms = (48, 49, 130, 6)
                    & (first_release_date >= {$currentDate});
                    limit 5;", "text/plain"
            )->post('https://api.igdb.com/v4/games')
            ->json();
        });
    }

    public function mount($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function render()
    {
        return view('livewire.coming-soon');
    }
}
