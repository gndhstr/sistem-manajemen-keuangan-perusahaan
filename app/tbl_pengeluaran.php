<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_pengeluaran extends Model
{
    protected $table ="tbl_pengeluarans";
    protected $fillable =[
        "id_kategori",
        "id_user",
        "id_user_create",
        "id_user_edit",
        "tgl_pengeluaran",
        "status",
    ];
}
