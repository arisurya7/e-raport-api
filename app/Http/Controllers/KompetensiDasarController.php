<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\KompetensiDasar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class KompetensiDasarController extends BaseController{

    public function store(Request $request){
        $this->validate($request, [
            'id_mapel' => 'required',
            'kode_kd' => 'required',
            'kategori_kd' => 'required',
            'deskripsi_kd' => 'required',
        ]);

        $kd = KompetensiDasar::create([
            'id_mapel' => $request->input('id_mapel'),
            'kode_kd' => $request->input('kode_kd'),
            'kategori_kd' => $request->input('kategori_kd'),
            'deskripsi_kd' => $request->input('deskripsi_kd'),
        ]);

        if ( $kd ) {
            return response()->json([
                'success' => true,
                'message' => 'success add kompetensi dasar'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add kompetensi dasar'
        ], 400);
    }

    public function show(Request $request){
        $userAuth = Auth::user();
        $kd = DB::table('users')
                ->join('mapel', 'mapel.id_user', '=', 'users.id_user')
                ->join('kompetensi_dasar', 'kompetensi_dasar.id_mapel', '=', 'mapel.id_mapel')
                ->select('kompetensi_dasar.*')
                ->where('users.id_user', '=', $userAuth->id_user)->get();
        
        if ( $kd ) {
            return response()->json([
                'success' => true,
                'data' => [
                    'kd' => $kd
                    ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail get kd'
        ], 400);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'id_mapel' => 'required',
            'kategori_kd' => 'required',
            'kode_kd' => 'required',
            'deskripsi_kd' => 'required',

        ]);

        $kd = KompetensiDasar::find($id);

        if($kd->fill($request->all())->save()) {
            $kd->fill($request->all())->save();
            return response()->json([
                'success' => true,
                'message' => 'success update kd'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail update kd'
        ], 400);
    }

    public function destroy($id){
        if(KompetensiDasar::destroy($id)) {
            return response()->json([
                'success' => true,
                'message' => 'success delete kd'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data kd not found'
        ], 404);
    }
}