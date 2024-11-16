<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mkriteria;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class MkriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($devisis)
    {
        // dd($devisis);
        // die();
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
                $devisis = $devisis;
                $title = 'Data Kriteria';
                $data =Mkriteria::where('devisi','=',$devisis)->get();
                 // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php
                return view('admin.mkriteria.index',['title' => $title, 'data' => $data, 'devisis'=>$devisis]);
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
    public function create($devisis)
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
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data periode
            if (Auth::User()->id==1){
                //jika berhasi (user id =1)
                $title = "Tambah data Kriteria";
                $atribut  = (['Benefit','Cost']);

                return view('admin.mkriteria.create',['title' => $title,  'devisis' => $devisis, 'atribut' => $atribut]);
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

    public function store(Request $req, $devisis, $id = null)
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
                $this->validate($req, [
                    'nama' => 'required',
                    'satuan' => 'required',
                    'atribut' => 'required',
                ]);

                $devisis = $devisis;
                if ($devisis === "Cuci") {
                    $kode = "C";
                }elseif($devisis === "Strika"){
                    $kode = "S";
                }elseif($devisis === "Packing"){
                    $kode = "P";
                }else {
                    $status = "Data Devisi SAlah";
                return redirect()->back()->with('error', $status);

                }
                $kriteriastam = new Mkriteria;
                $kriteriastam->devisi = $devisis;
                $kriteriastam->nama = $req->nama;
                $kriteriastam->kode = "A";
                $kriteriastam->satuan = $req->satuan;
                $kriteriastam->atribut = $req->atribut;
                $kriteriastam->save();
                $alternatifsew = Mkriteria::findOrFail($kriteriastam->id);
                DB::TABLE('mkriterias')->where('id','=',$kriteriastam->id)->UPDATE(['kode'=> $kode.$kriteriastam->id]);
                 $alternatifsew->save();

                 $carinama2 = Mkriteria::where('nama','=',$req->nama)->count();
                    if ($carinama2 > 1) {
                        DB::TABLE('mkriterias')->where('id','=',$kriteriastam->id)->delete();
                    return redirect()->back()->with('warning','Data Nama Sudah Dipakai Pada Data Master Kriteria lain!');
                    }

                $status = "1 Data Mater Kriteria baru telah diunggah.";
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
    public function edit($devisis, string $id)
    {
        try
        {
            $kriterias = Mkriteria::findOrFail($id);
            $params = [
                'title' => 'Ubah Data Master Kriteria',
                'devisis' => $devisis,
                'kriterias' => $kriterias,
                'atribut'  => (['Benefit','Cost']),
            ];
            return view('admin.mkriteria.edit',[ $devisis, $kriterias])->with($params);
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
    public function update(Request $request, $devisis, $id)
    {
        if (Auth::User()->id== '1'){

            try
            {
                $this->validate($request, [
                    'nama' => 'required',
                    'atribut' => 'required',
                    'satuan' => 'required',
                ]);

                $kriterubahs = Mkriteria::findOrFail($id);
                 $nama = $kriterubahs->nama;
                $kriterubahs->nama = $request->nama;
                $kriterubahs->satuan = $request->satuan;
                $kriterubahs->atribut = $request->atribut;
                $kriterubahs->save();

                    $carinama = Mkriteria::where('devisi','=',$devisis)->where('nama','=',$request->nama)->count();
                    if ($carinama > 1) {
                        DB::TABLE('mkriterias')->where('id','=',$kriterubahs->id)->UPDATE(['nama'=> $nama]);
                    return redirect()->back()->with('warning','Data Nama Sudah Dipakai Pada Kriteria lain pada periode ini!');
                    }
                    $krubah = Kriteria::where('mkriteria','=', $kriterubahs->id)->get();

                    foreach ($krubah as $kreyss => $vralaue) {

                        DB::TABLE('kriterias')->where('mkriteria','=',$vralaue->id)->UPDATE(['nama'=> $kriterubahs->nama, 'satuan'=>$kriterubahs->satuan,'atribut'=>$kriterubahs->atribut ]);
                    }




                return redirect()->route('kriteriam.index',[$devisis])->with('success','Data Master Kriteria Berhasil di Ubah!');
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
    public function destroy($devisis,string $id)
    {
        if (Auth::User()->kategori== "Admin"){
            try
            {
                $relationships = array('kriteriask');
                $admin = Mkriteria::findOrFail($id);
                $should_delete = true;
                foreach($relationships as $r) {
                    if ($admin->$r->isNotEmpty()) {
                        $should_delete = false;
                        return redirect()->route('kriteriam.index',[$devisis])->with('error', "User <strong>$admin->name</strong> tidak bisa dihapus karna sudah dipakai pada data lainnya.");
                    }
                }
                if ($should_delete == true) {
                    $admin->delete();
                    return redirect()->route('kriteriam.index',[$devisis])->with('success', "User <strong>$admin->name</strong> Berhasil dihapus");
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
        else{
            return redirect()->route('login')->with('warning','Data tidak valid!');
        }
    }
}
