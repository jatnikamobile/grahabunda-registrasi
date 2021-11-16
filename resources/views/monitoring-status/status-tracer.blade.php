@extends('layouts.main')
@section('title','Status Tracer | Modul Registrasi')
@section('monitoring_status','active')
@section('status_tracer','active')
@section('header','Status Tracer')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
            </div>
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab2" data-toggle="tab">Keluar</a></li>
                    <li><a href="#tab3" data-toggle="tab">Terima</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab2">
                        <form id="keluar" class="form-inline">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> Print <br> Keluar</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="printKeluar" id="printKeluar" placeholder="No Registrasi"/>
                                    <button type="submit" class="btn btn-warning btn-sm" id="btnScanKeluar" style="margin-left: 10px;"><i class="ace-icon fa fa-barcode"></i>Scan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <form id="terima" class="form-inline">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> Print Terima</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="printTerima" id="printTerima" placeholder="No Registrasi"/>
                                    <button type="submit" class="btn btn-success btn-sm" id="btnScanTerima" style="margin-left: 10px;"><i class="ace-icon fa fa-barcode"></i>Scan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                        <form id="cariPrintnan">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Tanggal Print</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="date1" id="date1" style="margin-right: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <button type="submit" class="btn btn-info btn-sm" name="btnCari" id="btnCari"><i class="fa fa-search"></i> Cari</button>
                                <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
                <section>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:auto;" id="table-status">
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

    $('#cariPrintnan').submit(function(ev) {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('status-tracer.find') }}",
            type: "PUT",
            data: {
                _method : 'PUT',
                date1: $('[name=date1]').val()
            },
            beforeSend(){
                $('#table-status').html('<div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success: function(response){
                $('#table-status').html(response);
            }
        });
    });


    $('[name=printSiap]').keyup(function() {
        if ($(this).val().length == 8 ){
            $('#siap').submit();
        }
    });
    $('#siap').submit(function(ev) {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('status-tracer.siap') }}",
            type: "POST",
            data: {
                siap: $('[name=printSiap]').val()
            },
            beforeSend(){
                $('#table-status').html('<div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success: function(response){
                if (response == 0) {
                    $('#btnCari').click();
                    alert('Nomor Registrasi kosong');
                } else {
                    $('#btnCari').click();
                    $('[name=printSiap]').val('');
                }
            }
        });
    });

    $('[name=printKeluar]').keyup(function() {
        if ($(this).val().length == 8 ){
            $('#keluar').submit();
        }
    });
    $('#keluar').submit(function(ev) {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('status-tracer.keluar') }}",
            type: "POST",
            data: {
                keluar: $('[name=printKeluar]').val()
            },
            beforeSend(){
                $('#table-status').html('<div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success: function(response){
                if (response == 0) {
                    $('#btnCari').click();
                    alert('Nomor Registrasi kosong');
                } else {
                    $('#btnCari').click();
                    $('[name=printKeluar]').val('');
                }
            }
        });
    });


    $('[name=printTerima]').keyup(function() {
        if ($(this).val().length == 8 ){
            $('#terima').submit();
        }
    });
    $('#terima').submit(function(ev) {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('status-tracer.terima') }}",
            type: "POST",
            data: {
                terima: $('[name=printTerima]').val()
            },
            beforeSend(){
                $('#table-status').html('<div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success: function(response){
                if (response == 0) {
                    $('#btnCari').click();
                    alert('Nomor Registrasi kosong');
                } else {
                    $('#btnCari').click();
                    $('[name=printTerima]').val('');
                }
            }
        });
    });
</script>
@endsection