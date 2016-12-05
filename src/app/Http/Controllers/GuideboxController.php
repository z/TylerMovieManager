<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;

class GuideboxController extends Controller
{
    /**
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
                new PrivateCacheStrategy(
                    new LaravelCacheStorage(
                        Cache::store('redis')
                    )
                )
            ),
            'cache'
        );

        // Initialize the client with the handler option
        $client = new Client(['handler' => $stack]);

        $api_url = 'https://api-public.guidebox.com/v1.43/US/' . config('app.guidebox_api_key');

        $search_request = $client->request('GET', $api_url . '/search/movie/title/' . $movie_name . '/fuzzy');
        if ( $search_request->getStatusCode() == 200) {
            $search_data =  json_decode($search_request->getBody()->getContents());
            $movie = $search_data->results[0];

            $metadata_request = $client->request('GET', $api_url . '/movie/' . $movie->id);

            $metadata = json_decode($metadata_request->getBody());

            $images_request = $client->request('GET', $api_url . '/movie/' . $movie->id .'/images/all');

            $images = json_decode($images_request->getBody());

            if ($images->results->thumbnails) {
                $image = $images->results->thumbnails[0]->xlarge->url;
            } else {
                $image = false;
            }

            $data = [
                'imdb' => $metadata->imdb,
                'overview' => $metadata->overview,
                'image' => $image,
            ];

            return response($data);
        } else {
            return $search_request->getStatusCode();
        }
    }
}
