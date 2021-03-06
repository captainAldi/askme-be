<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Event;

class EventTableSeeder extends Seeder
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
                "nama_event"  => "All Minds Januari 2019",
                "code" => "am-01-2019",
                "status" => "active"
            ],
            [
                "nama_event"  => "All Minds Februari 2020",
                "code" => "am-02-2019",
                "status" => "not active"
            ],
        ];

        foreach ($data as $key) {
            Event::create($key);
        }
    }
}
