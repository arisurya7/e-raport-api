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

        $siswa = Siswa::where('id_siswa',$request->query('id_siswa'))->first()->get(['nama_siswa','nama_panggilan', 'nis', 'nisn', 'kelas'])[0];
        $sekolah = Sekolah::where('id_sekolah', Auth::user()->id_sekolah)->first()->get()[0];
        $pengetahuan_kd = DB::select('CALL nilai_pengetahuan_by_kd('.$request->query('id_siswa').','.$request->query('id_ta').')');
        $keterampilan_kd = DB::select('CALL nilai_keterampilan_by_kd('.$request->query('id_siswa').','.$request->query('id_ta').')');
        
        //finding nilai akhir pengetahuan
        $idf_mapel = [];
        $min_kd = [9999999999,''];
        $max_kd = [0,''];
        $na_nk = [];
        $nilai_pengetahuan = [];
        
        foreach ($pengetahuan_kd as $key => $pengetahuan) {
            if (in_array($pengetahuan->id_mapel, $idf_mapel)) {
                //cek min max
                if($min_kd[0] > $pengetahuan->na) {
                    $min_kd[0] = $pengetahuan->na;
                    $min_kd[1] = $pengetahuan->deskripsi_kd;
                }
                if($max_kd[0] < $pengetahuan->na) {
                    $max_kd[0] = $pengetahuan->na;
                    $max_kd[1] = $pengetahuan->deskripsi_kd;
                }

                //hitung
                array_push($na_nk,$pengetahuan->na);
                $avg_na = array_sum($na_nk)/count($na_nk);
                $predikat = $avg_na==0? '' : checkPredikatScore($avg_na)[0];
                $deskripsi = $avg_na==0? '' : $siswa->nama_panggilan.' '. checkPredikatScore($max_kd[0])[1]. ' dalam ' .$max_kd[1].', ' . checkPredikatScore($min_kd[0])[1].' dalam ' .$min_kd[1].'.';
               
                //update
                $nilai_pengetahuan[$pengetahuan->id_mapel]['nilai'] = $avg_na;
                $nilai_pengetahuan[$pengetahuan->id_mapel]['predikat'] = $predikat;
                $nilai_pengetahuan[$pengetahuan->id_mapel]['deskripsi'] = $deskripsi;                  
               
            } else {
                //reset nilai
                $min_kd = [9999999999,''];
                $max_kd = [0,''];
                $na_nk = [];

                //cek min max
                if($min_kd[0] > $pengetahuan->na) {
                    $min_kd[0] = $pengetahuan->na;
                    $min_kd[1] = $pengetahuan->deskripsi_kd;
                }
                if($max_kd[0] < $pengetahuan->na) {
                    $max_kd[0] = $pengetahuan->na;
                    $max_kd[1] = $pengetahuan->deskripsi_kd;
                }
                
                //hitung
                array_push($na_nk,$pengetahuan->na);
                $avg_na = array_sum($na_nk)/count($na_nk);
                $predikat = $avg_na==0? '' : checkPredikatScore($avg_na)[0];
                $deskripsi = $avg_na==0? '' : $siswa->nama_panggilan.' '. checkPredikatScore($max_kd[0])[1]. ' dalam ' .$max_kd[1].', ' . checkPredikatScore($min_kd[0])[1].' dalam ' .$min_kd[1].'.';

                //create
                $nilai_pengetahuan[$pengetahuan->id_mapel] = [ 
                    'id_mapel' => $pengetahuan->id_mapel,
                    'nama_mapel' => $pengetahuan->nama_mapel,
                    'kkm' => $pengetahuan->kkm,
                    'nilai' => $avg_na,
                    'predikat' => $predikat,
                    'deskripsi' => $deskripsi
                ];

                array_push($idf_mapel, $pengetahuan->id_mapel);
            }

                

        }
        dd($nilai_pengetahuan);
    

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


function checkPredikatScore($score){ 
    $score = round($score,0,PHP_ROUND_HALF_UP);
    if($score >= 88){
       return ['A','sangat baik'];
    }else if ($score >= 74 && $score <= 87){
       return ['B','baik'];
    }else if ($score >= 60 && $score <= 73){
       return ['C','cukup'];
    }else if ($score <= 59){
       return ['D','perlu bimbingan'];
    }
 }

