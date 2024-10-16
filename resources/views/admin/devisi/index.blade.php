@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Divisi</h3>
        <br>
        <table>
            <tr>
                <td>                    
                    <strong>Periode </strong>
                </td>
                <td>
                    <strong> : </strong>
                </td>
                <td>
                    <strong> {{ $periodes->tahun }} - {{ $periodes->nama }} </strong>
                </td>
            </tr>            
        </table>
        <br>
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
                            <i class="fa fa-fw fa-tachometer-alt"></i> Data Divisi
                        </div> 
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th> 
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th> 
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th> 
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>  
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($data as $val)
                        <tr>
                            <td style="text-align: center;">{{$loop->iteration}}</td>                           
                            <td>
                                {{ucfirst($val->nama)}}
                            </td>
                            
                            <td>
                                <p>Status :  
                <?php if ($val->status == "Tidak Konsisten"): ?>
                  <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span>
                <?php else: ?>
                  <span style="color: #1AAC06; font-weight: 800;">Konsisten</span>
                <?php endif ?>
              </p>
                            </td>
                            
                            <td style="text-align: center;">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="{{ $val }}">
                                     <div class="form-group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('kriteria.index',[$periodes, $val->id]) }}"><i class="fa fa-eye"></i>Kriteria</a> 
                                        
                                    </div>
                                </form>
                            </td>
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