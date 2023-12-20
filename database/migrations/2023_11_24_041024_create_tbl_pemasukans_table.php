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
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')->references('id_kategori')->on('tbl_kategoris');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('tbl_users');
            $table->unsignedBigInteger("id_user_create");
            $table->foreign('id_user_create')->references('id')->on('tbl_users');
            $table->unsignedBigInteger("id_user_edit");
            $table->foreign('id_user_edit')->references('id')->on('tbl_users');
            $table->integer("jml_masuk")->default(0);
            $table->date("tgl_pemasukan");
            $table->text("catatan")->default('');
            $table->string('bukti_pemasukan');
            $table->string('status')->nullable()->default('');
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
