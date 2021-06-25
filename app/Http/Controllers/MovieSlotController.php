<?php

namespace App\Http\Controllers;

use App\Models\MovieSlot;
use Illuminate\Http\Request;

class MovieSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'movie_id' => 'required|integer',
            'slot_id' => 'required|integer'
        ]);

        $slot = new MovieSlot();
        $slot->movie_id = $request->movie_id;
        $slot->slot_id = $request->slot_id;
        $slot->save();

        if ($slot)
            return response()->json([
                'success' => true,
                'data' => $slot
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos no se pudo asignar el horario a la pelicula.'
            ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovieSlot  $movieSlot
     * @return \Illuminate\Http\Response
     */
    public function show(MovieSlot $movieSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovieSlot  $movieSlot
     * @return \Illuminate\Http\Response
     */
    public function edit(MovieSlot $movieSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MovieSlot  $movieSlot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MovieSlot $movieSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovieSlot  $movieSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_movie,$id_slot)
    {
        //
    }

}