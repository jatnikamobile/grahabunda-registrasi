@extends('layouts.main')
@section('title','Surat Kontrol | Modul Registrasi')
@section('menu-min','menu-min')
@section('menu_surat_kontrol','active')
@section('header','Surat Kontrol')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <!-- <div class="panel-heading">
            </div> -->
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                        <form action="{{Request::url()}}" method="get">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Asal</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input name="instalasi" type="radio" id="1" value="1" class="with-gap radio-col-blue" />
                                        <label for="1">Rawat Jalan</label>
                                        <input name="instalasi" type="radio" id="2" value="2" class="with-gap radio-col-blue" />
                                        <label for="2">Rawat Inap</label>
                                        <input name="instalasi" type="radio" id="3" value="3" class="with-gap radio-col-blue" />
                                        <label for="3">Konsul</label>
                                        <input name="instalasi" type="radio" id="4" value="4" class="with-gap radio-col-blue" />
                                        <label for="4">Radiologi</label>
                                        <input name="instalasi" type="radio" id="5" value="5" class="with-gap radio-col-blue" />
                                        <label for="5">Laboratorium</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">No Rekam Medis</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Medrec" id="Medrec" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Medrec') !== null ? Request::input('Medrec') : Request::input('Medrec') ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Firstname') !== null ? Request::input('Firstname') : Request::input('Firstname') ?>"/>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Cari</button>
                                    <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:auto;">
                    <table class="table table-bordered" id="table-list-pasien">
                        <thead>
                            <tr class="info">
                                <th>No</th>
                                <th>No Surat</th>
                                <th>No Surat Kontrol BPJS</th>
                                <th>Rekam Medis</th>
                                <th>Tgl Kunjungan Sebelum</th>
                                <th>No Registrasi Sebelum</th>
                                <th>No Rujukan Sebelum</th>
                                <th>Nama Pasien</th>
                                <th>Poli Rujukan</th>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $n = $list->perPage() * ($list->currentPage() -1);
                        @endphp
                        @foreach($list as $key => $l)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>{{ $l->NoSurat }}</td>
                                <td>{{ $l->no_surat_kontrol_bpjs }}</td>
                                <td>{{ $l->Medrec }}</td>
                                <td>{{ date('d/m/Y',strtotime($l->TanggalRujukan)) }}</td>
                                <td>{{ $l->Regno }}</td>
                                <td>{{ $l->Norujukan }}</td>
                                <td>{{ $l->Firstname }}</td>
                                <td>{{ $l->NMPoli}}</td>
                                <td>{{ date('d/m/Y',strtotime($l->TanggalSurat)) }}</td>
                                <td>
                                    <!-- Print Detail Pasien -->
                                   <!--  <a href="{{ route('mst-psn.print', ['Medrec' => $l->Medrec]) }}" target="_blank" title="Print Detail"><i class="fa fa-eye"></i></a> -->
                                    <!-- Edit Form -->
                                    @if ($inst == 3) 
                                        <a href="{{ route('srt-knsl.form', [substr($l->no_surat_kontrol_bpjs,0,6)]) }}" title="Daftarkan Pasien"> <i class="fa fa-reply green"></i>
                                        </a>
                                    @elseif ($inst == 4) 
                                        <a href="{{ route('radiologi.form', [$l->no_surat_kontrol_bpjs,$l->Medrec] ) }}" title="Daftarkan Pasien"> <i class="fa fa-reply green"></i>
                                        </a>
                                    @elseif ($inst == 5) 
                                        <a href="{{ route('laboratorium.form', [$l->no_surat_kontrol_bpjs,$l->Medrec] ) }}" title="Daftarkan Pasien"> <i class="fa fa-reply green"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('srt-kntrl.form', [$l->no_surat_kontrol_bpjs]) }}" title="Daftarkan Pasien"> <i class="fa fa-reply green"></i>
                                        </a>
                                    @endif
                                    <!-- Edit Form -->
                                    <!-- Delete Form -->
                                    <!-- <a href="{{ route('mst-psn.form-delete') }}" title="Hapus Pasien" onclick="event.preventDefault(); document.getElementById('delete-form-{{$l->Medrec}}').submit();"> <i class="fa fa-trash red"></i>
                                    </a> -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>No Surat</th>
                                <th>No Surat Kontrol BPJS</th>
                                <th>Rekam Medis</th>
                                <th>Tgl Kunjungan Sebelum</th>
                                <th>No Registrasi Sebelum</th>
                                <th>No Rujukan Sebelum</th>
                                <th>Nama Pasien</th>
                                <th>Poli Rujukan</th>
                                <th>Tanggal Rujukan</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Firstname'=>Request::input('Firstname'),'MedRec'=>Request::input('MedRec'),'Phone'=>Request::input('Phone'),'Tgl_lahir'=>Request::input('Tgl_lahir'),'Alamat'=>Request::input('Alamat')])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
    });
</script>
@endsection