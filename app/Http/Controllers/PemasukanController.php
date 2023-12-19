<?php

namespace App\Http\Controllers;

use App\tbl_pemasukan;
use App\tbl_kategori;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemasukans = tbl_pemasukan::with('kategori')->where('status', '1')->get();
        $kategori = tbl_kategori::all();

        return view('pemasukan.index', compact('pemasukans', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = tbl_kategori::all();
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
            'id_kategori' => 'required',
            'id_user' => 'required',
            'id_user_create' => 'required',
            'id_user_edit' => 'required',
            'jml_masuk' => 'required',
            'catatan' => 'nullable',
            'bukti_pemasukan' => 'required',
            'status' => 'nullable',
        ]);

        $pemasukan = new tbl_pemasukan();
        $pemasukan->fill($request->all());
        $pemasukan->jml_masuk = $request->input('jml_masuk', 0);
        $pemasukan->catatan = $request->input('catatan', '');
        $pemasukan->bukti_pemasukan = $request->input('bukti_pemasukan', '');
        $pemasukan->status ='1';
        $pemasukan->save();

        return redirect()->route('daftarPemasukan')->with('success', 'Pemasukan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_pemasukan $pemasukan)
    {
        $kategori = tbl_kategori::all();
        return view('editPemasukan', compact('pemasukan', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_pemasukan $pemasukan)
    {
        $validatedData = $request->validate([
            'id_kategori' => 'required|integer',
            'id_user' => 'required|integer',
            'id_user_create' => 'required|integer',
            'id_user_edit' => 'required|integer',
            'tgl_pemasukan' => 'required|string',
            'jml_masuk' => 'required|string|max:255',
            'bukti_pemasukan' => 'required|string',
            'catatan' => 'nullable|string',
            'status' => 'nullable',
        ]);

        $pemasukan->id_kategori = $validatedData['id_kategori'];
        $pemasukan->id_user = $validatedData['id_user'];
        $pemasukan->id_user_create = $validatedData['id_user_create'];
        $pemasukan->id_user_edit = $validatedData['id_user_edit'];
        $pemasukan->tgl_pemasukan = $validatedData['tgl_pemasukan'];
        $pemasukan->jml_masuk = $validatedData['jml_masuk'];
        $pemasukan->bukti_pemasukan = $validatedData['bukti_pemasukan'];
        $pemasukan->status = $validatedData['status'];
        $pemasukan->catatan = $validatedData['catatan'];
        $pemasukan->save();

        return redirect()->route('daftarPemasukan')->with('success', 'Data pemasukan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_pemasukan $pemasukan)
    {
        $pemasukan->status = '0';
        $pemasukan->save();
        return redirect()->route('daftarPemasukan')->with('success', 'Data Berhasil dihapus');
    }
}
