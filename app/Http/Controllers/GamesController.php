<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
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

        $game = Cache::remember('game', 3, function()use($accessToken, $slug){
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
        return view(
            'game.show',
            [
                'game' => $this->formatGameForView($game[0])
            ]
        );
    }

    private function formatGameForView($game)
    {
        $temp = collect($game)->merge([
            'coverImageUrl' => isset($game['cover']) ? Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) : '',
            'genres' => collect($game['genres'])->pluck('name')->implode(', '),
            'involved_companies' => isset($game[ 'involved_companies']) ?  $game['involved_companies'][0]['company']['name'] : '',
            'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            'rating' => isset($game['rating']) ? round($game['rating']) . '%' : '0%',
            'rating_count' => isset($game['rating_count']) ? round($game['rating_count']) . '%' : '0%',
            'storyline' => $this->checkAndReturnDescription($game['storyline'] ?? null, $game['summary'] ?? null),
            'trailer' => isset($game['videos']) ? "https://youtube.com/watch/{$game['videos'][0]['video_id']}" : null,
            'screenshots' => isset($game['screenshots']) ? $this->generateUrlScreenshots($game['screenshots']) : null
        ]);
        dump($temp);
        return $temp;
    }

    public function generateUrlScreenshots($screenshots)
    {
        return collect($screenshots)->map(function($image){
            return Str::replaceFirst('thumb', 'screenshot_big', $image['url']);
        });
    }

    public function checkAndReturnDescription($storyline = null, $summary = null)
    {
        if(!$storyline && !$summary){
            return '';
        }
        if($storyline){
            return $storyline;
        } else if($summary) {
            return $summary;
        }
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
