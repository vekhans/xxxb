@extends('layouts.admin.phome')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Admin / Pengelola</h3>
        <hr/>
        <div class="clearfix"></div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="form-group">
                    <div class="form-row">
                        <div style="text-align: left;"> 
                            <a href="{{route('rasaadmin')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a>
                            <!-- <a href="{{route('admin.index')}}" class="active"><i class="fa fa-fw fa-table"></i>Data Admin </a> -->
                            <a><i class="fa fa-edit"></i> :{!!' <strong>'.$admin->name.'</strong>'!!}</a> 
                        </div>  
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6" style="text-align: left;"> 
                        <div>
                            <p><strong> Nama           : </strong> {{ucfirst($admin->name)}} </p>
                            <p><strong> Nama Lengkap   : </strong> {{ucfirst($admin->lengkap)}} </p>
                            <p><strong> Email          : </strong> {{($admin->email)}} </p>
                            <p><strong> Telepon        : </strong> {{($admin->telepon)}} </p>
                            <p><strong> Alamat         : </strong> {{($admin->alamat)}} </p>
                            <p><strong> Gender         : </strong> {{ucfirst($admin->gender)}} </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-offset-3 text-center">
                            <img id="img-preview" class="img-responsive" style="border-radius: 20%; height: 210px; width: 209px;" alt="User Image" src="{{asset($admin->file)}}" />
                        </div>
                        <br>
                        <p class="text-center">
                            <a href="                            
                            <?php if ((Auth::user()->kategori) == 'Pimpinan'): ?>
                                {{ route('admins.edit', $admin->id) }}
                            <?php endif ?>
                                " class="btn btn-warning btn-sm text-center"><i class="fa fa-fw fa-edit" title="Ubah"></i> Ubah</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection