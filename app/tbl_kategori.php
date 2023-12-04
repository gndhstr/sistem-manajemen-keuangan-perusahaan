<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_kategori extends Model
{
    protected $table ="tbl_kategoris";
    protected $primaryKey = 'id_kategori';
    protected $fillable =[
        "nama_kategori",
        "jenis_kategori",
    ];
}
