<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth; 
use App\Models\User; 
use App\Models\Periode; 
use App\Models\Devisi;   
class DevisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($periodes)
    {
        try
        {
            // cek apakah user sudah login atau belum
            if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login
                return redirect()->route('login')->with('warning','Data tidak valid!');
            }
            // cek apakah id user = 1 
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            if (Auth::User()->id==1){
                //jika berhasi (user id =1)  
                $title = 'Data Devisi';   
                $periodes = Periode::findOrFail($periodes);
                $data = Devisi::where('periode','=',$periodes->id)->orderBy('id', 'asc')->get();  

                // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php 
                return view('admin.devisi.index',['title' => $title, 'periodes'=>$periodes, 'data'=>$data]);
            }
            else{
                return redirect()->route('login')->with('warning','Data tidak valid!');
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
    public function create($periodes, $id=null)
    {
         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req, $periodes, $id = null)
    {
         
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
