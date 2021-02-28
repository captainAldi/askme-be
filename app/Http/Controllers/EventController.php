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
        $dataEvents = Event::where('code', $request->input('event_code'))
            ->where('status', '=', 'active')
            ->first();

        if (!$dataEvents) {
            return response()->json([
                'message' => 'Event Tidak Ada / Sudah di Tutup!',
            ], 403);
        }

        return response()->json([
            'message' => 'Data Berhasil di Ambil !',
            'data'     => $dataEvents
        ], 200);

    }

    public function createEvent(Request $request)
    {
        // Get Judul 
        $judulEvent = $request->input('judul');

        // Get Code 
        $codeEvent = $request->input('code');

        // Get Status
        $statusEvent = $request->input('status') == 'false' ? 'not active' : 'active' ;

        // Simpan Event
        $dataEvent = new Event();
        $dataEvent->nama_event = $judulEvent;
        $dataEvent->code = $codeEvent;
        $dataEvent->status = $statusEvent;


        $isOtherActive = Event::where('status', '=', 'active')->first();
        $isStatusActive = $statusEvent == 'active';

        if ($isStatusActive) {
            if (!$isOtherActive) {
                $dataEvent->save();

                return response()->json([
                    'message' => 'data berhasil di Simpan !',
                    'data'  => $dataEvent
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Ada Event Aktif Lain !',
                ], 406);
            }
        } else {
            $dataEvent->save();

            return response()->json([
                'message' => 'data berhasil di Tambah !',
                'data'  => $dataEvent
            ], 200);
        }

    }

    public function getKhususEvent(Request $request, $id)
    {

        // Events 
        $dataEvents = Event::where('code', $id)->first();

        if (!$dataEvents) {
            return response()->json([
                'message' => 'Event Tidak Ada / Sudah di Tutup!',
            ], 403);
        }

        return response()->json([
            'message' => 'Data Berhasil di Ambil !',
            'data'     => $dataEvents
        ], 200);

    }

    public function editEvent(Request $request, $id)
    {
        // Temukan
        $dataEvent = Event::where('code', '=', $id)->first();

        // Cek ada atau Tidak
        if(!$dataEvent) {
            return response()->json([
                'message' => 'Data Tidak Ada !',
            ], 404);
        }

        // Data Memiliki Relasi
        // if($dataEvent->questions()->exists()) 
        // {
        //     return response()->json([
        //         'message' => 'Event Memiliki Relasi !',
        //     ], 406);
        // } 

        // Pesan Jika Error
        $messages = [
            'judul.required'         => 'Masukkan Judul !',
            'code.required'          => 'Masukkan Event Code !',
            'code.unique'            => 'Event Code Sudah di Pakai !',
            'status.required'        => 'Masukkan Status !',
        ];

         //Validasi Data
        $validasiData = $this->validate($request, [
            'judul'        => 'required',
            'code'         => 'required|unique:events,code,' . $dataEvent->id,
            'status'       => 'required'
        ], $messages);

        // Get Status
        $statusEvent = $request->input('status') == 'false' ? 'not active' : 'active' ;

        // Simpan Data
        $dataEvent->nama_event   = $request->input('judul');
        $dataEvent->code   = $request->input('code');
        $dataEvent->status   = $statusEvent;

        $isOtherActive = Event::where('status', '=', 'active')->first();
        $isStatusActive = $statusEvent == 'active';

        if ($isStatusActive) {
            if (!$isOtherActive) {
                $dataEvent->save();

                return response()->json([
                    'message' => 'data berhasil di ubah !',
                    'data'  => $dataEvent
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Ada Event Aktif Lain !',
                ], 406);
            }
        } else {
            $dataEvent->save();

            return response()->json([
                'message' => 'data berhasil di ubah !',
                'data'  => $dataEvent
            ], 200);
        }

    }

    public function deleteEvent($id)
    {
        // Temukan
        $dataEvent = Event::where('code', '=', $id)->first();

        // Cek ada atau Tidak
        if(!$dataEvent) {
            return response()->json([
                'message' => 'Data Tidak Ada !',
            ], 404);
        }

        // Data Memiliki Relasi
        if($dataEvent->questions()->exists()) 
        {
            return response()->json([
                'message' => 'Event Memiliki Relasi !',
            ], 406);
        } 

        // Delete Records
        $dataEvent->delete();

        return response()->json([
            'message' => 'Data Berhasil di Hapus',
        ], 200);

    }
}
