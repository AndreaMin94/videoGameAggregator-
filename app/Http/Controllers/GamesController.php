<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{
    public function index(){
        $response = Http::post(
            'https://id.twitch.tv/oauth2/token',
            config('services.igdb')
        )->json();

        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(4)->timestamp;
        $currentDate = Carbon::now()->timestamp;
        $popularGames = Http::withHeaders([
            'Client-ID' => env('IGDB_CLIENT_ID'),
            'Authorization' => 'Bearer ' . $response['access_token']
        ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating, slug, total_rating_count;
                where platforms = (48, 49, 130, 6)
                & (first_release_date >= {$before}
                & first_release_date < {$after}
               );
                sort rating_count desc;
                limit 12;", "text/plain"
        )->post('https://api.igdb.com/v4/games')->json();

        $recentlyReviewed = Http::withHeaders([
            'Client-ID' => env('IGDB_CLIENT_ID'),
            'Authorization' => 'Bearer ' . $response['access_token']
        ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating, slug, rating_count, summary;
                where platforms = (48, 49, 130, 6)
                & (first_release_date >= {$before}
                & first_release_date < {$currentDate}
                );
                sort total_rating_count desc;
                limit 3;", "text/plain"
        )->post('https://api.igdb.com/v4/games')->json();

        $mostAnticipated = Http::withHeaders([
            'Client-ID' => env('IGDB_CLIENT_ID'),
            'Authorization' => 'Bearer ' . $response['access_token']
        ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating,total_rating_count, total_rating;
                where platforms = (48, 49, 130, 6)
                ;
                sort total_rating_count desc;
                limit 4;", "text/plain"
        )->post('https://api.igdb.com/v4/games')->json();

        $comingSoon = Http::withHeaders([
            'Client-ID' => env('IGDB_CLIENT_ID'),
            'Authorization' => 'Bearer ' . $response['access_token']
        ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating;
                where platforms = (48, 49, 130, 6)
                & (first_release_date >= {$currentDate});
                limit 5;", "text/plain"
        )->post('https://api.igdb.com/v4/games')->json();

        return view('welcome', compact('popularGames', 'recentlyReviewed', 'mostAnticipated', 'comingSoon'));
    }

    public static function mergeSortGames($games){
        if(count($games) < 2){
            return $games;
        }

        $left = [];
        $right = [];
        for($i=0; $i < count($games); $i++){
            if($i < count($games) / 2){
                $left[] = $games[$i];
            } else {
                $right[] = $games[$i];
            }
        }

        $left = GamesController::mergeSortGames($left);
        $right = GamesController::mergeSortGames($right);

        return GamesController::merge($left, $right);
    }

    public static function merge($left, $right){
        $result = [];

        while(count($left) > 0 && count($right) > 0){
            if($left[0]['rating'] > $right[0]['rating']){
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }

        while(count($left) > 0){
            $result[] = array_shift($left);
        }

        while(count($right) > 0){
            $result[] = array_shift($right);
        }

        return $result;
    }
}
