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

        return view('welcome', compact('accessToken'));
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
