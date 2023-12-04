<?php

namespace App\Http\Controllers;

use App\tbl_pemasukan;
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

        //pemasukan 1 minggu terakhir
        $mingguan = $time->now()->subWeek()->addDays(1);
        $pemasukanMingguans = tbl_pemasukan::where('created_at', '>=', $mingguan)->get();
        $pemasukanMingguanTotal = $pemasukanMingguans->sum('jml_masuk');

        //pemasukan 1 bulan terakhir
        $bulanan = $time->now()->subMonth();
        $pemasukanBulanans = tbl_pemasukan::where('created_at', '>=', $bulanan)->get();
        $pemasukanBulananTotal = $pemasukanBulanans->sum('jml_masuk');

        //pemasukan Harian
        $pemasukanHarians = [];
        $tanggalHarianD = [];
        for ($i = 0; $i < 7; $i++) {
            // Copy dari tanggal dari minggu terakhir dan increment sampai hari ini (+6)
            $tanggalHarian = $mingguan->copy()->addDays($i)->format('Y-m-d');

            $tanggalHarianD[$i] = $mingguan->copy()->addDays($i)->format('d-M');

            // Query untuk mendapatkan data pemasukan harian
            $pemasukanHarian = tbl_pemasukan::where('created_at', '=', $tanggalHarian)->get();

            // Menyimpan data harian ke dalam array
            $pemasukanHarians[$i] = $pemasukanHarian->sum('jml_masuk');
        }

        //Pemasukan 2 minggu terakhir
        $perbandinganMingguanTanggal =  $mingguan->copy()->addDays(-7);
        $dataPerbandinganMingguan = tbl_pemasukan::whereBetween('created_at', [$perbandinganMingguanTanggal, $mingguan])->get();
        $pemasukanPerbandinganMingguanTotal = $dataPerbandinganMingguan->sum('jml_masuk');
        
        //Persentase perbandingan 2 minggu terakhir dengan 1 minggu terakhir
        if ($pemasukanPerbandinganMingguanTotal != 0) {
            $persentasePerbandingan = (($pemasukanMingguanTotal - $pemasukanPerbandinganMingguanTotal) / $pemasukanPerbandinganMingguanTotal) * 100;
        } else {
            // Handle the case where $pemasukanPerbandinganMingguanTotal is 0 to avoid division by zero
            $persentasePerbandingan = 0;
        }

        $totalPemasukan = tbl_pemasukan::all()->sum('jml_masuk');

        // $pemasukanMingguanTotal = 0;
        // $pemasukanBulananTotal = 0;

        return view('direktur.dashboard', [
            'pemasukanHarians' => $pemasukanHarians,
            'pemasukanMingguan' => $pemasukanMingguanTotal,
            'pemasukanBulanan' => $pemasukanBulananTotal,
            'totalPemasukan' => $totalPemasukan,
            'tanggalMingguan' => $mingguan->format('d-m-Y'),
            'tanggalBulanan' => $bulanan->format('d-m-Y'),
            'tanggalHarians' => $tanggalHarianD,
            'persentasePerbandingan' => $persentasePerbandingan,
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
