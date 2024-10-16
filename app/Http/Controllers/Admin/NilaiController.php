<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Periode;
use App\Models\Devisi;
use App\Models\Rank;
use App\Models\Nilai;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Alternatifnb;
use App\Models\Kriterianb;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($periodes, $devisis, $kriterias)
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
            if (Auth::User()->kategori=="Admin"){
                //jika berhasi (user id =1)
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);
                $kriterias = Kriteria::findOrFail($kriterias);
                $title = 'Data Nilai Kriteria';
                $data = Nilai::where('kriteria','=',$kriterias->id)->get();
                // return "sss";
                // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php
                return view('admin.nilai.index',['title' => $title, 'data' => $data,'periodes'=>$periodes,'devisis'=>$devisis,'kriterias'=>$kriterias]);
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
    public function create($periodes, $devisis,$kriterias)
    {
        try
        {
            // cek apakah user sudah login atau belum
            if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login
                return redirect()->route('login')->with('warning','Data tidak valid!');
            }
            if(!$periodes)
            {
                return redirect()->route('periode.index');
            }
            if(!$devisis)
            {
                return redirect()->route('devisi.index',[$periodes]);
            }
            if(!$kriterias)
            {
                return redirect()->route('kriteria.index',[$periodes,$devisis]);
            }
            // cek apakah id user = 1
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data periode
            if (Auth::User()->kategori=="Admin"){
                //jika berhasi (user id =1)
                $title = "Tambah Data Nilai Kriteria";
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);
                $kriterias = Kriteria::findOrFail($kriterias);
                return view('admin.nilai.create',['title' => $title, 'periodes' => $periodes,'devisis' => $devisis, 'kriterias' => $kriterias]);
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
     * Store a newly created resource in storage.
     */
    public function store($periodes, $devisis,$kriterias,  Request $req)
    {
        try
        {

            // cek apakah user sudah login atau belum
            if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login
                return redirect()->route('login')->with('warning','Data tidak valid!');
            }
            if(!$periodes)
            {
                return redirect()->route('periode.index');
            }
            if(!$devisis)
            {
                return redirect()->route('devisi.index',[$periodes]);
            }
            if(!$kriterias)
            {
                return redirect()->route('kriteria.index',[$periodes,$devisis]);
            }

            // cek apakah id user = 1
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            if (Auth::User()->id==1){
                $this->validate($req, [
                    'nilai1' => 'required|numeric',
                    'nilai2' => 'required|numeric',
                    'bobot' => 'required|numeric',
                ]);
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);
                $kriterias = Kriteria::findOrFail($kriterias);

                $nilaibaru1 = $req->nilai1;
                $nilaibaru2 = $req->nilai2;
                $bobotbaru = $req->bobot;

                    $carikode = Nilai::where('kriteria','=',$kriterias->id)->count();
                    if ($carikode < 0) {
                        if ($nilaibaru1 < 1 )

                        return redirect()->back()->with('warning','Data Nilai Awal harus > 0!');
                        }

                    if ($carikode >= 5) {
                    return redirect()->back()->with('warning','Data Nilai Pada Kriteria Ini sudah 5!');
                    }
                    if ($nilaibaru1 < 0) {
                        return redirect()->back()->with('warning','Data Nilai Kriteria tidak boleh < 0');
                    }
                    if ($nilaibaru2 < 0) {
                        return redirect()->back()->with('warning','Data Nilai Kriteria tidak boleh < 0');
                    }
                    if ($nilaibaru2 <= $nilaibaru1) {
                        return redirect()->back()->with('warning','Data Nilai 2 tidak boleh lebih kecil dari Nilai 1 Kriteria');
                    }
                    if ($bobotbaru < 0) {
                        return redirect()->back()->with('warning','Data Bobot Kriteria tidak boleh < 0');
                    }

                    $nilaiss = Nilai::where('kriteria','=',$kriterias->id)->get();
                    foreach ($nilaiss as $rowex => $valex) {
                        if ($nilaibaru1 <= $valex->nilai1 or $nilaibaru1 <= $valex->nilai2) {
                            return redirect()->back()->with('warning','Data Nilai 1 sudah ada dalam range nilai Kriteria!');
                        }
                        if ($nilaibaru2 <= $valex->nilai1 or $nilaibaru2 <= $valex->nilai2) {
                            return redirect()->back()->with('warning','Data Nilai 2 sudah ada dalam range nilai Kriteria!');
                            }
                        if ($bobotbaru == $valex->bobot) {
                            return redirect()->back()->with('warning','Data bobot Kriteria Sudah ada!');
                            }

                    }


                $title = "Simpan Data Nilai Kriteria";
                $nilaitambah = new Nilai;
                $nilaitambah->kriteria = $kriterias->id;
                $nilaitambah->nilai1 = $req->nilai1;
                $nilaitambah->nilai2 = $req->nilai2;
                $nilaitambah->bobot = $req->bobot;
                $nilaitambah->save();

                $status = "1 Data Nilai Kriteria baru telah diunggah.";
                return redirect()->back()->with('success', $status);
                // return redirect()->route('kriteria.index',[$periodes,$devisis])->with('success', $status);
                // dd($kriteria->toArray());
                // die;
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($periodes, $devisis, $kriterias, string $id)
    {
        // try
        // {
        //     $periodes = Periode::findOrFail($periodes);
        //     $devisis = Devisi::findOrFail($devisis);
        //     $kriterias =Kriteria::findOrFail($kriterias);
        //     $nilais = Nilai::findOrFail($id);
        //     $params = [
        //         'title' => 'Ubah Data Kriteria',
        //         'periodes' => $periodes,
        //         'devisis' => $devisis,
        //         'kriterias' => $kriterias,
        //         'nilais'  => $nilais,
        //     ];
        //     return view('admin.nilai.edit',[$periodes, $devisis, $kriterias, $nilais])->with($params);
        // }
        // catch (ModelNotFoundException $ex)
        // {
        //     if ($ex instanceof ModelNotFoundException)
        //     {
        //         return response()->view('errors.'.'404');
        //     }
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $periodes, $devisis, $kriterias, $id)
    {
        if (Auth::User()->id== '1'){

            // try
            // {
            //     $this->validate($request, [
            //         'nilai' => 'required|numeric',
            //         'bobot' => 'required|numeric',
            //     ]);
            //     $periodes = Periode::findOrFail($periodes);
            //     $devisis = Devisi::findOrFail($devisis);
            //     $kriterias = Kriteria::findOrFail($kriterias);

            //     $nilaibaru1 = $req->nilai1;
            //     $nilaibaru2 = $req->nilai2;
            //     $bobotbaru = $req->bobot;



            //     if ($nilaibaru1 < 0) {
            //         return redirect()->back()->with('warning','Data Nilai Kriteria tidak boleh < 0');
            //     }
            //     if ($nilaibaru2 < 0) {
            //         return redirect()->back()->with('warning','Data Nilai Kriteria tidak boleh < 0');
            //     }
            //     if ($nilaibaru2 <= $nilaibaru1) {
            //         return redirect()->back()->with('warning','Data Nilai 2 tidak boleh lebih kecil dari Nilai 1 Kriteria');
            //     }
            //     if ($bobotbaru < 0) {
            //         return redirect()->back()->with('warning','Data Bobot Kriteria tidak boleh < 0');
            //     }

            //     $nilaiss = Nilai::where('kriteria','=',$kriterias->id)->get();
            //     foreach ($nilaiss as $rowex => $valex) {
            //         if ($nilaibaru1 <= $valex->nilai1 or $nilaibaru1 <= $valex->nilai2) {
            //             return redirect()->back()->with('warning','Data Nilai 1 sudah ada dalam range nilai Kriteria!');
            //         }
            //         if ($nilaibaru2 <= $valex->nilai1 or $nilaibaru2 <= $valex->nilai2) {
            //             return redirect()->back()->with('warning','Data Nilai 2 sudah ada dalam range nilai Kriteria!');
            //             }
            //         if ($bobotbaru == $valex->bobot) {
            //             return redirect()->back()->with('warning','Data bobot Kriteria Sudah ada!');
            //             }

            //     }

            //     $nilaiss = Nilai::where('kriteria','=',$kriterias->id)->get();
            //     foreach ($nilaiss as $roweg => $valehx) {
            //         if ($nilaibaru == $valehx->nilai) {
            //         return redirect()->back()->with('warning','Data Nilai Kriteria Sudah ada!');
            //         }
            //         if ($bobotbaru == $valehx->bobot) {
            //             return redirect()->back()->with('warning','Data Bobot Kriteria Sudah ada!');
            //             }
            //     }
            //     $kriterubahs->nilai = $nilaibaru;
            //     $kriterubahs->bobot = $bobotbaru;
            //     $kriterubahs->save();






            //     return redirect()->route('kriteria.index',[$periodes, $devisis])->with('success','Data Kriteria Berhasil di Ubah!');
            //  }
            // catch (ModelNotFoundException $ex)
            // {
            //     if ($ex instanceof ModelNotFoundException)
            //     {
            //         return response()->view('errors.'.'404');
            //     }
            // }
        }
        else{
            $status = "Anda Tidak Punya Hak Akses";
            return redirect()->route('login')->with('warning', $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($periodes,$devisis, $kriterias, string $id)
    {
        if (Auth::User()->kategori== "Admin"){
            try
            {
                $devisis = Devisi::findOrFail($devisis);
                $kriterias = Kriteria::findOrFail($kriterias);
                $admin = Nilai::findOrFail($id);
                $hapusan = Alternatifnb::where('kriteria','=',$kriterias)->get();
                foreach ($hapusan as $keyss => $valaue) {
                     $hcias = Alternatifnb::findOrFail($valaue->id);

                     $hcias->update(['nilai' => 0]);
                }


                $admin->delete();
                $ubahststusp = DB::TABLE('devisis')->where('id','=',$devisis->id)->UPDATE(['status'=> 'Tidak Konsisten']);
                $ubahststusd = DB::TABLE('periodes')->where('id','=',$periodes)->UPDATE(['status'=> 'Tidak Konsisten']);
                $status = "1 Data Nilai Kriteria telah dihapus.";
                return redirect()->back()->with('success', $status);
            }
            catch (ModelNotFoundException $ex)
            {
                if ($ex instanceof ModelNotFoundException)
                {
                    return response()->view('errors.'.'404');
                }
            }
        }
        else{
            $status = "Anda Tidak Punya Hak Akses";
            return redirect()->route('login')->with('warning', $status);
        }
    }
}
