<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen', function (Blueprint $table) {
            $table->bigIncrements('id_absen');
            $table->unsignedBigInteger('id_users');
            $table->integer('ganjilsakit')->default(0);
            $table->integer('ganjilizin')->default(0);
            $table->integer('ganjilalpha')->default(0);
            $table->integer('genapsakit')->default(0);
            $table->integer('genapizin')->default(0);
            $table->integer('genapalpha')->default(0);
            $table->year('tahun');
            $table->timestamps();
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen');
    }
}
