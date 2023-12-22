<?php

namespace App\Http\Controllers;

use App\User;
use App\tbl_pemasukan;
use App\tbl_pengeluaran;
use App\tbl_anggaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $time = new Carbon();
        $time->setTimeZone('Asia/Jakarta');
        $user = Auth::user();
        $year = date('Y');

        $user = Auth::user();
        $role_user = 4;
        $divisi_user = $user->id_divisi;
    
        $users = User::where('role', $role_user)
                  ->where('id_divisi', $divisi_user)
                  ->get();
    
        $pemasukans = tbl_pemasukan::where('status', "1")->get();
        $pengeluarans = tbl_pengeluaran::where('status', "1")->get();
    
        $totalMasuk = 0;
        $totalKeluar = 0;
    
        foreach ($users as $user) {
            $JmlMasuk = $pemasukans->where('id_user', $user->id)->sum('jml_masuk');
            $JmlKeluar = $pengeluarans->where('id_user', $user->id)->sum('jml_keluar');
            $saldo = $JmlMasuk - $JmlKeluar;
    
            $totalMasuk += $JmlMasuk;
            $totalKeluar += $JmlKeluar;
        }
    
        $perbandinganPemasukanPengeluaran = 0;
        if ($totalMasuk > 0) {
            $perbandinganPemasukanPengeluaran = (($totalMasuk - $totalKeluar) / $totalMasuk) * 100;
        }

        $currentTime = now();
        $greeting = $this->getGreeting($currentTime);

        return view("karyawan.dashboard", [
            "users" => $users,
            "pemasukans" => $pemasukans,
            "pengeluarans" => $pengeluarans,
            "totalMasuk" => $totalMasuk,
            "totalKeluar" => $totalKeluar,
            "perbandinganPemasukanPengeluaran" => $perbandinganPemasukanPengeluaran,
            "divisi"=> $user->division->nama_divisi,
            'greeting' => $greeting,
            "saldo" => $saldo,
        ]);
    }
    
    private function getGreeting($time)
    {
        $hour = $time->hour;
    
        if ($hour >= 5 && $hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tbl_pemasukan  $tbl_pemasukan
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_pemasukan $tbl_pemasukan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_pemasukan  $tbl_pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_pemasukan $tbl_pemasukan)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_pemasukan  $tbl_pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_pemasukan $tbl_pemasukan)
    {
        //
    }
}
