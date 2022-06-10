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
        $accessToken = $response['access_token'];
        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(4)->timestamp;
        $currentDate = Carbon::now()->timestamp;

        $comingSoon = Http::withHeaders([
            'Client-ID' => env('IGDB_CLIENT_ID'),
            'Authorization' => 'Bearer ' . $response['access_token']
        ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation, rating;
                where platforms = (48, 49, 130, 6)
                & (first_release_date >= {$currentDate});
                limit 5;", "text/plain"
        )->post('https://api.igdb.com/v4/games')->json();


        return view('welcome', compact('comingSoon', 'accessToken'));
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
