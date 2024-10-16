<?php

namespace App\Http\Controllers\Depan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Periode; 
use App\Models\Kriteria;  
use App\Models\Alternatif;  
use Illuminate\Support\Facades\DB; 
use Barryvdh\DomPDF\Facade\Pdf;

class DepanController extends Controller
{
    public function index()
    {
        $title     = 'Perankingan ';
        $periodeobj = Periode::where('status','=','Konsisten')->get(); 
        return view('depan.hitung.index',['title'=>$title, 'periodeobj'=>$periodeobj]);
    }
    public function show($periodes)
    {
        try
            {
                // cek apakah user sudah login atau belum
                 
                // cek apakah id user = 1 
                //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
                    //jika berhasi (user id =1) 
                    //maka akan membuat title dengan nama title = Data Profil'
                    $title = 'Data Ranking'; 
                    $juk = Kriteria::where('periode','=', $periodes)->count();
                    $jua = Alternatif::where('periode','=', $periodes)->count();     
                    //mengambil semua data yang ada di dalam table user'
                    $data = Alternatif::where('periode','=', $periodes)->orderBy('rank')->get();
                    $periodes = Periode::findOrFail($periodes);
                    $pdf = Pdf::loadView('depan.hitung.show', ['periodes'=>$periodes,'title' => $title, 'juk' => $juk,'jua' => $jua, 'data' => $data]);
                    return $pdf->download('Data Ranking.pdf');
                    // menampilkan halaman user yang lokasinya ada di profil/resource/view/admin/profil/index.blade.php  
                 
            }
        catch (ModelNotFoundException $ex) 
            {
                if ($ex instanceof ModelNotFoundException)
                {
                    return response()->view('errors.'.'404');
                }
            }   
    }
    public function rekapandep($periodes)
    {
        try
        {
            // cek apakah user sudah login atau belum
             
            // cek apakah id user = 1 
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            
                //jika berhasi (user id =1) 
                //maka akan membuat title dengan nama title = Data Profil'
                $title = 'Rekapan Data Ranking';  
                $jua = Alternatif::where('periode','=', $periodes)->count();     
                //mengambil semua data yang ada di dalam table user'
                $data = Alternatif::where('periode','=', $periodes)->withSum('alrank','total')->orderBy('alrank_sum_total','desc')->get();
                $periodes = Periode::findOrFail($periodes); 
                $pdf = Pdf::loadView('depan.hitung.edit', ['periodes'=>$periodes, 'title' => $title, 'jua' => $jua, 'data' => $data]);
                return $pdf->download('Data Rekap Ranking.pdf');
                // menampilkan halaman user yang lokasinya ada di profil/resource/view/admin/profil/index.blade.php  
             
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
