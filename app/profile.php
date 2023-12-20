<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    protected $table ="tbl_users";
    protected $primaryKey = 'id';
    protected $fillable =[
        "id",
        "nama",
        "alamat",
        "foto_profil",
        "nomor_telepon",
        "id_divisi",
    ];
    public function division()
    {
        return $this->belongsTo(tbl_divisi::class, 'id_divisi');
    } 
    public function role_user()
    {
        return $this->belongsTo(tbl_role::class, 'role');
    }
}
