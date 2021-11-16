@extends('layouts.main')
@section('title','Print Tracer | Modul Registrasi')
@section('menu-min','menu-min')
@section('monitoring_status','active')
@section('tracer','active')
@section('header','Print Tracer')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('tracer-print',['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Tujuan'=>Request::input('Tujuan')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print Semua dari Periode <?=Request::input('date1') !== null ? Request::input('date1') : date('d-m-Y')?> s/d <?=Request::input('date2') !== null ? Request::input('date2') : date('d-m-Y')?> </a>
            </div>
            <div class="panel-body no-padding">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> --}}
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#harian" aria-controls="harian" role="tab" data-toggle="tab">Harian</a>
                        </li>
                        <li><button class="btn btn-info btn-white btn-xs btn-round" type="button" id="resynBtn" style="float:right"><i class="fa fa-refresh"></i></button></li>
                    </ul>                    
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active row" id="harian">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                                <form action="{{Request::url()}}" method="get">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <!--div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Tujuan</label>
                                            <div class="input-group col-sm-9">
                                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                                <select name="Tujuan" id="pengobatan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                                    <option value="<?= Request::input('Tujuan') !== null ? Request::input('Tujuan') : Request::input('Tujuan') ?>">-= Tujuan =-</option>
                                                </select>
                                            </div>
                                        </div-->
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Poli</label>
                                            <div class="input-group col-sm-9">
                                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                                <select name="poli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                                    <option value="<?= Request::input('Poli') !== null ? Request::input('Poli') : Request::input('Poli') ?>">-= Poli =-</option>
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
                                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Cari</button>
                                                <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                                            </div>
                                        </div>
                                        <div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"></div>
                                </form>
                            </div>
                            <section>
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="overflow:auto;height:400px;">
                                    <div id="list-tracer"></div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="">
                                    <div id="preview-tracer"></div>
                                </div>
                            </section>
                        </div>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var load_time = 1;
    var tujuan = "{{ Request::input('Tujuan') }}"
    var poli = "{{ Request::input('Poli') }}"
    var date1 = "{{ Request::input('date1') }}"
    $(document).ready(function(){
        load_list(date1,poli,tujuan);
    });
    // ===================================
    function load_list(tanggal='',poli='',tujuan='') {
        $.ajax({
            url: "{{ route('tracer-list') }}",
            type: "GET",
            data: {date1:tanggal,poli:poli,tujuan:tujuan},
            beforeSend:function(){
                $('#list-tracer').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(resp){
                $('#list-tracer').html(resp);
            },
        });
    }
    var print_count = 0;
    function load_preview(regno='') {
        $.ajax({
            url: "{{ route('tracer-print-one') }}",
            type: "GET",
            data: {Regno:regno},
            beforeSend:function(){
                $('#preview-tracer').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(resp){
                $('#preview-tracer').html(resp);
                $("#preview-tracer").printThis({
                    afterPrint: function() {
                        $.post('{{ route('tracer-set-print-status') }}', {regno});
                        console.log('Print');
                    }
                });
                
            },
        });
    }
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