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
            $table->integer('id_kategori');
            $table->integer('id_divisi');
            $table->string('rencana_anggaran',255);
            $table->string('aktualisasi_anggaran',255);
            $table->date("tgl_anggaran");
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
