<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaipengetahuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_pengetahuan', function (Blueprint $table) {
            $table->id('id_np');
            $table->foreignId('id_siswa')->unsigned();
            $table->foreignId('id_ta')->unsigned();
            $table->foreignId('id_mapel')->unsigned();
            $table->foreignId('id_kd')->unsigned();
            $table->foreignId('id_tema')->unsigned();
            $table->foreignId('id_jn')->unsigned();
            $table->integer('nilai');
            $table->timestamps();
        });

        //relation
        Schema::table('nilai_pengetahuan', function (Blueprint $table) {
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_pengetahuan', function (Blueprint $table) {
            $table->foreign('id_ta')->references('id_ta')->on('tahun_ajaran')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_pengetahuan', function (Blueprint $table) {
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_pengetahuan', function (Blueprint $table) {
            $table->foreign('id_kd')->references('id_kd')->on('kompetensi_dasar')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_pengetahuan', function (Blueprint $table) {
            $table->foreign('id_tema')->references('id_tema')->on('tema')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_pengetahuan', function (Blueprint $table) {
            $table->foreign('id_jn')->references('id_jn')->on('jenis_nilai')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_pengetahuan');
    }
}
