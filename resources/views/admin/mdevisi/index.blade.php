@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Divisi</h3>
        <br>

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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td>
                                 CUCI
                            </td>
                            <td style="text-align: center;">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="Cuci">
                                     <div class="form-group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('kriteriam.index',["Cuci"]) }}"><i class="fa fa-eye"></i>Kriteria</a>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: center;">2</td>
                            <td>
                                 STRIKA
                            </td>
                            <td style="text-align: center;">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="Strika">
                                     <div class="form-group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('kriteriam.index',["Strika"]) }}"><i class="fa fa-eye"></i>Kriteria</a>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: center;">2</td>
                            <td>
                                 PACKING
                            </td>
                            <td style="text-align: center;">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="Packing">
                                     <div class="form-group">
                                        <a class="btn btn-sm btn-primary" href="{{ route('kriteriam.index',["Packing"]) }}"><i class="fa fa-eye"></i>Kriteria</a>
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
