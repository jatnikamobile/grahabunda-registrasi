@extends('layouts.main')
@section('title','Registrasi Pasien | Modul Registrasi')
@section('register','active')
@section('pasien','active')
@section('header','Registrasi Pasien')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
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
                                    <label class="col-sm-3 control-label no-padding-right">Berdasarkan No. RM</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="medrec" id="Medrec" style="margin-right: 10px;"
                                        value="<?= Request::input('medrec') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Total</label>
                                    <div class="input-group col-sm-3">
                                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">{{ $total }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Poli</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="poli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('poli') !== null ? Request::input('poli') : Request::input('poli') ?>">-= Poli =-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Berdasarkan Daftar</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="Tanggal" id="Tanggal" style="margin-right: 10px;" value="<?=Request::input('Tanggal') !== null ? Request::input('Tanggal') : date('Y-m-d')?>"/>
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
                                    <th>Rekam Medis</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Registrasi</th>
                                    <th>Poli</th>
                                    <th>Kategori</th>
                                    <th>Pembatalan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($list)
                                @foreach($list as $key => $l)
                                    <tr>
                                        <td>{{ $l->urutanpasienke }}</td>
                                        <td>{{ $l->no_rm_pas_reg }}</td>
                                        <td>{{ $l->nm_pas }}</td>
                                        <td>{{ date('d/m/Y',strtotime($l->tgl_awal_reg)) }}</td>
                                        <td>{{ $l->nm_sub }}</td>
                                        <td>{{ $l->tni_bpjs }}</td>
                                        <td><form method="POST" action={{ route('pembatalan.pasien')}}>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id_reg" value="{{ $l->id_register }}">
                                            <button type="submit" class="btn btn-danger" title="Pembatalan Pasien"><i class="fa fa-trash"></i></button>
                                        </form></td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        
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
</script>
@endsection