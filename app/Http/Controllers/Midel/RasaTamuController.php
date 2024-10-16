<?php
namespace App\Http\Controllers\Midel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Auth; 
use App\Models\User;  
class RasaTamuController extends Controller
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
	    if (Auth::User()->kategori == 'Tamu')
		{
			$title = "Dashboard";
	        $pesantamu = "Silahkan Hubungi Admin Untuk mendapatkan Akses Lebih"; 
	        return view('thome',['title' => $title, 'pesantamu'=>$pesantamu]);
		} else
		{
            return redirect()->route('rasatamu')->with('warning','Data tidak valid!');
        }
	}
    //
}
