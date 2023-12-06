<?php

namespace App\Http\Controllers;

use App\tbl_pemasukan;
use App\tbl_pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DirekturDashboardController extends Controller
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

        /* ------------------------------------- PEMASUKAN MINGGUAN------------------------------------- */
        //pemasukan 1 minggu terakhir
        $mingguan = $time->now()->subWeek()->addDays(1); //tanggal 1 minggu lalu
        $pemasukanMingguans = tbl_pemasukan::whereDate('created_at', '>=', $mingguan)->get();
        $pemasukanMingguanTotal = $pemasukanMingguans->sum('jml_masuk');

        //pemasukan 1 bulan terakhir
        $bulanan = $time->now()->subMonth(); //tanggal 1 bulan lalu
        $pemasukanBulanans = tbl_pemasukan::whereDate('created_at', '>=', $bulanan)->get();
        $pemasukanBulananTotal = $pemasukanBulanans->sum('jml_masuk');

        //pemasukan Harian
        $pemasukanHarians = [];
        $tanggalHarians = [];
        for ($i = 0; $i < 7; $i++) {
            // Copy dari tanggal dari minggu terakhir dan increment sampai hari ini (+6)
            $tanggalHarian = $mingguan->copy()->addDays($i)->format('Y-m-d');

            $tanggalHarians[$i] = $mingguan->copy()->addDays($i)->format('d-M');

            // Query untuk mendapatkan data pemasukan harian
            $pemasukanHarian = tbl_pemasukan::where('created_at', '=', $tanggalHarian)->get();

            // Menyimpan data harian ke dalam array
            $pemasukanHarians[$i] = $pemasukanHarian->sum('jml_masuk');
        }

        $totalPemasukan = tbl_pemasukan::all()->sum('jml_masuk');        

        // tanggal sampai 6 bulan sebelumnya
        $tanggalBulanans = [];
        $tanggalBulanansYMD = [];        

        // Loop untuk mendapatkan 6 bulan sebelumnya
        for ($i = 6; $i >= 0; $i--) {
            $tanggalBulanans[$i] = strtoupper($time->now()->subMonth($i)->format('M'));
            $tanggalBulanansYMD[$i] = strtoupper($time->now()->subMonth($i)->format('y-m-d'));
        }

        /* ------------------------------------- PENGELUARAN MINGGUAN ------------------------------------- */
        //pengeluaran 1 minggu terakhir
        $pengeluaranMingguans = tbl_pengeluaran::whereDate('created_at', '>=', $mingguan)->get();
        $pengeluaranMingguanTotal = $pengeluaranMingguans->sum('jml_keluar');

        //pengeluaran 1 bulan terakhir
        $pengeluaranBulanans = tbl_pengeluaran::whereDate('created_at', '>=', $bulanan)->get();
        $pengeluaranBulananTotal = $pengeluaranBulanans->sum('jml_keluar');

        $pengeluaranHarians = [];
        for ($i = 0; $i < 7; $i++) {
            // Copy dari tanggal dari minggu terakhir dan increment sampai hari ini (+6)
            $tanggalHarian = $mingguan->copy()->addDays($i)->format('Y-m-d');

            // Query untuk mendapatkan data pengeluaran harian
            $pengeluaranHarian = tbl_pengeluaran::where('created_at', '=', $tanggalHarian)->get();

            // Menyimpan data harian ke dalam array
            $pengeluaranHarians[$i] = $pengeluaranHarian->sum('jml_keluar');
        }

        $totalpengeluaran = tbl_pengeluaran::all()->sum('jml_keluar');

        /* ------------------------------------- PERBANDINGAN PEMASUKAN DAN PENGELUARAN MINGGUAN ------------------------------------- */
        if ($totalPemasukan == 0 && $totalpengeluaran == 0) {
            $perbandinganPemasukanPengeluaranMingguan = 0;
        } elseif ($totalpengeluaran == 0) {
            $perbandinganPemasukanPengeluaranMingguan = 100;
        } else {
            $perbandinganPemasukanPengeluaranMingguan = (($totalPemasukan - $totalpengeluaran) / $totalPemasukan) * 100;
        }

        /* ------------------------------------- PERBANDINGAN PEMASUKAN DAN PENGELUARAN BULANAN ------------------------------------- */
        
        if ($totalPemasukan == 0 && $totalpengeluaran == 0) {
            $perbandinganPemasukanPengeluaranBulanan = 0;
        } elseif ($totalpengeluaran == 0) {
            $perbandinganPemasukanPengeluaranBulanan = 100;
        } else {
            $perbandinganPemasukanPengeluaranBulanan = (($totalPemasukan - $totalpengeluaran) / $totalPemasukan) * 100;
        }
        
        /* ------------------------------------- PERBANDINGAN PEMASUKAN TIAP 6 BULAN TERAKHIR ------------------------------------- */
        


        /* ------------------------------------- PERBANDINGAN PEMASUKAN DENGAN MINGGU SEBELUMNYA ------------------------------------- */
        //Pemasukan 2 minggu terakhir
        $perbandinganMingguanTanggal =  $mingguan->copy()->addDays(-7);
        $dataPerbandinganMingguan = tbl_pemasukan::whereBetween('created_at', [$perbandinganMingguanTanggal, $mingguan->addDays(-1)])->get();
        $pemasukanPerbandinganMingguanTotal = $dataPerbandinganMingguan->sum('jml_masuk');

        //Persentase perbandingan 2 minggu terakhir dengan 1 minggu terakhir
        if ($pemasukanPerbandinganMingguanTotal != 0) {
            $persentasePerbandingan = (($pemasukanMingguanTotal - $pemasukanPerbandinganMingguanTotal) / $pemasukanPerbandinganMingguanTotal) * 100;
        } elseif ($pemasukanPerbandinganMingguanTotal == 0 && $pemasukanMingguanTotal == 0) {
            $persentasePerbandingan = 0;
        } else {
            // Membuat persentase perbandingan 100% jika data 2 minggu terakhir hingga 1 minggu terakhir 0
            $persentasePerbandingan = 100;
        }

        return view('direktur.dashboard', [
            'pemasukanHarians' => $pemasukanHarians,
            'pemasukanMingguan' => $pemasukanMingguanTotal,
            'pemasukanBulanan' => $pemasukanBulananTotal,
            'totalPemasukan' => $totalPemasukan,
            'pengeluaranHarians' => $pengeluaranHarians,
            'pengeluaranMingguan' => $pengeluaranMingguanTotal,
            'pengeluaranBulanan' => $pengeluaranBulananTotal,
            'totalPengeluaran' => $totalpengeluaran,
            'tanggalMingguan' => $mingguan->addDays(1)->format('d-m-Y'),
            'tanggalBulanan' => $bulanan->format('d-m-Y'),
            'tanggalBulanans' => $tanggalBulanans,
            'tanggalHarians' => $tanggalHarians,
            'perbandinganPemasukanPengeluaranMingguan' => $perbandinganPemasukanPengeluaranMingguan,            
            'perbandinganPemasukanPengeluaranBulanan' => $perbandinganPemasukanPengeluaranBulanan,
            'dump' => dd($tanggalBulanansYMD),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
