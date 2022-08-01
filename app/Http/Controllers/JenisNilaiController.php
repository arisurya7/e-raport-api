<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\JenisNilai;
use Illuminate\Http\Request;
use Auth;

class JenisNilaiController extends BaseController{
    
    public function show(Request $request){
        $jenis_nilai = JenisNilai::all();
        if($jenis_nilai){
            return response()->json([
                'success' => true,
                'data' => $jenis_nilai
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'something fail'
        ], 500);
    }
}