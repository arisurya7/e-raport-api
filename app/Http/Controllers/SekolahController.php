<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends BaseController{

    public function store(Request $request){
        $this->validate($request, [
            'nama_sekolah' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        $sekolah = Sekolah::create([
            'nama_sekolah' => $request->input('nama_sekolah'),
            'telp' => $request->input('telp'),
            'alamat' => $request->input('alamat'),
            'kelurahan' => $request->input('kelurahan'),
            'kecamatan' => $request->input('kecamatan'),
            'kabupaten' => $request->input('kabupaten'),
            'provinsi' => $request->input('provinsi'),
        ]);

        if($sekolah) {
            return response()->json([
                'success' => true,
                'message' => 'success added sekolah'
            ], 201);
        } 

        return response()->json([
            'success' => false,
            'message' => 'add sekolah fail'
        ], 400);

    }

    public function show(Request $request){
        $sekolah = Sekolah::all();
        if ($sekolah) {
            return response()->json([
                'success' => true,
                'data' => $sekolah
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'sekolah not found'
        ], 404);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'nama_sekolah' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        $sekolah = Sekolah::find($id);
        
        if($sekolah->fill($request->all())->save()){ 
            return response()->json([
                'success' => true,
                'message' => 'update sekolah success'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'update data failed'
        ], 400);
        
    }

    public function destroy($id){
        if(Sekolah::destroy($id)){
            return response()->json([
                'success' => true,
                'message' => 'delete data success'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data not found'
        ], 404);
    }
}