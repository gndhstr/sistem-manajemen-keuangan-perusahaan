<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_role extends Model
{
    protected $table ="tbl_roles";
    protected $primaryKey = 'id_role';
    protected $fillable =[
        "role",
    ];
}
