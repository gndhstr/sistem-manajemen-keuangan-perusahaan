<?php

namespace App\Http\Controllers;

use App\tbl_divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisis = tbl_divisi::all();
        return view("divisi.index",["divisis"=>$divisis]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("divisi.index");
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
          "nama_divisi" => "required|string|max:255",  
        ])->validate();
        $divisi = new tbl_divisi($validasiData);
        $divisi->save();
        
        return redirect(route("daftarDivisi"))->with("success","Divisi $divisi->nama_divisi berhasil ditambah");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tbl_divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_divisi $divisi)
    {
        return view("divisi.index",[
            "divisi"=>$divisi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_divisi  $divisi
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, tbl_divisi $divisi)
{
    $validasiData = $request->validate([
        "nama_divisi" => "required|string|max:255",
    ]);

    $divisi->nama_divisi = $validasiData["nama_divisi"];
    $divisi->save();

    return redirect(route("daftarDivisi"))->with("success","Divisi $divisi->nama_divisi berhasil diubah");
}

    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_divisi $divisi)
    {
        $divisi->delete();
        return redirect(route("daftarDivisi"))->with("success","Divisi $divisi->nama_divisi berhasil dihapus");
    }
}
