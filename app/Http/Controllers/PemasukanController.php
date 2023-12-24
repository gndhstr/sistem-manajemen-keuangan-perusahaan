<?php

namespace App\Http\Controllers;

use App\tbl_pemasukan;
use App\tbl_kategori;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $tampil)
    {
        // $pemasukans = tbl_pemasukan::with('kategori')->where('status', '1')->get();
        $kategori = tbl_kategori::all();
        //filter tanggal
        $startDate = $tampil->input('start_date', now()->subMonth()->startOfDay());
        $endDate = $tampil->input('end_date', now()->endOfDay());
    
        $pemasukans = tbl_pemasukan::with('kategori')
            ->where('status', '1')
            ->whereBetween('tgl_pemasukan', [$startDate, $endDate])
            ->get();
            // dd($startDate, $endDate);
        return view('pemasukan.index', compact('pemasukans', 'kategori'));
    }

    //cetak
        public function cetak(Request $cetak)
        {
            // $pemasukans = tbl_pemasukan::with('kategori')->where('status', '1')->get();
            $kategori = tbl_kategori::all();
            //filter tanggal
            $startDate = $cetak->input('start_date', now()->subMonth()->startOfDay());
            $endDate = $cetak->input('end_date', now()->endOfDay());
        
            $pemasukans = tbl_pemasukan::with('kategori')
                ->where('status', '1')
                ->whereBetween('tgl_pemasukan', [$startDate, $endDate])
                ->orderBy('tgl_pemasukan')
                ->get();
            
            // inisialisasi
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $pdf = new Dompdf($options);
            
            $view = View::make('pemasukan.cetak', compact('pemasukans', 'kategori','startDate', 'endDate'))->render();
            $pdf->loadHtml($view);

            $pdf->render();
            return $pdf->stream('Data Pemasukan.pdf');
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
        return view('createPemasukan', compact('kategori'));
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

        return redirect()->route('daftarPemasukan')->with('success', 'Pemasukan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_pemasukan $pemasukan)
    {
        $kategori = tbl_kategori::all();
        return view('editPemasukan', compact('pemasukan', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_pemasukan $pemasukan)
    {
        $validatedData = $request->validate([
            'id_kategori' => 'required|integer',
            'id_user' => 'required|integer',
            'id_user_create' => 'required|integer',
            'id_user_edit' => 'required|integer',
            'tgl_pemasukan' => 'required|string',
            'jml_masuk' => 'required|string|max:255',
            'bukti_pemasukan' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'catatan' => 'nullable|string',
            'status' => 'nullable',
        ]);
        if ($request->hasFile('bukti_pemasukan')) {
            // Delete the old file
            Storage::delete('bukti_pemasukan/' . $pemasukan->bukti_pemasukan);
    
            // Upload and save the new file
            $file = $request->file('bukti_pemasukan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_pemasukan', $fileName, 'public');
            $pemasukan->bukti_pemasukan = $fileName;
        }
        $pemasukan->id_kategori = $validatedData['id_kategori'];
        $pemasukan->id_user = $validatedData['id_user'];
        $pemasukan->id_user_create = $validatedData['id_user_create'];
        $pemasukan->id_user_edit = $validatedData['id_user_edit'];
        $pemasukan->tgl_pemasukan = $validatedData['tgl_pemasukan'];
        $pemasukan->jml_masuk = $validatedData['jml_masuk'];
        $pemasukan->catatan = $validatedData['catatan'];
        $pemasukan->save();

        return redirect()->route('daftarPemasukan')->with('success', 'Data pemasukan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_pemasukan $pemasukan)
    {
        $pemasukan->status = '0';
        $pemasukan->save();
        return redirect()->route('daftarPemasukan')->with('success', 'Data Berhasil dihapus');
    }
}
