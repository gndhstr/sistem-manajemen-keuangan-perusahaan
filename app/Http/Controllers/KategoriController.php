<?php

namespace App\Http\Controllers;

use App\tbl_kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategoris = tbl_kategori::all();
        return view("kategori.index",[
            "kategoris"=>$kategoris,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("kategori.index");
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
         "nama_kategori"=>"required|string
         |max:255",   
         "jenis_kategori"=>"required|string|max:255",   
        ])->validate();

        $kategori = new tbl_kategori($validasiData);
        $kategori->save();

        return redirect(route("daftarKategori"))->with("berhasil","Kategori $kategori->nama_kategori berhasil ditambah");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tbl_kategori  $tbl_kategori
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_kategori $tbl_kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_kategori  $tbl_kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_kategori $kategori)
    {
        return view("kategori.index",[
            "kategori"=>$kategori,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_kategori $kategori)
    {
        $validasiData = validator($request->all(),[
            "nama_kategori"=>"required|string
            |max:255",   
            "jenis_kategori"=>"required|string|max:255",   
           ])->validate();
   
           $kategori->nama_kategori=$validasiData["nama_kategori"];
           $kategori->jenis_kategori=$validasiData["jenis_kategori"];
           $kategori->save();
   
           return redirect(route("daftarKategori"))->with("berhasil","Kategori $kategori->nama_kategori berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_kategori $kategori)
    {
        $kategori->delete();
        return redirect(route("daftarKategori"))->with("berhasil","Kategori $kategori->nama_kategori berhasil dihapus");
    }
}
