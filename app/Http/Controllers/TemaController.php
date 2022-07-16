<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Tema;
use Illuminate\Http\Request;
use Auth;

class TemaController extends BaseController{

    public function store(Request $request){
        $this->validate($request, [
            'id_mapel' => 'required',
            'nama_tema' => 'required',
        ]);

        $tema = Tema::create([
            'id_mapel' => $request->input('id_mapel'),
            'nama_tema' => $request->input('nama_tema'),
        ]);

        if ( $tema ) {
            return response()->json([
                'success' => true,
                'message' => 'success add tema'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add tema'
        ], 400);
    }

    public function show(Request $request){
        $tema = Tema::all();
        
        if ( $tema ) {
            return response()->json([
                'success' => true,
                'data' => [
                    'tema' => $tema
                    ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail get tema'
        ], 400);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'id_mapel' => 'required',
            'nama_tema' => 'required',
        ]);

        $tema = Tema::find($id);

        if($tema->fill($request->all())->save()) {
            $tema->fill($request->all())->save();
            return response()->json([
                'success' => true,
                'message' => 'success update tema'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail update tema'
        ], 400);
    }

    public function destroy($id){
        if(Tema::destroy($id)) {
            return response()->json([
                'success' => true,
                'message' => 'success delete tema'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data kd not found'
        ], 404);
    }
}