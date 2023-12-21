<?php

namespace App\Http\Controllers;

use App\User;
use App\tbl_pemasukan;
use App\tbl_pengeluaran;
use App\tbl_kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $role_user = 4;
        $divisi_user = $user->id_divisi;
        
        $users = User::where('role', $role_user)
                  ->where('id_divisi', $divisi_user)
                  ->get();

        $kategoris = tbl_kategori::all();
        $pemasukans = tbl_pemasukan::where('status', "1")->get();
        $pengeluarans = tbl_pengeluaran::where('status', "1")->get();
        return view("manajer.mutasi",
        [
            "login" => $user,
            "kategori" =>$kategoris,
            "users"=>$users,
            "pemasukans"=>$pemasukans,
            "pengeluarans"=>$pengeluarans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'bukti_pemasukan' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable',
        ]);
    
        $file = $request->file('bukti_pemasukan');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('bukti_pemasukan', $fileName, 'public');    

        $pemasukan = new tbl_pemasukan();
        $pemasukan->fill($request->all());
        $pemasukan->jml_masuk = $request->input('jml_masuk', 0);
        $pemasukan->catatan = $request->input('catatan', '');
        $pemasukan->bukti_pemasukan = $fileName;
        $pemasukan->status = '1';
        $pemasukan->save();

        return redirect()->route('daftarMutasi')->with('success', 'Pemasukan berhasil ditambahkan');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePemasukan(Request $request, tbl_pemasukan $pemasukan)
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

        return redirect()->route('manajer.mutasi')->with('success', 'Data pemasukan berhasil diperbarui');
    }

    
    public function updatePengeluaran(Request $request, tbl_pengeluaran $pengeluaran)
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

        return redirect()->route('manajer.mutasi')->with('success', 'Data pemasukan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\tbl_pengeluaran  $pengeluaran
     * @param  App\tbl_pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroyPemasukan(tbl_pemasukan $pemasukan)
    {
        $pemasukan->status = '0';
        $pemasukan->save();
        return redirect()->route('daftarMutasi')->with('success', 'Data Berhasil dihapus');
    }    public function destroyPengeluaran(tbl_pengeluaran $pengeluaran)
    {
        $pengeluaran->status = '0';
        $pengeluaran->save();
        return redirect()->route('daftarMutasi')->with('success', 'Data Berhasil dihapus');
    }
}
