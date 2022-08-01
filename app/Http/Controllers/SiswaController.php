<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class SiswaController extends BaseController{

    public function store(Request $request){
        $this->validate($request, [
            'id_user' => 'required',
            'username' => 'required:unique:siswa',
            'password' => 'required',
            'nis' => 'required',
            'nisn' => 'required',
            'nama_siswa' => 'required',
            'nama_panggilan' => 'required',
            'ttl' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',
        ]);

        $siswa = Siswa::create([
            'id_user' => $request->input('id_user'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'nis' => $request->input('nis'),
            'nisn' => $request->input('nisn'),
            'nama_siswa' => $request->input('nama_siswa'),
            'nama_panggilan' => $request->input('nama_panggilan'),
            'ttl' => $request->input('ttl'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'agama' => $request->input('agama'),
            'alamat' => $request->input('alamat'),
            'kelas' => $request->input('kelas'),
        ]);

        if($siswa) {
            return response()->json([
                'success' => true,
                'message' => 'success add siswa'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add siswa'
        ], 400);

    }

    public function show(Request $request){
        $user = Auth::user();
        $siswa_user = Siswa::where('id_user', $user->id_user)->get();
        
        if($siswa_user){
            return response()->json([
                'success' => true,
                'data' => $siswa_user
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'data mapel not found'
        ], 404);

    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'id_user' => 'required',
            'username' => 'required',
            'password' => 'required',
            'nis' => 'required',
            'nisn' => 'required',
            'nama_siswa' => 'required',
            'nama_panggilan' => 'required',
            'ttl' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',
        ]);
        $request['password'] = Hash::make($request->input('password'));
        $siswa = Siswa::find($id);

        if($siswa->username != $request->input('username')){
            $this->validate($request, ['username' => 'unique:siswa']);
        }
        if($siswa->fill($request->all())->save()) {
            return response()->json([
                'success' => true,
                'message' => 'success update siswa'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail update siswa'
        ], 400);
    }

    public function destroy($id){
        if(Siswa::destroy($id)) {
            return response()->json([
                'success' => true,
                'message' => 'success delete siswa'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'delete siswa not found'
        ], 404);
    }
}