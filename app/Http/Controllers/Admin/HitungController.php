<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Periode; 
use App\Models\Devisi; 
use App\Models\Rank; 
use App\Models\Kriteria; 
use App\Models\Kriterianb; 
use App\Models\Alternatif; 
use App\Models\Alternatifnb;
use Illuminate\Support\Facades\DB; 
use Barryvdh\DomPDF\Facade\Pdf;
class HitungController extends Controller
{
    public function index($periodes)
    {
        // cek apakah user sudah login atau belum
        if(!Auth::User())
        {
            // jika tidak ada maka akan dikembalikan ke halaman login
            return redirect()->route('login')->with('warning','Data tidak valid!');
        }
        try
        {
            // cek apakah id user = 1 
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data hitung
            if (Auth::User()->kategori== 'Admin'){
                //jika berhasi (user id =1)  
                $title = 'Data Perhitungan';  
                //KITA GUNAKAN PRIODE SEBAGAI FILTER
                $periodes = Periode::findOrFail($periodes);
                $devisisc = Devisi::where('nama','=', 'Cuci')->where('periode','=',$periodes->id)->first();
                $devisiss = Devisi::where('nama','=', 'Strika')->where('periode','=',$periodes->id)->first();
                $devisisp = Devisi::where('nama','=', 'Packing')->where('periode','=',$periodes->id)->first();
                $data = Kriteria::where('devisi','=',$devisisc->id)->get();
                $datastrika = Kriteria::where('devisi','=',$devisiss->id)->get();
                $datapacking = Kriteria::where('devisi','=',$devisisp->id)->get();
                $datalat = Alternatif::where('periode','=',$periodes->id)->get();
                $datalatstrika = Alternatif::where('periode','=',$periodes->id)->get();
                $datalatpacking = Alternatif::where('periode','=',$periodes->id)->get();
                $rowss = Kriterianb::where('devisi','=',$devisisc->id)->get();
                $rowsstrika = Kriterianb::where('devisi','=',$devisiss->id)->get();
                $rowspacking = Kriterianb::where('devisi','=',$devisisp->id)->get();
                $datardff = Kriteria::where('devisi','=',$devisisc->id)->count();
                if ($datardff < 3) { 
                    return redirect()->route('kriteria.index',[$periodes->id, $devisisc->id])->with('warning','Silahkan Input Minimal 3 Kriteria pada Devisi Cuci!');
                }
                $datardffstrika = Kriteria::where('devisi','=',$devisiss->id)->count();
                if ($datardffstrika < 3) { 
                    return redirect()->route('kriteria.index',[$periodes->id, $devisiss->id])->with('warning','Silahkan Input Minimal 3 Kriteria pada Devisi Strika!');
                }
                $datardffpacking = Kriteria::where('devisi','=',$devisisp->id)->count();
                if ($datardffpacking < 3) { 
                    return redirect()->route('kriteria.index',[$periodes->id, $devisisp->id])->with('warning','Silahkan Input Minimal 3 Kriteria pada Devisi Packing!');
                }

                $datardssffc = Rank::all()->where('devisi','=',$devisisc->id)->where('periode','=',$periodes->id)->count();
                if ($datardssffc < 2) { 
                    return redirect()->route('alternatif.index',[$periodes->id])->with('warning','Silahkan Input Minimal 2 Alternatif pada devisi Cuci!');
                }
                $datardssffs = Rank::all()->where('devisi','=',$devisiss->id)->where('periode','=',$periodes->id)->count();
                if ($datardssffs < 2) { 
                    return redirect()->route('alternatif.index',[$periodes->id])->with('warning','Silahkan Input Minimal 2 Alternatif pada devisi Strika!');
                }
                $datardssffp = Rank::all()->where('devisi','=',$devisisp->id)->where('periode','=',$periodes->id)->count();
                if ($datardssffp < 2) { 
                    return redirect()->route('alternatif.index',[$periodes->id])->with('warning','Silahkan Input Minimal 2 Alternatif pada devisi Packing!');
                }
                $datassrdssffc = Alternatifnb::all()->where('periode','=',$periodes->id);
                foreach ($datassrdssffc as $key ) {
                    if ($key->nilai < 1) {
                        return redirect()->back()->with('warning','Silahkan atur Nilai Bobot Alternatif!');
                    }
                } 
                $datassrdssffs = Alternatifnb::all()->where('periode','=',$periodes->id);
                foreach ($datassrdssffs as $key ) {
                    if ($key->nilai < 1) {
                        return redirect()->back()->with('warning','Silahkan atur Nilai Bobot Alternatif!');
                    }
                } 
                $datassrdssffp = Alternatifnb::all()->where('periode','=',$periodes->id);
                foreach ($datassrdssffp as $key ) {
                    if ($key->nilai < 1) {
                        return redirect()->back()->with('warning','Silahkan atur Nilai Bobot Alternatif!');
                    }
                }
                // dd($datardff);
                // die();
                $analis = DB::table('alternatifnbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.kriteria')->where('k.devisi','=',$devisisc->id)->leftJoin('alternatifs as a', 'a.id','=','rk.alternatif')->SELECT ('k.nama as nama', 'rk.alternatif as alternatif', 'rk.kriteria as kriteria', 'rk.nilai as nilai' )->ORDERBY('rk.id', 'asc')->get();

                $hasilanalisis = [];
                foreach ($analis as $row) {
                    $hasilanalisis[$row->alternatif][$row->kriteria] = $row->nilai;
                }

                 $analisstrika = DB::table('alternatifnbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.kriteria')->where('k.devisi','=',$devisiss->id)->leftJoin('alternatifs as a', 'a.id','=','rk.alternatif')->SELECT ('k.nama as nama', 'rk.alternatif as alternatif', 'rk.kriteria as kriteria', 'rk.nilai as nilai' )->ORDERBY('rk.id', 'asc')->get();

                $hasilanalisisstrika = [];
                foreach ($analisstrika as $row) {
                    $hasilanalisisstrika[$row->alternatif][$row->kriteria] = $row->nilai;
                } 
                $analispacking = DB::table('alternatifnbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.kriteria')->where('k.devisi','=',$devisisp->id)->leftJoin('alternatifs as a', 'a.id','=','rk.alternatif')->SELECT ('k.nama as nama', 'rk.alternatif as alternatif', 'rk.kriteria as kriteria', 'rk.nilai as nilai' )->ORDERBY('rk.id', 'asc')->get();

                $hasilanalisispacking = [];
                foreach ($analispacking as $row) {
                    $hasilanalisispacking[$row->alternatif][$row->kriteria] = $row->nilai;
                }   
                // dd($analis);
                // die();    
                $nRI = array(
                    1 => 0,
                    2 => 0,
                    3 => 0.58,
                    4 => 0.9,
                    5 => 1.12,
                    6 => 1.24,
                    7 => 1.32,
                    8 => 1.41,
                    9 => 1.46,
                    10 => 1.49,
                    11 => 1.51,
                    12 => 1.48,
                    13 => 1.56,
                    14 => 1.57,
                    15 => 1.59
                );
                $rows = DB::table('kriterianbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.id1')->where('rk.devisi','=', $devisisc->id)->SELECT ('k.nama as nama', 'rk.id1 as id1','rk.id as id', 'rk.id2 as id2', 'rk.nilai as nilai' )->ORDERBY('id','asc')->get(); 
                $datas = []; 
                foreach ($rows as $row) {
                    $datas[$row->id1][$row->id2] = round($row->nilai, 3); 
                }
                $rowstrika = DB::table('kriterianbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.id1')->where('rk.devisi','=', $devisiss->id)->SELECT ('k.nama as nama', 'rk.id1 as id1','rk.id as id', 'rk.id2 as id2', 'rk.nilai as nilai' )->ORDERBY('id','asc')->get();
                $datasstrika = []; 
                foreach ($rowstrika as $row) {
                    $datasstrika[$row->id1][$row->id2] = round($row->nilai, 3); 
                } 
                $rowpacking = DB::table('kriterianbs as rk')->leftJoin('kriterias as k', 'k.id','=','rk.id1')->where('rk.devisi','=', $devisisp->id)->SELECT ('k.nama as nama', 'rk.id1 as id1','rk.id as id', 'rk.id2 as id2', 'rk.nilai as nilai' )->ORDERBY('id','asc')->get();               
                $dataspacking = []; 
                foreach ($rowpacking as $row) {
                    $dataspacking[$row->id1][$row->id2] = round($row->nilai, 3); 
                }

                $total = [];
                foreach ($datas as $key => $value) {
                    foreach ($value as $k => $v) {
                        $total[$k] = isset($total[$k]) ? ($total[$k] + $v) : $v;
                    }
                }
                $totalstrika = [];
                foreach ($datasstrika as $key => $value) {
                    foreach ($value as $k => $v) {
                        $totalstrika[$k] = isset($totalstrika[$k]) ? ($totalstrika[$k] + $v) : $v;
                    }
                }
                $totalpacking = [];
                foreach ($dataspacking as $key => $value) {
                    foreach ($value as $k => $v) {
                        $totalpacking[$k] = isset($totalpacking[$k]) ? ($totalpacking[$k] + $v) : $v;
                    }
                }

                $normal = [];  
                foreach ($datas as $key => $value) {
                    foreach ($value as $k => $v) {
                        $normal[$key][$k] = $datas[$key][$k] / $total[$k];         
                    }
                }
                $normalstrika = [];  
                foreach ($datasstrika as $key => $value) {
                    foreach ($value as $k => $v) {
                        $normalstrika[$key][$k] = $datasstrika[$key][$k] / $totalstrika[$k];
                    }
                }
                $normalpacking = [];  
                foreach ($dataspacking as $key => $value) {
                    foreach ($value as $k => $v) {
                        $normalpacking[$key][$k] = $dataspacking[$key][$k] / $totalpacking[$k];
                    }
                }

                $totalas = [];
                foreach ($normal as $key => $value) {
                    foreach ($value as $k => $v) {
                        $totalas[$k] = isset($totalas[$k]) ? ($totalas[$k] + $v) : $v;
                    }
                }
                $totalasstrika = [];
                foreach ($normalstrika as $key => $value) {
                    foreach ($value as $k => $v) {
                        $totalasstrika[$k] = isset($totalasstrika[$k]) ? ($totalasstrika[$k] + $v) : $v;
                    }
                }
                $totalaspacking = [];
                foreach ($normalpacking as $key => $value) {
                    foreach ($value as $k => $v) {
                        $totalaspacking[$k] = isset($totalaspacking[$k]) ? ($totalaspacking[$k] + $v) : $v;
                    }
                }

                $nilaikriteria=[];
                $rata = []; 
                foreach ($normal as $key => $value) {
                    $rata[$key] = array_sum($value) / count($value);
                    $nilaikriteria[$key] = array_sum($value);
                } 

                $nilaikriteriastrika=[];
                $ratastrika = []; 
                foreach ($normalstrika as $key => $value) {
                    $ratastrika[$key] = array_sum($value) / count($value);
                    $nilaikriteriastrika[$key] = array_sum($value);
                } 
                $nilaikriteriapacking=[];
                $ratapacking = []; 
                foreach ($normalpacking as $key => $value) {
                    $ratapacking[$key] = array_sum($value) / count($value);
                    $nilaikriteriapacking[$key] = array_sum($value);
                } 

                $totalbobot = (array_sum($rata)); 
                $totalbobotstrika = (array_sum($ratastrika)); 
                $totalbobotpacking = (array_sum($ratapacking)); 
                $totalnilai = (array_sum($nilaikriteria));
                $totalnilaistrika = (array_sum($nilaikriteriastrika));
                $totalnilaipacking = (array_sum($nilaikriteriapacking));
                
                $ahpmult = array();
                $ratamult = array_values($rata);
                foreach ($datas as $key => $value) {
                $no = 0;
                    foreach ($value as $k => $v) {
                        $ahpmult[$key] = isset($ahpmult[$key]) ? ($ahpmult[$key] + ($v * $ratamult[$no])) : $v * $ratamult[$no];
                        $no++;
                    }
                }
                $ahpmultstrika = array();
                $ratamultstrika = array_values($ratastrika);
                foreach ($datasstrika as $key => $value) {
                $no = 0;
                    foreach ($value as $k => $v) {
                        $ahpmultstrika[$key] = isset($ahpmultstrika[$key]) ? ($ahpmultstrika[$key] + ($v * $ratamultstrika[$no])) : $v * $ratamultstrika[$no];
                        $no++;
                    }
                }
                $ahpmultpacking = array();

                $ratamultpacking = array_values($ratapacking);
                foreach ($dataspacking as $key => $value) {
                $no = 0;
                    foreach ($value as $k => $v) {
                        $ahpmultpacking[$key] = isset($ahpmultpacking[$key]) ? ($ahpmultpacking[$key] + ($v * $ratamultpacking[$no])) : $v * $ratamultpacking[$no];
                        $no++;
                    }
                }

                $measure= [];
                $matriksd = $ahpmult;
                foreach ($matriksd as $key => $value) {
                    $measure[$key] = $value / $rata[$key];
                }

                $measurestrika= [];
                $matriksdstrika = $ahpmultstrika;
                foreach ($matriksdstrika as $key => $value) {
                    $measurestrika[$key] = $value / $ratastrika[$key];
                }

                $measurepacking= [];
                $matriksdpacking = $ahpmultpacking;
                foreach ($matriksdpacking as $key => $value) {
                $measurepacking[$key] = $value / $ratapacking[$key];
                }

                $CI = ((array_sum($measure) / count($measure)) - count($measure)) / (count($measure) - 1);
                $RI = $nRI[count($datas)];
                $CR = $CI / $RI;

                $CIstrika = ((array_sum($measurestrika) / count($measurestrika)) - count($measurestrika)) / (count($measurestrika) - 1);
                $RIstrika = $nRI[count($datasstrika)];
                $CRstrika = $CIstrika / $RIstrika;

                $CIpacking = ((array_sum($measurepacking) / count($measurepacking)) - count($measurepacking)) / (count($measurepacking) - 1);
                $RIpacking = $nRI[count($dataspacking)];
                $CRpacking = $CIpacking / $RIpacking;

                $statusperiode = "Tidak Konsisten";
                // dd($CRpacking);
                // dd($CRstrika);
                // dd($CR);
                // die();


                if ($CR > 0.10  or $CRstrika > 0.10 or $CRpacking > 0.10 ) {
                    $statusperiode = "Tidak Konsisten";
                }
                    else
                {
                    $statusperiode = "Konsisten";
                }
                $ubahststus = DB::TABLE('periodes')->where('id','=',$periodes->id)->UPDATE(['status'=> $statusperiode]);
                $alternatifbesar= [];
                $sssfr = DB::table('alternatifs')->where('periode','=', $periodes->id)->ORDERBY('id', 'asc')->get();
                foreach ($sssfr as $vbgfh ) {
                    $alternatifbesar[$vbgfh->id] = array('nama' => $vbgfh->nama  );                    
                }
                $alternatifbesarstrika= [];
                $sssfr = DB::table('alternatifs')->where('periode','=', $periodes->id)->ORDERBY('id', 'asc')->get();
                foreach ($sssfr as $vbgfh ) {
                    $alternatifbesarstrika[$vbgfh->id] = array('nama' => $vbgfh->nama  );                    
                }
                $alternatifbesarpacking= [];
                $sssfr = DB::table('alternatifs')->where('periode','=', $periodes->id)->ORDERBY('id', 'asc')->get();
                foreach ($sssfr as $vbgfh ) {
                    $alternatifbesarpacking[$vbgfh->id] = array('nama' => $vbgfh->nama  );                    
                }                
                $kriteriabesar= [];
                $rowkri = DB::table('kriterias')->where('devisi','=',$devisisc->id)->ORDERBY('id', 'asc')->get();
                foreach ($rowkri as $rowakl ) {
                    $kriteriabesar[$rowakl ->id] = array(
                        'nama' => $rowakl ->nama,
                        'atribut' => $rowakl ->atribut,
                        'bobot' => isset($rowakl ->bobot) ? $rowakl ->bobot : null
                    );
                }
                $kriteriabesarstrika= [];
                $rowkristrika = DB::table('kriterias')->where('devisi','=',$devisiss->id)->ORDERBY('id', 'asc')->get();
                foreach ($rowkristrika as $rowakl ) {
                    $kriteriabesarstrika[$rowakl ->id] = array(
                        'nama' => $rowakl ->nama,
                        'atribut' => $rowakl ->atribut,
                        'bobot' => isset($rowakl ->bobot) ? $rowakl ->bobot : null
                    );
                }

                $kriteriabesarpacking= [];
                $rowkripacking = DB::table('kriterias')->where('devisi','=',$devisisp->id)->ORDERBY('id', 'asc')->get();
                foreach ($rowkripacking as $rowakl ) {
                    $kriteriabesarpacking[$rowakl ->id] = array(
                        'nama' => $rowakl ->nama,
                        'atribut' => $rowakl ->atribut,
                        'bobot' => isset($rowakl ->bobot) ? $rowakl ->bobot : null
                    );
                }

                $topsisanalisis = DB::table('alternatifs as a')->leftJoin('alternatifnbs as ra', 'ra.alternatif','=','a.id')->leftJoin('kriterias as k', 'k.id','=','ra.kriteria')->where('k.devisi','=', $devisisc->id)->ORDERBY('ra.id', 'asc')->get();
                $topsisanalisisstrika = DB::table('alternatifs as a')->leftJoin('alternatifnbs as ra', 'ra.alternatif','=','a.id')->leftJoin('kriterias as k', 'k.id','=','ra.kriteria')->where('k.devisi','=', $devisiss->id)->ORDERBY('ra.id', 'asc')->get();
                $topsisanalisispacking = DB::table('alternatifs as a')->leftJoin('alternatifnbs as ra', 'ra.alternatif','=','a.id')->leftJoin('kriterias as k', 'k.id','=','ra.kriteria')->where('k.devisi','=', $devisisp->id)->ORDERBY('ra.id', 'asc')->get();

                $topsisanalisa = array();
                foreach ($topsisanalisis as $drow) {
                    $topsisanalisa[$drow->alternatif][$drow->kriteria] = $drow->nilai;
                }
                $topsisanalisastrika = array();
                foreach ($topsisanalisisstrika as $drow) {
                    $topsisanalisastrika[$drow->alternatif][$drow->kriteria] = $drow->nilai;
                }
                $topsisanalisapacking = array();
                foreach ($topsisanalisispacking as $drow) {
                    $topsisanalisapacking[$drow->alternatif][$drow->kriteria] = $drow->nilai;
                }
                $topsisnormal = [];
                $kuadrat = [];
                foreach ($topsisanalisa as $key => $value) {
                    foreach ($value as $k => $v) {
                        // $kuadrat[$k] += ($v * $v);
                        $kuadrat[$k] = isset($kuadrat[$k]) ? ($kuadrat[$k] + ($v * $v)) : ($v * $v);
                    }
                }
                foreach ($topsisanalisa as $key => $value) {
                    foreach ($value as $k => $v) {
                        $topsisnormal[$key][$k] = $v / sqrt($kuadrat[$k]);
                    }
                }
                $topsisnormalstrika = [];
                $kuadratstrika = [];
                foreach ($topsisanalisastrika as $key => $value) {
                    foreach ($value as $k => $v) {
                        // $kuadrat[$k] += ($v * $v);
                        $kuadratstrika[$k] = isset($kuadratstrika[$k]) ? ($kuadratstrika[$k] + ($v * $v)) : ($v * $v);
                    }
                }
                foreach ($topsisanalisastrika as $key => $value) {
                    foreach ($value as $k => $v) {
                        $topsisnormalstrika[$key][$k] = $v / sqrt($kuadratstrika[$k]);
                    }
                }
                $topsisnormalpacking = [];
                $kuadratpacking = [];
                foreach ($topsisanalisapacking as $key => $value) {
                    foreach ($value as $k => $v) {
                        // $kuadrat[$k] += ($v * $v);
                        $kuadratpacking[$k] = isset($kuadratpacking[$k]) ? ($kuadratpacking[$k] + ($v * $v)) : ($v * $v);
                    }
                }
                foreach ($topsisanalisapacking as $key => $value) {
                    foreach ($value as $k => $v) {
                        $topsisnormalpacking[$key][$k] = $v / sqrt($kuadratpacking[$k]);
                    }
                }
                $normalterbobot = [];
                foreach ($topsisnormal as $key => $value) {
                    foreach ($value as $k => $v) {
                        $normalterbobot[$key][$k] = $v * $rata[$k];
                    }
                }
                $idedata = [];
                $temp = array();
                foreach ($normalterbobot as $key => $value) {
                    foreach ($value as $k => $v) {
                        $temp[$k][] = $v;
                    }
                }
                foreach ($temp as $key => $value) {
                    $max = max($value);
                    $min = min($value);
                    if ($kriteriabesar[$key]['atribut'] == 'Benefit') {
                        $idedata['Positif'][$key] = $max;
                        $idedata['Negatif'][$key] = $min;
                    } else {
                        $idedata['Positif'][$key] = $min;
                        $idedata['Negatif'][$key] = $max;
                    }
                    // dd($min);
                    // die();
                }  
                $normalterbobotstrika = [];
                foreach ($topsisnormalstrika as $key => $value) {
                    foreach ($value as $k => $v) {
                        $normalterbobotstrika[$key][$k] = $v * $ratastrika[$k];
                    }
                }
                $idedatastrika = [];
                $tempstrika = array();
                foreach ($normalterbobotstrika as $key => $value) {
                    foreach ($value as $k => $v) {
                        $tempstrika[$k][] = $v;
                    }
                }
                foreach ($tempstrika as $key => $value) {
                    $max = max($value);
                    $min = min($value);
                    if ($kriteriabesarstrika[$key]['atribut'] == 'Benefit') {
                        $idedatastrika['Positif'][$key] = $max;
                        $idedatastrika['Negatif'][$key] = $min;
                    } else {
                        $idedatastrika['Positif'][$key] = $min;
                        $idedatastrika['Negatif'][$key] = $max;
                     
                    }
                }
                $normalterbobotpacking = [];
                foreach ($topsisnormalpacking as $key => $value) {
                    foreach ($value as $k => $v) {
                        $normalterbobotpacking[$key][$k] = $v * $ratapacking[$k];
                    }
                }
                $idedatapacking = [];
                $temppacking = array();
                foreach ($normalterbobotpacking as $key => $value) {
                    foreach ($value as $k => $v) {
                        $temppacking[$k][] = $v;
                    }
                }
                foreach ($temppacking as $key => $value) {
                    $max = max($value);
                    $min = min($value);
                    if ($kriteriabesarpacking[$key]['atribut'] == 'Benefit') {
                        $idedatapacking['Positif'][$key] = $max;
                        $idedatapacking['Negatif'][$key] = $min;
                    } else {
                        $idedatapacking['Positif'][$key] = $min;
                        $idedatapacking['Negatif'][$key] = $max;
                     
                    }
                }  
                $jarak = [];
                $ideall = $idedata;
                foreach ($normalterbobot as $key => $value) {
                    foreach ($value as $k => $v) { 
                        $jarak[$key]['Positif'] = isset($jarak[$key]['Positif']) ? ($jarak[$key]['Positif'] + pow(($v - $idedata['Positif'][$k]), 2)) : pow(($v - $idedata['Positif'][$k]), 2);
                        $jarak[$key]['Negatif'] = isset($jarak[$key]['Negatif']) ? ($jarak[$key]['Negatif'] + pow(($v - $idedata['Negatif'][$k]), 2)) : pow(($v - $idedata['Negatif'][$k]), 2);
                    }
                    $jarak[$key]['Positif'] = sqrt($jarak[$key]['Positif']);
                    $jarak[$key]['Negatif'] = sqrt($jarak[$key]['Negatif']);
                } 
                $jarakstrika = [];
                $ideallstrika = $idedatastrika;
                foreach ($normalterbobotstrika as $key => $value) {
                    foreach ($value as $k => $v) { 
                        $jarakstrika[$key]['Positif'] = isset($jarakstrika[$key]['Positif']) ? ($jarakstrika[$key]['Positif'] + pow(($v - $idedatastrika['Positif'][$k]), 2)) : pow(($v - $idedatastrika['Positif'][$k]), 2);
                        $jarakstrika[$key]['Negatif'] = isset($jarakstrika[$key]['Negatif']) ? ($jarakstrika[$key]['Negatif'] + pow(($v - $idedatastrika['Negatif'][$k]), 2)) : pow(($v - $idedatastrika['Negatif'][$k]), 2);
                    }
                    $jarakstrika[$key]['Positif'] = sqrt($jarakstrika[$key]['Positif']);
                    $jarakstrika[$key]['Negatif'] = sqrt($jarakstrika[$key]['Negatif']);
                }
                $jarakpacking = [];
                $ideallpacking = $idedatapacking;
                foreach ($normalterbobotpacking as $key => $value) {
                    foreach ($value as $k => $v) { 
                        $jarakpacking[$key]['Positif'] = isset($jarakpacking[$key]['Positif']) ? ($jarakpacking[$key]['Positif'] + pow(($v - $idedatapacking['Positif'][$k]), 2)) : pow(($v - $idedatapacking['Positif'][$k]), 2);
                        $jarakpacking[$key]['Negatif'] = isset($jarakpacking[$key]['Negatif']) ? ($jarakpacking[$key]['Negatif'] + pow(($v - $idedatapacking['Negatif'][$k]), 2)) : pow(($v - $idedatapacking['Negatif'][$k]), 2);
                    }
                    $jarakpacking[$key]['Positif'] = sqrt($jarakpacking[$key]['Positif']);
                    $jarakpacking[$key]['Negatif'] = sqrt($jarakpacking[$key]['Negatif']);
                }

                $pref = [];
                foreach ($jarak as $key => $value) {
                    $pref[$key] = round($value['Negatif'] / ($value['Positif'] + $value['Negatif']), 5);
                }
                $rtdata =  $pref;
                arsort($rtdata);
                $no = 1;
                $ranks = [];
                foreach ($rtdata as $key => $value) {
                   $ranks[$key] = $no++;
                }

                $prefstrika = [];
                foreach ($jarakstrika as $key => $value) {
                    $prefstrika[$key] = round($value['Negatif'] / ($value['Positif'] + $value['Negatif']), 5);
                }
                $rtdatastrika =  $prefstrika;
                arsort($rtdatastrika);
                $no = 1;
                $ranksstrika = [];
                foreach ($rtdatastrika as $key => $value) {
                   $ranksstrika[$key] = $no++;
                }
                $prefpacking = [];
                foreach ($jarakpacking as $key => $value) {
                    $prefpacking[$key] = round($value['Negatif'] / ($value['Positif'] + $value['Negatif']), 5);
                }
                $rtdatapacking =  $prefpacking;
                arsort($rtdatapacking);
                $no = 1;
                $rankspacking = [];
                foreach ($rtdatapacking as $key => $value) {
                   $rankspacking[$key] = $no++;
                } 
                foreach ($topsisnormal as $key => $value) { 
                    if ($CR > 0.10) {
                        DB::TABLE('ranks')->where('alternatif','=',$key)->where('devisi','=',$devisisc->id)->where('periode','=',$periodes->id)->UPDATE(['total'=> 0]);
                        DB::TABLE('devisis')->where('periode','=',$periodes->id)->where('id','=',$devisisc->id)->UPDATE(['status'=> "Tidak Konsisten"]);
                    } else {
                        DB::TABLE('ranks')->where('alternatif','=',$key)->where('devisi','=',$devisisc->id)->where('periode','=',$periodes->id)->UPDATE(['total'=> $pref[$key]]);
                        DB::TABLE('devisis')->where('periode','=',$periodes->id)->where('id','=',$devisisc->id)->UPDATE(['status'=> "Konsisten"]);
                    }
                }
                foreach ($topsisnormalstrika as $key => $value) { 
                    if ($CRstrika > 0.10) {
                        DB::TABLE('ranks')->where('alternatif','=',$key)->where('devisi','=',$devisiss->id)->where('periode','=',$periodes->id)->UPDATE(['total'=> 0]);
                        DB::TABLE('devisis')->where('periode','=',$periodes->id)->where('is','=',$devisiss->id)->UPDATE(['status'=> "Tidak Konsisten"]);
                    } else {
                        DB::TABLE('ranks')->where('alternatif','=',$key)->where('devisi','=',$devisiss->id)->where('periode','=',$periodes->id)->UPDATE(['total'=> $prefstrika[$key]]);
                        DB::TABLE('devisis')->where('periode','=',$periodes->id)->where('id','=',$devisiss->id)->UPDATE(['status'=> "Konsisten"]);
                    }
                }
                foreach ($topsisnormalpacking as $key => $value) { 
                    if ($CRpacking > 0.10) {
                        DB::TABLE('ranks')->where('alternatif','=',$key)->where('devisi','=',$devisisp->id)->where('periode','=',$periodes->id)->UPDATE(['total'=> 0]);
                        DB::TABLE('devisis')->where('periode','=',$periodes->id)->where('id','=',"Packing")->UPDATE(['status'=> "Tidak Konsisten"]);
                    } else {
                        DB::TABLE('ranks')->where('alternatif','=',$key)->where('devisi','=',$devisisp->id)->where('periode','=',$periodes->id)->UPDATE(['total'=> $prefpacking[$key]]);
                        DB::TABLE('devisis')->where('periode','=',$periodes->id)->where('id','=',$devisisp->id)->UPDATE(['status'=> "Konsisten"]);
                    }
                }
                $datalats = Rank::where('devisi','=',$devisisc->id)->where('periode','=',$periodes->id)->orderBy('total','desc')->get();
                $datalatsstrika = Rank::where('devisi','=',$devisiss->id)->where('periode','=',$periodes->id)->orderBy('total','desc')->get(); 
                $datalatspacking = Rank::where('devisi','=',$devisisp->id)->where('periode','=',$periodes->id)->orderBy('total','desc')->get();  
                $totalis = Alternatif::where('periode','=', $periodes->id)->withSum('alrank','total')->orderBy('alrank_sum_total','desc')->get();
 
                return view('admin.hitung.index',['title' => $title, 'data' => $data, 'datalat' => $datalat, 'rowss' => $rowss, 'periodes'=>$periodes, 'hasilanalisis' => $hasilanalisis, 'nRI'=>$nRI, 'datas' => $datas, 'total' =>$total, 'totalbobot' =>$totalbobot, 'totalas' =>$totalas, 'normal' => $normal, 'nilaikriteria' => $nilaikriteria,'rata'=>$rata, 'totalnilai'=>$totalnilai, 'measure'=>$measure, 'alternatifbesar'=>$alternatifbesar, 'alternatifbesarstrika'=>$alternatifbesarstrika, 'alternatifbesarpacking'=>$alternatifbesarpacking, 'kriteriabesar'=>$kriteriabesar, 'topsisanalisa'=>$topsisanalisa, 'topsisnormal'=>$topsisnormal, 'normalterbobot'=>$normalterbobot, 'idedata'=>$idedata, 'jarak'=>$jarak, 'pref'=>$pref, 'ranks'=>$ranks,'datalats'=>$datalats, 'datastrika' =>$datastrika,'datasstrika' =>$datasstrika, 'totalstrika'=>$totalstrika, 'normalstrika'=>$normalstrika, 'totalasstrika'=>$totalasstrika, 'nilaikriteriastrika'=>$nilaikriteriastrika, 'ratastrika'=>$ratastrika, 'totalbobotstrika'=>$totalbobotstrika, 'totalnilaistrika'=>$totalnilaistrika, 'ahpmultstrika'=>$ahpmultstrika, 'measurestrika'=>$measurestrika, 'hasilanalisisstrika'=>$hasilanalisisstrika, 'datalatstrika'=>$datalatstrika, 'datalatsstrika'=>$datalatsstrika, 'topsisnormalstrika'=>$topsisnormalstrika, 'normalterbobotstrika'=>$normalterbobotstrika, 'idedatastrika'=>$idedatastrika, 'jarakstrika'=>$jarakstrika, 'prefstrika'=>$prefstrika, 'ranksstrika'=>$ranksstrika, 'datapacking' =>$datapacking,'dataspacking' =>$dataspacking, 'totalpacking'=>$totalpacking, 'normalpacking'=>$normalpacking, 'totalaspacking'=>$totalaspacking, 'nilaikriteriapacking'=>$nilaikriteriapacking, 'ratapacking'=>$ratapacking, 'totalbobotpacking'=>$totalbobotpacking, 'totalnilaipacking'=>$totalnilaipacking, 'ahpmultpacking'=>$ahpmultpacking, 'measurepacking'=>$measurepacking, 'hasilanalisispacking'=>$hasilanalisispacking, 'datalatpacking'=>$datalatpacking, 'datalatspacking'=>$datalatspacking, 'topsisnormalpacking'=>$topsisnormalpacking, 'normalterbobotpacking'=>$normalterbobotpacking, 'idedatapacking'=>$idedatapacking, 'jarakpacking'=>$jarakpacking, 'prefpacking'=>$prefpacking, 'rankspacking'=>$rankspacking,  'totalis'=>$totalis, 'statusperiode'=>$statusperiode]); 
            }
            else{
                return redirect()->route('login')->with('status','Data tidak valid!');
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
    public function show($periodes, $devisis)
    {
        try
        {
            // cek apakah user sudah login atau belum
            if(!Auth::User())
            {
                // jika tidak ada maka akan dikembalikan ke halaman login 
                $status = "Data tidak valid profil c!...";
                return redirect()->route('login')->with('warning', $status);
            }
            // cek apakah id user = 1 
            //artinya hanya user dengan id = 1 saja yang bisa mengakses data profil
            if (Auth::User()->kategori== 'Admin'){ 
                //jika berhasi (user id =1) 
                //maka akan membuat title dengan nama title = Data Profil'
                $periodes = Periode::findOrFail($periodes); 
                $devisis = Devisi::where('nama','=', $devisis)->where('periode','=',$periodes->id)->first();
                $title = 'Data Ranking '.$devisis->nama; 
                $juk = Kriteria::where('devisi','=', $devisis->id)->count();
                $jua = Alternatif::where('periode','=', $periodes)->count();     
                //mengambil semua data yang ada di dalam table user'
                
                $data = Rank::where('devisi','=', $devisis->id)->where('periode','=', $periodes->id)->orderBy('total','desc')->get(); 
                // dd($data);
                // die();
                $pdf = Pdf::loadView('admin.hitung.show', ['periodes'=>$periodes, 'title' => $title, 'juk' => $juk,'jua' => $jua, 'data' => $data, 'devisis'=>$devisis]);
                return $pdf->download('Data Ranking.pdf');
                // menampilkan halaman user yang lokasinya ada di profil/resource/view/admin/profil/index.blade.php  
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
    public function rekapansx($periodes)
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
            if (Auth::User()->kategori== 'Admin'){ 
                //jika berhasi (user id =1) 
                //maka akan membuat title dengan nama title = Data Profil'
                $title = 'Rekapan Data Ranking';  
                $jua = Alternatif::where('periode','=', $periodes)->count();     
                //mengambil semua data yang ada di dalam table user'
                $data = Alternatif::where('periode','=', $periodes)->withSum('alrank','total')->orderBy('alrank_sum_total','desc')->get();
                $periodes = Periode::findOrFail($periodes); 
                $pdf = Pdf::loadView('admin.hitung.edit', ['periodes'=>$periodes, 'title' => $title, 'jua' => $jua, 'data' => $data]);
                return $pdf->download('Data Rekap Ranking.pdf');
                // menampilkan halaman user yang lokasinya ada di profil/resource/view/admin/profil/index.blade.php  
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
}
