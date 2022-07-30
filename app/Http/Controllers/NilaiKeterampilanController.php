<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\NilaiKeterampilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class NilaiKeterampilanController extends BaseController
{
    
    public function store(Request $request){
        $this->validate($request, [
            'id_siswa' => 'required',
            'id_ta' => 'required',
            'id_mapel' => 'required',
            'id_kd' => 'required',
            'id_kt' => 'required',
            'nilai' => 'required',
        ]);

        $nilai_ketrampilan = NilaiKeterampilan::create([
            'id_siswa' => $request->input('id_siswa'),
            'id_ta' => $request->input('id_ta'),
            'id_mapel' => $request->input('id_mapel'),
            'id_kd' => $request->input('id_kd'),
            'id_kt' => $request->input('id_kt'),
            'nilai' => $request->input('nilai')
        ]);

        if($nilai_ketrampilan) {
            return response()->json([
                'success' => true,
                'message' => 'success add nilai'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add nilai'
        ], 400);

    }

    
    public function update(Request $request, $id){
        $this->validate($request, [
            'nilai' => 'required',
        ]);

        $nilai_keterampilan = NilaiKeterampilan::find($id);
        $nilai_keterampilan->nilai = $request->input('nilai');
        
        if($nilai_keterampilan->isDirty()){
            $nilai_keterampilan->save();
            return response()->json([
                'success' => true,
                'message' => 'success update nilai'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'nothing change'
        ], 400);
    }

    public function destroy($id){
        if(NilaiKeterampilan::destroy($id)) {
            return response()->json([
                'success' => true,
                'message' => 'success delete nilai'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data nilai not found'
        ], 404);
    }

}
