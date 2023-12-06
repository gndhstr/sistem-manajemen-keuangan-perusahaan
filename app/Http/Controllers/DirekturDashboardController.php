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
        $pemasukanBulanan = tbl_pemasukan::whereDate('created_at', '>=', $bulanan)->get();
        $pemasukanBulananTotal = $pemasukanBulanan->sum('jml_masuk');

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

        /* ------------------------------------- PEMASUKAN DAN PENGELUARAN TIAP 6 BULAN TERAKHIR ------------------------------------- */
        // data pemasukan dan pengeluaran sampai 6 bulan sebelumnya
        $tanggalBulanans = [];
        $tanggalBulanansYMD = [];    
        $pemasukanBulanans = [];
        $pengeluaranBulanans = [];

        // Loop untuk mendapatkan 6 bulan sebelumnya
        for ($i = 6; $i >= 0; $i--) {
            $tanggalAwal = $time->now()->subMonth($i)->startOfMonth();
            $tanggalAkhir = $time->now()->subMonth($i)->endOfMonth();
        
            $tanggalBulanans[$i] = strtoupper($tanggalAwal->format('M'));
            $tanggalBulanansYMD[$i] = strtoupper($tanggalAwal->format('Y-m-d'));
        
            // Ambil data untuk setiap bulan
            $pemasukanBulanans[$i] = tbl_pemasukan::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->get()->sum('jml_masuk');
            $pengeluaranBulanans[$i] = tbl_pengeluaran::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->get()->sum('jml_keluar');
        }

        /* ------------------------------------- PENGELUARAN MINGGUAN ------------------------------------- */
        //pengeluaran 1 minggu terakhir
        $pengeluaranMingguans = tbl_pengeluaran::whereDate('created_at', '>=', $mingguan)->get();
        $pengeluaranMingguanTotal = $pengeluaranMingguans->sum('jml_keluar');

        //pengeluaran 1 bulan terakhir
        $pengeluaranBulanan = tbl_pengeluaran::whereDate('created_at', '>=', $bulanan)->get();
        $pengeluaranBulananTotal = $pengeluaranBulanan->sum('jml_keluar');

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
            $perbandinganPemasukanPengeluaranMingguan = (($pemasukanMingguanTotal - $pengeluaranMingguanTotal) / $pemasukanMingguanTotal) * 100;
        }

        /* ------------------------------------- PERBANDINGAN PEMASUKAN DAN PENGELUARAN BULANAN ------------------------------------- */
        if ($totalPemasukan == 0 && $totalpengeluaran == 0) {
            $perbandinganPemasukanPengeluaranBulanan = 0;
        } elseif ($totalpengeluaran == 0) {
            $perbandinganPemasukanPengeluaranBulanan = 100;
        } else {
            $perbandinganPemasukanPengeluaranBulanan = (($pemasukanBulananTotal - $pengeluaranBulananTotal) / $pemasukanBulananTotal) * 100;
        }           

        return view('direktur.dashboard', [
            'pemasukanHarians' => $pemasukanHarians,
            'pemasukanBulanans' => $pemasukanBulanans,
            'pengeluaranBulanans' => $pengeluaranBulanans,
            'pemasukanMingguan' => $pemasukanMingguanTotal,
            'pemasukanBulanan' => $pemasukanBulananTotal,
            'totalPemasukan' => $totalPemasukan,
            'pengeluaranHarians' => $pengeluaranHarians,
            'pengeluaranMingguan' => $pengeluaranMingguanTotal,
            'pengeluaranBulanan' => $pengeluaranBulananTotal,
            'totalPengeluaran' => $totalpengeluaran,
            'tanggalMingguan' => $mingguan->format('d-m-Y'),
            'tanggalBulanan' => $bulanan->format('d-m-Y'),
            'tanggalBulanans' => $tanggalBulanans,
            'tanggalHarians' => $tanggalHarians,
            'perbandinganPemasukanPengeluaranMingguan' => $perbandinganPemasukanPengeluaranMingguan,            
            'perbandinganPemasukanPengeluaranBulanan' => $perbandinganPemasukanPengeluaranBulanan,
            // 'dump' => dd($pemasukanBulanans),
        ]);
    }    
}
