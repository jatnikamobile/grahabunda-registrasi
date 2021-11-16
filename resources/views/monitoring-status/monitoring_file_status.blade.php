@extends('layouts.main')
@section('title','Monitoring File Status | Modul Registrasi')
@section('monitoring_status','active')
@section('monitoring_file_status','active')
@section('header','Monitoring File Status')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('monitoring-status-print',['date1'=>Request::input('date1'),'date2'=>Request::input('date2')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print</a>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <section>
                    <div class="input-group col-sm-12">
                        <form action="{{Request::url()}}" method="get">
                            <input type="text" name="Regno" id="Regno" placeholder="No Registrasi" style="margin-right: 10px;" value="<?= Request::input('Regno') !== null ? Request::input('Regno') : Request::input('Regno') ?>"/>
                            <input type="text" name="Medrec" id="Medrec" placeholder="Rekam Medis" value="<?= Request::input('Medrec') !== null ? Request::input('Medrec') : Request::input('Medrec') ?>"/>
                            <input type="text" name="Firstname" id="Firstname" placeholder="Nama" value="<?= Request::input('Firstname') !== null ? Request::input('Firstname') : Request::input('Firstname') ?>"/>
                            <input type="date" name="date1" id="date1" style="margin-left: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>" />
                            <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                            <input type="date" name="date2" id="date2" style="margin-left: 10px;" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d')?>" />
                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                            <div class="pull-right"><a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a></div>
                        </form>
                    </div>
                    <table class="table table-bordered" id="table-list-pasien" style="margin-top: 10px;">
                        <thead>
                            <tr class="info">
                                <th>No.Reg</th>
                                <th>RM</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Reg</th>
                                <th>Jam Reg</th>
                                <th>Tgl Klr</th>
                                <th>Jam Klr</th>
                                <th>Keterangan</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Bayar</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $key => $l)
                                <td>{{ $l->regno }}</td>
                                <td>{{ $l->medrec }}</td>
                                <td>{{ $l->firstname }}</td>
                                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                                <td>{{ date('H:i:s',strtotime($l->regtime)) }}</td>
                                @if($l->tanggalkeluar == '')
                                <td></td>
                                <td></td>
                                @else
                                <td>{{ date('d/m/Y',strtotime($l->tanggalkeluar)) }}</td>
                                <td>{{ date('H:i:s',strtotime($l->jamkeluar)) }}</td>
                                @endif
                                <td>{{ $l->status }}</td>
                                <td>{{ $l->nmpoli }}</td>
                                <td>{{ $l->nmdoc }}</td>
                                <td>{{ $l->nmtuju }}</td>
                                <td>{{ $l->nmcbayar }}</td>
                                <td>{{ $l->validuser }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.Reg</th>
                                <th>RM</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Reg</th>
                                <th>Jam Reg</th>
                                <th>Tgl Klr</th>
                                <th>Jam Klr</th>
                                <th>Keterangan</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Bayar</th>
                                <th>User</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Firstname'=>Request::input('Firstname'),'Medrec'=>Request::input('Medrec'),'Regno'=>Request::input('Regno')])->links() }}
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