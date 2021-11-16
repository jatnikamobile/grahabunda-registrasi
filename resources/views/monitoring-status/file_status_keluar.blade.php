@extends('layouts.main')
@section('title','Monitoring Status Keluar | Modul Registrasi')
@section('monitoring_status','active')
@section('file_status_keluar','active')
@section('header','Monitoring Status Keluar')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('file-status-keluar-print',['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Poli'=>Request::input('Poli')])}}" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print Semua</a>
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
                            <select name="Poli" id="Poli" style="width: 150px;">
		                        <option value="<?= Request::input('Poli') !== null ? Request::input('Poli') : Request::input('Poli') ?>">-= Poli =-</option>
		                    </select>
                            <input type="date" name="date1" id="date1" style="margin-left: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>" />
                            <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                            <input type="date" name="date2" id="date2" style="margin-left: 10px;" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d')?>" />
                            <button type="submit" class="btn btn-info btn-sm" name="cari" value="Cari"><i class="fa fa-search"></i></button>
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
                                <th>Tgl Klr</th>
                                <th>Jam Reg</th>
                                <th>Jam Klr</th>
                                <th>Kunjungan</th>
                                <th>NoUrut</th>
                                <th>Print</th>
                                <th>R Rawat</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Cara Bayar</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $key => $l)
                            @if($l->validuser == '')
                            <tr style="background-color: rgba(255, 0, 0, 0.3);" data-id="{{ $l->regno }}" data-json="{{ json_encode($l) }}" id="list_data">
                            @else
                            <tr data-id="{{ $l->regno }}" data-json="{{ json_encode($l) }}" id="list_data">
                            @endif
                                <td>{{ $l->regno }}</td>
                                <td>{{ $l->medrec }}</td>
                                <td>{{ $l->firstname }}</td>
                                @if($l->tanggalkeluar == '')
                                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                                <td></td>
                                <td>{{ substr($l->regtime,11,5) }}</td>
                                <td></td>
                                @else
                                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                                <td>{{ date('d/m/Y',strtotime($l->tanggalkeluar)) }}</td>
                                <td>{{ substr($l->regtime,11,5) }}</td>
                                <td>{{ substr($l->jamkeluar,11,5) }}</td>
                                @endif
                                <td>{{ $l->kunjungan }}</td>
                                <td>{{ $l->nomorurut }}</td>
                                <td>{{ $l->prn }}</td>
                                <td>{{ $l->nmbangsal }}</td>
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
                                <th>Tgl Klr</th>
                                <th>Jam Reg</th>
                                <th>Jam Klr</th>
                                <th>Kunjungan</th>
                                <th>NoUrut</th>
                                <th>Print</th>
                                <th>R Rawat</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Cara Bayar</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Firstname'=>Request::input('Firstname'),'Medrec'=>Request::input('Medrec'),'Regno'=>Request::input('Regno'),'Poli'=>Request::input('Poli')])->links() }}
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-file-status" tabindex="-1" role="dialog" aria-labelledby="modal-file-status" aria-hidden="true" id="modal-file-status">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('file-status-keluar-post') }}" method="post">
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
                                <input name="Status" type="radio" class="ace" value="1" checked />
                                <span class="lbl">&nbsp; Diambil/Diantar Langsung ke Poli</span>
                            </label>
                            <label>
                                <input name="Status" type="radio" class="ace" value="2"/>
                                <span class="lbl">&nbsp; Diambil/Diantar Langsung ke Rawat Inap</span>
                            </label>
                            <label>
                                <input name="Status" type="radio" class="ace" value="3"/>
                                <span class="lbl">&nbsp; Dipinjam</span>
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
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Kategori:</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="Kategori" id="Kategori">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href=".modal-slip" data-toggle="modal" data-target=".modal-slip" class="btn btn-primary"><i class="fa fa-print"></i>Print Label</a>
                    <a href="{{ route('file-status-keluar-slip-monitoring') }}" class="btn btn-primary linkroute" target="_blank"><i class="fa fa-print"></i> Print Slip</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="save-status">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-slip" tabindex="-1" role="dialog" aria-labelledby="modal-slip" aria-hidden="true" id="modal-slip">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('file-status-keluar-label') }}" method="get" target="_blank">
                <h5 class="modal-title" id="exampleModalLongTitle">Print</h5>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Status:</label>
                        <input type="text" class="form-control" id="RegnoStatus" name="RegnoStatus" readonly>
                        <div class="radio">
                            <label>
                                <input name="Label" type="radio" class="ace" value="24" checked />
                                <span class="lbl">&nbsp; 24 Label</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-sm" name="print" value="Print"><i class="fa fa-print"></i> Print</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    $(".select2").select2();
    $('#Poli').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.poli')}}",
            dataType: 'json',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KDPoli;
                        item.text = item.NMPoli;
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                    ${item.NMPoli}
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });
    $('#Kategori').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.kategori-pasien')}}",
            dataType: 'json',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KdKategori;
                        item.text = item.NmKategori;
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                   ${item.NmKategori}
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
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
        if (data.nmunit == null) {
            $newnmunit = 'ASKES';
            var $kategori = $("<option selected></option>").val(data.kategori).text(data.nmkategori + " - " + $newnmunit);
        }else{
            var $kategori = $("<option selected></option>").val(data.kategori).text(data.nmkategori + " - " + data.nmunit);
        }
        $('#modal-file-status [name=Kategori]').append($kategori).trigger('change');
        $('#modal-file-status [name=NmPenjamin]').val(data.namapeminjam);
        $('#modal-file-status [name=noBagian]').val(data.bagian);
        $('#modal-file-status [name=keterangan]').val(data.keterangan);
        $('#modal-slip [name=RegnoStatus]').val(data.regno);

        $('#modal-file-status .linkroute').attr('href', '{{ route('file-status-keluar-slip-monitoring') }}?noRegno='+data.regno);
        
        $('#modal-file-status').modal('toggle');
    });

</script>
@endsection