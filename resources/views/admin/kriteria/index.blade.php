@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Kriteria</h3>
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
            <tr>
                <td>                    
                    <strong>Divisi </strong>
                </td>
                <td>
                    <strong> : </strong>
                </td>
                <td>
                    <strong> {{ $devisis->nama}} </strong>
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
                            <a href="{{route('devisi.index',[$periodes])}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Divisi</a>
                            <i class="fa fa-fw fa-tachometer-alt"></i> Data Kriteria
                             
                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            <a href="{{ route('kriteria.create',[$periodes, $devisis]) }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Data Kriteria </a>
                            <a href="{{ route('kriterianb.index',[$periodes, $devisis]) }}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Data Nilai Bobot </a>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Atribut</th>
                            <th>Aksi</th> 
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Atribut</th>
                            <th>Aksi</th>  
                        </tr>
                    </tfoot>
                    <tbody>
                        @forelse($data as $val)
                        <tr>
                            <td style="text-align: center;">{{$loop->iteration}}</td>
                            
                             <td>
                                {{($val->kode)}}
                            </td>
                           
                            <td>
                                {{($val->nama)}}
                            </td>
                            
                            <td>
                                {{ucfirst($val->atribut)}}
                            </td>
                            
                            <td style="text-align: center;">
                                <form class="formDelete" action="{{route('kriteria.destroy',[$periodes, $devisis, $val->id])}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="{{ $val }}">
                                     <div class="form-group">
                                        <a href="{{ route('nilai.index',[$periodes, $devisis, $val->id]) }}"  class="btn btn-sm btn-primary"><i class="fa fa-edit" title="Nilai"></i> Nilai</a>
                                        <a href="{{ route('kriteria.edit',[$periodes, $devisis, $val->id]) }}"  class="btn btn-sm btn-warning"><i class="fa fa-edit" title="Ubah"></i> Ubah</a> 
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus data?')" title="Hapus"><i class="icon-7 ri-delete-bin-line"></i>Hapus</button> 

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