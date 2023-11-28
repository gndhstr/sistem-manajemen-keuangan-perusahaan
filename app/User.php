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

    // protected $fillable = [
    //     'nama', 'username', 'password',
    // ];

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
}
