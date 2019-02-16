<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\User;
use JWTFactory;
use JWTAuth;

class AuthController extends Controller
{
    public function loginUser(Request $request) {
        $user = DB::table('users')->where("email", $request->email)->first();
        if (empty($user)) {
            return response()->json("User not found", 404);
        }
        if (Hash::check($request->password, $user->password,)) {
            $payload = JWTFactory::sub(123)->email($request->email)->make();
            $token = JWTAuth::encode($payload);
            $headers = ['X-Token-Auth' => $token];
            return response()->json($user, 200, $headers);
        } else {
            return response('Unauthorized Action', 401);
        }
    }

    public function authenticateUser(Request $request) {
        $user = User::find($request->user->id);
        return response()->json($user, 200);
    }

    public function editUser(Request $request) {
        $user = User::find($request->user->id);
        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->newPassword) {
            if (Hash::check($request->oldPassword, $user->password,)) {
                $user->password = Hash::make($request->newPassword);
            } else {
                //old pass wrong
                return response("Wrong Password", 400);
            }
        }
        $user->save();
        return response()->json($user, 200);
    }
    
    public function registerUser(Request $request) {
        if (!empty(DB::table('users')->where("email", $request->email)->first())) {
            return response('User already exist with this email', 409);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json($user, 201);
    }
    // public function guard()
    // {
    //     return Auth::guard();
    // }
}
