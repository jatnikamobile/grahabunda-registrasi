@extends('layouts.main')
@section('title','Rujukan Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('rujukan_pasien','active')
@section('header','Rujukan Pasien BPJS')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('reg-bpjs-rujukan.form')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
            </div>
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
                                    <label class="col-sm-3 control-label no-padding-right">No Rekam Medis</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="medrec" id="medrec" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('medrec') !== null ? Request::input('medrec') : Request::input('medrec') ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="nama" id="nama" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('nama') !== null ? Request::input('nama') : Request::input('nama') ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Date</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="date1" id="date1" style="width: 45%" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>"/>
                                        <span class="" id="" style="background-color:white; margin-right: 10px;">&nbsp;s/d&nbsp;</span>
                                        <input type="date" name="date2" id="date2" style="width: 45%" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d')?>" />
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
                <section>
                    <table class="table table-bordered" id="table-list-pasien">
                        <thead>
                            <tr class="info">
                                <th>No</th>
                                <th>No SEP</th>
                                <th>Tgl Rujukan</th>
                                <th>No Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th>No Rujukan</th>
                                <th>No Peserta</th>
                                <th>User</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $n = $list->perPage() * ($list->currentPage() -1);
                            @endphp
                            @foreach($list as $key => $l)
                                <tr>
                                    <td>{{ ++$n }}</td>
                                    <td>{{ $l->nosep }}</td>
                                    <td>{{ date('d/m/Y',strtotime($l->tglrujukan)) }}</td>
                                    <td>{{ $l->medrec }}</td>
                                    <td>{{ $l->firstname }}</td>
                                    <td>{{ $l->norujukan }}</td>
                                    <td>{{ $l->nopeserta }}</td>
                                    <td>{{ $l->validuser }}</td>
                                    <td>
                                        <div class="pull-right">
                                            <a class="btn btn-xs btn-primary" target="_blank" href="{{route('reg-bpjs-rujukan.print', ['norujukan'=>$l->norujukan])}}">
                                                <i class="fa fa-print"></i> Print
                                            </a>
                                            <a class="btn btn-xs btn-warning" href="{{route('reg-bpjs-rujukan.form', [$l->norujukan])}}">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a class="btn btn-xs" href="{{route('reg-bpjs-rujukan.delete', [$l->nosep])}}">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'nama'=>Request::input('nama'),'medrec'=>Request::input('medrec')])->links() }}
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