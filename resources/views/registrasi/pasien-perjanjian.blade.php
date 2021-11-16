@extends('layouts.main')
@section('title','Registrasi Pasien | Modul Registrasi')
@section('register','active')
@section('pasien_perjanjian','active')
@section('header','Registrasi Pasien Perjanjian')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                        <form action="{{Request::url()}}" method="get">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">No. RM</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="medrec" id="Medrec" style="margin-right: 10px;"
                                        value="<?= Request::input('medrec') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label no-padding-right">Total Perjanjian</label>
                                    <div class="input-group col-sm-6">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <h4>{{ $total }}</h4>
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Berdasarkan Pejanjian Daftar</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="date1" id="date1" style="margin-right: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d') ?>"/>
                                        <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                                        <input type="date" name="date2" id="date2" style="margin-left: 10px;" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d') ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Cari</button>
                                <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
                <section>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:auto;">
                        <table class="table table-bordered" id="table-list-pasien">
                            <thead>
                                <tr class="info">
                                    <th>Antrian</th>
                                    <th>No.Registrasi</th>
                                    <th>Rekam Medis</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Registrasi</th>
                                    <th>Sex</th>
                                    <th>Kunjungan</th>
                                    <th>Cara Bayar</th>
                                    <th>Tujuan</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Perjanjian</th>
                                    <th>Kategori</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $l)
                                    <tr>
                                        <td>{{ $l->NomorUrut }}</td>
                                        <td>{{ $l->Regno }}</td>
                                        <td>{{ $l->Medrec }}</td>
                                        <td>{{ $l->Firstname }}</td>
                                        <td>{{ date('d/m/Y',strtotime($l->Regdate)) }}</td>
                                        <td>{{ $l->Sex }}</td>
                                        <td>{{ $l->Kunjungan }}</td>
                                        <td>{{ $l->NMCbayar }}</td>
                                        <td>{{ $l->NMTuju }}</td>
                                        <td>{{ $l->NMPoli }}</td>
                                        <td>{{ $l->NmDoc }}</td>
                                        @if($l->Perjanjian == 'true')
                                            @if($l->Kategori == '2')
                                                <td><a href="{{ route('reg-bpjs-daftar.form-edit', [$l->Regno]) }}"><span class="label label-warning arrowed arrowed-right">Perjanjian {{ date('d/m/Y',strtotime($l->Regdate)) }}</span></a>
                                                </td>
                                            @elseif($l->Kategori == '1')
                                                <td>
                                                    <a href="{{ route('reg-umum-daftar.edit', [$l->Regno]) }}" title="Edit Pasien"><span class="label label-warning arrowed arrowed-right">Perjanjian {{ date('d/m/Y',strtotime($l->Regdate)) }}</span></a>
                                                </td>
                                            @endif
                                        @else
                                        <td><span class="label label-success arrowed-in arrowed-in-right">Datang</span></td>
                                        @endif
                                        <td>{{ $l->NmKategori }}</td>
                                        <td>{{ $l->ValidUser }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2')])->links() }}
                    </div>
                </section>
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