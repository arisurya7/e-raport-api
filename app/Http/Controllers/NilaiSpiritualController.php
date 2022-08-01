<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\NilaiSpiritual;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

class NilaiSpiritualController extends BaseController
{
    
    public function store(Request $request){
        $this->validate($request, [
            'id_siswa' => 'required',
            'id_ta' => 'required',
            'ketaatan_beribadah' => 'required',
            'berprilaku_bersyukur' => 'required',
            'berdoa' => 'required',
            'toleransi' => 'required'
        ]);

        $siswa = Siswa::find($request->input('id_siswa'));
        $deskripsi = deskripsiNilaiSpiritual($request, $siswa['nama_panggilan']);

        $nilaispiritual = NilaiSpiritual::create([
            'id_siswa' => $request->input('id_siswa'),
            'id_ta' => $request->input('id_ta'),
            'ketaatan_beribadah' => $request->input('ketaatan_beribadah'),
            'berprilaku_bersyukur' => $request->input('berprilaku_bersyukur'),
            'berdoa' => $request->input('berdoa'),
            'toleransi' => $request->input('toleransi'),
            'deskripsi' => $deskripsi
        ]);

        if($nilaispiritual) {
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

        $this->validate($request, [
            'tahunajaran' => 'required'
        ]);

        $user = Auth::user();
        $nilai_spiritual_siswa = DB::table('users')
                                ->join('siswa', 'users.id_user', '=', 'siswa.id_user')
                                ->join('nilai_spiritual', 'siswa.id_siswa', '=', 'nilai_spiritual.id_siswa')
                                ->select('nilai_spiritual.id_spiritual','siswa.id_siswa','siswa.nama_siswa','nilai_spiritual.deskripsi')
                                ->where('users.id_user','=',$user->id_user)
                                ->where('nilai_spiritual.id_ta','=',$request->query('tahunajaran'))
                                ->get();
        
        if($nilai_spiritual_siswa){
            return response()->json([
                'success' => true,
                'data' => [
                    'nilaispiritual' => $nilai_spiritual_siswa
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
            'ketaatan_beribadah' => 'required',
            'berprilaku_bersyukur' => 'required',
            'berdoa' => 'required',
            'toleransi' => 'required',
        ]);

        $nilai_spriritual = NilaiSpiritual::find($id);
        $nilai_spriritual->ketaatan_beribadah = $request->input('ketaatan_beribadah');
        $nilai_spriritual->berprilaku_bersyukur = $request->input('berprilaku_bersyukur');
        $nilai_spriritual->berdoa = $request->input('berdoa');
        $nilai_spriritual->toleransi = $request->input('toleransi');
        
        if($nilai_spriritual->isDirty(
            'ketaatan_beribadah','berprilaku_bersyukur', 'berdoa','toleransi'
        )){
            $siswa = Siswa::find($nilai_spriritual->id_siswa);
            $deskripsi = deskripsiNilaiSpiritual($request, $siswa->nama_panggilan);
            $nilai_spriritual->deskripsi = $deskripsi;
            $nilai_spriritual->save();

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
        $nilai_spiritual = NilaiSpiritual::find($id);
        if($nilai_spiritual) {
            return response()->json([
                'success' => true,
                'data' => [
                    'nilaispiritual' => $nilai_spiritual
                ]
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data not found'
        ], 404);
    }
    
}

function deskripsiNilaiSpiritual($request, $nickname){
    $penilaian = [
        'ketaatan beribadah' => $request->input('ketaatan_beribadah'),
        'berprilaku bersyukur' => $request->input('berprilaku_bersyukur'),
        'berdoa' => $request->input('berdoa'),
        'toleransi' => $request->input('toleransi')
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