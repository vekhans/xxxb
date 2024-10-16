@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Admin / Pengelola</h3>
        <hr/>
        @if(session('status'))
          <div class="alert alert-info alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>{{session('status')}}</strong>
          </div>
        @endif
        <div class="clearfix"></div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="form-group">
                    <div class="form-row">
                        <div  class="col-md-9" style="text-align: left;"> 
                            <a href="{{route('rasaadmin')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a>
                            <i class="fa fa-table"></i> Data Admin 
                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            @if (Auth::user()->id == 1)
                            <a href="{{route('admin.create')}}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Data</a>
                            @else
                            -
                            @endif
                         </div>
                    </div>
                </div>
            </div>
            <div class="card-header"><strong>Data Admin</strong></div>

            <div class="card-body table-responsive">
                <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> -->
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th> 
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama</th> 
                            <th>Email</th> 
                            <th>Foto</th> 
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if(count($data))
                        @foreach ($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.show', $row->id) }}"><i class="fa fa-fw fa-user" title="Admin"></i> {{$row->name}}</a>
                                <hr>
                                {{$row->lengkap}}
                            </td>
                            <td>
                                {{$row->email}}
                                <hr>
                                {{$row->telepon}}
                                <hr>
                                {{$row->gender}}
                            </td>                             
                            <td class="text-center"> 
                                <div>
                                <img id="img-preview" src="{{ asset($row->file) }}" class="img-responsive rounded-circle" style="height: 114px; width: 110px;" alt="foto user" />                                    
                                </div>
                            </td>                             
                            <td style="justify-content: center;">
                                <form class="formDelete" action="{{route('admin.destroy',$row->id)}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="{{ $row }}">
                                     <div class="form-group">
                                        <a href="
                                        <?php if (Auth::user()->kategori === 'Admin'): ?>
                                            {{ route('admin.show',Auth::user()->id)}}
                                        <?php endif ?>
                                        <?php if (Auth::user()->kategori === 'Pimpinan'): ?>
                                            {{ route('admins.show',Auth::user()->id)}}
                                        <?php endif ?>



                                        "  class="btn btn-sm btn-warning"><i class="fa fa-edit" title="Ubah"></i> Ubah</a> 
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus data?')" title="hapus"><i class="icon-7 ri-delete-bin-line"></i>Hapus</button> 
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection