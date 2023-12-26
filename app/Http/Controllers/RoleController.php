<?php

namespace App\Http\Controllers;

use App\tbl_role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = tbl_role::all();
        return view("role.index",["roles"=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("role.index");
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
            "role" => "required|string|max:255",  
          ])->validate();
          $role = new tbl_role($validasiData);
          $role->save();
          
          return redirect(route("daftarRole"))->with("berhasil"," $role->role berhasil ditambah");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tbl_role  $tbl_role
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_role $tbl_role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_role  $tbl_role
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_role $role)
    {
        return view("divisi.index",[
            "role"=>$role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_role  $tbl_role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_role $role)
    {
        $validasiData = $request->validate([
            "role" => "required|string|max:255",
        ]);
    
        $role->role = $validasiData["role"];
        $role->save();
    
        return redirect(route("daftarRole"))->with("berhasil"," $role->role berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_role  $tbl_role
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_role $role)
    {
        $role->delete();
        return redirect(route("daftarRole"))->with("berhasil"," $role->role berhasil dihapus");
    }
}
