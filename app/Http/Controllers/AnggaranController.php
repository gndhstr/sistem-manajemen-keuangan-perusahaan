<?php

namespace App\Http\Controllers;

use App\tbl_anggaran;
use Carbon\Carbon;
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
        $year = date('Y');

        $anggarans = tbl_anggaran::where('status', '1')
                    ->where('id_divisi', $divisi_login)
                    ->orderBy('tgl_anggaran', 'desc')
                    ->get();

        $time = new Carbon();
        $time->setTimeZone('Asia/Jakarta');

        /* ------------------------------------- ANGGARAN SAMPAI 6 BULAN SEBELUMNYA ------------------------------------- */
        $tanggalBulanans = [];
        $rencanaBulanans = [];
        $aktualisasiBulanans = [];

        // Loop untuk mendapatkan 6 bulan sebelumnya
        for ($i = 6; $i >= 0; $i--) {
            $tanggalAwal = $time->now()->subMonth($i)->startOfMonth();
            $tanggalAkhir = $time->now()->subMonth($i)->endOfMonth();

            $tanggalBulanans[$i] = strtoupper($tanggalAwal->format('M'));

            // Ambil data untuk setiap bulan
            $rencanaBulanans[$i] = tbl_anggaran::whereBetween('tgl_anggaran', [$tanggalAwal, $tanggalAkhir])->where('id_divisi', $divisi_login)->where('status', '1')->get()->sum('rencana_anggaran');
            $aktualisasiBulanans[$i] = tbl_anggaran::whereBetween('tgl_anggaran', [$tanggalAwal, $tanggalAkhir])->where('id_divisi', $divisi_login)->where('status', '1')->get()->sum('aktualisasi_anggaran');
        }

        /* ----------------------------- PERSENTASE PERBANDINGAN AKTUALISASI DAN RENCANA DI BULAN INI ----------------------------- */
        if ($aktualisasiBulanans[0] == 0 && $rencanaBulanans[0] == 0) {
            $perbandinganAnggaran = 0;
        } elseif ($rencanaBulanans[0] == 0) {
            $perbandinganAnggaran = 100;
        } elseif ($aktualisasiBulanans[0] == 0) {
            $perbandinganAnggaran = -100;
        } else {
            $perbandinganAnggaran = (($aktualisasiBulanans[0] - $rencanaBulanans[0]) / $aktualisasiBulanans[0]) * 100;
        }
    
        return view("manajer.anggaran", [
            "divisi_login" => $divisi_login,
            "divisi"=> $user->division->nama_divisi,
            'tanggalBulanans' => $tanggalBulanans,
            'anggarans' => $anggarans,
            'rencanaBulanans' => $rencanaBulanans,
            'aktualisasiBulanans' => $aktualisasiBulanans,
            'perbandinganAnggaran' => $perbandinganAnggaran,
            'tahun' => $year,
        ]);

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
            'rencana_anggaran' => 'required|numeric',
            'aktualisasi_anggaran' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $anggaran = new tbl_anggaran([
            'id_divisi' => Auth::user()->id_divisi,
            'id_kategori' => 8,
            'rencana_anggaran' => $request->rencana_anggaran,
            'aktualisasi_anggaran' => $request->aktualisasi_anggaran,
            'tgl_anggaran' => $request->tanggal,
            'status' => '1',
        ]);
        $anggaran->save();
    
        return redirect(route('anggaran'))->with('berhasil', 'Anggaran berhasil ditambah');
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
            'rencana_anggaran' => 'required|numeric',
            'aktualisasi_anggaran' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    

        $anggaran->id_divisi = Auth::user()->id_divisi;
        $anggaran->id_kategori = 8;
        $anggaran->rencana_anggaran = $request->rencana_anggaran;
        $anggaran->aktualisasi_anggaran = $request->aktualisasi_anggaran;
        $anggaran->tgl_anggaran = $request->tanggal;
    
        $anggaran->save();
    
        return redirect(route('anggaran'))->with('berhasil', 'Anggaran berhasil diperbarui');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_anggaran  $tbl_anggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_anggaran $anggaran)
    {
        $anggaran->status = '0';
        $anggaran->save();
        return redirect(route("anggaran"))->with("berhasil","Anggaran berhasil dihapus");
    }
}
