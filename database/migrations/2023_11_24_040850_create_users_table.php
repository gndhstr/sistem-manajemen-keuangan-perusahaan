<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->bigInteger('id_divisi')->unsigned()->nullable();
            $table->foreign('id_divisi')->references('id_divisi')->on('tbl_divisis');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_profil')->nullable(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
