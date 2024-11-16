<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Periode;
use App\Models\Devisi;
use App\Models\Rank;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Alternatifnb;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AlternatifController extends Controller
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
                $title = 'Data Alternatif';
                $data = Alternatif::where('periode','=',$periodes)->get();
                $periodes = Periode::findOrFail($periodes);

                $rankss=[];
                foreach ($data as $rowakl ) {
                    $rankss[$rowakl->id] = array(
                        'alternatif' => $rowakl ->id,
                    );
                }
                return view('admin.alternatif.index',['title' => $title, 'data' => $data, 'rankss' => $rankss, 'periodes'=>$periodes]);
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
        try
        {
            // cek apakah user sudah login atau belum
            if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login
                return redirect()->route('login')->with('warning','Data tidak valid!');
            }
             // cek apakah id user = 1
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data devisi
            if (Auth::User()->id==1){
                //jika berhasi (user id =1)
                $title = "Tambah Data Alternatif";
                $periodes = Periode::findOrFail($periodes);
                $devisi = Devisi::where('periode','=',$periodes->id)->get();
                return view('admin.alternatif.create',['title' => $title, 'periodes' => $periodes, 'devisi'=>$devisi]);
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
    public function store(Request $req, $periodes, $id = null)
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
            // cek apakah id user = 1
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            if (Auth::User()->id==1){
                $this->validate($req, [
                    'namaal' => 'required',
                ]);
                $devisi      =$req->devisi;
                $carinama = Alternatif::where('periode','=',$periodes)->where('nama','=',$req->namaal)->count();
                if ($carinama > 0) {
                    return redirect()->back()->with('warning','Data Nama Sudah Dipakai Pada alternatif lain pada periode ini!');
                }
                if (!preg_match("/^[a-zA-Z ]*$/",$req->namaal)) {
                    return redirect()->back()->with('warning','Data Nama Harus Berisi Huruf Saja!');
                  }
                $devisis = Devisi::where('periode','=',$periodes)->get();

                $alternatifg = new Alternatif;
                $alternatifg->kode = "A".$alternatifg->id;
                $alternatifg->periode = $periodes;
                $alternatifg->nama = $req->namaal;
                $alternatifg->save();

                $alternatifsew = Alternatif::findOrFail($alternatifg->id);
                DB::TABLE('alternatifs')->where('id','=',$alternatifg->id)->UPDATE(['kode'=> "A".$alternatifg->id]);
                 $alternatifsew->save();

                $alternatifg->altrank()->sync($devisi);
                foreach ($devisi as $keys => $values) {
                    DB::TABLE('ranks')->where('alternatif','=',$alternatifg->id)->where('devisi','=',$values)->UPDATE(['periode'=> $periodes]);
                }
                foreach ($devisi as $keys => $values) {
                    $kriteria = Kriteria::all()->WHERE('devisi','=',$values);
                    foreach ($kriteria as $key) {
                        $kriteriass2 = new Alternatifnb;
                        $kriteriass2->periode = $periodes;
                        $kriteriass2->alternatif = $alternatifg->id;
                        $kriteriass2->kriteria   = $key->id;
                        $kriteriass2->nilai   = 0;
                        $kriteriass2->save();
                    }
                }
                foreach ($devisis as $key => $valued) {
                    $updatestatsdevv = Devisi::findOrFail($valued->id);
                    $updatestatsdevv->status = "Tidak Konsisten";
                    $updatestatsdevv->save();
                }
                $ubahststus = DB::TABLE('periodes')->where('id','=',$periodes)->UPDATE(['status'=> 'Tidak Konsisten']);
                $status = "1 Data Alternatif baru telah diunggah.";
                return redirect()->back()->with('success', $status);
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
    public function show($periodes, string $id)
    {
        try
        {
            $periodes = Periode::findOrFail($periodes);
            $alternatif = Alternatif::findOrFail($id);
            $devisis = Devisi::where('periode','=',$periodes->id)->get();
            $params = [
                'title' => 'Ubah Data Alternatif',
                'periodes' => $periodes,
                'devisis' => $devisis,
                'alternatif' => $alternatif,
            ];
            return view('admin.alternatif.show',[$periodes, $alternatif])->with($params);
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
     * Show the form for editing the specified resource.
     */
    public function edit($periodes, string $id)
    {
        try
        {
            $periodes = Periode::findOrFail($periodes);
            $alternatif = Alternatif::findOrFail($id);
            $devisis = Devisi::where('periode','=',$periodes->id)->get();
            $params = [
                'title' => 'Ubah Data Alternatif',
                'periodes' => $periodes,
                'devisis' => $devisis,
                'alternatif' => $alternatif,
            ];
            return view('admin.alternatif.edit',[$periodes, $alternatif])->with($params);
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
    public function update(Request $request, $periodes, $id)
    {
        if (Auth::User()->id== 1){
            try
            {
                $this->validate($request, [
                    'nama' => 'required',
                ]);
                $carikode1 = 1;


                $alternatifse = Alternatif::findOrFail($id);
                $kode = $alternatifse->kode;
                $nama = $alternatifse->nama;


                $alternatifse->nama = $request->nama;
                $alternatifse->save();
                $cariko = Alternatif::all()->where('periode','=',$periodes)->where('kode','=',$request->kode)->count();
                $carikode1 = 1;
                if ($cariko > $carikode1) {
                    DB::TABLE('alternatifs')->where('id','=',$alternatifse->id)->UPDATE(['kode'=> $kode]);
                    return redirect()->back()->with('warning','Data Kode Sudah Dipakai Pada alternatif lain pada periode ini!');
                }
                $carina = Alternatif::all()->where('periode','=',$periodes)->where('nama','=',$request->nama)->count();
                if ($carina > $carikode1 ) {
                    DB::TABLE('alternatifs')->where('id','=',$alternatifse->id)->UPDATE(['nama'=> $nama]);
                    return redirect()->back()->with('warning','Data nama Sudah Dipakai Pada alternatif lain pada periode ini!');
                }





                $devisi      =$request->devisi;
                $alternatifse->altrank()->sync($devisi);
                foreach ($devisi as $key => $valued) {
                    $updatestatsdevv = Devisi::findOrFail($valued);
                    $updatestatsdevv->status = "Tidak Konsisten";
                    $updatestatsdevv->save();
                }
                $periodese = Periode::findOrFail($periodes);
                $periodese->status = "Tidak Konsisten";
                $periodese->save();
                return redirect()->route('alternatif.index',[$periodes])->with('success','Data Alternatif Berhasil di Ubah!');
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
            return redirect()->route('login')->with('danger', $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($periodes, string $id)
    {
        if (Auth::User()->id== 1){
            try
            {
                $admin = Alternatif::findOrFail($id);
                $hapusan = Alternatifnb::where('alternatif','=',$id)->get();
                foreach ($hapusan as $keyss => $valaue) {
                     $hcias = Alternatifnb::findOrFail($valaue->id);
                     $hcias->delete();
                }
                $hapusrank = Rank::where('alternatif','=',$id)->where('periode','=',$periodes)->get();
                foreach ($hapusrank as $keys => $valaues) {
                     $hranks = Rank::findOrFail($valaues->id);
                     $hranks->delete();
                }

                $admin->delete();
                $ubahststus = DB::TABLE('periodes')->where('id','=',$periodes)->UPDATE(['status'=> 'Tidak Konsisten']);
                return redirect()->route('alternatif.index',[$periodes])->with('success', "Alternatif <strong>$admin->kode - $admin->nama</strong> Berhasil dihapus dari semua tabel.");
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
            return redirect()->route('login')->with('danger', $status);
        }
    }
}