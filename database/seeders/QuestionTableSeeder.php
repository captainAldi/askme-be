<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "event_id"  => 1,
                "penanya"   => "Naruto",
                "judul"     => "Pertanyaan 1 ?",
                "like"      => 1,
            ],
            [
                "event_id"  => 1,
                "penanya"   => "",
                "judul"     => "Pertanyaan 12 ?",
                "like"      => 2,
            ],
        ];

        foreach ($data as $key) {
            Question::create($key);
        }
    }
}
