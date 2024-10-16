@extends('layouts.admin.admin')
@section('content')

<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Periode</h3>
        <br>
        <strong> </strong>
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
                        <div class="col-md-9" style="text-align: left;"> 
                            <a href="{{route('rasaadmin')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a>
                            <a href="{{route('periode.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a> 
                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            <?php if (Auth::user()->kategori === 'Admin'): ?>
                                <a href="{{route('periode.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>   
                            <?php endif ?> 

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th>
                            <th>Tahun / Periode</th>
                            <th>Keterangan</th> 
                            <th>Perhitungan</th>

                            <?php if (Auth::user()->kategori === 'Admin'): ?>
                            <th>Aksi</th>                                 
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th>
                            <th>Tahun / Periode</th>
                            <th>Keterangan</th> 
                            <th>Perhitungan</th>
                            <?php if (Auth::user()->kategori === 'Admin'): ?>
                            <th>Aksi</th>                                
                            <?php endif ?> 
                        </tr>
                    </tfoot>
                    <tbody>
                         @forelse($data as $val)
                        <tr>
                            <td style="text-align: center;">{{$loop->iteration}}</td>
                            <td>
                                {{ucfirst($val->tahun)}} 
                                <p>
                                    
                                {{$val->nama}}
                                </p>
                            </td>
                            <td>
                                <p>Status :  
                <?php if ($val->status == "Tidak Konsisten"): ?>
                  <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span>
                <?php else: ?>
                  <span style="color: #1AAC06; font-weight: 800;">Konsisten</span>
                <?php endif ?>
              </p>
                                
                                {{$val->keterangan}}
                            </td>
                            <?php if (Auth::user()->kategori === 'Admin'): ?>
                            <td style="text-align: center;">
                                <form class="formDelete" action="{{route('periode.destroy',$val->id)}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="{{ $val->id }}">
                                    <div class="form-group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('devisi.index',[$val->id]) }}"><i class="fa fa-eye"></i>Divisi</a>
                                        <a class="btn btn-sm btn-secondary" href="{{ route('alternatif.index',[$val->id]) }}"><i class="fa fa-eye"></i>Alternatif</a> 
                                        <a class="btn btn-sm btn-success" href="{{ route('perhitungan.index',[$val->id]) }}"><i class="fa fa-eye"></i>Perhitungan</a> 
                                           
                                    </div>
                                </form>
                            </td> 
 
                                
                            <?php endif ?>
                             
                           
                            <?php if (Auth::user()->kategori === 'Admin'): ?>
                            <td style="text-align: center;">
                                <form class="formDelete" action="{{route('periode.destroy',$val->id)}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="{{ $val->id }}">
                                    <div class="form-group">
                                         
                                        <a class="btn btn-sm btn-warning" href="{{ route('periode.edit',$val->id) }}"><i class="fa fa-edit"></i>Ubah</a>   
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus data?')" title="hapus"><i class="icon-7 ri-delete-bin-line"></i>Hapus</button>   
                                    </div>
                                </form>
                            </td> 
 
                                
                            <?php endif ?>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="15" class="text-center">Tidak Ada Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection