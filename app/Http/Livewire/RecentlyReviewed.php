<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class RecentlyReviewed extends Component
{
    public $recentlyReviewed = [];
    public $accessToken;

    public function loadRecentlyReviewedGames()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $currentDate = Carbon::now()->timestamp;

        $this->recentlyReviewed = Http::withHeaders([
            'Client-ID' => env('IGDB_CLIENT_ID'),
            'Authorization' => 'Bearer ' . $this->accessToken
        ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating, slug, rating_count, summary;
                where platforms = (48, 49, 130, 6)
                & (first_release_date >= {$before}
                & first_release_date < {$currentDate}
                );
                sort total_rating_count desc;
                limit 3;", "text/plain"
        )->post('https://api.igdb.com/v4/games')->json();
    }

    public function mount($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function render()
    {
        return view('livewire.recently-reviewed');
    }
}
