<?php
namespace App\Http\Controllers\Midel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth; 
use App\Models\User;  
use App\Models\Periode; 
use App\Models\Kriteria;   
use App\Models\Alternatif;  
use Illuminate\Support\Facades\DB;
class RasaAdminController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
	    if (Auth::User()->kategori === 'Admin')
		{
			$title = "Dashboard";
	        $jumlahadmin = User::all()->count();
	        $jumlahperiode = Periode::all()->count();
	        $jumlahkriteria = Kriteria::all()->count();
	        $jumlahalternatif = Alternatif::all()->count();
	        return view('home',['title' => $title, 'jumlahadmin'=>$jumlahadmin, 'jumlahkriteria'=>$jumlahkriteria, 'jumlahalternatif'=>$jumlahalternatif, 'jumlahperiode'=>$jumlahperiode]);
		} else
		{
            return redirect()->route('rasaadmin')->with('warning','Data tidak valid!');
        }
	}
}
