@extends('layouts.admin.phome')
@section('content')

<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Devisi</h3>
        <br>
        <strong>Periode :{{$periodes->tahun}}-{{ $periodes->nama}}</strong>
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
                            <a href="{{route('periodes.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a>
                            <a href="{{route('devisis.index',[$periodes])}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th> 
                            <th>Devisi</th> 
                            <th>Perhitungan</th>  
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
                            <th>No.</th> 
                            <th>Devisi</th> 
                            <th>Perhitungan</th>  
                        </tr>
                    </tfoot>
                    <tbody> 
                        <tr>
                            <td style="text-align: center;">1</td>
                             
                            <td>
                                Cuci
                            </td> 
                            <td style="text-align: center;">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="cuci">
                                    <div class="form-group">
                                        <?php if (Auth::user()->kategori === 'Admin'): ?>
                                            <?php 
                                                $devisis="cuci";
                                             ?>
                                            <a class="btn btn-sm btn-primary" href="{{ route('kriteria.index',[$periodes, $devisis]) }}"><i class="fa fa-eye"></i>Kriteria</a>
                                            
                                        <?php endif ?>
                                                                     
                                    </div>
                                </form>
                            </td>
                             
  
                            
                        </tr>
                        <tr>
                            <td style="text-align: center;">2</td>
                             
                            <td>
                                Strika
                            </td> 
                            <td style="text-align: center;">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="strika">
                                    <div class="form-group">
                                        <?php if (Auth::user()->kategori === 'Admin'): ?>
                                            <?php 
                                            $devisis="strika";
                                             ?>
                                            <a class="btn btn-sm btn-primary" href="{{ route('kriteria.index',[$periodes, $devisis]) }}"><i class="fa fa-eye"></i>Kriteria</a>
                                            
                                        <?php endif ?>
                                                                     
                                    </div>
                                </form>
                            </td>
                             
  
                            
                        </tr>
                        <tr>
                            <td style="text-align: center;">3</td>
                             
                            <td>
                                Packing
                            </td> 
                            <td style="text-align: center;">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="packing">
                                    <div class="form-group">
                                        <?php if (Auth::user()->kategori === 'Admin'): ?>
                                            <?php 
                                            $devisis="packing";
                                             ?>
                                            <a class="btn btn-sm btn-primary" href="{{ route('kriteria.index',[$periodes, $devisis]) }}"><i class="fa fa-eye"></i>Kriteria</a>
                                            
                                        <?php endif ?>
                                                                     
                                    </div>
                                </form>
                            </td>
                             
  
                            
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection