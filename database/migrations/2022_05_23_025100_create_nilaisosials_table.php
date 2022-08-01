<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisosialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_sosial', function (Blueprint $table) {
            $table->id('id_sosial');
            $table->foreignId('id_siswa')->unsigned();
            $table->foreignId('id_ta')->unsigned();
            $table->string('jujur', 5);
            $table->string('disiplin', 5);
            $table->string('tanggung_jawab', 5);
            $table->string('santun', 5);
            $table->string('peduli', 5);
            $table->string('percaya_diri', 5);
            $table->text('deskripsi');
            $table->timestamps();
        });

        Schema::table('nilai_sosial', function (Blueprint $table) {
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_sosial', function (Blueprint $table) {
            $table->foreign('id_ta')->references('id_ta')->on('tahun_ajaran')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_sosial');
    }
}
