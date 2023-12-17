<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_pemasukan extends Model
{
    protected $table = "tbl_pemasukans";
    protected $primaryKey = 'id_pemasukan';

    protected $fillable = [
        "id_kategori",
        "id_user",
        "id_user_create",
        "id_user_edit",
        "tgl_pemasukan",
        "status",
    ];

    public function getRouteKeyName()
    {
        return 'id_pemasukan';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kategori()
    {
        return $this->belongsTo(tbl_kategori::class, 'id_kategori', 'id_kategori');
    }
}
