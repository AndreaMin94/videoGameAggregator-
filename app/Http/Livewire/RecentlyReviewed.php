<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RecentlyReviewed extends Component
{
    public $accessToken;

    public function loadRecentlyReviewedGames()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $currentDate = Carbon::now()->timestamp;

         $unformattedGames =  Cache::remember(
            'recentlyReviewed', 10,
            function() use($currentDate, $before) {
                return Http::withHeaders([
                    'Client-ID' => env('IGDB_CLIENT_ID'),
                    'Authorization' => 'Bearer ' . $this->accessToken
                ])->withBody(
                        "fields name, slug, cover.url, first_release_date, platforms.abbreviation, rating, slug, rating_count, summary;
                        where platforms = (48, 49, 130, 6)
                        & (first_release_date >= {$before}
                        & first_release_date < {$currentDate}
                        );
                        sort total_rating_count desc;
                        limit 3;", "text/plain"
                )->post('https://api.igdb.com/v4/games')
                ->json();
            }
        );
        return $this->formatForView($unformattedGames);
    }

    public function formatForView($games)
    {
        return collect($games)->map(function($game){
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
        return view('livewire.recently-reviewed',
            [
                'recentlyReviewed' => $this->loadRecentlyReviewedGames()
            ]
        );
    }
}
