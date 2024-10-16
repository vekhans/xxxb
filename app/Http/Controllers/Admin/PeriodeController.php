<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User; 
use App\Models\Periode;
use App\Models\Devisi;
use App\Models\Kriteria; 
use App\Models\Alternatif;
use App\Models\Alternatifnb;
use App\Models\Kriterianb; 
use Illuminate\Support\Facades\DB;
class PeriodeController extends Controller
{
    /**
     * Display isting of the resource.
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
                $title = 'Data Periode'; 
                //mengambil semua data yang ada di dalam table user'
                $data = Periode::all();
                // menampilkan halaman user yang lokasinya ada di profil/resource/view/admin/profil/index.blade.php 
                return view('admin.periode.index',['title' => $title, 'data' => $data]);
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
                $title = "Tambah data Periode"; 
                // mengambil semua data yang ada di dalam table jenis_beritas'
                //$trimas = User::where('aturan','=','kuning')->get();    
                return view('admin.periode.create',['title' => $title]);
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
    public function store(Request $req)
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
                    'tahun' => 'required|numeric',
                    'keterangan' => 'required',                     
                ]);
                //jika berhasi (user id =1) 
                $title = "Tambah data Periode";  
                $periode = new Periode;
                $periode->nama   = $req->nama;
                $periode->tahun     = $req->tahun;
                $periode->keterangan    = $req->keterangan;
                $periode->save();

                $devisic = New Devisi;
                $devisic->nama   = "Cuci";
                $devisic->periode   = $periode->id;
                $devisic->save();
                $devisis = New Devisi;
                $devisis->nama   = "Strika";
                $devisis->periode   = $periode->id;
                $devisis->save();
                $devisip = New Devisi;
                $devisip->nama   = "Packing";
                $devisip->periode   = $periode->id;
                $devisip->save();
                $status = "1 Data Periode baru telah diunggah.";
                return redirect()->route('periode.index')->with('success', $status);
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
    public function edit(string $id)
    {
        if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login 
                $status = "Data tidak valid!...";
                return redirect()->route('login')->with('warning', $status);
            }
        if (Auth::User()->id== 1){
            try
            {
                $periodes = Periode::findOrFail($id);
                 
                $params = [
                    'title' => 'Ubah Data Periode',
                    'periodes' => $periodes,
                     
                ];
                return view('admin.periode.edit')->with($params);
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
            $status = "Anda Tidak Punyak Hak Akses!...";
                return redirect()->route('login')->with('warning', $status);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) 
    {
        if (Auth::User()->id== '1'){
             
            try
            {
                $this->validate($request, [
                    // 'tahun' => 'required|unique:periodes',
                    // 'nama' => 'required|max:100|unique:periodes',
                    // 'keterangan' => 'required',
                    'tahun' => 'required',
                    'nama' => 'required',
                    'keterangan' => 'required',
                ]); 
                $periodes = Periode::findOrFail($id);
                $periodes->tahun = $request->tahun;
                $periodes->nama = $request->nama;
                $periodes->keterangan = $request->keterangan;
                $periodes->save();
                 return redirect()->route('periode.index')->with('success','Data Periode Berhasil di Ubah!');
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
            return redirect()->route('home')->with('warning', $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::User()->id== 1){
            try
            {
                $admin = Periode::findOrFail($id);              
                $hapusan = Alternatifnb::where('periode','=',$id)->get();
                foreach ($hapusan as $keyss3 => $valaue3) {
                     $hcvvias = Alternatifnb::findOrFail($valaue3->id);
                     $hcvvias->delete(); 
                }
                $hapussan = Devisi::where('periode','=',$id)->get();
                foreach ($hapussan as $keyss4 => $valaue4) {
                     $hcxshiaus = Devisi::findOrFail($valaue4->id);
                     $hcxshiaus->delete(); 
                }
                 $lapusan = Alternatif::where('periode','=',$id)->get();
                foreach ($lapusan as $keyss => $valaue) {
                     $hcias = Alternatif::findOrFail($valaue->id);
                     $hcias->delete(); 
                }
                
                $admin->delete();
                return redirect()->route('periode.index')->with('success', "Periode <strong>$admin->Tahun - $admin->nama</strong> Berhasil dihapus dari semua tabel.");
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
            return view('layouts.temp.hak');
        }
    }
}
