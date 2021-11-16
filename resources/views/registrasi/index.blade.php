@extends('layouts.main')
@section('title','Registrasi Pasien | Modul Registrasi')
@section('register','active')
@section('pasien','active')
@section('header','Registrasi Pasien')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('register-print',['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Tujuan'=>Request::input('Tujuan'),'Kategori'=>Request::input('Kategori'),'GroupUnit'=>Request::input('GroupUnit'),'Unit'=>Request::input('Unit'),'korpUnit'=>Request::input('korpUnit'),'Dokter'=>Request::input('Dokter'),'Poli'=>Request::input('Poli')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print Registrasi</a>
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
                                    <label class="col-sm-3 control-label no-padding-right">No RM</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Medrec" id="Medrec" value="<?=Request::input('Medrec') !== null ? Request::input('Medrec') : ''?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Kategori</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Kategori" id="Kategori" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('Kategori') !== null ? Request::input('Kategori') : Request::input('Kategori') ?>">-= Kategori =-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">GroupUnit</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="GroupUnit" id="GroupUnit" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('GroupUnit') !== null ? Request::input('GroupUnit') : Request::input('GroupUnit') ?>">-= GroupUnit =-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Unit</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Unit" id="Unit" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('Unit') !== null ? Request::input('Unit') : Request::input('Unit') ?>">-= Unit =-</option>
                                        </select>
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">&emsp;</span>
                                        <select name="korpUnit" id="korpUnit" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6 select2">
                                            <option value="<?= Request::input('korpUnit') !== null ? Request::input('korpUnit') : Request::input('korpUnit') ?>">-= Sub Unit =-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label no-padding-right">Total Semua Pendaftaran</label>
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
                                    <th>Poli</th>
                                    <th>No.Registrasi</th>
                                    <th>Rekam Medis</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Registrasi</th>
                                    <th>Sex</th>
                                    <th>Kunjungan</th>
                                    <th>Cara Bayar</th>
                                    <th>Tujuan</th>
                                    <th>Dokter</th>
                                    <th>Kategori</th>
                                    <th>User</th>
                                    <th>Aksi</th>
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
                                        <td style="font-size:15px"><b>{{ $l->NMPoli }}</b></td>
                                        <td>{{ $l->Regno }}</td>
                                        <td>{{ $l->Medrec }}</td>
                                        <td>{{ $l->Firstname }}</td>
                                        <td>{{ date('d/m/Y',strtotime($l->Regdate)) }}</td>
                                        <td>{{ $l->Sex }}</td>
                                        <td>{{ $l->Kunjungan }}</td>
                                        <td>{{ $l->NMCbayar }}</td>
                                        <td>{{ $l->NMTuju }}</td>
                                        <td>{{ $l->NmDoc }}</td>
                                        <td>{{ $l->NmKategori }}</td>
                                        @if($l->ValidUpdate != '')
                                        <td>{{ $l->ValidUpdate }}</td>
                                        @else 
                                        <td>{{ $l->ValidUser }}</td>
                                        @endif

                                        @if($l->Deleted != '')
                                        <!-- <tr class="warning"> -->
                                            <td>Telah Dihapus</td>
                                        @else
                                        <td>
                                            <!-- Print Detail -->
                                            <a href="{{ route('mst-psn.print', ['Medrec' => $l->Medrec]) }}" target="_blank" title="Print Detail"><i class="fa fa-print"></i></a>
                                            <!-- Print Detail -->
                                            <a href="{{ route('file-status-keluar-label', ['RegnoStatus' => $l->Regno]) }}" title="Print Label"><i class="fa fa-inbox orange"></i></a>
                                            <!-- Print Kartu Pasien -->
                                            <a href="{{ route('mst-psn.print-kartu', ['Medrec' => $l->Medrec]) }}" target="_blank" title="Print Kartu Pasien"><i class="fa fa-credit-card"></i></a>
                                            <!-- Edit Pasien -->
                                            @if($l->StatusReg == 1)
                                            <a href="{{ route('reg-bpjs-daftar.form-edit', [$l->Regno]) }}" title="Edit Pasien"> <i class="fa fa-pencil green"></i></a>
                                            @else
                                            <a href="{{ route('reg-umum-daftar.edit', [$l->Regno]) }}" title="Edit Pasien"> <i class="fa fa-pencil green"></i></a>
                                            @endif
                                        </td>
                                        @endif
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Tujuan'=>Request::input('Tujuan'),'Kategori'=>Request::input('Kategori'),'GroupUnit'=>Request::input('GroupUnit'),'Unit'=>Request::input('Unit'),'korpUnit'=>Request::input('korpUnit'),'Dokter'=>Request::input('Dokter'),'Poli'=>Request::input('Poli'),'Medrec'=>Request::input('Medrec')])->links() }}
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
                   ${item.KdKategori} - ${item.NmKategori}
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
    $('#GroupUnit').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.group-unit')}}",
            dataType: 'json',
            data: function(params) {
                return {
                    ktg : $('#Kategori option:selected').val(),
                    q: params.term,
                    offset: (params.page || 0) * 20
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.GroupUnit;
                        item.text = item.GroupUnit;
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
                   ${item.GroupUnit}
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
    $('#Unit').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.unit-kategori')}}",
            dataType: 'json',
            data: function(params) {
                return {
                    ktg : $('#Kategori option:selected').val(),
                    group_ktg : $('#GroupUnit option:selected').val(),
                    q: params.term,
                    offset: (params.page || 0) * 20
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.NmUnit;
                        item.text = item.NmUnit;
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
                   ${item.NmUnit}
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
    $('#Unit').on('change', function() {
        $('#korpUnit').html("<option value=''>-= Sub Unit =-</option>");
        if ($('#GroupUnit option:selected').text() == 'DINAS') {
            // var list = document.getElementById("korpUnit");
            $('#korpUnit').html("<option value=''>-= Sub Unit =-</option><option value='1'>SUAMI</option><option value='2'>ISTRI</option><option value='3'>ANAK 1</option><option value='4'>ANAK 2</option><option value='5'>ANAK 3</option>");
        }
    });
</script>
@endsection