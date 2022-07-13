<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisnilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_nilai', function (Blueprint $table) {
            $table->id('id_jn');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::table('tema_jenis', function (Blueprint $table) {
            $table->foreign('id_tema')->references('id_tema')->on('tema')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('tema_jenis', function (Blueprint $table) {
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
        Schema::dropIfExists('jenis_nilai');
    }
}
