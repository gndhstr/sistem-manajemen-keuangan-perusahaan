<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_anggaran extends Model
{
    protected $table ="tbl_anggaran";
    protected $fillable =[
        "id_kategori",
        "id_user",
        "rencana_anggaran",
        "aktualisasi_anggaran",
        "tgl_pemasukan",
    ];
}
