<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserTableSeeder extends Seeder
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
                "name"  => "Renaldi Yulvianda",
                "email" => "renaldi@alterra.id",
                "password" => Hash::make("qweqwe1"),
            ],
            [
                "name"  => "Sugeng Riyadi",
                "email" => "sugeng@alterra.id",
                "password" => Hash::make("qweqwe2"),
            ],
        ];

        foreach ($data as $key) {
            User::create($key);
        }
    }
}
