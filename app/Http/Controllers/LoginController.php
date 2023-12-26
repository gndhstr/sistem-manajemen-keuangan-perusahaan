<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\user;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class LoginController extends Controller
{
    use SendsPasswordResetEmails;
    public function login()
  {
    if (Auth::user()){
        if (Auth::user()->role == "1") {
            return redirect()->intended("/admin");
        } elseif (Auth::user()->role == "2") {
            return redirect()->intended("/direktur");
        } elseif (Auth::user()->role == "3") {
            return redirect()->intended("/manajer");
        } elseif (Auth::user()->role == "4") {
            return redirect()->intended("/karyawan");
        }
    } else {
        return view("login/index");
    }
    // return view("login/index");
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
        return redirect(route('index'))->withErrors('Username atau password salah.');
    }
  public function logout()
  {
   Auth::logout();
   return redirect(route('index'));
  }

  //lupa password
  public function lupa()
  {
    return view('login.lupa');
  }

  public function email(Request $request)
  {
      $this->validateEmail($request);

      $response = $this->broker()->sendResetLink(
          $this->credentials($request)
      );

      return $response == Password::RESET_LINK_SENT
      ? $this->sendResetLinkResponse($request, $response)
          : $this->sendResetLinkFailedResponse($request, $response);
  }

  public function resetpass(Request $request)
  {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed'
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
         function ($user, $password){
            $user->forceFill([
                'password' =>Hash::make($password)
             ])->setRememberToken(Str::random(60));

             $user->save();
             
             event(new PasswordReset($user));
         }
        );


        return $status === Password::PASSWORD_RESET
        ? redirect()->route('logout')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
  }

  public function showResetForm($token)
    {
        return view('login.reset')->with(
            ['token' => $token, 'email' => request('email')]
        );
    }

}

