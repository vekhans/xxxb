<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Devisi;
use App\Models\Kriteria;
use App\Models\Kriterianb;
use App\Models\Periode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KriteriapController extends Controller
{
    public function index($periodes, $devisis)
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
            if (Auth::User()->id==2){
                //jika berhasi (user id =1)
                $devisis = Devisi::findOrFail($devisis);
                $title = 'Data Kriteria';
                $data = Kriteria::where('devisi','=',$devisis->id)->get();
                $rowss = Kriterianb::where('devisi','=',$devisis->id)->get();
                $periodes = Periode::findOrFail($periodes);
                // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php
                return view('pimpinan.kriteria.index',['title' => $title, 'data' => $data,'periodes'=>$periodes,'devisis'=>$devisis]);
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
}