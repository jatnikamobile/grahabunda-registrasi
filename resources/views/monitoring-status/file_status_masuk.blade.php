@extends('layouts.main')
@section('title','Monitoring Status Masuk | Modul Registrasi')
@section('monitoring_status','active')
@section('file_status_masuk','active')
@section('header','Monitoring Status Masuk')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('file-status-masuk-print',['date1'=>Request::input('date1'),'date2'=>Request::input('date2')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print</a>
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
                            <input type="text" name="Medrec" id="Medrec" placeholder="No Rekam Medis" value="<?= Request::input('Medrec') !== null ? Request::input('Medrec') : Request::input('Medrec') ?>"/>
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
                                <th>Tgl Msk</th>
                                <th>Jam Msk</th>
                                <th>Keterangan</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Bayar</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $key => $l)
                            @if($l->status == '')
                            <tr style="background-color: rgba(255, 0, 0, 0.3);" data-id="{{ $l->regno }}" data-json="{{ json_encode($l) }}" id="list_data">
                            @else
                            <tr data-id="{{ $l->regno }}" data-json="{{ json_encode($l) }}" id="list_data">
                            @endif
                                <td>{{ $l->regno }}</td>
                                <td>{{ $l->medrec }}</td>
                                <td>{{ $l->firstname }}</td>
                                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                                <td>{{ substr($l->regtime,11,5) }}</td>
                                @if($l->tanggalmasuk == '')
                                <td></td>
                                <td></td>
                                @else
                                <td>{{ date('d/m/Y',strtotime($l->tanggalmasuk)) }}</td>
                                <td>{{ substr($l->jammasuk,11,5) }}</td>
                                @endif
                                <td>{{ $l->status }}</td>
                                <td>{{ $l->nmpoli }}</td>
                                <td>{{ $l->nmdoc }}</td>
                                <td>{{ $l->nmtuju }}</td>
                                <td>{{ $l->nmcbayar }}</td>
                                <td>{{ $l->validuser }}</td>
                                <td><button class="btn btn-primary btn-edit"><i class="fa fa-edit"></i></button></td>
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
                                <th>Tgl Msk</th>
                                <th>Jam Msk</th>
                                <th>Keterangan</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Bayar</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Firstname'=>Request::input('Firstname'),'Medrec'=>Request::input('Medrec'),'Regno'=>Request::input('Regno')])->links() }}
                </section>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-file-status" tabindex="-1" role="dialog" aria-labelledby="modal-file-status" aria-hidden="true" id="modal-file-status">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('file-status-masuk-post') }}" method="post">
                {{ csrf_field() }}
                <h5 class="modal-title" id="exampleModalLongTitle">File Status Keluar</h5>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No Registrasi:</label>
                        <input type="text" class="form-control" id="noRegno" name="noRegno" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No Rekam Medik:</label>
                        <input type="text" class="form-control" id="noMedrec" name="noMedrec" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama Pasien:</label>
                        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tanggal:</label>
                        <input type="date" class="form-control" id="no_tanggal" name="no_tanggal" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Jam:</label>
                        <input type="text" class="form-control" id="no_jam" name="no_jam" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Status:</label>
                        <div class="radio">
                            <label>
                                <input name="Status" type="radio" class="ace" value="1"/>
                                <span class="lbl">&nbsp; Status Kembali</span>
                            </label>
                            <label>
                                <input name="Status" type="radio" class="ace" value="2"/>
                                <span class="lbl">&nbsp; Mutasi Rawat Inap</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama Penjamin:</label>
                        <input type="text" class="form-control" id="NmPenjamin" name="NmPenjamin">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Bagian:</label>
                        <input type="text" class="form-control" id="noBagian" name="noBagian">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Keterangan:</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="save-status">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
    });

    $('#table-list-pasien').on("click", '.btn-edit', function(){
        let button = $(this);
        let tr = button.parents('tr');
        let data = JSON.parse(tr.attr('data-json'));
        $('#modal-file-status [name=noRegno]').val(data.regno);
        $('#modal-file-status [name=noMedrec]').val(data.medrec);
        $('#modal-file-status [name=nama_pasien]').val(data.firstname);
        $('#modal-file-status [name=no_tanggal]').val(data.regdate.substring(0,10));
        $('#modal-file-status [name=no_jam]').val(data.regtime.substring(11,16));
        if (data.nstatus != null) {
            $("#modal-file-status [name=Status][value=" + data.nstatus + "]").attr('checked', 'checked');
        }
        $('#modal-file-status [name=NmPenjamin]').val(data.namapeminjam);
        $('#modal-file-status [name=noBagian]').val(data.bagian);
        $('#modal-file-status [name=keterangan]').val(data.keterangan);
        
        $('#modal-file-status').modal('toggle');
    });
</script>
@endsection