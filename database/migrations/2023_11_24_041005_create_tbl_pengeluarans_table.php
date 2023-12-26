<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pengeluarans', function (Blueprint $table) {
            $table->bigIncrements('id_pengeluaran');
            $table->bigInteger('id_kategori')->unsigned();
            $table->foreign('id_kategori')->references('id_kategori')->on('tbl_kategoris');
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('tbl_users');
            // bingung tipenya
            $table->bigInteger("id_user_create");
            $table->bigInteger("id_user_edit");
            $table->integer("jml_keluar");
            $table->date("tgl_pengeluaran");
            $table->text("catatan");
            $table->binary('bukti_pengeluaran');
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
        Schema::dropIfExists('tbl_pengeluarans');
    }
}
