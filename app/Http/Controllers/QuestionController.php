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

    public function getSemuaQuestions(Request $request) 
    {
        //Variable Pencarian
        $cari_event = $request->input('event');
        $cari_pertanyaan = $request->input('pertanyaan');
        $cari_penanya = $request->input('penanya');

        $tipe_sort = 'desc';
        $var_sort = 'created_at';

        // Semua Questions
        $semuaQuestions = Question::query();

        // Kondisi Search
        if ($cari_event != '') {
            $semuaQuestions = $semuaQuestions->whereHas('event', function($query) use($cari_event) {
                return $query->where('code', '=', $cari_event);
            });  
        }

        if ($cari_pertanyaan != '') {
            $semuaQuestions = $semuaQuestions->where('judul', 'LIKE', '%'.$cari_pertanyaan.'%');
        }

        if ($cari_penanya != '') {
            $semuaQuestions = $semuaQuestions->where('penanya', 'LIKE', '%'.$cari_penanya.'%');
        }

        if( $request->has('sortbydesc') || $request->has('sortby') ) {
            $tipe_sort = $request->input('sortbydesc');
            $var_sort = $request->input('sortby');

            $semuaQuestions = $semuaQuestions
                                ->select('questions.*')
                                ->join('events', 'questions.event_id', '=', 'events.id')
                                ->orderBy('questions.'.$var_sort, $tipe_sort);

            // $semuaQuestions = $semuaQuestions->event()->orderBy($var_sort, $tipe_sort);
        }

        // Eager Loading
        $semuaQuestions = $semuaQuestions->with('event');

        //Tampilkan
        
        $set_pagination = $request->input('per_page');

        if ($set_pagination != '') {
            $semuaQuestions = $semuaQuestions
                        ->paginate($set_pagination);
        } else {
            $semuaQuestions = $semuaQuestions
                        ->paginate(10);
        }
        

        //Show the Data
        return response()->json([
            'message' => 'Data Berhasil di Ambil',
            'data'  => $semuaQuestions,
        ], 200);


    }
}
