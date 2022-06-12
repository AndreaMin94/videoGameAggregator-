<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];
    public $accessToken;

    public function loadMostAnticipated()
    {
        $currentDate = Carbon::now()->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(4)->timestamp;

         $unformattedGames = Cache::remember('mostAnticipated', 10, function()use($currentDate, $afterFourMonths){
            return Http::withHeaders([
                'Client-ID' => env('IGDB_CLIENT_ID'),
                'Authorization' => 'Bearer ' . $this->accessToken
            ])->withBody(
                    "fields name, slug, cover.url, first_release_date, platforms.abbreviation, rating,total_rating_count, total_rating;
                    where platforms = (48, 49, 130, 6)
                    & (first_release_date >= {$currentDate}
                    & first_release_date < {$afterFourMonths}
                    );
                    sort total_rating_count desc;
                    limit 4;", "text/plain"
            )->post('https://api.igdb.com/v4/games')
            ->json();
        });

        $this->mostAnticipated = $this->formatForView($unformattedGames);
        // dd($this->mostAnticipated);
    }

    public function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => isset($game['cover']) ?
                Str::replaceFirst('thumb', 'cover_big', $game['cover']['url'])
                    : 'https://via.placeholder.com/264x352',
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
        return view('livewire.most-anticipated');
    }
}
