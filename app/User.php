<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // Model User
    // protected $fillable = ['id_divisi', 'nama', 'role'];


    protected $guarded = [
        'id'
    ]; // guarded (datanya di proteksi/yang gabole diisi) ini kebalikan dari fillable, pake ini aja biar gapayah nambah2 lagi fillable kalo ada data baru

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function division() //relasi terhadap tbl_users
    {
        return $this->belongsTo(tbl_divisi::class, 'id_divisi');
    }
    // User.php
    public function role_user()
    {
        // return $this->belongsTo('App\tbl_role', 'role');
        return $this->belongsTo(tbl_role::class, 'role');
    }

    public function pemasukan()
    {
        return $this->hasMany(tbl_pemasukan::class, 'id_user');
    }

    public function pengeluaran()
    {
        return $this->hasMany(tbl_pengeluaran::class, 'id_user');
    }
}
