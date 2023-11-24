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
            $table->integer('id_kategori');
            $table->integer('id_user');
            // bingung tipenya
            // $table->string("id_user_create",255);
            // $table->string("id_user_edit",255);
            $table->date("tgl_pengeluaran");
            $table->text("catatan");
            $table->string('bukti_pengeluaran');
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
