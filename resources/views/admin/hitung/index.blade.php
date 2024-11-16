@extends('layouts.admin.admin')
@section('content')
<div id="content-wrapper">
    <div class="container-fluid">
        <h3>Data Perhitungan Menggunakan AHP dan Topsis</h3>
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
                            <a href="{{route('periode.index')}}" class="active"><i class="fa fa-fw fa-tachometer-alt"></i> Data Periode</a>
                            <i class="fa fa-fw fa-tachometer-alt"></i> Data Perhitungan  
                        </div> 
                        <div class="col-md-3" style="text-align: right;"> 
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <button class="tablink" onclick="openPage('Rekapan', this, '#269ecf')" id="defaultOpen">Rekapan</button>
                <button style="float: left;"  class="tablink" onclick="openPage('cuci', this, '#8D94F2')">Divisi Cuci</button>
                <button class="tablink" onclick="openPage('strika', this, '#064560')">Divisi Strika</button>
                <button class="tablink" onclick="openPage('packing', this, '#20c59c')">Divisi Packing</button>
                <div id="cuci" class="tabcontent">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="x908" style="text-align: center; background-color: gray; color:white;" >
                                <h3 class="mb-0">
                                    <strong>
                                         Mengukur Konsistensi Kriteria (AHP)
                                    </strong> 
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr1">
                                <h3 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp1" aria-expanded="true" aria-controls="clp1">
                                        <h4>
                                            Matriks Perbandingan Kriteria
                                        </h4>
                                    </button>
                                </h3>
                            </div>
                            <div id="clp1" class="collapse show" aria-labelledby="hdr1" data-parent="#accordion">
                                <div class="card-body">
                                     <p>
                                        Pertama-tama menyusun hirarki dimana diawali dengan tujuan, kriteria dan alternatif-alternatif pada tingkat paling bawah. Selanjutnya menetapkan perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik.
                                    </p>
                                    <p>
                                        Nilai diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi dengan bilangan (1) sedangkan isi nilai perbandingan antara (1) sampai dengan (5) kebalikannya, kemudian dijumlahkan perkolom.
                                        Data matrik tersebut seperti terlihat pada tabel berikut.
                                    </p>                             
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered" id="dataTable">
                                            <thead class="thead-dark text-center">
                                                <tr>                            
                                                    <th>Nama Kriteria</th>
                                                    <?php 
                                                    foreach ($datas as $key => $value) {
                                                        foreach ($data as $sss) {
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
                                                    <th>Nama Kriteria</th>
                                                    <?php
                                                    foreach ($datas as $key => $value) {
                                                        foreach ($data as $sss) {
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
                                                                foreach ($data as $cdfg) {
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
                                                                    echo "<td style='$class'>" . round($dt, 5) . "</td>";
                                                                    $b++;
                                                                }
                                                                $no++;
                                                                $b++;
                                                            ?>
                                                        </tr>
                                                        <?php $a++;
                                                    endforeach;
                                                ?>
                                                <?php 
                                                    echo "<tr><th style='text-align: center;'>Total</th>";
                                                    foreach ($total as $key => $value) {
                                                        echo "<td class='text-primary'>" . round($total[$key], 5) . "</td>";
                                                    }
                                                    echo "</tr>";
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="dhdr2">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#iclp2" aria-expanded="true" aria-controls="iclp2">
                                        <h4>
                                            Nilai Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="iclp2" class="collapse show" aria-labelledby="dhdr2" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Nilai kriteria fungsinya untuk memastikan matrik perbandingan yang telah dibuat sudah benar atau belum. Matrik perbandingan di katakan benar apabila jumlah setiap kolom kriteria = 1 dan jumlah kolom nilai kriteria = jumlah kriteria dimana nilai kriteria di dapat dari jumlah setiap baris kriteria.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            echo "<thead><tr><th style='text-align: center; background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normal as $key => $value) { 
                                                foreach ($data as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Nilai Kriteria</th>";
                                            $no = 1;
                                            foreach ($normal as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($data as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }
                                                foreach ($value as $k => $v) {
                                                    echo "<td  style='text-align: right'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right'>" . round($nilaikriteria[$key], 5) . "</td>"; 
                                                 
                                                echo "</tr>";

                                                $no++;
                                            }
                                            echo "<th style='text-align: center;'>Total</th>";
                                            foreach ($totalas as $k => $v) {
                                                echo "<td class='text-primary' style='text-align: right'>" . round($v, 5) . "</td>";
                                            }
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalnilai . "</td>";
                                             
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr2">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp2" aria-expanded="true" aria-controls="clp2">
                                        <h4>
                                            Matriks Bobot Prioritas Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="clp2" class="collapse show" aria-labelledby="hdr2" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Setelah matrik nilai kriteria sudah benar/valid, langkah selanjutnya adalah menghitung bobot Prioritas per kriteria, Dengan cara membagi setiap nilai kriteria dengan jumlah kriteria seperti terlihat pada berikut.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            echo "<thead><tr><th style='text-align: center; background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normal as $key => $value) { 
                                                foreach ($data as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align:center; background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Nilai Kriteria</th>";
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Bobot Prioritas</th></tr></thead>";
                                            $no = 1;
                                            foreach ($normal as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($data as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }

                                                foreach ($value as $k => $v) {
                                                    echo "<td  style='text-align: right'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right'>" . round($nilaikriteria[$key], 5) . "</td>"; 
                                                echo "<td class='text-primary' style='text-align: right'>" . round($rata[$key], 5) . "</td>";
                                                echo "</tr>";

                                                $no++;
                                            }
                                            echo "<th style='text-align: center;'>Total</th>";
                                            foreach ($totalas as $k => $v) {
                                                echo "<td class='text-primary' style='text-align: right'>" . round($v, 5) . "</td>";
                                            }
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalnilai . "</td>";
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalbobot . "</td>";
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr3">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp3" aria-expanded="false" aria-controls="clp3">
                                        <h4>
                                            Matriks Konsistensi Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="clp3" class="collapse show" aria-labelledby="hdr3" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian seperti terlihat pada tabel berikut.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            $cm = $measure;
                                            echo "<thead><tr><th style='text-align: center;  background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normal as $key => $value) {
                                                foreach ($data as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align: center;  background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center;  background-color: black; color: white;'>Bobot</th></tr></thead>";
                                            $no = 1;
                                            foreach ($normal as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($data as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }
                                                foreach ($value as $k => $v) {
                                                    echo "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right;'>" . round($cm[$key], 5) . "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                    <p>Berikut tabel ratio index berdasarkan ordo matriks.</p>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: black; color: white;">Ordo Matriks</th>
                                            <?php
                                            foreach ($nRI as $key => $value) {
                                                if (count($datas) == $key)
                                                    echo "<td class='text-primary' style='text-align: center;'>$key</td>";
                                                else
                                                    echo "<td style='text-align: right;'>$key</td>";
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">Ratio Index</th>
                                            <?php
                                            foreach ($nRI as $key => $value) {
                                                if (count($datas) == $key)
                                                    echo "<td class='text-primary' style='text-align: center;'>$value</td>";
                                                else
                                                    echo "<td style='text-align: center;'>$value</td>";
                                            }
                                            ?> 
                                        </tr>
                                    </table>
                                </div>                 
                            </div>
                            <div class="card-footer">
                                <?php
                                $CI = ((array_sum($cm) / count($cm)) - count($cm)) / (count($cm) - 1);
                                $RI = $nRI[count($datas)];
                                $CR = $CI / $RI;
                                echo "<p>Consistency Index: " . round($CI, 3) . "<br />";
                                echo "Ratio Index: " . round($RI, 3) . "<br />";
                                echo "Consistency Ratio: " . round($CR, 3);
                                if ($CR > 0.10) {
                                    echo "<h3>(Tidak Konsisten)</h3> <br/>";
                                } else {
                                    echo " <h3>(Konsisten) </h3> <br/>";
                                }
                                ?>
                            </div>
                        </div>
                        <br> 
                    </div>
                    <?php if ($CR > 0.10): ?>
                        <H3>Perhitungan Kriteria Berdasarkan AHP tidak Konsistens</H3>
                    <?php else: ?>
                        <div id="acsscordion">
                            <div class="card">
                                <div class="card-header" id="x908" style="text-align: center; background-color: gray; color:white;" >
                                    <h3 class="mb-0 text-center">
                                        <strong>
                                            Perhitungan TOPSIS
                                        </strong> 
                                    </h3>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd1">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd1" aria-expanded="true" aria-controls="clpd1">
                                            <h4>
                                                Hasil Analisa
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd1" class="collapse show" aria-labelledby="hdrd1" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead class="thead-dark text-center">
                                                    <tr>
                                                        <th>Nama</th>
                                                        <?php 
                                                        foreach ($data as $key => $value) {
                                                            echo "<th>" .  $value->nama . "</th>";
                                                        }
                                                        ?> 
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-dark text-center">
                                                    <tr>
                                                        <th style="text-align: center;">Nama</th>
                                                        <?php 
                                                        foreach ($data as $key => $value) {
                                                            echo "<th style='text-align: center;'>" .  $value->nama . "</th>";
                                                        }
                                                        ?> 
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $a = 1;
                                                    foreach ($hasilanalisis as $key => $value) : ?>
                                                        <tr> 
                                                            <?php 
                                                            foreach ($datalat as $kessy => $vaalue) {
                                                                if ($key == $vaalue->id) {
                                                                    echo "<th>$vaalue->nama</th>";
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                            $b = 1;
                                                            foreach ($value as $k => $dt) {
                                                                echo "<td style='text-align: right;'> $dt </td>";
                                                                $b++;
                                                            }
                                                            $no++;
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
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd2">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd2" aria-expanded="true" aria-controls="clpd2">
                                            <h4>
                                                Normalisasi
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd2" class="collapse show" aria-labelledby="hdrd2" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive"> 
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $normal = $topsisnormal;
                                                $r = "";
                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'>Nama</th>";
                                                $no = 1;
                                                foreach ($normal[key($normal)] as $key => $value) :?>
                                                <?php      
                                                    foreach ($data as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama</th>"; 
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php
                                                $no = 1;
                                                foreach ($normal as $key => $value) : ?>
                                                    <?php 
                                                    $r .= "<tr>";
                                                    foreach ($datalat as $kessy => $vaalue) {
                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th>" . $vaalue->nama . "</th>";
                                                        }
                                                    }
                                                    ?>
                                                    <?php 
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                    ?>
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php 
                                                $r .= "</tr>";
                                                echo  $r;
                                                ?>
                                            </table>                                                  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd3">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd3" aria-expanded="true" aria-controls="clpd3">
                                            <h4>
                                                Normalisasi Terbobot
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd3" class="collapse show" aria-labelledby="hdrd3" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $r = "";
                                                $terbobot = $normalterbobot;

                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'>Nama</th>";
                                                $no = 1;
                                                foreach ($terbobot[key($terbobot)] as $key => $value) : ?>
                                                    <?php 
                                                     
                                                    foreach ($data as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama - $vaalue->atribut</th>";
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php

                                                $no = 1;
                                                foreach ($terbobot as $key => $value): ?>
                                                    <?php 
                                                    $r .= "<tr>";
                                                    foreach ($datalat as $kessy => $vaalue) {
                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th >" . $vaalue->nama . "</th>";
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php
                                                $r .= "</tr>";
                                                echo  $r;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd4">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd4" aria-expanded="true" aria-controls="clpd4">
                                            <h4>
                                                Matriks Solusi Ideal
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd4" class="collapse show" aria-labelledby="hdrd4" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $r = "";
                                                $ideal = $idedata;

                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'> Nama</th>";
                                                $no = 1;
                                                foreach ($ideal[key($ideal)] as $key => $value) : ?>
                                                    <?php 
                                                    foreach ($data as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama - $vaalue->atribut</th>";
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php

                                                $no = 1;
                                                foreach ($ideal as $key => $value) {
                                                    $r .= "<tr>";
                                                    $r .= "<th style='text-align: left;'>" . $key . "</th>";
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                }
                                                $r .= "</tr>";
                                                echo  $r; 
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd5">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd5" aria-expanded="true" aria-controls="clpd5">
                                            <h4>
                                                Jarak Solusi & Nilai Preferensi
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd5" class="collapse show" aria-labelledby="hdrd5" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <tr>
                                                    <th style="text-align: center; background-color: black; color: white;">Nama</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Positif</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Negatif</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Preferensi</th>
                                                </tr>
                                                <?php
                                                    $jarak = $jarak;
                                                    $pref = $pref;
                                                    foreach ($topsisnormal as $key => $value) {
                                                        echo "<tr style='text-align: center;'>";
                                                        foreach ($datalat as $kessy => $vaalue) {
                                                            if ($key == $vaalue->id) {
                                                                echo "<th>$vaalue->nama</th>";
                                                            }
                                                        }             
                                                        echo "<td style='text-align: right;'>" . round($jarak[$key]['Positif'], 5) . "</td>";
                                                        echo "<td style='text-align: right;'>" . round($jarak[$key]['Negatif'], 5) . "</td>";
                                                        echo "<td style='text-align: right;'>" . round($pref[$key], 5) . "</td>";
                                                        echo "</tr>";
                                                        $no++;
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd6">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd6" aria-expanded="true" aria-controls="clpd6">
                                            <h4>
                                                Perankingan
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd6" class="collapse show" aria-labelledby="hdrd6" data-parent="#acsscordion">                                   
                                    <br>
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-dark text-center">
                                                <tr>                            
                                                    <th>No.</th>
                                                    <th>Kode</th> 
                                                    <th>Nama</th> 
                                                    <th>Total</th>  
                                                    <th>Ranking</th>
                                                </tr>
                                            </thead>
                                            <tfoot class="thead-dark text-center">
                                                <tr>                            
                                                    <th>No.</th>
                                                    <th>Kode</th> 
                                                    <th>Nama</th>
                                                    <th>Total</th>  
                                                    <th>Ranking</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @forelse($datalats as $val)
                                                <tr>
                                                    <td style="text-align: center;">{{$loop->iteration}}</td>
                                                    <td>
                                                        {{ucfirst($val->altr->kode)}}
                                                    </td>
                                                   
                                                    <td>
                                                        {{ucfirst($val->altr->nama)}}
                                                    </td>  
                                                    <td style="text-align: right;">
                                                        {{$val->total}}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{$loop->iteration}}
                                                    </td>  
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="15" class="text-center">Tidak Ada Data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="text-center"> 
                                            <br>
                                            <a class="btn btn-success btn-sm" href=" {{ route('perhitungan.show',[$periodes, 'cuci' ])}}">Cetak Data Ranking</a>
                                            <br>
                                        </div>
                                        <br>
                                    </div>
                                    <!-- /// -->
                                </div>
                            </div>
                        </div> 
                    <?php endif ?>
                </div>
                <div id="strika" class="tabcontent">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="x908" style="text-align: center; background-color: gray; color:white;" >
                                <h3 class="mb-0">
                                    <strong>
                                         Mengukur Konsistensi Kriteria (AHP)
                                    </strong> 
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr1">
                                <h3 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp1" aria-expanded="true" aria-controls="clp1">
                                        <h4>
                                            Matriks Perbandingan Kriteria
                                        </h4>
                                    </button>
                                </h3>
                            </div>
                            <div id="clp1" class="collapse show" aria-labelledby="hdr1" data-parent="#accordion">
                                <div class="card-body">
                                     <p>
                                        Pertama-tama menyusun hirarki dimana diawali dengan tujuan, kriteria dan alternatif-alternatif pada tingkat paling bawah. Selanjutnya menetapkan perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik.
                                    </p>
                                    <p>
                                        Nilai diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi dengan bilangan (1) sedangkan isi nilai perbandingan antara (1) sampai dengan (5) kebalikannya, kemudian dijumlahkan perkolom.
                                        Data matrik tersebut seperti terlihat pada tabel berikut.
                                    </p>                             
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered" id="dataTable">
                                            <thead class="thead-dark text-center">
                                                <tr>                            
                                                    <th>Nama Kriteria</th>
                                                    <?php 
                                                    foreach ($datasstrika as $key => $value) {
                                                        foreach ($datastrika as $sss) {
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
                                                    <th>Nama Kriteria</th>
                                                    <?php
                                                    foreach ($datasstrika as $key => $value) {
                                                        foreach ($datastrika as $sss) {
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
                                                    foreach ($datasstrika as $key => $value) : ?>
                                                        <tr> 
                                                            <th hidden="true"><?= $key ?></th>
                                                            <?php
                                                                foreach ($datastrika as $cdfg) {
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
                                                                    echo "<td style='$class'>" . round($dt, 5) . "</td>";
                                                                    $b++;
                                                                }
                                                                $no++;
                                                                $b++;
                                                            ?>
                                                        </tr>
                                                        <?php $a++;
                                                    endforeach;
                                                ?>
                                                <?php 
                                                    echo "<tr><th style='text-align: center;'>Total</th>";
                                                    foreach ($totalstrika as $key => $value) {
                                                        echo "<td class='text-primary'>" . round($totalstrika[$key], 5) . "</td>";
                                                    }
                                                    echo "</tr>";
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="dhdr2">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#iclp2" aria-expanded="true" aria-controls="iclp2">
                                        <h4>
                                            Nilai Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="iclp2" class="collapse show" aria-labelledby="dhdr2" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Nilai kriteria fungsinya untuk memastikan matrik perbandingan yang telah dibuat sudah benar atau belum. Matrik perbandingan di katakan benar apabila jumlah setiap kolom kriteria = 1 dan jumlah kolom nilai kriteria = jumlah kriteria dimana nilai kriteria di dapat dari jumlah setiap baris kriteria.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            echo "<thead><tr><th style='text-align: center; background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalstrika as $key => $value) { 
                                                foreach ($datastrika as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Nilai Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalstrika as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($datastrika as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }
                                                foreach ($value as $k => $v) {
                                                    echo "<td  style='text-align: right'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right'>" . round($nilaikriteriastrika[$key], 5) . "</td>"; 
                                                 
                                                echo "</tr>";

                                                $no++;
                                            }
                                            echo "<th style='text-align: center;'>Total</th>";
                                            foreach ($totalasstrika as $k => $v) {
                                                echo "<td class='text-primary' style='text-align: right'>" . round($v, 5) . "</td>";
                                            }
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalnilaistrika . "</td>";
                                             
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr2">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp2" aria-expanded="true" aria-controls="clp2">
                                        <h4>
                                            Matriks Bobot Prioritas Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="clp2" class="collapse show" aria-labelledby="hdr2" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Setelah matrik nilai kriteria sudah benar/valid, langkah selanjutnya adalah menghitung bobot Prioritas per kriteria, Dengan cara membagi setiap nilai kriteria dengan jumlah kriteria seperti terlihat pada berikut.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            echo "<thead><tr><th style='text-align: center; background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalstrika as $key => $value) { 
                                                foreach ($datastrika as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align:center; background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Nilai Kriteria</th>";
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Bobot Prioritas</th></tr></thead>";
                                            $no = 1;
                                            foreach ($normalstrika as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($datastrika as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }

                                                foreach ($value as $k => $v) {
                                                    echo "<td  style='text-align: right'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right'>" . round($nilaikriteriastrika[$key], 5) . "</td>"; 
                                                echo "<td class='text-primary' style='text-align: right'>" . round($ratastrika[$key], 5) . "</td>";
                                                echo "</tr>";

                                                $no++;
                                            }
                                            echo "<th style='text-align: center;'>Total</th>";
                                            foreach ($totalasstrika as $k => $v) {
                                                echo "<td class='text-primary' style='text-align: right'>" . round($v, 5) . "</td>";
                                            }
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalnilaistrika . "</td>";
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalbobotstrika . "</td>";
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr3">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp3" aria-expanded="false" aria-controls="clp3">
                                        <h4>
                                            Matriks Konsistensi Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="clp3" class="collapse show" aria-labelledby="hdr3" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian seperti terlihat pada tabel berikut.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            $cmstrika = $measurestrika;
                                            echo "<thead><tr><th style='text-align: center;  background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalstrika as $key => $value) {
                                                foreach ($datastrika as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align: center;  background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center;  background-color: black; color: white;'>Bobot</th></tr></thead>";
                                            $no = 1;
                                            foreach ($normalstrika as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($datastrika as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }
                                                foreach ($value as $k => $v) {
                                                    echo "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right;'>" . round($cmstrika[$key], 5) . "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                    <p>Berikut tabel ratio index berdasarkan ordo matriks.</p>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: black; color: white;">Ordo Matriks</th>
                                            <?php
                                            foreach ($nRI as $key => $value) {
                                                if (count($datasstrika) == $key)
                                                    echo "<td class='text-primary' style='text-align: center;'>$key</td>";
                                                else
                                                    echo "<td style='text-align: right;'>$key</td>";
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">Ratio Index</th>
                                            <?php
                                            foreach ($nRI as $key => $value) {
                                                if (count($datasstrika) == $key)
                                                    echo "<td class='text-primary' style='text-align: center;'>$value</td>";
                                                else
                                                    echo "<td style='text-align: center;'>$value</td>";
                                            }
                                            ?> 
                                        </tr>
                                    </table>
                                </div>                 
                            </div>
                            <div class="card-footer">
                                <?php
                                $CIstrika = ((array_sum($cmstrika) / count($cmstrika)) - count($cmstrika)) / (count($cmstrika) - 1);
                                $RIstrika = $nRI[count($datasstrika)];
                                $CRstrika = $CIstrika / $RIstrika;
                                echo "<p>Consistency Index: " . round($CIstrika, 3) . "<br />";
                                echo "Ratio Index: " . round($RIstrika, 3) . "<br />";
                                echo "Consistency Ratio: " . round($CRstrika, 3);
                                if ($CRstrika > 0.10) {
                                    echo "<h3>(Tidak konsisten)</h3> <br/>";
                                } else {
                                    echo " <h3>(Konsisten) </h3> <br/>";
                                }
                                ?>
                            </div>
                        </div>
                        <br> 
                    </div>
                    <?php if ($CRstrika > 0.10): ?>
                        <H3>Perhitungan Kriteria Berdasarkan AHP tidak Konsistens</H3>
                    <?php else: ?>
                        <div id="acsscordion">
                            <div class="card">
                                <div class="card-header" id="x908" style="text-align: center; background-color: gray; color:white;" >
                                    <h3 class="mb-0 text-center">
                                        <strong>
                                            Perhitungan TOPSIS
                                        </strong> 
                                    </h3>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd1">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd1" aria-expanded="true" aria-controls="clpd1">
                                            <h4>
                                                Hasil Analisa
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd1" class="collapse show" aria-labelledby="hdrd1" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead class="thead-dark text-center">
                                                    <tr>
                                                        <th>Nama</th>
                                                        <?php 
                                                        foreach ($datastrika as $key => $value) {
                                                            echo "<th>" .  $value->nama . "</th>";
                                                        }
                                                        ?> 
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-dark text-center">
                                                    <tr>
                                                        <th style="text-align: center;">Nama</th>
                                                        <?php 
                                                        foreach ($datastrika as $key => $value) {
                                                            echo "<th style='text-align: center;'>" .  $value->nama . "</th>";
                                                        }
                                                        ?> 
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $a = 1;
                                                    foreach ($hasilanalisisstrika as $key => $value) : ?>
                                                        <tr> 
                                                            <?php 
                                                            foreach ($datalatstrika as $kessy => $vaalue) {
                                                                if ($key == $vaalue->id) {
                                                                    echo "<th>$vaalue->nama</th>";
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                            $b = 1;
                                                            foreach ($value as $k => $dt) {
                                                                echo "<td style='text-align: right;'> $dt </td>";
                                                                $b++;
                                                            }
                                                            $no++;
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
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd2">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd2" aria-expanded="true" aria-controls="clpd2">
                                            <h4>
                                                Normalisasi
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd2" class="collapse show" aria-labelledby="hdrd2" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive"> 
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $normalstrika = $topsisnormalstrika;
                                                $r = "";
                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'>Nama</th>";
                                                $no = 1;
                                                foreach ($normalstrika[key($normalstrika)] as $key => $value) :?>
                                                <?php      
                                                    foreach ($datastrika as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama</th>"; 
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php
                                                $no = 1;
                                                foreach ($normalstrika as $key => $value) : ?>
                                                    <?php 
                                                    $r .= "<tr>";
                                                    foreach ($datalatstrika as $kessy => $vaalue) {
                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th>" . $vaalue->nama . "</th>";
                                                        }
                                                    }
                                                    ?>
                                                    <?php 
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                    ?>
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php 
                                                $r .= "</tr>";
                                                echo  $r;
                                                ?>
                                            </table>                                                  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd3">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd3" aria-expanded="true" aria-controls="clpd3">
                                            <h4>
                                                Normalisasi Terbobot
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd3" class="collapse show" aria-labelledby="hdrd3" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $r = "";
                                                $terbobotstrika = $normalterbobotstrika;

                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'>Nama</th>";
                                                $no = 1;
                                                foreach ($terbobotstrika[key($terbobotstrika)] as $key => $value) : ?>
                                                    <?php 
                                                     
                                                    foreach ($datastrika as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama - $vaalue->atribut</th>";
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php

                                                $no = 1;
                                                foreach ($terbobotstrika as $key => $value): ?>
                                                    <?php 
                                                    $r .= "<tr>";
                                                    foreach ($datalatstrika as $kessy => $vaalue) {
                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th >" . $vaalue->nama . "</th>";
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php
                                                $r .= "</tr>";
                                                echo  $r;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd4">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd4" aria-expanded="true" aria-controls="clpd4">
                                            <h4>
                                                Matriks Solusi Ideal
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd4" class="collapse show" aria-labelledby="hdrd4" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $r = "";
                                                $idealstrika = $idedatastrika;

                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'> Nama</th>";
                                                $no = 1;
                                                foreach ($idealstrika[key($idealstrika)] as $key => $value) : ?>
                                                    <?php 
                                                    foreach ($datastrika as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama - $vaalue->atribut</th>";
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php

                                                $no = 1;
                                                foreach ($idealstrika as $key => $value) {
                                                    $r .= "<tr>";
                                                    $r .= "<th style='text-align: left;'>" . $key . "</th>";
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                }
                                                $r .= "</tr>";
                                                echo  $r; 
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd5">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd5" aria-expanded="true" aria-controls="clpd5">
                                            <h4>
                                                Jarak Solusi & Nilai Preferensi
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd5" class="collapse show" aria-labelledby="hdrd5" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <tr>
                                                    <th style="text-align: center; background-color: black; color: white;">Nama</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Positif</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Negatif</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Preferensi</th>
                                                </tr>
                                                <?php
                                                    $jarakstrika = $jarakstrika;
                                                    $prefstrika = $prefstrika;
                                                    foreach ($topsisnormalstrika as $key => $value) {
                                                        echo "<tr style='text-align: center;'>";
                                                        foreach ($datalatstrika as $kessy => $vaalue) {
                                                            if ($key == $vaalue->id) {
                                                                echo "<th>$vaalue->nama</th>";
                                                            }
                                                        }             
                                                        echo "<td style='text-align: right;'>" . round($jarakstrika[$key]['Positif'], 5) . "</td>";
                                                        echo "<td style='text-align: right;'>" . round($jarakstrika[$key]['Negatif'], 5) . "</td>";
                                                        echo "<td style='text-align: right;'>" . round($prefstrika[$key], 5) . "</td>";
                                                        echo "</tr>";
                                                        $no++;
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd6">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd6" aria-expanded="true" aria-controls="clpd6">
                                            <h4>
                                                Perankingan
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd6" class="collapse show" aria-labelledby="hdrd6" data-parent="#acsscordion"> 
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-dark text-center">
                                                <tr>                            
                                                    <th>No.</th>
                                                    <th>Kode</th> 
                                                    <th>Nama</th> 
                                                    <th>Total</th>  
                                                    <th>Ranking</th>
                                                </tr>
                                            </thead>
                                            <tfoot class="thead-dark text-center">
                                                <tr>                            
                                                    <th>No.</th>
                                                    <th>Kode</th> 
                                                    <th>Nama</th>
                                                    <th>Total</th>  
                                                    <th>Ranking</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @forelse($datalatsstrika as $val)
                                                <tr>
                                                    <td style="text-align: center;">{{$loop->iteration}}</td>
                                                    
                                                    <td>
                                                        {{ucfirst($val->altr->kode)}}
                                                    </td>
                                                   
                                                    <td>
                                                        {{ucfirst($val->altr->nama)}}
                                                    </td> 
                                                    <td style="text-align: right;">
                                                        {{$val->total}}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{$loop->iteration}}
                                                    </td>  
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="15" class="text-center">Tidak Ada Data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="text-center"> 
                                            <br>
                                            <a class="btn btn-success btn-sm" href=" {{ route('perhitungan.show',[$periodes, 'strika' ])}}">Cetak Data Ranking</a>
                                            <br>
                                        </div>
                                        <br>
                                    </div> 
                                </div>
                            </div>
                        </div> 
                    <?php endif ?>
                </div>
                <div id="packing" class="tabcontent">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="x908" style="text-align: center; background-color: gray; color:white;" >
                                <h3 class="mb-0">
                                    <strong>
                                         Mengukur Konsistensi Kriteria (AHP)
                                    </strong> 
                                </h3>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr1">
                                <h3 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp1" aria-expanded="true" aria-controls="clp1">
                                        <h4>
                                            Matriks Perbandingan Kriteria
                                        </h4>
                                    </button>
                                </h3>
                            </div>
                            <div id="clp1" class="collapse show" aria-labelledby="hdr1" data-parent="#accordion">
                                <div class="card-body">
                                     <p>
                                        Pertama-tama menyusun hirarki dimana diawali dengan tujuan, kriteria dan alternatif-alternatif pada tingkat paling bawah. Selanjutnya menetapkan perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik.
                                    </p>
                                    <p>
                                        Nilai diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi dengan bilangan (1) sedangkan isi nilai perbandingan antara (1) sampai dengan (5) kebalikannya, kemudian dijumlahkan perkolom.
                                        Data matrik tersebut seperti terlihat pada tabel berikut.
                                    </p>                             
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered" id="dataTable">
                                            <thead class="thead-dark text-center">
                                                <tr>                            
                                                    <th>Nama Kriteria</th>
                                                    <?php 
                                                    foreach ($dataspacking as $key => $value) {
                                                        foreach ($datapacking as $sss) {
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
                                                    <th>Nama Kriteria</th>
                                                    <?php
                                                    foreach ($dataspacking as $key => $value) {
                                                        foreach ($datapacking as $sss) {
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
                                                    foreach ($dataspacking as $key => $value) : ?>
                                                        <tr> 
                                                            <th hidden="true"><?= $key ?></th>
                                                            <?php
                                                                foreach ($datapacking as $cdfg) {
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
                                                                    echo "<td style='$class'>" . round($dt, 5) . "</td>";
                                                                    $b++;
                                                                }
                                                                $no++;
                                                                $b++;
                                                            ?>
                                                        </tr>
                                                        <?php $a++;
                                                    endforeach;
                                                ?>
                                                <?php 
                                                    echo "<tr><th style='text-align: center;'>Total</th>";
                                                    foreach ($totalpacking as $key => $value) {
                                                        echo "<td class='text-primary'>" . round($totalpacking[$key], 5) . "</td>";
                                                    }
                                                    echo "</tr>";
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="dhdr2">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#iclp2" aria-expanded="true" aria-controls="iclp2">
                                        <h4>
                                            Nilai Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="iclp2" class="collapse show" aria-labelledby="dhdr2" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Nilai kriteria fungsinya untuk memastikan matrik perbandingan yang telah dibuat sudah benar atau belum. Matrik perbandingan di katakan benar apabila jumlah setiap kolom kriteria = 1 dan jumlah kolom nilai kriteria = jumlah kriteria dimana nilai kriteria di dapat dari jumlah setiap baris kriteria.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            echo "<thead><tr><th style='text-align: center; background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalpacking as $key => $value) { 
                                                foreach ($datapacking as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Nilai Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalpacking as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($datapacking as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }
                                                foreach ($value as $k => $v) {
                                                    echo "<td  style='text-align: right'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right'>" . round($nilaikriteriapacking[$key], 5) . "</td>"; 
                                                 
                                                echo "</tr>";

                                                $no++;
                                            }
                                            echo "<th style='text-align: center;'>Total</th>";
                                            foreach ($totalaspacking as $k => $v) {
                                                echo "<td class='text-primary' style='text-align: right'>" . round($v, 5) . "</td>";
                                            }
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalnilaipacking . "</td>";
                                             
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr2">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp2" aria-expanded="true" aria-controls="clp2">
                                        <h4>
                                            Matriks Bobot Prioritas Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="clp2" class="collapse show" aria-labelledby="hdr2" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Setelah matrik nilai kriteria sudah benar/valid, langkah selanjutnya adalah menghitung bobot Prioritas per kriteria, Dengan cara membagi setiap nilai kriteria dengan jumlah kriteria seperti terlihat pada berikut.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            echo "<thead><tr><th style='text-align: center; background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalpacking as $key => $value) { 
                                                foreach ($datapacking as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align:center; background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Nilai Kriteria</th>";
                                            echo "<th style='text-align: center; background-color: black; color: white;'>Bobot Prioritas</th></tr></thead>";
                                            $no = 1;
                                            foreach ($normalpacking as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($datapacking as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }

                                                foreach ($value as $k => $v) {
                                                    echo "<td  style='text-align: right'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right'>" . round($nilaikriteriapacking[$key], 5) . "</td>"; 
                                                echo "<td class='text-primary' style='text-align: right'>" . round($ratapacking[$key], 5) . "</td>";
                                                echo "</tr>";

                                                $no++;
                                            }
                                            echo "<th style='text-align: center;'>Total</th>";
                                            foreach ($totalaspacking as $k => $v) {
                                                echo "<td class='text-primary' style='text-align: right'>" . round($v, 5) . "</td>";
                                            }
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalnilaipacking . "</td>";
                                            echo "<td class='text-primary' style='text-align: right'>" . $totalbobotpacking . "</td>";
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header" id="hdr3">
                                <h4 class="mb-0 text-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#clp3" aria-expanded="false" aria-controls="clp3">
                                        <h4>
                                            Matriks Konsistensi Kriteria
                                        </h4>
                                    </button>
                                </h4>
                            </div>
                            <div id="clp3" class="collapse show" aria-labelledby="hdr3" data-parent="#accordion">
                                <div class="card-body">
                                    <p>Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian seperti terlihat pada tabel berikut.</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <?php
                                            $cmpacking = $measurepacking;
                                            echo "<thead><tr><th style='text-align: center;  background-color: black; color: white;'>Nama Kriteria</th>";
                                            $no = 1;
                                            foreach ($normalpacking as $key => $value) {
                                                foreach ($datapacking as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th style='text-align: center;  background-color: black; color: white;'>$vaalue->nama</th>";
                                                    }
                                                }
                                                $no++;
                                            }
                                            echo "<th style='text-align: center;  background-color: black; color: white;'>Bobot</th></tr></thead>";
                                            $no = 1;
                                            foreach ($normalpacking as $key => $value) {
                                                echo "<tr>"; 
                                                foreach ($datapacking as $kessy => $vaalue) {
                                                    if ($key == $vaalue->id) {
                                                        echo "<th>$vaalue->nama</th>";
                                                    }
                                                }
                                                foreach ($value as $k => $v) {
                                                    echo "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                }
                                                echo "<td class='text-primary' style='text-align: right;'>" . round($cmpacking[$key], 5) . "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                            echo "</tr>";
                                            ?>
                                        </table>
                                    </div>
                                    <p>Berikut tabel ratio index berdasarkan ordo matriks.</p>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: black; color: white;">Ordo Matriks</th>
                                            <?php
                                            foreach ($nRI as $key => $value) {
                                                if (count($dataspacking) == $key)
                                                    echo "<td class='text-primary' style='text-align: center;'>$key</td>";
                                                else
                                                    echo "<td style='text-align: right;'>$key</td>";
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <th style="background-color: black; color: white;">Ratio Index</th>
                                            <?php
                                            foreach ($nRI as $key => $value) {
                                                if (count($dataspacking) == $key)
                                                    echo "<td class='text-primary' style='text-align: center;'>$value</td>";
                                                else
                                                    echo "<td style='text-align: center;'>$value</td>";
                                            }
                                            ?> 
                                        </tr>
                                    </table>
                                </div>                 
                            </div>
                            <div class="card-footer">
                                <?php
                                $CIpacking = ((array_sum($cmpacking) / count($cmpacking)) - count($cmpacking)) / (count($cmpacking) - 1);
                                $RIpacking = $nRI[count($dataspacking)];
                                $CRpacking = $CIpacking / $RIpacking;
                                echo "<p>Consistency Index: " . round($CIpacking, 3) . "<br />";
                                echo "Ratio Index: " . round($RIpacking, 3) . "<br />";
                                echo "Consistency Ratio: " . round($CRpacking, 3);
                                if ($CRpacking > 0.10) {
                                    echo "<h3>(Tidak konsisten)</h3> <br/>";
                                } else {
                                    echo " <h3>(Konsisten) </h3> <br/>";
                                }
                                ?>
                            </div>
                        </div>
                        <br> 
                    </div>
                    <?php if ($CRpacking > 0.10): ?>
                        <H3>Perhitungan Kriteria Berdasarkan AHP tidak Konsistens</H3>
                    <?php else: ?>
                        <div id="acsscordion">
                            <div class="card">
                                <div class="card-header" id="x908" style="text-align: center; background-color: gray; color:white;" >
                                    <h3 class="mb-0 text-center">
                                        <strong>
                                            Perhitungan TOPSIS
                                        </strong> 
                                    </h3>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd1">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd1" aria-expanded="true" aria-controls="clpd1">
                                            <h4>
                                                Hasil Analisa
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd1" class="collapse show" aria-labelledby="hdrd1" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead class="thead-dark text-center">
                                                    <tr>
                                                        <th>Nama</th>
                                                        <?php 
                                                        foreach ($datapacking as $key => $value) {
                                                            echo "<th>" .  $value->nama . "</th>";
                                                        }
                                                        ?> 
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-dark text-center">
                                                    <tr>
                                                        <th style="text-align: center;">Nama</th>
                                                        <?php 
                                                        foreach ($datapacking as $key => $value) {
                                                            echo "<th style='text-align: center;'>" .  $value->nama . "</th>";
                                                        }
                                                        ?> 
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $a = 1;
                                                    foreach ($hasilanalisispacking as $key => $value) : ?>
                                                        <tr> 
                                                            <?php 
                                                            foreach ($datalatpacking as $kessy => $vaalue) {
                                                                if ($key == $vaalue->id) {
                                                                    echo "<th>$vaalue->nama</th>";
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                            $b = 1;
                                                            foreach ($value as $k => $dt) {
                                                                echo "<td style='text-align: right;'> $dt </td>";
                                                                $b++;
                                                            }
                                                            $no++;
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
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd2">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd2" aria-expanded="true" aria-controls="clpd2">
                                            <h4>
                                                Normalisasi
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd2" class="collapse show" aria-labelledby="hdrd2" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive"> 
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $normalpacking = $topsisnormalpacking;
                                                $r = "";
                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'>Nama</th>";
                                                $no = 1;
                                                foreach ($normalpacking[key($normalpacking)] as $key => $value) :?>
                                                <?php      
                                                    foreach ($datapacking as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama</th>"; 
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php
                                                $no = 1;
                                                foreach ($normalpacking as $key => $value) : ?>
                                                    <?php 
                                                    $r .= "<tr>";
                                                    foreach ($datalatpacking as $kessy => $vaalue) {
                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th>" . $vaalue->nama . "</th>";
                                                        }
                                                    }
                                                    ?>
                                                    <?php 
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                    ?>
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php 
                                                $r .= "</tr>";
                                                echo  $r;
                                                ?>
                                            </table>                                                  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd3">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd3" aria-expanded="true" aria-controls="clpd3">
                                            <h4>
                                                Normalisasi Terbobot
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd3" class="collapse show" aria-labelledby="hdrd3" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $r = "";
                                                $terbobotpacking = $normalterbobotpacking;

                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'>Nama</th>";
                                                $no = 1;
                                                foreach ($terbobotpacking[key($terbobotpacking)] as $key => $value) : ?>
                                                    <?php 
                                                     
                                                    foreach ($datapacking as $kessy => $vaalue) {

                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama - $vaalue->atribut</th>";
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php

                                                $no = 1;
                                                foreach ($terbobotpacking as $key => $value): ?>
                                                    <?php 
                                                    $r .= "<tr>";
                                                    foreach ($datalatpacking as $kessy => $vaalue) {
                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th >" . $vaalue->nama . "</th>";
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php
                                                $r .= "</tr>";
                                                echo  $r;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd4">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd4" aria-expanded="true" aria-controls="clpd4">
                                            <h4>
                                                Matriks Solusi Ideal
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd4" class="collapse show" aria-labelledby="hdrd4" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <?php
                                                $r = "";
                                                $idealpacking = $idedatapacking;

                                                $r .= "<tr><th style='text-align: center; background-color: black; color: white;'> Nama</th>";
                                                $no = 1;
                                                foreach ($idealpacking[key($idealpacking)] as $key => $value) : ?>
                                                    <?php 
                                                    foreach ($datapacking as $kessy => $vaalue) {
                                                        if ($key == $vaalue->id) {
                                                            $r .= "<th style='text-align: center; background-color: black; color: white;'>$vaalue->nama - $vaalue->atribut</th>";
                                                        }
                                                    }
                                                    $no++;
                                                    ?> 
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php

                                                $no = 1;
                                                foreach ($idealpacking as $key => $value) {
                                                    $r .= "<tr>";
                                                    $r .= "<th style='text-align: left;'>" . $key . "</th>";
                                                    foreach ($value as $k => $v) {
                                                        $r .= "<td style='text-align: right;'>" . round($v, 5) . "</td>";
                                                    }
                                                    $r .= "</tr>";
                                                    $no++;
                                                }
                                                $r .= "</tr>";
                                                echo  $r; 
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd5">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd5" aria-expanded="true" aria-controls="clpd5">
                                            <h4>
                                                Jarak Solusi & Nilai Preferensi
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd5" class="collapse show" aria-labelledby="hdrd5" data-parent="#acsscordion">
                                    <div class="card-body"> 
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <tr>
                                                    <th style="text-align: center; background-color: black; color: white;">Nama</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Positif</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Negatif</th>
                                                    <th style="text-align: center; background-color: black; color: white;">Preferensi</th>
                                                </tr>
                                                <?php
                                                    $jarakpacking = $jarakpacking;
                                                    $prefpacking = $prefpacking;
                                                    foreach ($topsisnormalpacking as $key => $value) {
                                                        echo "<tr style='text-align: center;'>";
                                                        foreach ($datalatpacking as $kessy => $vaalue) {
                                                            if ($key == $vaalue->id) {
                                                                echo "<th>$vaalue->nama</th>";
                                                            }
                                                        }             
                                                        echo "<td style='text-align: right;'>" . round($jarakpacking[$key]['Positif'], 5) . "</td>";
                                                        echo "<td style='text-align: right;'>" . round($jarakpacking[$key]['Negatif'], 5) . "</td>";
                                                        echo "<td style='text-align: right;'>" . round($prefpacking[$key], 5) . "</td>";
                                                        echo "</tr>";
                                                        $no++;
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header" id="hdrd6">
                                    <h4 class="mb-0 text-center">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#clpd6" aria-expanded="true" aria-controls="clpd6">
                                            <h4>
                                                Perankingan 
                                            </h4>
                                        </button>
                                    </h4>
                                </div>
                                <div id="clpd6" class="collapse show" aria-labelledby="hdrd6" data-parent="#acsscordion">
                                    <br>
                                    <!-- ///// -->
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead class="thead-dark text-center">
                                                <tr>                            
                                                    <th>No.</th>
                                                    <th>Kode</th> 
                                                    <th>Nama</th> 
                                                    <th>Total</th>  
                                                    <th>Ranking</th>
                                                </tr>
                                            </thead>
                                            <tfoot class="thead-dark text-center">
                                                <tr>                            
                                                    <th>No.</th>
                                                    <th>Kode</th> 
                                                    <th>Nama</th>
                                                    <th>Total</th>  
                                                    <th>Ranking</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @forelse($datalatspacking as $val)
                                                <tr>
                                                    <td style="text-align: center;">{{$loop->iteration}}</td>
                                                    
                                                    <td>
                                                        {{ucfirst($val->altr->kode)}}
                                                    </td>
                                                   
                                                    <td>
                                                        {{ucfirst($val->altr->nama)}}
                                                    </td> 
                                                    <td style="text-align: right;">
                                                        {{$val->total}}
                                                    </td> 
                                                    <td style="text-align: center;">
                                                        {{$loop->iteration}}
                                                    </td>  
                                                </tr>
                                              
                                                @empty
                                                <tr>
                                                    <td colspan="15" class="text-center">Tidak Ada Data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="text-center"> 
                                            <br>
                                            <a class="btn btn-success btn-sm" href=" {{ route('perhitungan.show',[$periodes, 'packing' ])}}">Cetak Data Ranking</a>
                                            <br>
                                        </div>
                                        <br>
                                    </div>
                                    <!-- /// -->
                                </div>
                            </div>
                        </div> 
                    <?php endif ?>
                </div>
                <div id="Rekapan" class="tabcontent">  
                    <div class="card">
                        <div class="card-header" id="hdrd6">
                            <h4 class="mb-0 text-center">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#clpd6" aria-expanded="true" aria-controls="clpd6">
                                    <h4>
                                        Rekapan Perankingan 
                                    </h4>
                                </button>
                                <h6 style="font-weight: 800;">Status Penilaian Kriteria (AHP): 
                                    <?php if ($statusperiode == "Tidak Konsisten"): ?>
                                        <span style="color: #CD3232; font-weight: 800;">{{$statusperiode}}</span>
                                        <span><hr></span>
                                        <p>
                                            <?php if ($CR > 0.10): ?>
                                            Status Penilaian Kriteria (AHP) Divisi Cuci : <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span><?php endif ?>
                                        </p>
                                        <p>
                                            <?php if ($CRstrika > 0.10): ?>
                                            Status Penilaian Kriteria (AHP) Divisi Strika : <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span><?php endif ?>
                                        </p>
                                        <p>
                                            <?php if ($CRpacking > 0.10): ?>
                                            Status Penilaian Kriteria (AHP) Divisi Packing : <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span><?php endif ?>
                                        </p>
                                    <?php else: ?>
                                        <span style="color: #1AAC06; font-weight: 800;">{{$statusperiode}}</span>
                                    <?php endif ?>
                                </h6>                                        
                            </h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered" id="ccc" width="100%" cellspacing="0">
                                <thead class="thead-dark text-center">
                                    <tr>                            
                                        <th>No.</th>
                                        <th>Kode</th> 
                                        <th>Nama</th> 
                                        <th>Total</th>  
                                        <th>Ranking</th>
                                    </tr>
                                </thead>
                                <tfoot class="thead-dark text-center">
                                    <tr>                            
                                        <th>No.</th>
                                        <th>Kode</th> 
                                        <th>Nama</th>
                                        <th>Total</th>  
                                        <th>Ranking</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @forelse($totalis as $val)
                                    <tr>
                                        <td style="text-align: center;">{{$loop->iteration}}</td>
                                        
                                        <td>
                                            {{ucfirst($val->kode)}}
                                        </td>
                                       
                                        <td>
                                            {{ucfirst($val->nama)}}
                                        </td> 
                                        <td style="text-align: right;">
                                            {{$val->alrank_sum_total}}
                                        </td>
                                        <td style="text-align: center;">
                                            {{$loop->iteration}}
                                        </td>  
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="15" class="text-center">Tidak Ada Data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <br>
                            <div class="text-center"> 
                                <br>
                                <a class="btn btn-success btn-sm" href=" {{ route('rekapankk',[$periodes])}}">Rekapan Data Ranking</a>
                                <br>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="hdrd6">
                            <h4 class="mb-0 text-center">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#clpd6" aria-expanded="true" aria-controls="clpd6">
                                    <h4>
                                        Perankingan Divisi Cuci

                                    </h4>
                                    <p>
                                        Status Penilaian Kriteria (AHP) : 
                                        <?php if ($CR > 0.10): ?>
                                            <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span>
                                        <?php else: ?>
                                            <span style="color: #1AAC06; font-weight: 800;">Konsisten</span>
                                        <?php endif ?>
                                    </p>
                                </button>
                            </h4>
                        </div>
                        <div id="clpd6" class="collapse show" aria-labelledby="hdrd6" data-parent="#acsscordion">                             
                            <br>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered" id="ccc" width="100%" cellspacing="0">
                                    <thead class="thead-dark text-center">
                                        <tr>                            
                                            <th>No.</th>
                                            <th>Kode</th> 
                                            <th>Nama</th> 
                                            <th>Total</th>  
                                            <th>Ranking</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark text-center">
                                        <tr>                            
                                            <th>No.</th>
                                            <th>Kode</th> 
                                            <th>Nama</th>
                                            <th>Total</th>  
                                            <th>Ranking</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($datalats as $val)
                                        <tr>
                                            <td style="text-align: center;">{{$loop->iteration}}</td>
                                            
                                            <td>
                                                {{ucfirst($val->altr->kode)}}
                                            </td>
                                           
                                            <td>
                                                {{ucfirst($val->altr->nama)}}
                                            </td> 
                                            <td style="text-align: right;">
                                                {{$val->total}}
                                            </td>
                                            <td style="text-align: center;">
                                                {{$loop->iteration}}
                                            </td>  
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="15" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <br>
                                <div class="text-center"> 
                                    <br>
                                    <a class="btn btn-success btn-sm" href=" {{ route('perhitungan.show',[$periodes, 'Cuci' ])}}">Cetak Data Ranking</a>
                                    <br>
                                </div>
                                <br>
                            </div>
                            <!-- /// -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="hdrd6">
                            <h4 class="mb-0 text-center">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#clpd6" aria-expanded="true" aria-controls="clpd6">
                                    <h4>
                                        Perankingan Divisi Strika
                                    </h4>
                                    <p>
                                        Status Penilaian Kriteria (AHP) : 
                                        <?php if ($CRstrika > 0.10): ?>
                                            <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span>
                                        <?php else: ?>
                                            <span style="color: #1AAC06; font-weight: 800;">Konsisten</span>
                                        <?php endif ?>
                                    </p>
                                </button>
                            </h4>
                        </div>
                        <div id="clpd6" class="collapse show" aria-labelledby="hdrd6" data-parent="#acsscordion">                             
                            <br>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark text-center">
                                        <tr>                            
                                            <th>No.</th>
                                            <th>Kode</th> 
                                            <th>Nama</th> 
                                            <th>Total</th>  
                                            <th>Ranking</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark text-center">
                                        <tr>                            
                                            <th>No.</th>
                                            <th>Kode</th> 
                                            <th>Nama</th>
                                            <th>Total</th>  
                                            <th>Ranking</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($datalatsstrika as $val)
                                        <tr>
                                            <td style="text-align: center;">{{$loop->iteration}}</td>
                                            
                                            <td>
                                                {{ucfirst($val->altr->kode)}}
                                            </td>
                                           
                                            <td>
                                                {{ucfirst($val->altr->nama)}}
                                            </td> 
                                            <td style="text-align: right;">
                                                {{$val->total}}
                                            </td>
                                            <td style="text-align: center;">
                                                {{$loop->iteration}}
                                            </td>  
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="15" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <br>
                                <div class="text-center"> 
                                    <br>
                                    <a class="btn btn-success btn-sm" href=" {{ route('perhitungan.show',[$periodes, 'Strika' ])}}">Cetak Data Ranking</a>
                                    <br>
                                </div>
                                <br>
                            </div>
                            <!-- /// -->
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-header" id="hdrd6">
                            <h4 class="mb-0 text-center">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#clpd6" aria-expanded="true" aria-controls="clpd6">
                                    <h4>
                                        Perankingan Divisi Packing
                                    </h4>
                                    <p>
                                        Status Penilaian Kriteria (AHP) : 
                                        <?php if ($CRpacking > 0.10): ?>
                                            <span style="color: #CD3232; font-weight: 800;">Tidak Konsisten</span>
                                        <?php else: ?>
                                            <span style="color: #1AAC06; font-weight: 800;">Konsisten</span>
                                        <?php endif ?>
                                    </p>
                                </button>
                            </h4>
                        </div>
                        <div id="clpd6" class="collapse show" aria-labelledby="hdrd6" data-parent="#acsscordion">
                            <br>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark text-center">
                                        <tr>                            
                                            <th>No.</th>
                                            <th>Kode</th> 
                                            <th>Nama</th> 
                                            <th>Total</th>  
                                            <th>Ranking</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark text-center">
                                        <tr>                            
                                            <th>No.</th>
                                            <th>Kode</th> 
                                            <th>Nama</th>
                                            <th>Total</th>  
                                            <th>Ranking</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($datalatspacking as $val)
                                        <tr>
                                            <td style="text-align: center;">{{$loop->iteration}}</td>
                                            
                                            <td>
                                                {{ucfirst($val->altr->kode)}}
                                            </td>
                                           
                                            <td>
                                                {{ucfirst($val->altr->nama)}}
                                            </td> 
                                            <td style="text-align: right;">
                                                {{$val->total}}
                                            </td>
                                            <td style="text-align: center;">
                                                {{$loop->iteration}}
                                            </td>  
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="15" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <br>
                                <div class="text-center"> 
                                    <br>
                                    <a class="btn btn-success btn-sm" href=" {{ route('perhitungan.show',[$periodes, 'Packing' ])}}">Cetak Data Ranking</a>
                                    <br>
                                </div>
                                <br>
                            </div>
                            <!-- /// -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("nnnn");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "desc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
/*If a switch has been marked, make the switch
and mark that a switch has been done:*/
rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
switching = true;
//Each time a switch is done, increase this count by 1:
switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
        if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
        }
    }
  }
}
</script>
@endsection

