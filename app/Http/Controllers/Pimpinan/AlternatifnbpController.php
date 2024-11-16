<?php

namespace App\Http\Controllers\Pimpinan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Periode;
use App\Models\Devisi;
use App\Models\Nilai;
use App\Models\Kriteria;
use App\Models\Kriterianb;
use App\Models\Alternatif;
use App\Models\Alternatifnb;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class AlternatifnbpController extends Controller
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
            if (Auth::User()->kategori== 'Pimpinan' or Auth::User()->kategori== 'Admin'){
                //jika berhasi (user id =1)
                $title = 'Data Nilai Bobot Alternatif';
                $periodes = Periode::findOrFail($periodes);
                $devisisc = Devisi::where('nama','=', 'Cuci')->where('periode','=',$periodes->id)->first();
                $sdata = Kriteria::all()->where('devisi','=',$devisisc->id);
                $ddata = Kriterianb::all()->where('devisi','=',$devisisc->id);
                $tdata = Alternatif::all()->where('periode','=',$periodes->id);
                $edata = Alternatifnb::all()->where('devisi','=',$periodes->id);
                $heads = Kriteria::all()->where('devisi','=',$devisisc->id)->count();
                $rows = DB::table('alternatifnbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.kriteria')->leftJoin('alternatifs as a', 'a.id','=','rk.alternatif')->where ('k.devisi','=', $devisisc->id)->SELECT ('k.nama as nama', 'rk.alternatif as alternatif', 'rk.kriteria as kriteria', 'rk.nilai as nilai' )->ORDERBY('rk.id', 'asc')->get();
                $datas = array();
                foreach ($rows as $row) {
                    $datas[$row->alternatif][$row->kriteria] = $row->nilai;
                }



                $devisiss = Devisi::where('nama','=', 'Strika')->where('periode','=',$periodes->id)->first();
                      // dd($devisiss);
                      // die();
                $sdatas = Kriteria::all()->where('devisi','=',$devisiss->id);
                $ddatas = Kriterianb::all()->where('devisi','=',$devisiss->id);
                $tdatas = Alternatif::all()->where('periode','=',$periodes->id);
                $edatas = Alternatifnb::all()->where('periode','=',$periodes->id);
                $headss = Kriteria::all()->where('devisi','=',$devisiss->id)->count();
                $rowss = DB::table('alternatifnbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.kriteria')->leftJoin('alternatifs as a', 'a.id','=','rk.alternatif')->where ('k.devisi','=', $devisiss->id)->SELECT ('k.nama as nama', 'rk.alternatif as alternatif', 'rk.kriteria as kriteria', 'rk.nilai as nilai' )->ORDERBY('rk.id', 'asc')->get();
                $datass = array();
                foreach ($rowss as $row) {
                    $datass[$row->alternatif][$row->kriteria] = $row->nilai;
                }


                     $devisisp = Devisi::where('nama','=', 'Packing')->where('periode','=',$periodes->id)->first();

                    $sdatap = Kriteria::all()->where('devisi','=',$devisisp->id);
                    $ddatap = Kriterianb::all()->where('devisi','=',$devisisp->id);
                    $tdatap = Alternatif::all()->where('periode','=',$periodes->id);
                    $edatap = Alternatifnb::all()->where('periode','=',$periodes->id);
                    $rowsp = DB::table('alternatifnbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.kriteria')->leftJoin('alternatifs as a', 'a.id','=','rk.alternatif')->where ('k.devisi','=', $devisisp->id)->SELECT ('k.nama as nama', 'rk.alternatif as alternatif', 'rk.kriteria as kriteria', 'rk.nilai as nilai' )->ORDERBY('rk.id', 'asc')->get();
                    $datasp = array();
                    foreach ($rowsp as $row) {
                        $datasp[$row->alternatif][$row->kriteria] = $row->nilai;
                    }



                    // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php
                    return view('pimpinan.alternatifnb.index',['title' => $title,
                        'datas' => $datas,
                        'rows' => $rows,
                        'sdata' => $sdata,
                        'ddata' => $ddata,
                        'tdata' => $tdata,
                        'edata' => $edata,

                        'datass' => $datass,
                        'rowss' => $rowss,
                        'sdatas' => $sdatas,
                        'ddatas' => $ddatas,
                        'tdatas' => $tdatas,
                        'edatas' => $edatas,

                        'datasp' => $datasp,
                        'rowsp' => $rowsp,
                        'sdatap' => $sdatap,
                        'ddatap' => $ddatap,
                        'tdatap' => $tdatap,
                        'edatap' => $edatap,





                        'periodes'=>$periodes]);
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
    public function edit($periodes, string $key)
    {
        try
        {
          if(!Auth::User())
            {
                return redirect()->route('login')->with('warning','Data tidak valid!');
            }
            if (Auth::User()->kategori =='Pimpinan' or Auth::User()->kategori=='Admin'){
                //jika berhasi (user id =1)
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::WHERE('periode','=',$periodes->id);
                $alternatifnb = Alternatifnb::where('periode','=',$periodes->id)->where('alternatif','=',$key)->orderBy('id')->get();

                    $kriteriase = Kriteria::orderBy('devisi','desc')->get();
                    $nilaisa = Nilai::all();

                // dd($kriteriase);
                // die();


                $params = [
                    'title' => 'Ubah Data Nilai Bobot Alternatif',
                    'periodes' => $periodes,
                    'devisis' => $devisis,
                    'alternatifnb' => $alternatifnb,
                    'kriteriase' => $kriteriase,
                    'nilaisa' => $nilaisa,
                    'alternatif'  => ([$key]),
                    'key' =>$key,
                ];
                 return view('pimpinan.alternatifnb.edit',[$periodes, $key])->with($params);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $periodes, string $_POSTI)
    {
        if (Auth::User()->kategori== 'Pimpinan'){
            if(!$periodes){
                return redirect()->route('periodes.index')->with('warning','Data tidak valid!');
            }

            try
            {
                $ddl=[];
                foreach ($request->except('_token', '_method') as $key => $value) {
                    $ID = str_replace('ID-', '', $key);

                    Alternatifnb::where('id', $ID)->where('periode', $periodes)->update(['bobot' => $value, 'status' => "Baru"]);

                    $dataalter = Alternatifnb::where('id', $ID)->where('periode', $periodes)->first();
                    $datanilai = Nilai::where('kriteria','=',$dataalter->kriteria)->get();

                    $dds= [];
                    $ddl=[];
                    foreach ($datanilai as  $ker => $danilai){
                        $dds[]= $danilai->nilai1;
                        $ddl[]=$danilai->bobot;
                        // if ($value >= $danilai->nilai1 && $value <= $danilai->nilai2 )
                        if ($value >= $danilai->nilai1){
                            Alternatifnb::where('id', $ID)->where('periode', $periodes)->update(['nilai' => $danilai->bobot, 'status' => "Lama"]);
                        }
                        // if ($value <= 0){
                        //     Alternatifnb::where('id', $ID)->where('periode', $periodes)->update(['nilai' => 0, 'status' => "Awal"]);
                        // }

                    }
                    //         dd($dds);
                    // die();

                    // // dd($dataalter);
                    // // die();
                    // // dd($datanilai->toArray());
                    // // die();

                }
                // dd($ddl);
                //     die();

                return redirect()->route('alternatifnb.index',[$periodes])->with('info', "Data berhasil diubah.");

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
            $status = "Anda Bukan Super Admin!...";
            return redirect()->route('login')->with('warning', $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
