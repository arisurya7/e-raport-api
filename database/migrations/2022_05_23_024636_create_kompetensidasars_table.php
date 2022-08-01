<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetensidasarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetensi_dasar', function (Blueprint $table) {
            $table->id('id_kd');
            $table->foreignId('id_mapel');
            $table->string('kode_kd');
            $table->string('kategori_kd');
            $table->text('deskripsi_kd');
            $table->timestamps();
        });

        Schema::table('kompetensi_dasar', function (Blueprint $table) {
            $table->foreign('id_mapel')->references('id_mapel')->on('mapel')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kompetensi_dasar');
    }
}
