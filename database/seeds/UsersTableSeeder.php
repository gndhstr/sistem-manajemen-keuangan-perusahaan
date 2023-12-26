<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh: Menambahkan satu pengguna ke tabel users
        DB::table('tbl_users')->insert([
            'nama' => 'Admin Utama',
            'username' => 'host',
            'password' => bcrypt('hos123'),
        ]);
    }
}
