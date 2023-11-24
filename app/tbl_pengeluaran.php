<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_pengeluaran extends Model
{
    protected $table ="tbl_pengeluaran";
    protected $fillable =[
        "id_kategori",
        "id_user",
        // "id_user_create", belum 
        // "id_user_edit",
        "tgl_pengeluaran",
        "status",
    ];
}
