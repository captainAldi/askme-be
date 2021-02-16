<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Event;

class EventController extends Controller
{
    public function getAllEvents(Request $request)
    {

        // Events 
        $dataEvents = Event::all();

        return response()->json([
            'message' => 'Data Berhasil di Ambil !',
            'data'     => $dataEvents
        ], 200);

    }

    public function getSpecificEvent(Request $request)
    {

        // Events 
        $dataEvents = Event::where('code', $request->input('event_code'))->first();

        if (!$dataEvents) {
            return response()->json([
                'message' => 'Event Tidak Ada !',
            ], 404);
        }

        return response()->json([
            'message' => 'Data Berhasil di Ambil !',
            'data'     => $dataEvents
        ], 200);

    }
}
