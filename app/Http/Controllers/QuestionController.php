<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Question;
use App\Models\Event;

use App\Events\QuestionCreatedEvent;
use App\Events\QuestionLikedEvent;

class QuestionController extends Controller
{
    public function getAllQuestions(Request $request, $event)
    {

        // Query Questions

        $dataQuestions = Question::query();

        // Get by event
        $dataQuestions = $dataQuestions->whereHas('event', function($query) use($event) {
            return $query->where('code', '=', $event);
        });  

        //Get by sort
        $sortBy = $request->input('sort_by');
        $dataQuestions = $dataQuestions->orderBy($sortBy, 'desc');

        // Get the Data
        $dataQuestions = $dataQuestions->get();

        return response()->json([
            'message' => 'Data Berhasil di Ambil !',
            'data'     => $dataQuestions
        ], 200);

    }

    public function createQuestions(Request $request)
    {
        // Get Event ID
        $eventCode = $request->input('event_id');

        // Get Judul Pertanyaan
        $judulPertanyaan = $request->input('judul');

        // Get Penanya
        $penanya = $request->input('penanya');

        // Simpan Pertanyaan
        $dataPertanyaan = new Question();
        $dataPertanyaan->event_id = $eventCode;
        $dataPertanyaan->judul = $judulPertanyaan;
        $dataPertanyaan->penanya = $penanya;
        $dataPertanyaan->like = 0;
        $dataPertanyaan->save();

        event(new QuestionCreatedEvent($dataPertanyaan));

    }

    public function likeQuestions($id)
    {
        // Get Event Code
        // $eventCode = $request->input('event_code');

        // Simpan Pertanyaan
        $dataPertanyaan = Question::find($id);
        $dataPertanyaan->like = $dataPertanyaan->like + 1;
        $dataPertanyaan->save();

        event(new QuestionLikedEvent($dataPertanyaan));
    }
}
