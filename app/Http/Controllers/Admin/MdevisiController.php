<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MdevisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            // cek apakah user sudah login atau belum
            if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login
                $status = "Data tidak valid!...";
                return redirect()->route('login')->with('warning', $status);
            }
            // cek apakah id user = 1
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            if (Auth::User()->kategori=== "Admin"){
                //jika berhasi (user id =1)
                //maka akan membuat title dengan nama title = Data Profil'
                $title = 'Data Devisi';
                //mengambil semua data yang ada di dalam table user'
                                 // menampilkan halaman user yang lokasinya ada di profil/resource/view/admin/profil/index.blade.php
                return view('admin.mdevisi.index',['title' => $title]);
            }

            else{
                $status = "Anda Bukan Super Admin!...";
                return redirect()->route('login')->with('warning', $status);
            }
        }
        catch (ModelNotFoundException $ex)
        {
            if ($ex instanceof ModelNotFoundException)
            {
                return response()->view('errors.'.'404');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}