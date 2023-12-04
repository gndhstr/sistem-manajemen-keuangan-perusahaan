<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPemasukansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pemasukans', function (Blueprint $table) {
            $table->bigIncrements('id_pemasukan');
            $table->bigInteger('id_kategori')->unsigned();
            $table->foreign('id_kategori')->references('id_kategori')->on('tbl_kategoris');
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('tbl_users');
            // bingung tipenya
            $table->bigInteger("id_user_create");
            $table->bigInteger("id_user_edit");
            $table->integer("jml_masuk");
            $table->date("tgl_pemasukan");
            $table->text("catatan");
            $table->string('bukti_pemasukan');
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
        Schema::dropIfExists('tbl_pemasukans');
    }
}
