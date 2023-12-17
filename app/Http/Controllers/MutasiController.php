<?php

namespace App\Http\Controllers;

use App\User;
use App\tbl_pemasukan;
use App\tbl_pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $role_user = 4;
        $divisi_user = $user->id_divisi;
        
        $users = User::where('role', $role_user)
                  ->where('id_divisi', $divisi_user)
                  ->get();

        $pemasukans = tbl_pemasukan::where('status', "1")->get();
        $pengeluarans = tbl_pengeluaran::where('status', "1")->get();
        return view("manajer.mutasi",
        [
            "users"=>$users,
            "pemasukans"=>$pemasukans,
            "pengeluarans"=>$pengeluarans,
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
