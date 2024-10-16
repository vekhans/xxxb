<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Periode;
use App\Models\Devisi;
use App\Models\Rank;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Alternatifnb;
use App\Models\Kriterianb;
use Illuminate\Support\Facades\DB;
class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            if (Auth::User()->id==1){
                //jika berhasi (user id =1)
                $devisis = Devisi::findOrFail($devisis);
                $title = 'Data Kriteria';
                $data = Kriteria::where('devisi','=',$devisis->id)->get();
                $rowss = Kriterianb::where('devisi','=',$devisis->id)->get();
                $periodes = Periode::findOrFail($periodes);
                // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php
                return view('admin.kriteria.index',['title' => $title, 'data' => $data,'periodes'=>$periodes,'devisis'=>$devisis]);
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
    public function create($periodes, $devisis)
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
            // cek apakah id user = 1
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data periode
            if (Auth::User()->id==1){
                //jika berhasi (user id =1)
                $title = "Tambah data Kriteria";
                $atribut  = (['Benefit','Cost']);
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);
                return view('admin.kriteria.create',['title' => $title, 'periodes' => $periodes,'devisis' => $devisis, 'atribut' => $atribut]);
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
    public function store(Request $req, $periodes, $devisis, $id = null)
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
            // cek apakah id user = 1
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            if (Auth::User()->id==1){
                $this->validate($req, [
                    'nama' => 'required',
                    'kode' => 'required|max:20',
                    'atribut' => 'required',
                ]);
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);

