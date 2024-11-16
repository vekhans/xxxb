@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Detail Data Alternatif</h3>
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
                            <a href="{{ route('alternatif.index',[$periodes]) }}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Alternatif</a>
                            <i class="fa fa-table"></i> Lihat Data Alternatif

                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <a href="{{ route('alternatif.index',[$periodes]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
               <div class="x_content">
                    <br />
                    <form method="POST" action="{{ route('alternatif.update',[$periodes, $alternatif]) }}" data-parsley-validate class="forms form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">Kode Alternatif<span class="required"></span>
                            </label>
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode">{{$alternatif->kode}}
                            </label>

                        </div>
                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3" for="nama">Nama Alternatif<span class="required">*</span>
                            </label>
                            <label class="control-label col-md-3 col-sm-3" for="nama">{{$alternatif->nama}}
                            </label>

                        </div>




                                <div class="form-group{{ $errors->has('devisi') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3 col-sm-3" for="devisi">Divisi <span class="required">*</span>
                                    </label>

                                        <select class="selectpicker form-control col-md-7 col-xs-12" id="devisi" name="devisi[]" multiple disabled>
                                             @foreach($devisis as $devisi)
                                            <option value="{{$devisi->id}}"
                                                @foreach($alternatif->alrank as $item)
                                                @if(in_array($devisi->id,old('devisi',[$item->devisi]))) selected="selected" @endif
                                            @endforeach>
                                                {{$devisi->nama}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('devisi'))
                                        <span class="help-block">{{ $errors->first('devisi') }}</span>
                                        @endif

                                </div>


<br>
<hr/>







                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <input name="_method" type="hidden" value="PUT">
                                <a href="{{ route('alternatif.index',[$periodes]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
