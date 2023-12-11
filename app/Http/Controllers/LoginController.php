<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function login()
  {
    return view("login/index");
  } 
  
  public function authenticate(Request $request){
    $crudentials = $request->only("username", "password");
    if(Auth::attempt($crudentials)){
        $user = Auth::user();
        // dd($user);

        // role direktur
        if($user->role == "1"){
            return redirect()->intended("/admin");
        }
        // role admin
        elseif($user->role == "2"){
            return redirect()->intended("/direktur");
        }
        // role manager
        elseif($user->role == "3"){
            return redirect()->intended("/manajer");
        }
        // role karyawan
        elseif($user->role == "4"){
            return redirect()->intended("/karyawan");
        }
    }
     // Pemberitahuan kesalahan jika otentikasi gagal
     return redirect(route('index'))->withErrors('Email atau password salah.');

  }
  public function logout()
  {
   Auth::logout();
   return redirect(route('index'));
  }


}
