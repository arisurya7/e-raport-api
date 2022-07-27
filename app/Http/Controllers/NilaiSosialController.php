<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\NilaiSosial;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class NilaiSosialController extends BaseController
{
    
    public function store(Request $request){
        $this->validate($request, [
            'id_siswa' => 'required',
            'id_ta' => 'required',
            'jujur' => 'required',
            'disiplin' => 'required',
            'tanggung_jawab' => 'required',
            'santun' => 'required',
            'peduli' => 'required',
            'percaya_diri' => 'required',
        ]);

        $siswa = Siswa::find($request->input('id_siswa'));
        $deskripsi = deskripsiNilaiSosial($request, $siswa['nama_panggilan']);

        $nilaisosial = NilaiSosial::create([
            'id_siswa' => $request->input('id_siswa'),
            'id_ta' => $request->input('id_ta'),
            'jujur' => $request->input('jujur'),
            'disiplin' => $request->input('disiplin'),
            'tanggung_jawab' => $request->input('tanggung_jawab'),
            'santun' => $request->input('santun'),
            'peduli' => $request->input('peduli'),
            'percaya_diri' => $request->input('percaya_diri'),
            'deskripsi' => $deskripsi,
        ]);

        if($nilaisosial) {
            return response()->json([
                'success' => true,
                'message' => 'success add nilai'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'fail add nilai'
        ], 400);

    }

    public function show(Request $request){
        $user = Auth::user();
        $nilai_sosial_siswa = DB::table('users')
                                ->join('siswa', 'users.id_user', '=', 'siswa.id_user')
                                ->join('nilai_sosial', 'siswa.id_siswa', '=', 'nilai_sosial.id_siswa')
                                ->select('nilai_sosial.id_sosial','siswa.id_siswa','siswa.nama_siswa','nilai_sosial.deskripsi')
                                ->where('users.id_user','=',$user->id_user)
                                ->where('nilai_sosial.id_ta','=',$request->query('tahunajaran'))
                                ->get();
        
        if($nilai_sosial_siswa){
            return response()->json([
                'success' => true,
                'data' => [
                    'nilaisosial' => $nilai_sosial_siswa
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'data mapel not found'
        ], 404);

    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'jujur' => 'required',
            'disiplin' => 'required',
            'tanggung_jawab' => 'required',
            'santun' => 'required',
            'peduli' => 'required',
            'percaya_diri' => 'required',
        ]);

        $nilai_sosial = NilaiSosial::find($id);
        $nilai_sosial->jujur = $request->input('jujur');
        $nilai_sosial->disiplin = $request->input('disiplin');
        $nilai_sosial->tanggung_jawab = $request->input('tanggung_jawab');
        $nilai_sosial->santun = $request->input('santun');
        $nilai_sosial->peduli = $request->input('peduli');
        $nilai_sosial->percaya_diri = $request->input('percaya_diri');
        if($nilai_sosial->isDirty(
            'jujur','disiplin', 'tanggung_jawab','santun','peduli', 'percaya_diri'
        )){
            $siswa = Siswa::find($nilai_sosial->id_siswa);
            $deskripsi = deskripsiNilaiSosial($request, $siswa->nama_panggilan);
            $nilai_sosial->deskripsi = $deskripsi;
            $nilai_sosial->save();

            return response()->json([
                'success' => true,
                'message' => 'success update nilai'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'nothing change'
        ], 400);
    }

    public function detail($id){
        $nilai_sosial = NilaiSosial::find($id);
        if($nilai_sosial) {
            return response()->json([
                'success' => true,
                'data' => [
                    'nilaisosial' => $nilai_sosial
                ]
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data not found'
        ], 404);
    }
    
}

function deskripsiNilaiSosial($request, $nickname){
    $penilaian = [
        'jujur' => $request->input('jujur'),
        'disiplin' => $request->input('disiplin'),
        'tanggung_jawab' => $request->input('tanggung_jawab'),
        'santun' => $request->input('santun'),
        'peduli' => $request->input('peduli'),
        'percaya_diri' => $request->input('percaya_diri')
    ];

    //Membuat kalimat per penilaian
    $sentance_sangat_baik = '';
    $sentance_baik = '';
    $sentance_perlu_bimbingan = '';
    foreach ($penilaian as $key => $value){
        if($value=='SB') $sentance_sangat_baik = $sentance_sangat_baik .$key.", ";
        if($value=='B') $sentance_baik = $sentance_baik .$key.", ";
        if($value=='PB') $sentance_perlu_bimbingan = $sentance_perlu_bimbingan .$key.", ";
    }
   
    //Slice tanda koma di akhir
    $sentance_sangat_baik = substr($sentance_sangat_baik, 0, -2);
    $sentance_baik = substr($sentance_baik, 0, -2);
    $sentance_perlu_bimbingan = substr($sentance_perlu_bimbingan, 0, -2);

    //Menggabungkan deskripsi
    $deskripsi = '';
    if($sentance_sangat_baik && $sentance_perlu_bimbingan){
        $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
     }else if($sentance_sangat_baik && $sentance_baik){
        $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . ', baik dalam '. $sentance_baik . '. ';
     }else if($sentance_baik && $sentance_perlu_bimbingan){
        $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
     }else if ($sentance_sangat_baik){
        $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '.';
     }else if ($sentance_baik){
        $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '.';
     }else if ($sentance_perlu_bimbingan){
        $deskripsi = 'Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
     }

    return $deskripsi;
}