<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\TemaJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class TemaJenisController extends BaseController{

    public function store(Request $request){
        $this->validate($request, [
            'id_tema' => 'required',
            'id_jn' => 'required',
        ]);

        $tema_jenis = TemaJenis::create([
            'id_tema' => $request->input('id_tema'),
            'id_jn' => $request->input('id_jn'),
        ]);

        if ( $tema_jenis ) {
            return response()->json([
                'success' => true,
                'message' => 'success add tema jenis'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add tema jenis'
        ], 400);
    }

    public function show(Request $request){
        $tema_jenis = TemaJenis::all();
        if ( $tema_jenis ) {
            return response()->json([
                'success' => true,
                'data' => [
                    'temajenis' => $tema_jenis
                    ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail get tema jenis'
        ], 400);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'id_tema' => 'required',
            'id_jn' => 'required',
        ]);

        $tema_jenis = TemaJenis::find($id);

        if($tema_jenis->fill($request->all())->save()) {
            $tema_jenis->fill($request->all())->save();
            return response()->json([
                'success' => true,
                'message' => 'success update tema jenis'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail update tema jenis'
        ], 400);
    }

    public function destroy($id){
        if(TemaJenis::destroy($id)) {
            return response()->json([
                'success' => true,
                'message' => 'success delete tema jenis'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data tema jenis not found'
        ], 404);
    }
}