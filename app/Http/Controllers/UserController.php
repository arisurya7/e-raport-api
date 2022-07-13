<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends BaseController
{
    
    public function register(Request $request){
        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'role' => 'required',
            'email' => 'required|unique:users',
            'nip' => 'required',
            'gelar' => 'required',
            'id_sekolah' => 'required',
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'username' => $request->input('username'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'role' => $request->input('role'),
            'email' => $request->input('email'),
            'nip' => $request->input('nip'),
            'gelar' => $request->input('gelar'),
            'token' => $request->input('token'),
            'id_sekolah' => $request->input('id_sekolah')
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'register successfully'
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'register failed'
            ], 401);
        }
    }

    public function login(Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();
        if ($user) {
            $isValidUser = Hash::check($password, $user->password);
            if($isValidUser) {
                $generateToken = bin2hex(random_bytes(40));
                $user->update(['token' => $generateToken]);
                return response()->json([
                    'success' => true,
                    'message' => 'success login',
                    'user' => $user
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'login failed'
        ], 401);
    }

    function update(Request $request) {
        
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'role' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'gelar' => 'required',
            'id_sekolah' => 'required',
        ]);
        
        $user = Auth::user();
        $user->username = $request->input('username'); 
        $user->password = Hash::make($request->input('password')); 
        $user->firstname = $request->input('firstname'); 
        $user->lastname = $request->input('lastname'); 
        $user->role = $request->input('role'); 
        $user->email = $request->input('email'); 
        $user->nip = $request->input('nip'); 
        $user->gelar = $request->input('gelar'); 
        $user->id_sekolah = $request->input('id_sekolah'); 

        if($user->isDirty()) {
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'data user success updated'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'no data change'
            ], 401);
        }

        return response()->json([
            'success' => false,
            'message' => 'update data failed'
        ], 401);
    }

    function show(Request $request) {
        $user = Auth::user();
        if($user) {
            return response()->json([
                'success' => true,
                'user'=> $user
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'failed get data user'
        ], 401);

    }
}
