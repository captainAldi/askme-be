<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    public function profile(Request $request, $id)
    {

        // Get API Key
        $api_token = $request->header('Authorization');

        // Find User
        $user = User::where('api_token', $api_token)->first();

        if($user->id != $id)
        {
            return response()->json([
                'message' => 'Anda Tidak Berhak !',
            ], 401);
        }

       return response()->json([
           'message' => 'Data Berhasil di Ambil !',
           'data'     => $user
       ], 200);

    }
}
