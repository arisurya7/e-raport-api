<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemakdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tema_kd', function (Blueprint $table) {
            $table->id('id_tkd');
            $table->foreignId('id_tema');
            $table->foreignId('id_kd');
            $table->timestamps();
        });

        Schema::table('tema_kd', function (Blueprint $table) {
            $table->foreign('id_tema')->references('id_tema')->on('tema')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('tema_kd', function (Blueprint $table) {
            $table->foreign('id_kd')->references('id_kd')->on('kompetensi_dasar')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tema_kd');
    }
}
