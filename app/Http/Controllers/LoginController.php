<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\user;

class LoginController extends Controller
{
  public function login()
  {
    return view("login/index");
  } 
  
  public function authenticate(Request $request)
    {
        $credentials = $request->only("username", "password");
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Mengambil data pengguna dari tabel users berdasarkan id
            $userData = user::find($user->id);

            if ($userData) {
                // Menyimpan data pengguna dalam session
                Session::put('userData', $userData);

                // Logika redirect sesuai dengan peran pengguna
                if ($user->role == "1") {
                    return redirect()->intended("/admin");
                } elseif ($user->role == "2") {
                    return redirect()->intended("/direktur");
                } elseif ($user->role == "3") {
                    return redirect()->intended("/manajer");
                } elseif ($user->role == "4") {
                    return redirect()->intended("/karyawan");
                }
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

