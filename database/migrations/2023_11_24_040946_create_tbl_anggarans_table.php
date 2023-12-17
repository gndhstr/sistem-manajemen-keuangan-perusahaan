<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_anggarans', function (Blueprint $table) {
            $table->bigIncrements('id_anggaran');
            $table->bigInteger('id_kategori')->unsigned();
            $table->foreign('id_kategori')->references('id_kategori')->on('tbl_kategoris');
            $table->bigInteger('id_divisi')->unsigned();
            $table->foreign('id_divisi')->references('id_divisi')->on('tbl_divisis');
            $table->integer('rencana_anggaran');
            $table->integer('aktualisasi_anggaran');
            $table->date("tgl_anggaran"); 
            $table->string('status',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_anggarans');
    }
}
