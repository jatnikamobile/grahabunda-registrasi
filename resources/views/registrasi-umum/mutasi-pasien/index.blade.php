@extends('layouts.main')
@section('title','Mutasi Pasien Umum | Modul Registrasi')
@section('register_umum','active')
@section('mutasi_ps_umum','active')
@section('header','Mutasi Pasien Umum')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('reg-umum-mutasi.form')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <section>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                            <form action="{{Request::url()}}" method="get">
                                <hr>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">No Registrasi</label>
                                        <div class="input-group col-sm-5">
                                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                            <input type="text" name="Regno" id="Regno" class="form-control input-sm" value="<?= Request::input('Regno') !== null ? Request::input('Regno') : Request::input('Regno') ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">Rekam Medis</label>
                                        <div class="input-group col-sm-5">
                                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                            <input type="text" name="Medrec" id="Medrec" class="form-control input-sm" value="<?= Request::input('Medrec') !== null ? Request::input('Medrec') : Request::input('Medrec') ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                        <div class="input-group col-sm-9">
                                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                            <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Firstname') !== null ? Request::input('Firstname') : Request::input('Firstname') ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">Berdasarkan Daftar</label>
                                        <div class="input-group col-sm-9">
                                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                            <input type="date" name="date1" id="date1" style="margin-right: 10px; width: 140px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>"/>
                                            <span class="" id="" style="background-color:white;">S/D</span>
                                            <input type="date" name="date2" id="date2" style="margin-left: 10px; width: 140px;" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d')?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i>Cari</button>
                                    <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div style="overflow:auto;" class="col-sm-12">
                        <table class="table table-bordered" id="table-list-pasien">
                            <thead>
                                <tr class="info">
                                    <th>No.Reg</th>
                                    <th>RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Mutasi</th>
                                    <th>Ruang</th>
                                    <th>Kelas</th>
                                    <th>Kamar</th>
                                    <th>Bed</th>
                                    <th>Bayar</th>
                                    <th>Kode</th>
                                    <th>Diagnosa</th>
                                    <th>Perusahaan</th>
                                    <th>Penjamin</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $l)
                                <tr>
                                    <td>{{ $l->regno }}</td>
                                    <td>{{ $l->medrec }}</td>
                                    <td>{{ $l->firstname }}</td>
                                    <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                                    <td>{{ $l->nmbangsal }}</td>
                                    <td>{{ $l->nmkelas }}</td>
                                    <td>{{ $l->nokamar }}</td>
                                    <td>{{ $l->nottidur }}</td>
                                    <td>{{ $l->nmcbayar }}</td>
                                    <td>{{ $l->kdicd }}</td>
                                    <td>{{ $l->diagnosa }}</td>
                                    <td>{{ $l->nmperusahaan }}</td>
                                    <td>{{ $l->nmjaminan }}</td>
                                    <td>{{ $l->validuser }}</td>
                                    <td>
                                        <a href="{{ route('mst-psn.print', ['Medrec' => $l->medrec]) }}" target="_blank" title="Print Detail"><i class="fa fa-print"></i></a>
                                        <a href="{{ route('ringkasan-pasien-masuk-print', ['noRegno'=>$l->regno]) }}" target="_blank" title="Print"><i class="fa fa-print"></i></a>
                                        <a href="{{ route('reg-umum-mutasi.edit', [$l->regno]) }}"> <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ route('reg-umum-mutasi.delete') }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{$l->regno}}').submit();"> <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-form-{{$l->regno}}" action="{{ route('reg-umum-mutasi.delete') }}" method="POST" style="display: none;">{{ csrf_field() }}
                                        <input type="hidden" name="Regno" id="Regno" value="{{$l->regno}}">
                                       </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No.Reg</th>
                                    <th>RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Mutasi</th>
                                    <th>Ruang</th>
                                    <th>Kelas</th>
                                    <th>Kamar</th>
                                    <th>Bed</th>
                                    <th>Bayar</th>
                                    <th>Kode</th>
                                    <th>Diagnosa</th>
                                    <th>Perusahaan</th>
                                    <th>Penjamin</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{$list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'nama'=>Request::input('nama'),'regno'=>Request::input('regno')])->links()}}
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