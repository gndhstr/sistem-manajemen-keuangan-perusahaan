<?php

namespace App\Http\Controllers;

use App\tbl_pengeluaran;
use App\tbl_kategori;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluarans = tbl_pengeluaran::with('kategori')->where('status', '1')->get();
        $kategori = tbl_kategori::all();

        return view('pengeluaran.index', compact('pengeluarans','kategori'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = tbl_kategori::all();
        return view('createPengeluaran', compact('kategori'));
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
            'jml_keluar' => 'required',
            'catatan' => 'nullable',
            'bukti_pengeluaran' => 'required',
            'status' => 'nullable',
        ]);

        $pengeluaran = new tbl_pengeluaran();
        $pengeluaran->fill($request->all());
        $pengeluaran->jml_keluar = $request->input('jml_keluar', 0);
        $pengeluaran->catatan = $request->input('catatan', '');
        $pengeluaran->bukti_pengeluaran = $request->input('bukti_pengeluaran', '');
        $pengeluaran->status ='1';
        $pengeluaran->save();

        return redirect()->route('daftarPengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tbl_pengeluaran  $tbl_pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_pengeluaran $tbl_pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_pengeluaran $pengeluaran)
    {
        $kategori = tbl_kategori::all();
        return view('editPengeluaran', compact('pengeluaran', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_pengeluaran  $tbl_pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_pengeluaran $pengeluaran)
    {
        $validatedData = $request->validate([
            'id_kategori' => 'required|integer',
            'id_user' => 'required|integer',
            'id_user_create' => 'required|integer',
            'id_user_edit' => 'required|integer',
            'tgl_pengeluaran' => 'required|string',
            'jml_keluar' => 'required|string|max:255',
            'bukti_pengeluaran' => 'required|string',
            'catatan' => 'nullable|string',
            'status' => 'nullable',
        ]);

        $pengeluaran->id_kategori = $validatedData['id_kategori'];
        $pengeluaran->id_user = $validatedData['id_user'];
        $pengeluaran->id_user_create = $validatedData['id_user_create'];
        $pengeluaran->id_user_edit = $validatedData['id_user_edit'];
        $pengeluaran->tgl_pengeluaran = $validatedData['tgl_pengeluaran'];
        $pengeluaran->jml_keluar = $validatedData['jml_keluar'];
        $pengeluaran->bukti_pengeluaran = $validatedData['bukti_pengeluaran'];
        $pengeluaran->status = $validatedData['status'];
        $pengeluaran->catatan = $validatedData['catatan'];
        $pengeluaran->save();

        return redirect()->route('daftarPengeluaran')->with('success', 'Data pemasukan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_pengeluaran  $tbl_pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_pengeluaran $pengeluaran)
    {
        $pengeluaran->status = '0';
        $pengeluaran->save();
        return redirect()->route('daftarPengeluaran')->with('success', 'Data Berhasil dihapus');
    }
}
