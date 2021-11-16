@extends('layouts.main')
@section('title','Registrasi Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('daftar_bpjs','active')
@section('header','Registrasi Pasien BPJS')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('reg-bpjs-daftar.form')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
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
                                    <label class="col-sm-3 control-label no-padding-right">No Registrasi</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Regno" id="Regno" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Regno') !== null ? Request::input('Regno') : Request::input('Regno') ?>"/>
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
                                <div>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Poli</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Poli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('Poli') !== null ? Request::input('Poli') : Request::input('Poli') ?>">-= Poli =-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Dokter</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Dokter" id="Dokter" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('Dokter') !== null ? Request::input('Dokter') : Request::input('Dokter') ?>">-= Dokter =-</option>
                                        </select>
                                        <div class="checkbox" style="display: table-cell;padding-left: 10px;">
                                            <label>
                                                <input type="checkbox" name="dpjp-only">
                                                <span class="lbl">Dokter DPJP</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Tujuan</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Tujuan" id="pengobatan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('Tujuan') !== null ? Request::input('Tujuan') : Request::input('Tujuan') ?>">-= Tujuan =-</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Berdasarkan Daftar</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="date1" id="date1" style="margin-right: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>"/>
                                        <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                                        <input type="date" name="date2" id="date2" style="margin-left: 10px;" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d')?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="pull-left">
                                <a href="{{route('reg-print',['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Poli'=>Request::input('Poli'), 'Dokter'=>Request::input('Dokter'), 'Tujuan'=>Request::input('Tujuan')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print Registrasi</a>
                                <a href="{{route('reg-print-lama',['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Poli'=>Request::input('Poli'), 'Dokter'=>Request::input('Dokter'), 'Tujuan'=>Request::input('Tujuan')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print Registrasi Pasien Lama</a>
                                <a href="{{route('reg-print-baru',['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Poli'=>Request::input('Poli'), 'Dokter'=>Request::input('Dokter'), 'Tujuan'=>Request::input('Tujuan')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print Registrasi Pasien Baru</a>
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
                                    <th>SEP</th>
                                    <th>Kd ICD</th>
                                    <th>Sex</th>
                                    <th>Kunjungan</th>
                                    <th>Cara Bayar</th>
                                    <th>Tujuan</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Ruang</th>
                                    <th>Kelas</th>
                                    <th>Jaminan</th>
                                    <th>Kategori</th>
                                    <th>User</th>
                                    <th>Perjanjian</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $l)
                                    @if($l->Deleted != '')
                                    <tr class="danger">
                                    @else
                                    <tr>
                                    @endif
                                        <td>{{ $l->NomorUrut }}</td>
                                        <td>{{ $l->Regno }}</td>
                                        <td>{{ $l->Medrec }}</td>
                                        <td>{{ $l->Firstname }}</td>
                                        <td>{{ date('d/m/Y',strtotime($l->Regdate)) }}</td>
                                        <td>{{ $l->NoSep }}</td>
                                        <td>{{ $l->KdIcd }}</td>
                                        <td>{{ $l->Sex }}</td>
                                        <td>{{ $l->Kunjungan }}</td>
                                        <td>{{ $l->NMCbayar }}</td>
                                        <td>{{ $l->NMTuju }}</td>
                                        <td>{{ $l->NMPoli }}</td>
                                        <td>{{ $l->NmDoc }}</td>
                                        <td>{{ $l->NmBangsal }}</td>
                                        <td>{{ $l->NMKelas }}</td>
                                        <td>{{ $l->NMJaminan }}</td>
                                        <td>{{ $l->NmKategori }}</td>
                                        @if($l->ValidUpdate != '')
                                        <td>{{ $l->ValidUpdate }}</td>
                                        @else 
                                        <td>{{ $l->ValidUser }}</td>
                                        @endif
                                        @if($l->Perjanjian == 'true')
                                        <td>Perjanjian {{ date('d/m/Y',strtotime($l->Regdate)) }}</td>
                                        @else
                                        <td></td>
                                        @endif

                                        @if($l->Deleted != '')
                                        <td></td>
                                        @else
                                        <td>@if($l->NoSep != '')<a href="{{ route('reg-bpjs-daftar.print-sep', ['Regno' => $l->Regno]) }}" target="_blank" class="btn-print"><i class="fa fa-print"></i>SEP</a>
                                            @endif
                                            <a href="{{ route('reg-bpjs-daftar.form-edit', [$l->Regno]) }}"> <i class="fa fa-pencil green"></i>
                                            </a>
                                            <a href="{{ route('reg-umum-daftar.edit', [$l->Regno]) }}" title="Pindah ke Umum"> <i class="fa fa-exchange orange"></i>
                                            </a>
                                            <form id="edit-form-{{$l->Regno}}" action="{{ route('reg-bpjs-daftar.form-edit') }}" method="POST" style="display: none;">
                                                {{ method_field('PUT') }} {{ csrf_field() }}
                                                <input type="hidden" name="Regno" id="Regno" value="{{$l->Regno}}">
                                            </form>
                                            <form action="{{ route('reg-bpjs-daftar-delete') }}" method="POST">
                                                {{ csrf_field() }}
                                            <input type="hidden" name="Regno" id="Regno" value="{{$l->Regno}}">
                                            <button type="submit" class="fa fa-trash"></button>
                                            {{-- <a href="{{ route('reg-bpjs-daftar-delete') }}"><i class="fa fa-trash"></i></a> --}}
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Firstname'=>Request::input('Firstname'),'MedRec'=>Request::input('MedRec'),'Regno'=>Request::input('Regno'),'Poli'=>Request::input('Poli')])->links() }}
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

    $('#poli').on('change', function() {
        $('[name=lamaPoli]').val($('#poli').val());
    });

    $('#Dokter').on('change', function() {
        $('[name=lamaDokter').val($('#Dokter').val());
    });

    $('#pengobatan').on('change', function() {
       $('[name=lamaKunjungan').val($('#pengobatan').val()); 
    });

    $('#date1').on('change', function() {
        $('[name=lamaDate1]').val($('#date1').val());
    });

    $('#date2').on('change', function() {
       $('[name=lamaDate2]').val($('#date2').val()); 
    });

    $(".select2").select2();
    
    $('#poli').select2({
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
    let kdPoli = '';
    $('#poli').on('select2:select', function(ev) {
        let data = ev.params.data;
        kdPoli = data.KDPoli;
        $('[name=KdPoliBpjs]').val(data.KdBPJS);;
    });
    $('#Dokter').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.dokter')}}",
            dataType: 'json',
            data: function(params) {
                return $.extend(params, {
                    kdPoli: kdPoli,
                    dpjpOnly: document.getElementsByName('dpjp-only')[0].checked ? 1 : 0,
                });
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KdDoc;
                        item.text = item.NmDoc;
                        return item;
                    }),
                    pagination: {
                        more: data.next_page_url
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
                    ${item.NmDoc} - ${item.KdDPJP}
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

    let KdDPJP = null;
    $('#Dokter').on('select2:select', function(ev){
        KdDPJP = ev.params.data.KdDPJP;
    });

    $('#pengobatan').select2({
        ajax: {
            // api/get_ppk
            url:"{{ route('api.select2.pengobatan') }}",
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
                        item.id = item.KDTuju;
                        item.text = item.NMTuju;
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

            return `<p>${item.NMTuju}</p>`;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });
</script>
@endsection