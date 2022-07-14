<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Auth;

class MapelController extends BaseController{

    public function store(Request $request){
        $this->validate($request, [
            'id_user' => 'required',
            'nama_mapel' => 'required',
            'kkm' => 'required',
            'is_mulok' => 'required',
            'is_religion' => 'required',
        ]);

        $mapel = Mapel::create([
            'id_user' => $request->input('id_user'),
            'nama_mapel' => $request->input('nama_mapel'),
            'kkm' => $request->input('kkm'),
            'is_mulok' => $request->input('is_mulok'),
            'is_religion' => $request->input('is_religion'),
        ]);

        if($mapel) {
            return response()->json([
                'success' => true,
                'message' => 'success add mapel'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add mapel'
        ], 400);

    }

    public function show(Request $request){
        $user = Auth::user();
        $mapel_user = Mapel::where('id_user', $user->id_user)->get();

        
        if($mapel_user){
            return response()->json([
                'success' => true,
                'data' => $mapel_user
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
            'nama_mapel' => 'required',
            'kkm' => 'required',
            'is_mapel' => 'required',
            'is_religion' => 'required',
        ]);

        $mapel = Mapel::find($id);

        if($mapel->fill($request->all())->save()) {
            $mapel->fill($request->all())->save();
            return response()->json([
                'success' => true,
                'message' => 'success update mapel'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail update mapel'
        ], 400);
    }

    public function destroy($id){
        if(Mapel::destroy($id)) {
            return response()->json([
                'success' => true,
                'message' => 'success delete mapel'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data mapel not found'
        ], 404);
    }
}