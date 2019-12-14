<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raport', function (Blueprint $table) {
            $table->bigIncrements('id_raport');
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_matapelajaran');
            $table->year('tahun');
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users');
            $table->foreign('id_guru')->references('id')->on('users');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->foreign('id_matapelajaran')->references('id_matapelajaran')->on('matapelajaran');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raport');
    }
}
