<?php

namespace App\Http\Controllers;

use App\tbl_anggaran;
use App\tbl_divisi;
use App\tbl_pemasukan;
use App\tbl_pengeluaran;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DirekturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $time = new Carbon();
        $time->setTimeZone('Asia/Jakarta');

        /* ------------------------------------- PEMASUKAN MINGGUAN------------------------------------- */
        //pemasukan 1 minggu terakhir
        $mingguan = $time->now()->subWeek()->addDays(1); //tanggal 1 minggu lalu
        $pemasukanMingguans = tbl_pemasukan::whereDate('created_at', '>=', $mingguan)->where('status', '1')->get();
        $pemasukanMingguanTotal = $pemasukanMingguans->sum('jml_masuk');

        //pemasukan 1 bulan ini
        $bulanan = $time->now()->startOfMonth(); //Bulan ini
        $pemasukanBulanan = tbl_pemasukan::whereDate('created_at', '>=', $bulanan)->where('status', '1')->get();
        $pemasukanBulananTotal = $pemasukanBulanan->sum('jml_masuk');

        //pemasukan Harian
        $pemasukanHarians = [];
        $tanggalHarians = [];
        for ($i = 0; $i < 7; $i++) {
            // Copy dari tanggal dari minggu terakhir dan increment sampai hari ini (+6)
            $tanggalHarian = $mingguan->copy()->addDays($i)->format('Y-m-d');

            $tanggalHarians[$i] = $mingguan->copy()->addDays($i)->format('d-M');

            // Query untuk mendapatkan data pemasukan harian
            $pemasukanHarian = tbl_pemasukan::where('created_at', '=', $tanggalHarian)->where('status', '1')->get();

            // Menyimpan data harian ke dalam array
            $pemasukanHarians[$i] = $pemasukanHarian->sum('jml_masuk');
        }

        $totalPemasukan = tbl_pemasukan::all()->where('status', '1')->sum('jml_masuk');

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
            $pemasukanBulanans[$i] = tbl_pemasukan::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->where('status', '1')->get()->sum('jml_masuk');
            $pengeluaranBulanans[$i] = tbl_pengeluaran::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->where('status', '1')->get()->sum('jml_keluar');
        }

        /* ------------------------------------- PENGELUARAN MINGGUAN ------------------------------------- */
        //pengeluaran 1 minggu terakhir
        $pengeluaranMingguans = tbl_pengeluaran::whereDate('created_at', '>=', $mingguan)->where('status', '1')->get();
        $pengeluaranMingguanTotal = $pengeluaranMingguans->sum('jml_keluar');

        //pengeluaran 1 bulan terakhir
        $pengeluaranBulanan = tbl_pengeluaran::whereDate('created_at', '>=', $bulanan)->where('status', '1')->get();
        $pengeluaranBulananTotal = $pengeluaranBulanan->sum('jml_keluar');

        $pengeluaranHarians = [];
        for ($i = 0; $i < 7; $i++) {
            // Copy dari tanggal dari minggu terakhir dan increment sampai hari ini (+6)
            $tanggalHarian = $mingguan->copy()->addDays($i)->format('Y-m-d');

            // Query untuk mendapatkan data pengeluaran harian
            $pengeluaranHarian = tbl_pengeluaran::where('created_at', '=', $tanggalHarian)->where('status', '1')->get();

            // Menyimpan data harian ke dalam array
            $pengeluaranHarians[$i] = $pengeluaranHarian->sum('jml_keluar');
        }

        $totalPengeluaran = tbl_pengeluaran::all()->where('status', '1')->sum('jml_keluar');

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

        return view('direktur.dashboard', [
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
        ]);
    }

    public function cashflow()
    {
        $divisis =  tbl_divisi::withCount('users')->with([
            'pemasukans' => function ($query) {
                $query->selectRaw('id_divisi, SUM(jml_masuk) as total_pemasukan')->where('status', '1')->groupBy('id_divisi');
            },
            'pengeluarans' => function ($query) {
                $query->selectRaw('id_divisi, SUM(jml_keluar) as total_pengeluaran')->where('status', '1')
                    ->groupBy('id_divisi');
            },
        ])->get();

        $pemasukans = tbl_pemasukan::select('id_pemasukan as id', 'id_kategori', 'id_user', 'id_user_create', 'id_user_edit', 'jml_masuk as jumlah', 'tgl_pemasukan as tanggal', 'catatan', 'bukti_pemasukan as bukti', 'status', 'created_at')->where('status', '1')
            ->addSelect(DB::raw("'pemasukan' as jenis_transaksi"));

        $pengeluarans = tbl_pengeluaran::select('id_pengeluaran as id', 'id_kategori', 'id_user', 'id_user_create', 'id_user_edit', 'jml_keluar as jumlah', 'tgl_pengeluaran as tanggal', 'catatan', 'bukti_pengeluaran as bukti', 'status', 'created_at')->where('status', '1')
            ->addSelect(DB::raw("'pengeluaran' as jenis_transaksi"));

        $riwayatPemasukanPengeluaran = $pemasukans->union($pengeluarans)->orderBy('created_at', 'desc')->take(10)->get();

        return view('direktur.cashflow', [
            // 'dump' => dd($divisis),
            'riwayatPemasukanPengeluaran' => $riwayatPemasukanPengeluaran,
            'divisis' => $divisis,
        ]);
    }

    public function cashflowDivisi(Request $request, $id)
    {
        $divisi = tbl_divisi::findOrFail($id);
        $totalPemasukan = $divisi->pemasukans->sum('jml_masuk');
        $totalPengeluaran = $divisi->pengeluarans->sum('jml_keluar');

        $users = tbl_divisi::with('users', 'pemasukans', 'pengeluarans')->find($id)->users;

        $pemasukans = tbl_divisi::with('users', 'pemasukans', 'pengeluarans')->find($id)->pemasukans;
        $pengeluarans = tbl_divisi::with('users', 'pemasukans', 'pengeluarans')->find($id)->pengeluarans;

        return response()->json([
            'divisi' => $divisi,
            'users' => $users,
            'pemasukans' => $pemasukans,
            'pengeluarans' => $pengeluarans,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
        ]);
    }

    public function anggaran()
    {
        $anggarans = tbl_anggaran::all()->where('status', '1');

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
            $rencanaBulanans[$i] = tbl_anggaran::whereBetween('tgl_anggaran', [$tanggalAwal, $tanggalAkhir])->where('status', '1')->get()->sum('rencana_anggaran');
            $aktualisasiBulanans[$i] = tbl_anggaran::whereBetween('tgl_anggaran', [$tanggalAwal, $tanggalAkhir])->where('status', '1')->get()->sum('aktualisasi_anggaran');
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

        return view('direktur.anggaran', [
            // 'dump' => dd($aktualisasiBulanans),
            'tanggalBulanans' => $tanggalBulanans,
            'anggarans' => $anggarans,
            'rencanaBulanans' => $rencanaBulanans,
            'aktualisasiBulanans' => $aktualisasiBulanans,
            'perbandinganAnggaran' => $perbandinganAnggaran,
        ]);
    }

    public function karyawan()
    {
        $karyawans = User::all()->where('role', '=', '4');

        return view('direktur.karyawan', [
            // 'dump' => dd($karyawans),
            'karyawans' => $karyawans,
        ]);
    }
}
