@extends('layouts.main')
@section('title','Master Pasien | Modul Registrasi')
@section('menu-min','menu-min')
@section('menu_master_ps','active')
@section('header','Master Pasien')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('mst-psn.form')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
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
                                    <label class="col-sm-3 control-label no-padding-right">No Rekam Medic</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" data-inputmask="'mask': '99-99-99'" name="Medrec" id="Medrec" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Medrec') !== null ? Request::input('Medrec') : Request::input('Medrec') ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Phone</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Phone" id="Phone" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Phone') !== null ? Request::input('Phone') : Request::input('Phone') ?>"/>
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
                                    <label class="col-sm-3 control-label no-padding-right">Alamat</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Address" id="Address" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Address') !== null ? Request::input('Address') : Request::input('Address') ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Tanggal Lahir</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="Tgl_lahir" id="Tgl_lahir" class="form-control input-sm col-xs-10 col-sm-5" value="<?=Request::input('Tgl_lahir') !== null ? Request::input('Tgl_lahir') : Request::input('Tgl_lahir')?>"/>
                                    </div>
                                </div>
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:auto;">
                    <table class="table table-bordered" id="table-list-pasien">
                        <thead>
                            <tr class="info">
                                <th>No</th>
                                <th>Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Daftar</th>
                                <th>Tempat, Tgl Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Kode Pos</th>
                                <th>No.Tlp</th>
                                <th>Kategori</th>
                                <th>User</th>
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
                                <td>{{ $l->Medrec }}</td>
                                <td>{{ $l->Firstname }}</td>
                                <td>{{ date('d/m/Y',strtotime($l->TglDaftar)) }}</td>
                                <td>{{ $l->Pod }}, {{ date('d/m/Y',strtotime($l->Bod)) }}</td>
                                <td>{{ $l->Sex }}</td>
                                <td>{{ $l->Address }}</td>
                                <td>{{ $l->KdPos }}</td>
                                <td>{{ $l->Phone}}</td>
                                <td>{{ $l->NmKategori }}</td>
                                <td>{{ $l->ValidUser }}</td>
                                <td>
                                    <!-- Print Detail Pasien -->
                                    <a href="{{ route('mst-psn.print', ['Medrec' => $l->Medrec]) }}" target="_blank" title="Print Detail"><i class="fa fa-print"></i></a>
                                    <!-- Print Pemeriksaan Depan -->
                                    <a href="{{ route('mst-psn.print-pemeriksaan', ['Medrec' => $l->Medrec]) }}" target="_blank" title="Print Pemeriksaan Depan"><i class="fa fa-bookmark"></i></a>
                                    <!-- Print Pemeriksaan Depan -->
                                    <!-- Print Pemeriksaan Belakang -->
                                    <a href="{{ route('mst-psn.print-pemeriksaan-back', ['Medrec' => $l->Medrec]) }}" target="_blank" title="Print Pemeriksaan Belakang"><i class="fa fa-bookmark-o"></i></a>
                                    <!-- Print Pemeriksaan Belakang -->
                                    <!-- Print Kartu Pasien -->
                                    <a href="{{ route('mst-psn.print-kartu', ['Medrec' => $l->Medrec]) }}" target="_blank" title="Print Kartu Pasien"><i class="fa fa-credit-card"></i></a>
                                    <!-- Edit Form -->
                                    <a href="{{ route('mst-psn.form-edit', [$l->Medrec]) }}" title="Edit Pasien"> <i class="fa fa-pencil green"></i>
                                    </a>
                                    <!-- Edit Form -->
                                    <!-- Delete Form -->
                                    <a href="{{ route('mst-psn.form-delete') }}" title="Hapus Pasien" 
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{$l->Medrec}}').submit();"> <i class="fa fa-trash red"></i>
                                    </a>
                                    <form id="delete-form-{{$l->Medrec}}" action="{{ route('mst-psn.form-delete') }}" method="POST" style="display: none;">
                                        {{ method_field('DELETE') }} {{ csrf_field() }}
                                        <input type="hidden" name="medrec" id="medrec" value="{{$l->Medrec}}">
                                    </form><!-- Delete Form -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>RM</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Daftar</th>
                                <th>Tempat, Tgl Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Kode Pos</th>
                                <th>No.Tlp</th>
                                <th>Kategori</th>
                                <th>User</th>
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