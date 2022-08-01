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
                $min_kd = checkMinValue($min_kd, $pengetahuan);
                $max_kd = checkMaxValue($max_kd, $pengetahuan);

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
                $min_kd = checkMinValue($min_kd, $pengetahuan);
                $max_kd = checkMaxValue($max_kd, $pengetahuan);
                
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

        //finding nilai akhir keterampilan
        $idf_mapel = [];
        $min_kd = [9999999999,''];
        $max_kd = [0,''];
        $na_nk = [];
        $nilai_keterampilan = [];
        foreach ($keterampilan_kd as $key => $keterampilan) {
            if (in_array($keterampilan->id_mapel, $idf_mapel)) {
                //cek min max
                $min_kd = checkMinValue($min_kd, $keterampilan);
                $max_kd = checkMaxValue($max_kd, $keterampilan);

                //hitung
                array_push($na_nk,$keterampilan->na);
                $avg_na = array_sum($na_nk)/count($na_nk);
                $predikat = $avg_na==0? '' : checkPredikatScore($avg_na)[0];
                $deskripsi = $avg_na==0? '' : $siswa->nama_panggilan.' '. checkPredikatScore($max_kd[0])[1]. ' dalam ' .$max_kd[1].', ' . checkPredikatScore($min_kd[0])[1].' dalam ' .$min_kd[1].'.';
               
                //update
                $nilai_keterampilan[$keterampilan->id_mapel]['nilai'] = $avg_na;
                $nilai_keterampilan[$keterampilan->id_mapel]['predikat'] = $predikat;
                $nilai_keterampilan[$keterampilan->id_mapel]['deskripsi'] = $deskripsi;                  
               
            } else {
                //reset nilai
                $min_kd = [9999999999,''];
                $max_kd = [0,''];
                $na_nk = [];

                //cek min max
                $min_kd = checkMinValue($min_kd, $keterampilan);
                $max_kd = checkMaxValue($max_kd, $keterampilan);
                
                //hitung
                array_push($na_nk,$keterampilan->na);
                $avg_na = array_sum($na_nk)/count($na_nk);
                $predikat = $avg_na==0? '' : checkPredikatScore($avg_na)[0];
                $deskripsi = $avg_na==0? '' : $siswa->nama_panggilan.' '. checkPredikatScore($max_kd[0])[1]. ' dalam ' .$max_kd[1].', ' . checkPredikatScore($min_kd[0])[1].' dalam ' .$min_kd[1].'.';

                //create
                $nilai_keterampilan[$keterampilan->id_mapel] = [ 
                    'id_mapel' => $keterampilan->id_mapel,
                    'nama_mapel' => $keterampilan->nama_mapel,
                    'kkm' => $keterampilan->kkm,
                    'nilai' => $avg_na,
                    'predikat' => $predikat,
                    'deskripsi' => $deskripsi
                ];

                array_push($idf_mapel, $keterampilan->id_mapel);
            }

        }

        $raport = [
            'siswa' => $siswa,
            'sekolah' => $sekolah,
            'nilai_sosial' => $nilai_sosial,
            'nilai_spiritual' => $nilai_spiritual,
            'nilai_pengetahuan' => array_values($nilai_pengetahuan),
            'nilai_keterampilan' => array_values($nilai_keterampilan)
        ];

        if($raport) {
            return response()->json([
                'success' => true,
                'data' => $raport
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail get raport'
        ], 400);

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

 function checkMinValue($arr_val, $values){
    $min_val = $arr_val;
    if($min_val[0] > $values->na) {
        $min_val[0] = $values->na;
        $min_val[1] = $values->deskripsi_kd;
    }
    return $min_val;
 }

 function checkMaxValue($arr_val, $values){
    $max_val = $arr_val;
    if($max_val[0] < $values->na) {
        $max_val[0] = $values->na;
        $max_val[1] = $values->deskripsi_kd;
    }
    return $max_val;
 }

