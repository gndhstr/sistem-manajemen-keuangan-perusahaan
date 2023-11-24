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
            $table->integer('id_kategori');
            $table->integer('id_user');
            // bingung tipenya
            // $table->string("id_user_create",255);
            // $table->string("id_user_edit",255);
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
