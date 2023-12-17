<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class KaryawanController extends Controller
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

        $roles = \App\tbl_role::all();
        $divisis = \App\tbl_divisi::all();
        return view("manajer.karyawan",
        [
            "users"=>$users,
            "roles"=>$roles,
            "divisis"=>$divisis,
            "role_user"=>$role_user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("manajer.karyawan");
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
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tbl_users',
            'jenis_kelamin' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);
    
        $user = new User([
            'id_divisi' => Auth::user()->id_divisi,
            'role' => 4,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->username . "123"),
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
        ]);
    
        $user->save();
    
        return redirect(route('karyawan'))->with('success', 'Karyawan ' . $request->nama . ' berhasil ditambah');
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
        return view("manajer.karyawan",[
            "user"=>$user,
        ]);
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->alamat = $request->alamat;

        $user->save();
    
        return redirect(route('karyawan'))->with('success', 'Data karyawan ' . $request->nama . ' berhasil diperbarui');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route("karyawan"))->with("success","Karyawan $user->nama berhasil dihapus");
    }
}
