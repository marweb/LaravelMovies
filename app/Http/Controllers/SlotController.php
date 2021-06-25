<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class SlotController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $slots = Slot::all();
        return response()->json([
            'success' => true,
            'data' => $slots
        ]);
    }
    public function show($id)
    {
        $slot = Slot::find($id);

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, el turno con el id ' . $id . ' no existe.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $slot
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'time' => 'required|date_format:H:i',
            'status' => 'required|integer'
        ]);

        $slot = new Slot();
        $slot->time = $request->time;
        $slot->status = $request->status;
        $slot->save();

        if ($slot)
            return response()->json([
                'success' => true,
                'data' => $slot
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos el horario no se pudo agregar.'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $slot = Slot::find($id);

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, el turno con el id ' . $id . ' no existe.'
            ], 400);
        }

        $updated = $slot->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, el turno no se pudo actualizar.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $slot = Slot::find($id);

        if (!$slot) {
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, el turno con el id ' . $id . ' no existe.'
            ], 400);
        }

        if ($slot->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'El turno no se pudo eliminar correctamente.'
            ], 500);
        }
    }
}