                $devper = Devisi::where('periode','=',$periodes->id)->get();
                foreach ($devper as $row => $val) {
                    $carikode = Kriteria::where('devisi','=',$val->id)->where('kode','=',$req->kode)->count();
                    if ($carikode > 0) {
                    return redirect()->back()->with('warning','Data Kode Sudah Dipakai Pada Kriteria lain pada periode ini!');
                    }
                    //RANI YANG HAPUS
                    // HAPUS INI KARNA PROGRAM MUNCUL WARNING!!
                    // $carinam = Kriteria::where('devisi','=',$val->id)->where('nama','=',$req->nama)->count();
                    // if ($carinam > 0) {
                    // return redirect()->back()->with('warning','Data Nama Sudah Dipakai Pada Kriteria lain pada periode ini!');
                    // }
                }
                $title = "Simpan Data Kriteria";
                $kriteriastam = new Kriteria;
                $kriteriastam->devisi = $devisis->id;
                $kriteriastam->nama = $req->nama;
                $kriteriastam->kode = $req->kode;
                $kriteriastam->atribut = $req->atribut;
                $kriteriastam->save();
                $kriteria = Kriteria::WHERE('devisi','=',$devisis->id)->get();
                foreach ($kriteria as $key) {
                    $kriteriass2 = new Kriterianb;
                    $kriteriass2->devisi = $devisis->id;
                    $kriteriass2->id1 = $kriteriastam->id;
                    $kriteriass2->id2 = $key->id;
                    $kriteriass2->save();
                }
                foreach ($kriteria as $val) {
                    if ($kriteriastam->id != $val->id) {
                        $kriteriass2 = new Kriterianb;
                        $kriteriass2->devisi = $devisis->id;
                        $kriteriass2->id1 = $val->id;
                        $kriteriass2->id2 = $kriteriastam->id;
                        $kriteriass2->save();
                    }
                }
                $relalternatif = Rank::WHERE('periode','=',$periodes->id)->WHERE('devisi','=',$devisis->id)->get();
                foreach ($relalternatif as $vaes) {
                    $aaaa = new Alternatifnb;
                    $aaaa->periode = $periodes->id;
                    $aaaa->alternatif = $vaes->alternatif;
                    $aaaa->kriteria = $kriteriastam->id;
                    $aaaa->nilai = 0;
                    $aaaa->save();
                }
                $status = "1 Data Kriteria baru telah diunggah.";
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
    public function edit($periodes, $devisis, string $id)
    {
        try
        {
            $periodes = Periode::findOrFail($periodes);
            $devisis = Devisi::findOrFail($devisis);
            $kriterias = Kriteria::findOrFail($id);
            $params = [
                'title' => 'Ubah Data Kriteria',
                'periodes' => $periodes,
                'devisis' => $devisis,
                'kriterias' => $kriterias,
                'atribut'  => (['Benefit','Cost']),
            ];
            return view('admin.kriteria.edit',[$periodes, $devisis, $kriterias])->with($params);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $periodes, $devisis, $id)
    {
        if (Auth::User()->id== '1'){

            try
            {
                $this->validate($request, [
                    'nama' => 'required',
                    'atribut' => 'required',
                    'kode' => 'required|max:100',
                ]);
                $periodes = Periode::findOrFail($periodes);

                $kriterubahs = Kriteria::findOrFail($id);
                $kode = $kriterubahs->kode;
                $nama = $kriterubahs->nama;
                $kriterubahs->nama = $request->nama;
                $kriterubahs->kode = $request->kode;
                $kriterubahs->atribut = $request->atribut;
                $kriterubahs->save();
                $devpered = Devisi::where('periode','=',$periodes->id)->get();
                foreach ($devpered as $rowe => $vale) {
                    $carikod = Kriteria::where('devisi','=',$vale->id)->where('kode','=',$request->kode)->count();
                    if ($carikod > 1) {
                        DB::TABLE('kriterias')->where('id','=',$kriterubahs->id)->UPDATE(['kode'=> $kode]);
                    return redirect()->back()->with('warning','Data Kode Sudah Dipakai Pada Kriteria lain pada periode ini!');
                    }
                    $carinama = Kriteria::where('devisi','=',$vale->id)->where('nama','=',$request->nama)->count();
                    if ($carinama > 1) {
                        DB::TABLE('kriterias')->where('id','=',$kriterubahs->id)->UPDATE(['nama'=> $nama]);
                    return redirect()->back()->with('warning','Data Nama Sudah Dipakai Pada Kriteria lain pada periode ini!');
                    }
                }

                foreach ($devpered as $rowde => $valed) {
                    $carikodiu = Kriteria::where('devisi','!=',$kriterubahs->devisi)->where('kode','=',$request->kode)->count();
                    if ($carikodiu > 0) {
                        DB::TABLE('kriterias')->where('id','=',$kriterubahs->id)->UPDATE(['kode'=> $kode]);
                    return redirect()->back()->with('warning','Data Kode Sudah Dipakai Pada Kriteria lain pada periode ini!');
                    }
                    $carinamaks = Kriteria::where('devisi','!=',$kriterubahs->devisi)->where('nama','=',$request->nama)->count();
                    if ($carinamaks > 0) {
                        DB::TABLE('kriterias')->where('id','=',$kriterubahs->id)->UPDATE(['nama'=> $nama]);
                    return redirect()->back()->with('warning','Data Nama Sudah Dipakai Pada Kriteria lain pada periode ini!');
                    }


                }




                return redirect()->route('kriteria.index',[$periodes, $devisis])->with('success','Data Kriteria Berhasil di Ubah!');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($periodes,$devisis,string $id)
    {
        if (Auth::User()->kategori== "Admin"){
            try
            {
                $devisis = Devisi::findOrFail($devisis);
                $admin = Kriteria::findOrFail($id);
                $hapusan = Alternatifnb::where('kriteria','=',$id)->get();
                foreach ($hapusan as $keyss => $valaue) {
                     $hcias = Alternatifnb::findOrFail($valaue->id);
                     $hcias->delete();
                }
                $hapussan = Kriterianb::where('id1','=',$id)->where('devisi','=',$devisis->id)->get();
                foreach ($hapussan as $keyss => $valaue) {
                     $hciaus = Kriterianb::findOrFail($valaue->id);
                     $hciaus->delete();
                }
                 $hgapussan = Kriterianb::where('id2','=',$id)->where('devisi','=',$devisis->id)->get();
                foreach ($hgapussan as $keyss => $valaue) {
                     $hgciaus = Kriterianb::findOrFail($valaue->id);
                     $hgciaus->delete();
                }
                $admin->delete();
                $ubahststusp = DB::TABLE('devisis')->where('id','=',$devisis->id)->UPDATE(['status'=> 'Tidak Konsisten']);
                $ubahststusd = DB::TABLE('periodes')->where('id','=',$periodes)->UPDATE(['status'=> 'Tidak Konsisten']);
                return redirect()->route('kriteria.index',[$periodes, $devisis])->with('success', "Kriteria <strong>$admin->kode - $admin->nama</strong> Berhasil dihapus dari semua tabel.");

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
