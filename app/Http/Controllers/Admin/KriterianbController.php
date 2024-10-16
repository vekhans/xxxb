<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth; 
use App\Models\User; 
use App\Models\Periode;
use App\Models\Devisi; 
use App\Models\Kriteria; 
use App\Models\Kriterianb; 
use Illuminate\Support\Facades\DB;
class KriterianbController extends Controller
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
                $title = 'Data Nilai Bobot Kriteria';   
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);
                $id2s = Kriteria::where('devisi','=',$devisis->id)->orderBy('id','desc')->get(); 
                $rows = DB::table('kriterianbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.id1')->where('rk.devisi','=', $devisis->id)->where('rk.devisi','=',$devisis->id)->SELECT ('k.nama as nama', 'rk.id1 as id1', 'rk.id2 as id2', 'rk.nilai as nilai' )->ORDERBY('id1', 'asc')->ORDERBY('id2', 'asc')->get();
                $datas = array();  
                foreach ($rows as $row) {
                    $datas[$row->id1][$row->id2] = $row->nilai; 
                } 
                $datas = array(); 
                foreach ($rows as $row) {
                    $datas[$row->id1][$row->id2] = round($row->nilai, 3); 
                }             
                $total = array();
                foreach ($datas as $key => $value) {
                    foreach ($value as $k => $v) {
                        $total[$k] = isset($total[$k]) ? ($total[$k] + $v) : $v;
                    }
                }
                $params = [
                    'title' => 'Ubah Data Nilai Bobot Kriteria',
                    'periodes' => $periodes,
                    'devisis' => $devisis, 
                    'rows' => $rows,
                    'datas' => $datas,      
                    'id2s'  => $id2s,
                    'nilai' => (['1' => '1. Sama penting dengan',
                        '2' => '2. Mendekati sedikit lebih penting dari',
                        '3' => '3. Sedikit lebih penting dari',
                        '4' => '4. Mendekati lebih penting dari',
                        '5' => '5. Lebih penting dari',
                        '6' => '6. Mendekati sangat penting dari',
                        '7' => '7. Sangat penting dari',
                        '8' => '8. Mendekati mutlak dari',
                        '9' => '9. Mutlak sangat penting dari',]),
                   'datas' =>$datas, 
                ];
                // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php 
                return view('admin.kriterianb.index',['title' => $title,'periodes'=>$periodes,'devisis'=>$devisis])->with($params);
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
    public function edit($periodes, $devisis,string $key)
    { 
        try
        {
          if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login
                return redirect()->route('login')->with('warning','Data tidak valid!');
            }
            // cek apakah id user = 1 
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            if (Auth::User()->id==1){
                //jika berhasi (user id =1)  
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);
                $kriterianb = Kriterianb::where('id1','=',$key)->where('devisi','=',$devisis->id)->get();

                $id2s = Kriteria::where('devisi','=',$devisis->id)->orderBy('id','asc')->get();
                $rows = DB::table('kriterianbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.id1')->where ('rk.devisi','=', $devisis->id)->SELECT ('k.nama as nama', 'rk.id1 as id1', 'rk.id2 as id2', 'rk.nilai as nilai' )->ORDERBY('k.id', 'asc')->get(); 
                $datas = array();  
                foreach ($rows as $row) {
                    $datas[$row->id1][$row->id2] = $row->nilai; 
                } 
 
                $params = [
                    'title' => 'Ubah Data Penerima',
                    'periodes' => $periodes,
                    'devisis' => $devisis,
                    'kriterianb' => $kriterianb, 
                    'datas' => $datas,                  
                    'id1'  => $id2s,
                    'id2s'  => $id2s,
                    'nilai' => (['1' => '1. Sama penting dengan',
                        '2' => '2. Mendekati sedikit lebih penting dari',
                        '3' => '3. Sedikit lebih penting dari',
                        '4' => '4. Mendekati lebih penting dari',
                        '5' => '5. Lebih penting dari',
                        '6' => '6. Mendekati sangat penting dari',
                        '7' => '7. Sangat penting dari',
                        '8' => '8. Mendekati mutlak dari',
                        '9' => '9. Mutlak sangat penting dari',]),
                   'key' =>$key, 
                ];
                 return view('admin.kriterianb.edit',[$periodes, $devisis, $key])->with($params);
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
    public function update(Request $request,$periodes, $devisis, string $id = null)
    {
        if (Auth::User()->id== '1'){
            if(!$periodes)
            {
                return redirect()->route('periode.index')->with('warning','Data tidak valid!');
            }
            if(!$devisis)
            {
                return redirect()->route('devisi.index',[$periodes])->with('warning','Data tidak valid!');
            }
            try
            {
                $this->validate($request, [
                    'id1' => 'required',
                    'nilai' => 'required',
                    'id2' => 'required',
                ]);
                $periodes = Periode::findOrFail($periodes);
                $devisis = Devisi::findOrFail($devisis);
                $id11 = $request->input('id1');
                $id12 = $request->input('id2');
                if ($id11 == $id12 ) {
                    return redirect()->route('kriterianb.index',[$periodes->id, $devisis->id])->with('warning', "Data kriteria yang sama Bobot tetap bernilai 1.");
                }
                if ($request->input('nilai') == '1. Sama penting dengan') {
                    $nilai3 = 1;
                }
                        if ($request->input('nilai') == '2. Mendekati sedikit lebih penting dari') {
                    $nilai3 = 2;
                } 
                if ($request->input('nilai') == '3. Sedikit lebih penting dari') {
                    $nilai3 = 3;
                }
                if ($request->input('nilai') == '4. Mendekati lebih penting dari') {
                    $nilai3 = 4;
                }
                if ($request->input('nilai') == '5. Lebih penting dari') {
                    $nilai3 = 5;
                }
                if ($request->input('nilai') == '6. Mendekati sangat penting dari') {
                    $nilai3 = 6;
                }
                if ($request->input('nilai') == '7. Sangat penting dari') {
                    $nilai3 = 7;
                }
                if ($request->input('nilai') == '8. Mendekati mutlak dari') {
                    $nilai3 = 8;
                }
                if ($request->input('nilai') == '9. Mutlak sangat penting dari') {
                    $nilai3 = 9;
                } 
                $nilai2 = 1/$nilai3;
                $kriterianbsss = Kriterianb::where('id1','=',$id11)->where('id2','=',$id12)->where('devisi','=',$devisis->id)->SELECT('kriterianbs.*')->get();
                foreach ($kriterianbsss as $keys => $value) {
                     $value->nilai = $nilai3;
                     $cucias = Kriterianb::findOrFail($value->id);
                     $cucias->nilai=$nilai3;
                     $cucias->save();
                 }
                 $kriterianabsss = Kriterianb::where('id1','=',$id12)->where('id2','=',$id11)->where('devisi','=',$devisis->id)->SELECT('kriterianbs.*')->get();
                foreach ($kriterianabsss as $keyss => $valaue) {
                     $valaue->nilai = round($nilai2,3);
                     $cias = Kriterianb::findOrFail($valaue->id);
                     $cias->nilai= round($nilai2,3);
                     $cias->save();
                 }
                 $ubahststusp = DB::TABLE('devisis')->where('id','=',$devisis->id)->UPDATE(['status'=> 'Tidak Konsisten']);
                 $ubahststusp = DB::TABLE('periodes')->where('id','=',$periodes->id)->UPDATE(['status'=> 'Tidak Konsisten']);
                 return redirect()->route('kriterianb.index',[$periodes->id, $devisis->id])->with('info', "Data berhasil diubah.");
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
