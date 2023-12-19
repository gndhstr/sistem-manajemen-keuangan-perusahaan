    public function index(){
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

        return view("karyawan.dashboard", [
            "users" => $users,
            "pemasukans" => $pemasukans,
            "pengeluarans" => $pengeluarans,
            "totalMasuk" => $totalMasuk,
            "totalKeluar" => $totalKeluar,
            "perbandinganPemasukanPengeluaran" => $perbandinganPemasukanPengeluaran,
            "divisi"=> $user->division->nama_divisi,
            "saldo" => $saldo,
        ]);
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
