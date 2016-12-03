<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Movie;
use App\Format;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            Movie::where('user_id', Auth::guard('token')->id())->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request...

        $format = Format::where('name', $request->format)->first();

        if (!$format) {
            return response()->json([
                'errors' => 'Format does not exist.'
            ], 404);
        }

        try {
            // if $movie, else, return HTTP 201
            $movie = new Movie;

            $movie->user_id = Auth::guard('token')->id();
            $movie->title = $request->title;
            $movie->format_id = $format->id;
            $movie->length = $request->length;
            $movie->year = $request->year;
            $movie->rating = $request->rating;

            $movie->save();
        }
        catch (Illuminate\Database\QueryException $e){
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Query error.'
            ], 400);
        }

        return response('', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(
            Movie::where('user_id', Auth::guard('token')->id())->where('id', $id)->first()
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request...

        $movie = Movie::where('user_id', Auth::guard('token')->id())->where('id', $id)->first();

        if (!$movie) {
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Movie not found.'
            ], 404);
        }

        $format = Format::where('name', $request->format)->first();

        if (!$format) {
            return response()->json([
                'errors' => 'Format does not exist.'
            ], 404);
        }

        try {
            $movie->title = $request->title;
            $movie->format_id = $format->id;
            $movie->length = $request->length;
            $movie->year = $request->year;
            $movie->rating = $request->rating;

            $movie->save();
        }
        catch (Illuminate\Database\QueryException $e){
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Query error.'
            ], 400);
        }

        return response('', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::where('user_id', Auth::guard('token')->id())->find($id);

        if (!$movie) {
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Movie not found.'
            ], 404);
        }

        try {
            $movie->delete();
        }
        catch (Illuminate\Database\QueryException $e){
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Query error.'
            ], 400);
        }
    }
}