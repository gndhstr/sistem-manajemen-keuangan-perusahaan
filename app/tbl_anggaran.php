<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_anggaran extends Model
{
    protected $table = "tbl_anggarans";
    protected $primaryKey = 'id_anggaran';

    protected $fillable = [
        "id_kategori",
        "id_divisi",
        "rencana_anggaran",
        "aktualisasi_anggaran",
        "tgl_anggaran",
        "status",
    ];

    public function kategori()
    {
        return $this->belongsTo(tbl_kategori::class, 'id_kategori');
    }

    public function divisi()
    {
        return $this->belongsTo(tbl_divisi::class, 'id_divisi');
    }
}

