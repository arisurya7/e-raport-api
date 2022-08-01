<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NilaiPengetahuanByKd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `nilai_pengetahuan_by_kd`;
        CREATE PROCEDURE `nilai_pengetahuan_by_kd` (IN id_siswa int, IN id_ta int)
        BEGIN
            SELECT mapel.id_mapel, mapel.nama_mapel, mapel.kkm, t.id_kd, t.na, t.deskripsi_kd FROM mapel
            LEFT JOIN
                (SELECT nilai_pengetahuan.id_mapel, nilai_pengetahuan.id_kd, AVG(nilai_pengetahuan.nilai) as na, kompetensi_dasar.deskripsi_kd
                FROM nilai_pengetahuan
                JOIN kompetensi_dasar on kompetensi_dasar.id_kd = nilai_pengetahuan.id_kd
                WHERE (nilai_pengetahuan.id_siswa = id_siswa) AND (nilai_pengetahuan.id_ta = id_ta)
                GROUP BY nilai_pengetahuan.id_kd, nilai_pengetahuan.id_mapel, kompetensi_dasar.deskripsi_kd) AS t
            ON t.id_mapel = mapel.id_mapel
            ORDER BY mapel.id_mapel;
        END;";
        \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
