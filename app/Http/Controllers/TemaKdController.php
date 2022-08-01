<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\TemaKd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class TemaKdController extends BaseController{

    public function store(Request $request){
        $this->validate($request, [
            'id_tema' => 'required',
            'id_kd' => 'required',
        ]);

        $tema_kd = TemaKd::create([
            'id_tema' => $request->input('id_tema'),
            'id_kd' => $request->input('id_kd'),
        ]);

        if ( $tema_kd ) {
            return response()->json([
                'success' => true,
                'message' => 'success add tema kd'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add tema kd'
        ], 400);
    }

    public function show(Request $request){
        $userAuth = Auth::user();
        $tema_kd = DB::table('tema_kd')
                    ->join('kompetensi_dasar', 'kompetensi_dasar.id_kd', '=', 'tema_kd.id_kd')
                    ->join('mapel', 'mapel.id_mapel', '=', 'kompetensi_dasar.id_mapel')
                    ->select('tema_kd.*')
                    ->where('mapel.id_user', '=', $userAuth->id_user)->get();
        
        if ( $tema_kd ) {
            return response()->json([
                'success' => true,
                'data' => [
                    'temakd' => $tema_kd
                    ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail get tema kd'
        ], 400);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'id_tema' => 'required',
            'id_kd' => 'required',
        ]);

        $tema_kd = TemaKd::find($id);

        if($tema_kd->fill($request->all())->save()) {
            $tema_kd->fill($request->all())->save();
            return response()->json([
                'success' => true,
                'message' => 'success update tema kd'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail update tema'
        ], 400);
    }

    public function destroy($id){
        if(TemaKd::destroy($id)) {
            return response()->json([
                'success' => true,
                'message' => 'success delete tema kd'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data kd not found kd'
        ], 404);
    }
}