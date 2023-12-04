<?php

namespace App\Http\Controllers;

use App\tbl_anggaran;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anggarans = tbl_anggaran::all();
        return view("manajer.anggaran",["anggarans"=>$anggarans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisis = \App\tbl_divisi::all();
        $kategoris = \App\tbl_kategori::all();
        
        return view("manajer.anggaran", ['divisis' => $divisis, 'kategoris' => $kategoris]);
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
          $anggaran = new tbl_anggaran($validasiData);
          $anggaran->save();
          
          return redirect(route("anggaran"))->with("success","Anggaran berhasil ditambah");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tbl_anggaran  $tbl_anggaran
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_anggaran $tbl_anggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_anggaran  $tbl_anggaran
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_anggaran $tbl_anggaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_anggaran  $tbl_anggaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_anggaran $tbl_anggaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_anggaran  $tbl_anggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_anggaran $tbl_anggaran)
    {
        //
    }
}
