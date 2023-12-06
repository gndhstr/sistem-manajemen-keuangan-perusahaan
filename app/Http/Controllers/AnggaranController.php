<?php

namespace App\Http\Controllers;

use App\tbl_anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $divisi_login = $user->id_divisi;
        $anggarans = tbl_anggaran::where('id_divisi', $divisi_login)->get();

        return view("manajer.anggaran", ["anggarans" => $anggarans, "divisi_login" => $divisi_login]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view("manajer.anggaran");
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|exists:tbl_kategoris,id_kategori',
            'rencana_anggaran' => 'required|numeric',
            'aktualisasi_anggaran' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $anggaran = new tbl_anggaran([
            'id_divisi' => Auth::user()->id_divisi,
            'id_kategori' => $request->kategori,
            'rencana_anggaran' => $request->rencana_anggaran,
            'aktualisasi_anggaran' => $request->aktualisasi_anggaran,
            'tgl_anggaran' => $request->tanggal,
        ]);
        $anggaran->save();
    
        return redirect(route('anggaran'))->with('success', 'Anggaran berhasil ditambah');
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
    public function edit(tbl_anggaran $anggaran)
    {
        return view("manajer.anggaran",[
            "anggaran"=>$anggaran,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_anggaran  $tbl_anggaran
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, tbl_anggaran $anggaran)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|exists:tbl_kategoris,id_kategori',
            'rencana_anggaran' => 'required|numeric',
            'aktualisasi_anggaran' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Perbarui data anggaran
        $anggaran->id_divisi = Auth::user()->id_divisi;
        $anggaran->id_kategori = $request->kategori;
        $anggaran->rencana_anggaran = $request->rencana_anggaran;
        $anggaran->aktualisasi_anggaran = $request->aktualisasi_anggaran;
        $anggaran->tgl_anggaran = $request->tanggal;
        
        // Anda mungkin perlu menyesuaikan bagian ini tergantung pada kebutuhan aplikasi Anda
    
        $anggaran->save();
    
        return redirect(route('anggaran'))->with('success', 'Anggaran berhasil diperbarui');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_anggaran  $tbl_anggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_anggaran $anggaran)
    {
        $anggaran->delete();
        return redirect(route("anggaran"))->with("success","Anggaran berhasil dihapus");
    }
}