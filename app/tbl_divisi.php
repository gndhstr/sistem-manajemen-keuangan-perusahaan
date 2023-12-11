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

    public function users()
    {
        return $this->hasMany(User::class, 'id_divisi', 'id_divisi');
    }

    public function pemasukans()
    {
        return $this->hasManyThrough(tbl_pemasukan::class, User::class, 'id_divisi', 'id_user', 'id_divisi', 'id');
    }

    public function pengeluarans()
    {
        return $this->hasManyThrough(tbl_pengeluaran::class, User::class, 'id_divisi', 'id_user', 'id_divisi', 'id');
    }    
}

