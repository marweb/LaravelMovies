<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all();
        //Movie List
        return response()->json([
            'success' => true,
            'message' => 'Listado de Peliculas',
            'data' => $movies
            ], Response::HTTP_OK);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
              //Validate data
              $data = $request->only('name', 'pubDate', 'movieImage', 'status');
              $validator = Validator::make($data, [
                  'name' => 'required|string',
                  'pubDate' => 'required|date',
                  'movieImage' => 'required|mimes:png,jpg,jpeg,gif|max:3048',
                  'status' => 'required'
              ]);

              //Send failed response if request is not valid
              if ($validator->fails()) {
                  return response()->json(['error' => $validator->messages()], 200);
              }

              if ($file = $request->file('movieImage')) {

                    $fileName = 'mov-'.time().'.'.$request->movieImage->extension();
                    $request->movieImage->move(public_path('uploads/movies'), $fileName);

                    //Request is valid, create new movie
                    $movie = Movie::create([
                        'name' => $request->name,
                        'pubDate' => $request->pubDate,
                        'movieImage' => $fileName,
                        'status' => $request->status
                    ]);

                    //Movie created, return success response
                    return response()->json([
                        'success' => true,
                        'message' => 'Pelicula creada correctamente',
                        'data' => $movie
                    ], Response::HTTP_OK);

                }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, la pelicula con el id ' . $id . ' no existe.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $movie
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
                return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, la pelicula con el id ' . $id . ' no existe.'
                ], 400);
        }

        //dd($request);

        if ($file = $request->file('movieImage')) {

                $imagePath = public_path('uploads/movies/'.$movie->movieImage);
                // Delete old movie image if file exist
                if(file_exists($imagePath)){
                    unlink($imagePath);
                }

                $fileName = 'mov-'.time().'.'.$request->movieImage->extension();
                $request->movieImage->move(public_path('uploads/movies'), $fileName);

                //Request is valid, update movie
                $movieData = [
                    'name' => $request->name,
                    'pubDate' => $request->pubDate,
                    'movieImage' => $fileName,
                    'status' => $request->status
                ];

        }else {

                //Request is valid, update movie
                $movieData = [
                    'name' => $request->name,
                    'pubDate' => $request->pubDate,
                    'status' => $request->status
                ];
        }

        $updated =  $movie->update($movieData);

        if ($updated) {
                //Movie updated, return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Pelicula editada correctamente',
                    'data' => $movie
                ], Response::HTTP_OK);
        } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Lo sentimos, la pelicula no se pudo actualizar.'
                ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, la pelicula con el id ' . $id . ' no existe.'
            ], 400);
        }

        $imagePath = public_path('uploads/movies/'.$movie->movieImage);
        // Delete movie image if file exist
        if(file_exists($imagePath)){
            unlink($imagePath);
        }

        if ($movie->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'La pelicula no se pudo eliminar correctamente.'
            ], 500);
        }
    }

    /**
     * Get Slots
     *
     * @return \Illuminate\Http\Response
     */
    public function getSlots($id)
    {
        $movie = Movie::with('slots')->find($id);

        return response()->json([
            'success' => true,
            'data' => $movie
        ]);
    }

    /**
     * Assign Slot
     *
     * @return \Illuminate\Http\Response
     */
    public function assignSlot(Request $request)
    {
        $movie = Movie::find($request->movie_id);
        $movie->slots()->attach($request->slot_id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove Slot
     *
     * @return \Illuminate\Http\Response
     */
    public function removeSlot(Request $request)
    {
        $movie = Movie::find($request->movie_id);
        $movie->slots()->detach($request->slot_id);

        return response()->json([
            'success' => true
        ]);
    }
}