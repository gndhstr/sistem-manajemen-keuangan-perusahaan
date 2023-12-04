<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = \App\tbl_role::all();
        $divisis = \App\tbl_divisi::all();
        return view("user.index",
        [
            "users"=>$users,
            "roles"=>$roles,
            "divisis"=>$divisis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \App\tbl_role::all();
        $divisis = \App\tbl_divisi::all();
        return view("user.index")->with([
            "roles" => $roles,
            "divisis" => $divisis
        ]);
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
            "nama"     => "required|string|max:255",  
            "role"  => "required|integer",  
            "id_divisi"=> "required|integer",  
        ])->validate();
    
        $user = new User($validasiData);
        $user->save();
        $roles = \App\tbl_role::all();
        $divisis = \App\tbl_divisi::all();
    
        return redirect(route("daftarUser"))
            ->with([
                "success" => "Data $user->nama berhasil ditambah",
                "roles" => $roles,
                "divisis" => $divisis,
            ]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = \App\tbl_role::all();
        $divisis = \App\tbl_divisi::all();
        return view("user.edit",[
            "user" => $user,
            "roles" => $roles,
            "divisis" => $divisis
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validasiData = validator($request->all(),[
            "nama"     =>"required|string|max:255",  
            "role"  => "required|integer",  
            "id_divisi"=>"required|integer",  
        ])->validate();
        $user->nama=$validasiData["nama"];
        $user->role=$validasiData["role"];
        $user->id_divisi=$validasiData["id_divisi"];
        $user->save();
        return redirect(route("daftarUser"));  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route("daftarUser"))->with("success","Data $user->nama berhasil dihapus");
    }
}
