@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data<Strika>Nilai Bobot Alternatif</Strika></h3>
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
                            
                            <?php if (Auth::user()->kategori === 'Admin'): ?>
                                 <a href="{{route('alternatif.index',[$periodes->id])}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Alternatif</a>
                            <?php endif ?> 
                            <i class="fa fa-table"></i> Data Nilai Bobot 
                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            <?php if (Auth::user()->kategori === 'Admin'): ?>
                                <a href="{{route('alternatif.index',[$periodes->id])}}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Data Alternatif </a> 
                            <?php endif ?>
                            <?php if (Auth::user()->kategori === 'Pimpinan'): ?>
                                 <a class="btn btn-sm btn-success" href="{{ route('perhitungan.index',[$periodes->id]) }}"><i class="fa fa-eye"></i>Perhitungan</a>
                                 <a href="{{route('periodes.index')}}" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left"></i>Data Periode</a>
                            <?php endif ?>                             
                        </div>
                    </div>
                </div>
            </div>
             
        </div>
    </div>
</div> 
@endsection
