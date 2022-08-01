<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaispiritualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_spiritual', function (Blueprint $table) {
            $table->id('id_spiritual');
            $table->foreignId('id_siswa')->unsigned();
            $table->foreignId('id_ta')->unsigned();
            $table->string('ketaatan_beribadah', 5);
            $table->string('berprilaku_bersyukur', 5);
            $table->string('berdoa', 5);
            $table->string('toleransi', 5);
            $table->text('deskripsi');
            $table->timestamps();
        });

        Schema::table('nilai_spiritual', function (Blueprint $table) {
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('nilai_spiritual', function (Blueprint $table) {
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
        Schema::dropIfExists('nilai_spiritual');
    }
}
