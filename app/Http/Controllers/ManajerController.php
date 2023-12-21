<?php

namespace App\Http\Controllers;

use App\User;
use App\tbl_pemasukan;
use App\tbl_pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManajerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $time = new Carbon();
        $time->setTimeZone('Asia/Jakarta');
        $user = Auth::user();
        $year = date('Y');
       
        $divisiUser = $user->id ? $user->division->id_divisi : '-' ;
        

        /* ------------------------------------- PEMASUKAN MINGGUAN------------------------------------- */
        //pemasukan 1 minggu terakhir
        $mingguan = $time->now()->subWeek()->addDays(1); //tanggal 1 minggu lalu
        $pemasukanMingguans = tbl_pemasukan::where('tgl_pemasukan', '>=', $mingguan)
        ->join('tbl_users', 'tbl_pemasukans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)
        ->where('status', '1')
        ->get();    
        $pemasukanMingguanTotal = $pemasukanMingguans->sum('jml_masuk');

        //pemasukan 1 bulan ini
        $bulanan = $time->now()->startOfMonth(); //Bulan ini
        $pemasukanBulanan = tbl_pemasukan::whereDate('tgl_pemasukan', '>=', $bulanan)->join('tbl_users', 'tbl_pemasukans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)->where('status', '1')->get();
        $pemasukanBulananTotal = $pemasukanBulanan->sum('jml_masuk');

        //pemasukan Harian
        $pemasukanHarians = [];
        $tanggalHarians = [];
        for ($i = 0; $i < 7; $i++) {
            // Copy dari tanggal dari minggu terakhir dan increment sampai hari ini (+6)
            $tanggalHarian = $mingguan->copy()->addDays($i)->format('Y-m-d');

            $tanggalHarians[$i] = $mingguan->copy()->addDays($i)->format('d-M');

            // Query untuk mendapatkan data pemasukan harian
            $pemasukanHarian = tbl_pemasukan::where('tgl_pemasukan', '=', $tanggalHarian)->join('tbl_users', 'tbl_pemasukans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)->where('status', '1')->get();

            // Menyimpan data harian ke dalam array
            $pemasukanHarians[$i] = $pemasukanHarian->sum('jml_masuk');
        }

        $totalPemasukan = tbl_pemasukan::join('tbl_users', 'tbl_pemasukans.id_user', '=', 'tbl_users.id')
            ->where('tbl_users.id_divisi', $divisiUser)
            ->where('tbl_pemasukans.status', '1')
            ->whereYear('tbl_pemasukans.tgl_pemasukan', $year) 
            ->sum('jml_masuk');


        /* ------------------------------------- PEMASUKAN DAN PENGELUARAN TIAP 6 BULAN TERAKHIR ------------------------------------- */
        // data pemasukan dan pengeluaran sampai 6 bulan sebelumnya
        $tanggalBulanans = [];
        $pemasukanBulanans = [];
        $pengeluaranBulanans = [];

        // Loop untuk mendapatkan 6 bulan sebelumnya
        for ($i = 6; $i >= 0; $i--) {
            $tanggalAwal = $time->now()->subMonth($i)->startOfMonth();
            $tanggalAkhir = $time->now()->subMonth($i)->endOfMonth();

            $tanggalBulanans[$i] = strtoupper($tanggalAwal->format('M'));

            // Ambil data untuk setiap bulan
            $pemasukanBulanans[$i] = tbl_pemasukan::whereBetween('tgl_pemasukan', [$tanggalAwal, $tanggalAkhir])->join('tbl_users', 'tbl_pemasukans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)->where('status', '1')->get()->sum('jml_masuk');
            $pengeluaranBulanans[$i] = tbl_pengeluaran::whereBetween('tgl_pengeluaran', [$tanggalAwal, $tanggalAkhir])->join('tbl_users', 'tbl_pengeluarans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)->where('status', '1')->get()->sum('jml_keluar');
        }

        /* ------------------------------------- PENGELUARAN MINGGUAN ------------------------------------- */
        //pengeluaran 1 minggu terakhir
        $pengeluaranMingguans = tbl_pengeluaran::whereDate('tgl_pengeluaran', '>=', $mingguan)->join('tbl_users', 'tbl_pengeluarans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)->where('status', '1')->get();
        $pengeluaranMingguanTotal = $pengeluaranMingguans->sum('jml_keluar');

        //pengeluaran 1 bulan terakhir
        $pengeluaranBulanan = tbl_pengeluaran::whereDate('tgl_pengeluaran', '>=', $bulanan)->join('tbl_users', 'tbl_pengeluarans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)->where('status', '1')->get();
        $pengeluaranBulananTotal = $pengeluaranBulanan->sum('jml_keluar');

        $pengeluaranHarians = [];
        for ($i = 0; $i < 7; $i++) {
            // Copy dari tanggal dari minggu terakhir dan increment sampai hari ini (+6)
            $tanggalHarian = $mingguan->copy()->addDays($i)->format('Y-m-d');

            // Query untuk mendapatkan data pengeluaran harian
            $pengeluaranHarian = tbl_pengeluaran::where('tgl_pengeluaran', '=', $tanggalHarian)->join('tbl_users', 'tbl_pengeluarans.id_user', '=', 'tbl_users.id')->where('tbl_users.id_divisi', $divisiUser)->where('status', '1')->get();

            // Menyimpan data harian ke dalam array
            $pemasukanHarians[$i] = $pemasukanHarian->sum('jml_masuk');
        }

        

        $totalPengeluaran = tbl_pengeluaran::join('tbl_users', 'tbl_pengeluarans.id_user', '=', 'tbl_users.id')
            ->where('tbl_users.id_divisi', $divisiUser)
            ->where('tbl_pengeluarans.status', '1')
            ->whereYear('tbl_pengeluarans.tgl_pengeluaran', $year) 
            ->sum('jml_keluar');
    
    
        /* ------------------------------------- PERBANDINGAN PEMASUKAN DAN PENGELUARAN MINGGUAN ------------------------------------- */
        if ($totalPemasukan == 0 && $totalPengeluaran == 0) {
            $perbandinganPemasukanPengeluaranMingguan = 0;
        } elseif ($totalPengeluaran == 0) {
            $perbandinganPemasukanPengeluaranMingguan = 100;
        } elseif ($pemasukanMingguanTotal == 0) {
            $perbandinganPemasukanPengeluaranMingguan = -100;
        } else {
            $perbandinganPemasukanPengeluaranMingguan = (($pemasukanMingguanTotal - $pengeluaranMingguanTotal) / $pemasukanMingguanTotal) * 100;
        }

        /* ------------------------------------- PERBANDINGAN PEMASUKAN DAN PENGELUARAN BULANAN ------------------------------------- */
        if ($totalPemasukan == 0 && $totalPengeluaran == 0) {
            $perbandinganPemasukanPengeluaranBulanan = 0;
        } elseif ($totalPengeluaran == 0) {
            $perbandinganPemasukanPengeluaranBulanan = 100;
        } elseif ($pemasukanBulananTotal == 0) {
            $perbandinganPemasukanPengeluaranBulanan = -100;
        } else {
            $perbandinganPemasukanPengeluaranBulanan = (($pemasukanBulananTotal - $pengeluaranBulananTotal) / $pemasukanBulananTotal) * 100;
        }

        /* ------------------------------------- PERBANDINGAN PEMASUKAN DAN PENGELUARAN TOTAL ------------------------------------- */
        if ($totalPemasukan == 0 && $totalPengeluaran == 0) {
            $perbandinganPemasukanPengeluaranTotal = 0;
        } elseif ($totalPengeluaran == 0) {
            $perbandinganPemasukanPengeluaranTotal = 100;
        } elseif ($totalPemasukan == 0) {
            $perbandinganPemasukanPengeluaranTotal = -100;
        } else {
            $perbandinganPemasukanPengeluaranTotal = (($totalPemasukan - $totalPengeluaran) / $totalPemasukan) * 100;
        }

        $currentTime = now();
        $greeting = $this->getGreeting($currentTime);


        return view('manajer.dashboard', [
            // 'dump' => dd($pemasukanBulanans),
            'pemasukanHarians' => $pemasukanHarians,
            'pemasukanBulanans' => $pemasukanBulanans,
            'pengeluaranBulanans' => $pengeluaranBulanans,
            'pemasukanMingguan' => $pemasukanMingguanTotal,
            'pemasukanBulanan' => $pemasukanBulananTotal,
            'totalPemasukan' => $totalPemasukan,
            'pengeluaranHarians' => $pengeluaranHarians,
            'pengeluaranMingguan' => $pengeluaranMingguanTotal,
            'pengeluaranBulanan' => $pengeluaranBulananTotal,
            'totalPengeluaran' => $totalPengeluaran,
            'tanggalMingguan' => $mingguan->format('d-m-Y'),
            'tanggalBulanan' => $bulanan->format('d-m-Y'),
            'tanggalBulanans' => $tanggalBulanans,
            'tanggalHarians' => $tanggalHarians,
            'perbandinganPemasukanPengeluaranMingguan' => $perbandinganPemasukanPengeluaranMingguan,
            'perbandinganPemasukanPengeluaranBulanan' => $perbandinganPemasukanPengeluaranBulanan,
            'perbandinganPemasukanPengeluaranTotal' => $perbandinganPemasukanPengeluaranTotal,
            'greeting' => $greeting,
            'tahun' => $year,
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

    }
}
