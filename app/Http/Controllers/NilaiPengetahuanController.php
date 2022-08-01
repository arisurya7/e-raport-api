<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\NilaiPengetahuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class NilaiPengetahuanController extends BaseController
{
    
    public function store(Request $request){
        $this->validate($request, [
            'id_siswa' => 'required',
            'id_ta' => 'required',
            'id_mapel' => 'required',
            'id_kd' => 'required',
            'id_tema' => 'required',
            'id_jn' => 'required',
            'nilai' => 'required',
        ]);

        $nilai_pengetahuan = NilaiPengetahuan::create([
            'id_siswa' => $request->input('id_siswa'),
            'id_ta' => $request->input('id_ta'),
            'id_mapel' => $request->input('id_mapel'),
            'id_kd' => $request->input('id_kd'),
            'id_tema' => $request->input('id_tema'),
            'id_jn' => $request->input('id_jn'),
            'nilai' => $request->input('nilai')
        ]);

        if($nilai_pengetahuan) {
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

        $nilai_pengetahuan = NilaiPengetahuan::find($id);
        $nilai_pengetahuan->nilai = $request->input('nilai');
        
        if($nilai_pengetahuan->isDirty()){
            $nilai_pengetahuan->save();
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
        if(NilaiPengetahuan::destroy($id)) {
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
