@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Tambah Data Kriteria</h3>
        <br>
        <table>

            <tr>
                <td>
                    <strong>Divisi </strong>
                </td>
                <td>
                    <strong> : </strong>
                </td>
                <td>
                    <strong> {{ $devisis}} </strong>
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
                            <a href="{{route('devisim.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Divisi</a>
                            <a href="{{ route('kriteriam.index',[$devisis, 'id'=>null]) }}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Kriteria</a>
                            <i class="fa fa-table"></i> Tambah Data Master Kriteria

                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <a href="{{ route('kriteriam.index',[$devisis]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
               <div class="x_content">
                    <br />
                    <form  method="post" action="{{ route('kriteriam.store',[$devisis]) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" name="formPendaftaran" onsubmit="return validateForm()">
                        {{ csrf_field() }}
                        <div class="row col-md-12">

                            <div class="col-md-12">
                                <div class="divs form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="nama">Nama Kriteria  <span class="required">*</span>
                                    </label>
                                    <input type="text=" value="" id="nama" name="nama" class="col-md-6" placeholder="Nama Kriteria" required>
                                    @if ($errors->has('nama'))
                                   <span class="help-block">{{ $errors->first('nama') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="divs form-group{{ $errors->has('satuan') ? ' has-error' : '' }}">
                                    <label class="col-md-3" for="satuan">Satuan Kriteria  <span class="required">*</span>
                                    </label>
                                    <input type="text=" value="" id="satuan" name="satuan" class="col-md-6" placeholder="Satuan Kriteria" required>
                                    @if ($errors->has('satuan'))
                                   <span class="help-block">{{ $errors->first('satuan') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('atribut') ? ' has-error' : '' }}"  >
                                    <label class="col-md-3" for="atribut">Atribut</label>
                                        <select class="col-md-5" name="atribut" id="atribut">
                                            @foreach($atribut as $k => $v)
                                            <option value="{{ $v }}" {{ (old('atribut')) && old('atribut') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('atribut'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('atribut') }}</strong>
                                            </span>
                                        @endif

                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                        </div>
                        <div class="row col-md-12" style="justify-content: center;">
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <button type="submit" class="btn btn-sm btn-success"><i class="ri-add-line"></i>Simpan</button>
                                <!-- <a href="{{ route('kriteriam.index',[$devisis]) }}">
                                    <button class="btn btn-sm btn-secondary"><i class="ri-arrow-left-fill"></i>Kembali</button>
                                </a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
