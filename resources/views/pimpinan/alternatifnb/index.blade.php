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
                <tr>
                    <td>                    
                        <strong>Divisi </strong>
                    </td>
                    <td>
                        <strong> : </strong>
                    </td>
                    <td>
                         
                    </td>
                </tr>
        </table>  
        <hr/>
        
        <div class="clearfix"></div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-9" style="text-align: left;"> 
                            <a href="{{route('rasaadmin')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a>
                            <a href="{{route('periodes.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a>                        
                             
                            <i class="fa fa-table"></i> Data Nilai Bobot Alternatif
                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                             
                            <?php if (Auth::user()->kategori === 'Pimpinan'): ?>
                                 <a class="btn btn-sm btn-success" href="{{ route('perhitungans.index',[$periodes]) }}"><i class="fa fa-eye"></i>Perhitungan</a>
                            <?php endif ?>                             
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <div style="background-color: gray; padding: 5px  5px; text-align: center; margin-bottom: 5px;">
                    <h4 style="color: white;"> Penilaian Divisi Cuci </h4>
                </div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
		                    <th>Kode</th>
		                    <?php 
		                    foreach ($sdata as $key => $value) {
		                    	echo "<th>" .  $value->nama . "</th>";
		                    }
			                ?>                     
		                    <th>Aksi</th>  
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
		                    <th>Kode</th>
		                    <?php 
		                    foreach ($sdata as $key => $value) {
		                    	echo "<th>" .  $value->nama . "</th>";
		                    }
			                ?>                     
		                    <th>Aksi</th>   
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
                                foreach ($tdata as $cdfg) {
                                    if ( $key === $cdfg->id) {
                                        echo "<th>$cdfg->kode - $cdfg->nama</th>";
                                    } 
                                } 
                            ?>
	                        <?php
	                        $b = 1;
	                        foreach ($value as $k => $dt) {
	                            if ($key == $k)
	                                $class = 'success';
	                            elseif ($b > $a)
	                                $class = 'danger';
	                            else
	                                $class = '';
	                            echo "<td class='$class'> $dt </td>";
	                            $b++;
	                        }
	                        $no++;
	                        ?>
	                        <th class="nw">
	                        	<form class="formDelete" action="" method="post">
	                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                                <input type="hidden" name="_method" value="delete">
	                                <input type="hidden" name="id" value="{{ $key }}">
	                                 <div class="form-group">
	                                <a href="{{ route('alternatifnb.edit', [$periodes, $key]) }}"  class="btn btn-sm btn-warning"><i class="fa fa-edit" title="Ubah"></i> Ubah</a>  

	                                </div>
	                            </form>
	                        </th>
	                    </tr>
		                <?php $a++;
		                endforeach;
		                ?>
                    </tbody>
                </table>
                <!-- cuci end -->

                <!-- strika  -->
                <div style="background-color: gray; padding: 5px  5px; text-align: center; margin-bottom: 5px;">
                    <h4 style="color: white;"> Penilaian Divisi Strika </h4>
                 </div>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th>Kode</th>
                            <?php 
                            foreach ($sdatas as $key => $value) {
                                echo "<th>" .  $value->nama . "</th>";
                            }
                            ?>                     
                            <th>Aksi</th>  
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
                            <th>Kode</th>
                            <?php 
                            foreach ($sdatas as $key => $value) {
                                echo "<th>" .  $value->nama . "</th>";
                            }
                            ?>                     
                            <th>Aksi</th>   
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $no = 1;
                        $a = 1;
                        foreach ($datass as $key => $value) : ?>
                        <tr> 
                             
                            <th hidden="true"><?= $key ?></th>

                            <?php
                                foreach ($tdatas as $cdfg) {
                                    if ( $key === $cdfg->id) {
                                        echo "<th>$cdfg->kode - $cdfg->nama</th>";
                                    } 
                                } 
                            ?>
                            <?php
                            $b = 1;
                            foreach ($value as $k => $dt) {
                                if ($key == $k)
                                    $class = 'success';
                                elseif ($b > $a)
                                    $class = 'danger';
                                else
                                    $class = '';
                                echo "<td class='$class'> $dt </td>";
                                $b++;
                            }
                            $no++;
                            ?>
                            <th class="nw">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="{{ $key }}">
                                     <div class="form-group">
                                    <a href="{{ route('alternatifnb.edit', [$periodes, $key]) }}"  class="btn btn-sm btn-warning"><i class="fa fa-edit" title="Ubah"></i> Ubah</a>  

                                    </div>
                                </form>
                            </th>
                        </tr>
                        <?php $a++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
                <!-- strika end -->

                <!-- packing mulai -->
                <div style="background-color: gray; padding: 5px  5px; text-align: center; margin-bottom: 5px;">
                    <h4 style="color: white;"> Penilaian Divisi Packing </h4>
                </div>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th>Kode</th>
                            <?php 
                            foreach ($sdatap as $key => $value) {
                                echo "<th>" .  $value->nama . "</th>";
                            }
                            ?>                     
                            <th>Aksi</th>  
                        </tr>
                    </thead>
                    <tfoot class="thead-dark text-center">
                        <tr>                            
                            <th>Kode</th>
                            <?php 
                            foreach ($sdatap as $key => $value) {
                                echo "<th>" .  $value->nama . "</th>";
                            }
                            ?>                     
                            <th>Aksi</th>   
                        </tr>
                    </tfoot>
                    <tbody> 
                        <?php 
                        $no = 1;
                        $a = 1;

                        foreach ($datasp as $key => $value) : ?>
                        <tr> 
                             
                            <th hidden="true"><?= $key ?></th>

                            <?php
                                foreach ($tdatap as $cdfg) {
                                    if ( $key === $cdfg->id) {
                                        echo "<th>$cdfg->kode - $cdfg->nama</th>";
                                    } 
                                } 
                            ?>
                            <?php
                            $b = 1;
                            foreach ($value as $k => $dt) {
                                if ($key == $k)
                                    $class = 'success';
                                elseif ($b > $a)
                                    $class = 'danger';
                                else
                                    $class = '';
                                echo "<td class='$class'> $dt </td>";
                                $b++;
                            }
                            $no++;
                            ?>
                            <th class="nw">
                                <form class="formDelete" action="" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="id" value="{{ $key }}">
                                     <div class="form-group">
                                    <a href="{{ route('alternatifnb.edit', [$periodes, $key]) }}"  class="btn btn-sm btn-warning"><i class="fa fa-edit" title="Ubah"></i> Ubah</a>  

                                    </div>
                                </form>
                            </th>
                        </tr>
                        <?php $a++;
                        endforeach;
                        ?>
                    </tbody>
                </table>

                <!-- packing end -->

                 
            </div>
        </div>
    </div>
</div> 
@endsection
