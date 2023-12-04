<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_kategori extends Model
{
    protected $table ="tbl_kategoris";
    protected $fillable =[
        "nama_kategori",
    ];
}
