<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\User; 

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
            if (Auth::User()->kategori=== 'Admin'){
                //jika berhasi (user id =1)  
                $title = 'Data Admin';  
                $data = User::all(); 
                 
                // menampilkan halaman slide yang lokasinya ada di profil/resource/view/admin/berita/index.blade.php 
                return view('admin.admin.home',['title' => $title, 'data' => $data]);
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
        if (Auth::User()->kategori== "Admin"){
            $admin = User::all();
            $params = [
                'title' => 'Tambah Data Admin', 
                'gender'  => (['Perempuan','Laki-laki']),
            ];
            return view('admin.admin.create')->with($params);
            }
        else{
            return redirect()->route('login')->with('warning','Data tidak valid!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        if (Auth::User()->kategori== "Admin"){
            $this->validate($req, [
                'name' => 'required|max:100|unique:users',
                'email'    => 'required|email|unique:users,email|max:100',
                'password' => 'required|min:5|confirmed', 
                'file'   => 'file'.('|image|max:2048'), 
                'lengkap' => 'required|max:100|unique:users',
                'alamat'   => 'required', 
                'gender'  => 'required',
                'telepon'   => 'required', 
            ]);             
            $admin = new User;
            $admin->name = $req->name;
            $admin->email = $req->email;
            $admin->password = bcrypt($req->password);
            $admin->alamat = $req->alamat;
            $admin->telepon = $req->telepon;
            $admin->gender = $req->gender;
            $admin->lengkap = $req->lengkap;
            if ($req->hasFile('file')) {
                    $dir = '/public/admin/';
                    $deir = '/storage/admin/';
                    if(!file_exists($dir)){
                        mkdir($dir, 0777, true);
                    }
                    // Upload
                    $file       = $req->file('file');
                    $filenamaa   = 'a'.uniqid().'.';
                    $extension  = $file->getClientOriginalExtension();
                    $fiker      = $filenamaa.$extension;
                    $path       = $req->file('file')->storeAs($dir,$fiker);
                     
                    $admin->file      = $deir.$fiker;
                }
            $admin->save();
            return redirect()->route('admin.index')->with('success', "User <strong>$admin->name</strong> sudah ditambahkan.");
        }
        else{
            return redirect()->route('login')->with('warning','Data tidak valid!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::User()->kategori== 'Admin'){
            try
            {
                $title = 'data admin';
                $admin = User::findOrFail($id);
                $params = [
                        'title' => 'Profil Admin',
                        'admin' => $admin,
                    ]; 
                     
                if($admin->id <> (Auth::user()->id)){
                    return redirect()->route('rasaadmin')->with('warning','Data tidak valid!');
                }
                else
                {
                    return view('admin.admin.show')->with($params);
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
    public function profil($id)
    {
        if (Auth::User()->kategori== 'Admin' or Auth::User()->kategori== 'Pimpinan'){
            try
            {
                $admin = User::findOrFail($id);
                $params = [
                    'title' => 'Hapus Data Admin',
                    'admin' => $admin,
                ];
                if($admin->id <> (Auth::user()->id)){
                    return redirect()->route('rasaadmin')->with('warning','Data tidak valid!');
                }
                else


                {return view('admin.admin.delete')->with($params);}
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::User()->kategori== 'Admin'){
            try
            {
                $admin = User::findOrFail($id);
                $params = [
                    'title' => 'Ubah Data Admin',
                    'admin' => $admin,
                    'gender'  => (['Perempuan','Laki-laki']),
                ];
                if($admin->id <> (Auth::user()->id)){
                    return redirect()->route('rasaadmin')->with('warning','Data tidak valid!');
                }
                else
                {return view('admin.admin.edit')->with($params);}
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) 
    {   
        if (Auth::User()->kategori== 'Admin'){
            try
            {
                $this->validate($request, [
                    'name' => 'required|max:100|unique:users,name,'.$id,
                    'lengkap' => 'required|max:100|unique:users,lengkap,'.$id,
                    'email'    => 'required|email|unique:users,email,'.$id.'|max:100',
                    'password' => 'required|min:5|confirmed',
                    'file'   => 'file'.('|image|max:1999'),
                    'gender'  => 'required',
                ]);
                $admin = User::findOrFail($id);
                if($admin->id <> (Auth::user()->id)){
                    return redirect()->route('rasaadmin')->with('warning','Data tidak valid!');
                }
                else                
                {
                    if ($image = $request->hasFile('file')) {
                        $dir = '/media/admin/';
                        
                        // Upload
                        $file       = $request->file('file');
                        $extension  = $file->getClientOriginalExtension();
                        $filenamaa   = 'a'.uniqid().'.'.$extension;
                        $request->file->move('media/admin/', $filenamaa);
                        if($admin->id) {
                            $media = User::find($admin->id);
                            if(file_exists('./'.$media->file)){
                                unlink('./'.$media->file);
                            }
                        }
                        $admin->file      = $dir.$filenamaa;
                    }
                    $admin->name = $request->name;
                    $admin->email     = $request->email;
                    $admin->password  = bcrypt($request->password);
                    $admin->alamat = $request->alamat;
                    $admin->telepon = $request->telepon;
                    $admin->lengkap= $request->lengkap;
                    $admin->gender= $request->gender;
                    $admin->save(); 
                    if ((Auth::user()->kategori) === 'Admin'){
                        return redirect()->route('admin.show',$id)->with('success', "User <strong>$admin->name</strong> sudah diubah.");
                    }
                    if ((Auth::user()->kategori) === 'Pimpinan'){
                        return redirect()->route('admins.show',$id)->with('success', "User <strong>$admin->name</strong> sudah diubah.");
                    }
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::User()->kategori== "Admin"){
            $admin = User::findOrFail($id);
            if ($admin->id == 1) {
                    return redirect()->route('admin.index')->with('error', "Admin <strong>$admin->name</strong> adalah Super Admin jadi tidak bisa di Hapus");
                }
            try
            {
                $relationships = array();
                $admin = User::findOrFail($id);
                $should_delete = true;
                foreach($relationships as $r) {
                    if ($admin->$r->isNotEmpty()) {
                        $should_delete = false; 
                        return redirect()->route('admin.index')->with('error', "User <strong>$admin->name</strong> tidak bisa dihapus karna sudah dipakai pada data lainnya.");
                    }
                }
                if ($should_delete == true) {
                    $admin->delete();
                    return redirect()->route('admin.index')->with('success', "User <strong>$admin->name</strong> Berhasil dihapus");
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
