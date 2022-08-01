<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\NilaiKeterampilan;
use App\Models\KompetensiDasar;
use App\Models\Keterampilan;
use App\Models\TemaKd;
use App\Models\TemaJenis;
use App\Models\Tema;
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

    public function pengetahuan(Request $request){
        $this->validate($request, [
            'id_mapel' => 'required',
            'id_jn' => 'required',
        ]);

        $list_nilai = DB::table('kompetensi_dasar')
                        ->join('tema_kd', 'tema_kd.id_kd', '=', 'kompetensi_dasar.id_kd')
                        ->join('tema_jenis', 'tema_jenis.id_tema', '=', 'tema_kd.id_tema')
                        ->join('tema', 'tema.id_tema', '=', 'tema_jenis.id_tema')
                        ->select('tema_kd.id_tkd', 'kompetensi_dasar.kode_kd', 'kompetensi_dasar.deskripsi_kd', 'tema.nama_tema')
                        ->where('kompetensi_dasar.id_mapel', '=', $request->query('id_mapel'))
                        ->where('tema_jenis.id_jn', '=', $request->query('id_jn'))
                        ->orderBy('tema.nama_tema')->get();
        
        if ($list_nilai) {
            return response()->json([
                'success' => true,
                'data' => [
                    'penilaian_pengetahuan' => $list_nilai
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail get list penilaian'
        ], 401);
    }

    public function keterampilan(Request $request){
        $this->validate($request, [
            'id_siswa' => 'required',
            'id_ta' => 'required',
            'id_mapel' => 'required',
        ]);

        $kompetensi_dasar = KompetensiDasar::where('id_mapel', $request->query('id_mapel'))
                                            ->where('kategori_kd', 'keterampilan')
                                            ->get(['id_kd','kode_kd','deskripsi_kd']);
        $keterampilan = Keterampilan::all();
        $nilai_keterampilan = NilaiKeterampilan::where('id_siswa', $request->query('id_siswa'))
                                                ->where('id_mapel', $request->query('id_mapel'))
                                                ->where('id_ta', $request->query('id_ta'))
                                                ->get(['id_nk','id_kd','id_kt','nilai']);
        $list_nilai= [];
        foreach ($kompetensi_dasar as $kd) {
            foreach ($keterampilan as $kt) {
                array_push($list_nilai, 
                    [ 
                        'id_siswa' => $request->query('id_siswa'),
                        'id_mapel' => $request->query('id_mapel'),
                        'id_ta' => $request->query('id_ta'),
                        'id_kd' => $kd->id_kd,
                        'kode_kd' => $kd->kode_kd,
                        'deskripsi_kd' => $kd->deskripsi_kd,
                        'id_kt' => $kt->id_kt,
                        'nama_kt' => $kt->nama,
                        'id_nk' => null,
                        'nilai' => null
                    ]
                );
            }
        }

        
        if( count($nilai_keterampilan) > 0) {
            foreach ($list_nilai as $key => $ln) {
                foreach ($nilai_keterampilan as $nk) {
                    if( ($ln['id_kd'] == $nk->id_kd) && ($ln['id_kt'] == $nk->id_kt) ) {
                        $list_nilai[$key]['id_nk'] = $nk->id_nk;
                        $list_nilai[$key]['nilai'] = $nk->nilai;
                        break;
                    }
                }
            }
        }
        
        if ($list_nilai) {
            return response()->json([
                'success' => true,
                'data' => [
                    'penilaian_keterampilan' => $list_nilai
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail get list keterampilan'
        ], 401);
    }
}