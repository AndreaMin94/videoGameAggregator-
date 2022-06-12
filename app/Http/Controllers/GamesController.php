<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GamesController extends Controller
{
    public function index(){
        $response = Http::post(
            'https://id.twitch.tv/oauth2/token',
            config('services.igdb')
        )->json();
        $accessToken = $response['access_token'];

        return view('welcome', compact('accessToken'));
    }

    public function show($slug){
        $response = Http::post(
            'https://id.twitch.tv/oauth2/token',
            config('services.igdb')
        )->json();
        $accessToken = $response['access_token'];

        $game = Cache::remember('game', 10, function()use($accessToken, $slug){
            return Http::withHeaders([
                'Client-ID' => env('IGDB_CLIENT_ID'),
                'Authorization' => 'Bearer ' . $accessToken
            ])->withBody(
                "fields name, cover.url, first_release_date, platforms.abbreviation,rating, rating_count, total_rating, total_rating_count, slug, genres.name , involved_companies.company.name, aggregated_rating, summary, websites.*, videos.*, screenshots.*, similar_games.cover.url, similar_games.name, similar_games.rating, similar_games.platforms.abbreviation, similar_games.slug, storyline;
                    where slug=\"{$slug}\";", "text/plain"
            )->post('https://api.igdb.com/v4/games')
            ->json();
        });
        // dd($game);
        abort_if(!$game, 404);
        return view('game.show', ['game' => $game[0]]);
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
