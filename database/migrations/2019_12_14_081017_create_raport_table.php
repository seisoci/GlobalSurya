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
            $table->integer('ganjilpengetahuankd1')->default(0);
            $table->integer('ganjilpengetahuankd2')->default(0);
            $table->integer('ganjilpengetahuankd3')->default(0);
            $table->integer('ganjilpengetahuankd4')->default(0);
            $table->integer('ganjilketerampilankd1')->default(0);
            $table->integer('ganjilketerampilankd2')->default(0);
            $table->integer('ganjilketerampilankd3')->default(0);
            $table->integer('ganjilketerampilankd4')->default(0);
            $table->integer('ganjilsikapkd1')->default(0);
            $table->integer('ganjilsikapkd2')->default(0);
            $table->integer('ganjilsikapkd3')->default(0);
            $table->integer('ganjilsikapkd4')->default(0);
            $table->integer('ganjilpts1')->default(0);
            $table->integer('ganjilpts2')->default(0);
            $table->integer('ganjilpts3')->default(0);
            $table->integer('genappengetahuankd1')->default(0);
            $table->integer('genappengetahuankd2')->default(0);
            $table->integer('genappengetahuankd3')->default(0);
            $table->integer('genappengetahuankd4')->default(0);
            $table->integer('genapketerampilankd1')->default(0);
            $table->integer('genapketerampilankd2')->default(0);
            $table->integer('genapketerampilankd3')->default(0);
            $table->integer('genapketerampilankd4')->default(0);
            $table->integer('genapsikapkd1')->default(0);
            $table->integer('genapsikapkd2')->default(0);
            $table->integer('genapsikapkd3')->default(0);
            $table->integer('genapsikapkd4')->default(0);
            $table->integer('genappts1')->default(0);
            $table->integer('genappts2')->default(0);
            $table->integer('genappts3')->default(0);
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
