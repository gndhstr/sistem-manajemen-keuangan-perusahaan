<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_pemasukan extends Model
{
    protected $table ="tbl_pemasukans";
    protected $fillable =[
        "id_kategori",
        "id_user",
        "id_user_create",
        "id_user_edit",
        "tgl_pemasukan",
        "status",
    ];
}
