@extends('layouts.admin.phome')
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
                            <a href="{{route('periodes.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a>
                            <a href="{{route('alternatifnb.index',[$periodes])}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Nilai Bobot Alternatif</a>
                            <i class="fa fa-table"></i> Ubah Data Nilai Bobot
                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <a href="{{route('alternatifnb.index',[$periodes])}}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Data Nilai Bobot Alternatif </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <br />
                <form method="POST" action="{{ route('alternatifnb.update', [$periodes, $key]) }}" data-parsley-validate class="forms form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row col-md-12">
                        <?php
                        foreach ($alternatifnb as $key => $value) : ?>

                                    <label class="col-md-7 form-control" for="nama">
                                        <p hidden="true"><?= $value->kriteria ?></p>
                                        <?php
                                        foreach ($kriteriase as $cdfg => $cds) : ?>
                                            <?php if ($cds->id == $value->kriteria): ?>
                                               <strong>Kriteria</strong> {{$cds->kode}} - {{$cds->nama}}
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    </label>
                                    <input class="form-control col-md-5" type="number" min="0" max="1000" name="ID-{{$value->id}}" value="{{$value->bobot}}" />


                        <?php endforeach; ?>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6" style="justify-content: center;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input name="_method" type="hidden" value="PUT">
                            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
