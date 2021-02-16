<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
 
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
 
        $email = $request->input("email");
        $password = $request->input("password");
 
        $user = User::where("email", $email)->first();
 
        if (!$user) {
            $out = [
                "message" => "User Tidak di Temukan !",
                "code"    => 404,
                "result"  => [
                    "token" => null,
                ]
            ];
            return response()->json($out, $out['code']);
        }
 
        if (Hash::check($password, $user->password)) {
            $newtoken  = Str::random(32);
 
            $user->update([
                'api_token' => $newtoken
            ]);
 
            $out = [
                "message" => "Login Sukses",
                "code"    => 200,
                "result"  => [
                    "profile"   => $user,
                    "api_token" => $newtoken,
                ]
            ];
        } else {
            $out = [
                "message" => "Password Salah !",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
        }

        return response()->json($out, $out['code']);
    }
 
}
