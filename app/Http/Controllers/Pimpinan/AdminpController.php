<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
class AdminpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show($id)
    {
        if (Auth::User()->kategori== 'Pimpinan'){
            try
            {
                $title = 'Data admin';
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
                    return view('pimpinan.admin.show')->with($params);
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::User()->kategori== 'Pimpinan'){
            try
            {
                $admin = User::findOrFail($id);
                $params = [
                    'title' => 'Ubah Data Admin',
                    'admin' => $admin,
                    'gender'  => (['Perempuan','Laki-laki']),
                ];
                if($admin->id <> (Auth::user()->id)){
                    return redirect()->route('rasatamu')->with('warning','Data tidak valid!');
                }
                else
                {return view('pimpinan.admin.edit')->with($params);}
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
        if (Auth::User()->kategori== 'Pimpinan'){
            try
            {
                $this->validate($request, [
                    'name' => 'required|max:100|unique:users,name,'.$id,
                    'lengkap' => 'required|max:100|unique:users,lengkap,'.$id,
                    'email'    => 'required|email|unique:users,email,'.$id.'|max:100',
                    'password' => 'required|min:5|confirmed',
                    'file'   => 'file'.('|image|max:2048'),
                    'gender'  => 'required',
                ]);
                $admin = User::findOrFail($id);
                if($admin->id <> (Auth::user()->id)){
                    return redirect()->route('rasatamu')->with('warning','Data tidak valid!');
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
                        return redirect()->route('admins.show',$id)->with('success', "User <strong>$admin->name</strong> sudah diubah.");
                     
                     
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
        //
    }
}
