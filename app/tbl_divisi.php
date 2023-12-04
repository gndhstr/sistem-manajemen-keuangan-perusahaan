<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class tbl_divisi extends Model
{
    protected $table = "tbl_divisis";
    protected $primaryKey = 'id_divisi';
    protected $fillable = [
        "nama_divisi",
    ];
}

