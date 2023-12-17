<?php

namespace App\Http\Controllers;

use App\profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userData = Session::get('userData');
        $id = $userData->id;
        // Check if the profile exists
        $profile = profile::find($id);    
        if (!$profile) {
            // Handle the case where the profile doesn't exist
            return redirect(route('Profile'))->withErrors('Profile not found.');
        }
    
        return view("profile.edit-profile", [
            "profile" => $profile
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("profile.edit-profile");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasiData = validator($request->all(),[
            "nama"     =>"string|max:255",  
            "alamat"  => "string",  
            "no_telepon"=>"string",
            
        ])->validate();
        $profile = new profile($validasiData);
        $profile->save();
        return redirect(route("Profile"));  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(profile $profile)
    {
        return view("profile.edit-profile",[
            "profile"=>$profile
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, profile $profile)
    {
        $validasiData = validator($request->all(), [
            "nama"           => "string|max:255",
            "alamat"         => "string",
            "nomor_telepon"  => "string",
        ])->validate();

        
        $profile->nama = $validasiData["nama"];
        $profile->alamat = $validasiData["alamat"];
        $profile->nomor_telepon = $validasiData["nomor_telepon"];
        $profile->save();
        session()->flash('success', 'Data berhasil diperbarui');
        return redirect(route("Profile"));
    }

    //password
    public function editPassword (){
        return view("profile.edit-profile");
    }
    public function updatePassword(Request $request){
        $user = Auth::user();
        
        $request->validate([
            "pw_lama"=>"required",
            "pw_baru"=>"required",
            "konfirm_pw"=>"required|same:pw_baru"

        ]);
        // dd($request->all());
        if(!Hash::check($request->input("pw_lama"), $user->password)){
            return redirect()->back()->withErrors(["pw_lama"=>"Kata sandi tidak sesuai"]);
        }

        $user->password = Hash::make($request->input("pw_baru"));
        $user->save();
        session()->flash('success', 'Kata sandi berhasil diperbarui');
        return redirect(route("Profile"));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(profile $profile)
    {
        //
    }
}