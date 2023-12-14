<?php

namespace App\Http\Controllers;

use App\tbl_pemasukan;
use App\tbl_kategori;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemasukan = tbl_pemasukan::with('kategori')->get();
        $kategori = tbl_kategori::all();

        return view('pemasukan.index', compact('pemasukan', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoris = tbl_kategori::all();
        return view('createPemasukan', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'id_kategori' => 'required',
            'id_user_create' => 'required',
            'id_user_edit' => 'required',
            'jml_masuk' => 'required',
            'catatan' => 'nullable',
        ]);

        $pemasukan = new tbl_pemasukan();
        $pemasukan->fill($request->all());
        $pemasukan->jml_masuk = $request->input('jml_masuk', 0);
        $pemasukan->catatan = $request->input('catatan', '');
        $pemasukan->bukti_pemasukan = $request->input('bukti_pemasukan', '');
        $pemasukan->status = $request->input('status', '');
        $pemasukan->save();

        return redirect()->route('daftarPemasukan')->with('success', 'Pemasukan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_pemasukan  $tbl_pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_pemasukan $tbl_pemasukan)
    {
        $pemasukan = tbl_pemasukan::findOrFail($tbl_pemasukan->id);
        $kategori = tbl_kategori::all();
        
        return view('editPemasukan', compact('pemasukan', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_pemasukan  $tbl_pemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_pemasukan $tbl_pemasukan)
    {
        $request->validate([
            'id_kategori' => 'required',
            'id_user' => 'required',
            'id_user_edit' => 'required',
            'tgl_pemasukan' => 'required',
            'jml_masuk' => 'required',
            'catatan' => 'nullable',
            'status' => 'nullable',
        ]);

        $tbl_pemasukan->update($request->all());

        return redirect()->route('daftarPemasukan')->with('success', 'Data pemasukan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_pemasukan  $tbl_pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_pemasukan $tbl_pemasukan)
    {
        $tbl_pemasukan->delete();
        return redirect(route("daftarPemasukan"))->with("success", "Data berhasil dihapus");
    }

}