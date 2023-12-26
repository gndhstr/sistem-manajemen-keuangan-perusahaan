<?php

namespace App\Http\Controllers;

use App\tbl_pengeluaran;
use App\tbl_kategori;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $tampil)
    {
        $time = new Carbon();
        $time->setTimeZone('Asia/Jakarta');

        $user = Auth::user();
        $id_user = $user->id;

        $kategori = tbl_kategori::all()->where('id_kategori', '<>', 8);
        $startDate = $tampil->input('start_date', now()->startOfMonth());
        $endDate = $tampil->input('end_date', now()->endOfMonth());
        $start_date = $time->now()->startOfMonth()->format('Y-m-d');
        $end_date = $time->now()->endOfMonth()->format('Y-m-d');
    
        $pengeluarans = tbl_pengeluaran::with('kategori')
            ->where('status', '1')
            ->where('id_user', $id_user)
            ->whereBetween('tgl_pengeluaran', [$startDate, $endDate])
            ->get();
            $total =$pengeluarans->sum("jml_keluar");
            // dd($startDate, $endDate);
        return view('pengeluaran.index', compact('pengeluarans', 'kategori', "total", 'start_date', 'end_date'));
    }
        //cetak
        public function cetak(Request $cetak)
        {
            // $pengeluarans = tbl_pengeluaran::with('kategori')->where('status', '1')->get();
            $kategori = tbl_kategori::all();
            //filter tanggal
            $startDate = $cetak->input('start_date', now()->subMonth()->startOfDay());
            $endDate = $cetak->input('end_date', now()->endOfDay());
        
            $pengeluarans = tbl_pengeluaran::with('kategori')
                ->where('status', '1')
                ->whereBetween('tgl_pengeluaran', [$startDate, $endDate])
                ->orderBy('tgl_pengeluaran')
                ->get();
            $total =$pengeluarans->sum("jml_keluar");
            
            // inisialisasi
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $pdf = new Dompdf($options);
            
            $view = View::make('pengeluaran.cetak', compact('pengeluarans', 'kategori','startDate', 'endDate',"total"))->render();
            $pdf->loadHtml($view);

            $pdf->render();
            return $pdf->stream('Data Pengeluaran.pdf');
        }
    // 
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
            'bukti_pengeluaran' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable',
        ]);
        $file = $request->file('bukti_pengeluaran');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('bukti_pengeluaran', $fileName, 'public');  
        $pengeluaran = new tbl_pengeluaran();
        $pengeluaran->fill($request->all());
        $pengeluaran->jml_keluar = $request->input('jml_keluar', 0);
        $pengeluaran->catatan = $request->input('catatan', '');
        $pengeluaran->bukti_pengeluaran = $fileName;
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
            'catatan' => 'nullable|string',
            'status' => 'nullable',
        ]);
    

        
    
        $pengeluaran->id_kategori = $validatedData['id_kategori'];
        $pengeluaran->id_user = $validatedData['id_user'];
        $pengeluaran->id_user_create = $validatedData['id_user_create'];
        $pengeluaran->id_user_edit = $validatedData['id_user_edit'];
        $pengeluaran->tgl_pengeluaran = $validatedData['tgl_pengeluaran'];
        $pengeluaran->jml_keluar = $validatedData['jml_keluar'];
        $pengeluaran->catatan = $validatedData['catatan'];
        $pengeluaran->save();
    
        return redirect()->route('daftarPengeluaran')->with('success', 'Data pengeluaran berhasil diperbarui');
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
