<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiketerampilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_keterampilan', function (Blueprint $table) {
            $table->id('id_nk');
            $table->foreignId('id_siswa')->unsigned();
            $table->foreignId('id_ta')->unsigned();
            $table->foreignId('id_mapel')->unsigned();
            $table->foreignId('id_kd')->unsigned();
            $table->foreignId('id_kt')->unsigned();
            $table->integer('nilai');
            $table->timestamps();
        });

         //relation
         Schema::table('nilai_keterampilan', function (Blueprint $table) {
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_keterampilan', function (Blueprint $table) {
            $table->foreign('id_ta')->references('id_ta')->on('tahun_ajaran')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_keterampilan', function (Blueprint $table) {
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_keterampilan', function (Blueprint $table) {
            $table->foreign('id_kd')->references('id_kd')->on('kompetensi_dasar')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_keterampilan', function (Blueprint $table) {
            $table->foreign('id_kt')->references('id_kt')->on('keterampilan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_keterampilan');
    }
}
