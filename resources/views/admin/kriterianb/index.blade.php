@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data<Strika>Nilai Bobot Kriteria</Strika></h3>
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
                    <strong> {{ $devisis->nama }} </strong>
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
                            <a href="{{route('kriteria.index',[$periodes, $devisis])}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Kriteria</a>
                            <i class="fa fa-table"></i> Data Nilai Bobot 
                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            <a href="{{route('kriteria.index',[$periodes, $devisis])}}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> Data Kriteria </a>   
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('kriterianb.update', [$periodes, $devisis, 1]) }}" data-parsley-validate class="forms form-horizontal form-label-left" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row col-md-12">
                    <div class="col-md-4 form-group{{ $errors->has('id1') ? ' has-error' : '' }}"  >
                        <label for="id1" class="control-label">Kriteria 1</label>
                        <div>
                            <select class="form-control" id="id1" name="id1">
                                @foreach($id2s as $row)
                                <option value="{{$row->id}}" {{$row->id  ? 'selected="selected"' : ''}}>{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach 
                            </select>
                            @if ($errors->has('id1'))
                            <span class="help-block">{{ $errors->first('id1') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 form-group{{ $errors->has('nilai') ? ' has-error' : '' }}"  >
                        <label for="nilai" class="control-label">Bobot </label>
                        <div>
                            <select class="form-control" name="nilai" id="nilai">
                                @foreach($nilai as $k => $v)
                                <option value="{{ $v }}" {{ (old('nilai')) && old('nilai') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('nilai'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nilai') }}</strong>
                                </span>
                            @endif 
                        </div>
                    </div>
                    <div class="col-md-4 form-group{{ $errors->has('id2') ? ' has-error' : '' }}">
                        <label class="control-label" for="id2">Kriteria 2<span class="required">*</span>
                        </label>
                        <div>
                            <select class="form-control" id="id2" name="id2">
                                @foreach($id2s as $row)
                                <option value="{{$row->id}}" {{$row->id  ? 'selected="selected"' : ''}}>{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach 
                            </select>
                            @if ($errors->has('id2'))
                            <span class="help-block">{{ $errors->first('id2') }}</span>
                            @endif
                        </div>
                    </div>
                    <br>
                    <hr> 
                </div>
                <div class="row mb-12" style="justify-content: center;">
                     <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8">
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                            <input name="_method" type="hidden" value="PUT">
                            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>Ubah</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-body table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th>Kode</th>
                            <?php
                            foreach ($datas as $key => $value) {
                                foreach ($id2s as $sss) {
                                    if ($sss->id == $key) {
                                        echo "<th>$sss->nama</th>"; 
                                    } 
                                }
                            }
                            ?> 
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
                            <th>Kode</th>
                            <?php
                            foreach ($datas as $key => $value) {
                                foreach ($id2s as $sss) {
                                    if ($sss->id == $key) {
                                        echo "<th>$sss->nama</th>"; 
                                    } 
                                }
                            }
                            ?>  
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                    $no = 1;
                    $a = 1;
                    foreach ($datas as $key => $value) : ?>
                        <tr> 
                            <th hidden="true"><?= $key ?></th>
                            <?php
                                foreach ($id2s as $cdfg) {
                                    if ( $key === $cdfg->id) {
                                        echo "<th>$cdfg->nama</th>";
                                    } 
                                } 
                            ?> 
                            <?php 
                                $b = 1;
                                foreach ($value as $k => $dt) {
                                    if ($key == $k)
                                        $class = 'background-color : #EEF760;';
                                    elseif ($b > $a)
                                        $class = 'background-color : #FF00E4;';
                                    else
                                        $class = 'background-color : white;';

 

                                    echo "<td style='$class'>" . round($dt, 3) . "</td>";
                                    $b++;
                                }
                                $no++;
                                $b++;
                            ?>                  

                             
                        </tr>
                        <?php $a++;
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection