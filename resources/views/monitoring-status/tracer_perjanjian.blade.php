@extends('layouts.main')
@section('title','Print Tracer Perjanjian | Modul Registrasi')
@section('menu-min','menu-min')
@section('monitoring_status','active')
@section('tracer-perjanjian','active')
@section('header','Print Tracer Perjanjian')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-body no-padding">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> --}}
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" class="active"><a href="#perjanjian" aria-controls="perjanjian" role="tab" data-toggle="tab">Perjanjian</a></li>                    
                    </ul>                    
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active row" id="perjanjian">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                                <form action="" method="get" id="find-perjanjian">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Poli</label>
                                            <div class="input-group col-sm-9">
                                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                                <select name="poli_perjanjian" id="poli_perjanjian" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                                    
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
                                                <input type="date" name="date1_perjanjian" id="date1_perjanjian" style="margin-right: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>"/>
                                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Cari</button>
                                                <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                                                <!-- <button id="print_all" type="button" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Print Semua</button> -->
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
                                    <div id="list-tracer-perjanjian"></div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="">
                                    <div id="preview-tracer-perjanjian"></div>
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
    });
    // =====================================
    function load_list_perjanjian(tanggal='',poli='') {
        $.ajax({
            url: "{{ route('tracer-list') }}",
            type: "GET",
            data: {date1:tanggal,poli:poli,perjanjian:true},
            beforeSend:function(){
                $('#list-tracer-perjanjian').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(resp){
                setTimeout(() => {
                    $('#list-tracer-perjanjian').html(resp);
                }, 6000);
            },
        });
    }
    function load_preview_perjanjian(regno='') {
        $.ajax({
            url: "{{ route('tracer-print-one') }}",
            type: "GET",
            data: {Regno:regno},
            beforeSend:function(){
                $('#preview-tracer-perjanjian').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(resp){
                $('#preview-tracer-perjanjian').html(resp);
                $("#preview-tracer-perjanjian").printThis();
            },
        });
    }

    $("#find-perjanjian").on("submit",function(e){
        e.preventDefault();
        poli = $("#poli_perjanjian").val();
        tanggal = $("#date1_perjanjian").val();
        load_list_perjanjian(tanggal,poli);
    });

    $('#date1').on('change', function() {
        $('[name=lamaDate1]').val($('#date1').val());
    });

    $('#date2').on('change', function() {
       $('[name=lamaDate2]').val($('#date2').val()); 
    });

    $(".select2").select2();

    $('#poli_perjanjian').select2({
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

    $("#print_all").on("click",function(){
        var date = $('#date1_perjanjian').val();
        url = "<?= url('Monitoring/Tracer/print-all?perjanjian=true&date1=') ?>"+date;
        window.open(url,'_blank');
    });
</script>
@endsection