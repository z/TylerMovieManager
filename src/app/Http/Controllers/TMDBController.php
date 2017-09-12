<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;

class TMDBController extends Controller
{
    /**3
     * -+
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param $movie_name
     *
     * @return \Illuminate\Http\Response
     */
    public function index($movie_name)
    {
        // Create default HandlerStack
        $stack = HandlerStack::create();

        $stack->push(
            new CacheMiddleware(
                new GreedyCacheStrategy(
                    new LaravelCacheStorage(
                        Cache::store('redis')
                    ),
                    18000
                )
            ),
            'greedy-cache'
        );

        Cache::flush();

        // Initialize the client with the handler option
        $client = new Client(['handler' => $stack]);

        $movie_hash = sha1($movie_name);

        $data = Cache::store('redis')->get($movie_hash);

        if ($data) {
            return response($data);
        } else {
            $api_url = 'https://api.themoviedb.org/3/';
            $web_url = 'https://image.tmdb.org/t/p/w500';

            $search_request = $client->request('GET', $api_url . 'search/movie?query=' . $movie_name . '&api_key=' . config('app.tmdb_api_key'));

            if ($search_request->getStatusCode() == 200) {
                $search_data = json_decode($search_request->getBody()->getContents());
                $movie = $search_data->results[0];

                if ($movie->poster_path) {
                    $image = $web_url . $movie->poster_path;
                } else {
                    $image = false;
                }

                $data = [
                    'imdb' => null,
                    'overview' => $movie->overview,
                    'image' => $image,
                ];

                Cache::store('redis')->put($movie_hash, $data, 10000);

                return response($data);
            } else {
                return response($search_request->getStatusCode());
            }
        }
    }
}
