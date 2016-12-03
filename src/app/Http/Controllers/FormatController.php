<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Format;

class FormatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            Format::all()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Limit access to admin
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Limit access to admin
        // Validate the request...

        try {
            $format = new Format;

            $format->name = $request->name;

            $format->save();
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
            Format::where('id', $id)->first()
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
        // Limit access to admin
        // if $format, else, return HTTP 201
        $format = Format::find($id);

        if (!$format) {
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Format not found.'
            ], 404);
        }

        try {
            $format->name = $request->name;

            $format->save();
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
        // Limit access to admin
        $format = Format::find($id);

        if (!$format) {
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Format not found.'
            ], 404);
        }

        try {
            $format->delete();
        }
        catch (Illuminate\Database\QueryException $e){
            // log: $e->getMessage();
            return response()->json([
                'errors' => 'Query error.'
            ], 400);
        }
    }
}