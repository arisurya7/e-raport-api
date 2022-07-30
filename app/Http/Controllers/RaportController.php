<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\NilaiPengetahuan;
use App\Models\NilaiKeterampilan;
use App\Models\NilaiSosial;
use App\Models\NilaiSpiritual;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class RaportController extends BaseController
{
    
    public function show(Request $request){
        $this->validate($request, [
            'id_siswa' => 'required',
            'id_ta' => 'required',
        ]);

        $nilai_sosial = NilaiSosial::where('id_siswa', $request->query('id_siswa'))
                                     ->where('id_ta', $request->query('id_ta'))
                                     ->get(['deskripsi']);
        $nilai_spiritual = NilaiSpiritual::where('id_siswa', $request->query('id_siswa'))
                                     ->where('id_ta', $request->query('id_ta'))
                                     ->get(['deskripsi']);

        $siswa = Siswa::where('id_siswa',$request->query('id_siswa'))->first()->get(['nama_siswa', 'nis', 'nisn', 'kelas']);
        $sekolah = Sekolah::where('id_sekolah', Auth::user()->id_sekolah)->first()->get();
        /*
        if($raport) {
            return response()->json([
                'success' => true,
                'message' => 'success add nilai'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add nilai'
        ], 400);
        */

    }

}
