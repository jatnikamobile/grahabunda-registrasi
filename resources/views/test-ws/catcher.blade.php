@extends('layouts.main')
@section('title','Beranda | Modul Registrasi')
@section('menu_beranda','active')
@section('header','Beranda')
@section('content')
<script src="<?=asset('public/js/ws-client.js')?>"></script>
<script>
let arr_append = new Array();
let ws = new AntrianWS("{{ config('ws.host') }}:{{ config('ws.port') }}", 'tracer', 1, function(data) {
    if(data.type == 'broadcast') {
        var {data, sender} = data;
        if(sender.type == 'tracer'){
            if(data.command == 'print') {
                append_data(data.parameters);
            }
        }
    }
});
ws.init();
function push_to_array(regno) { arr_append[regno] = true; }
</script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <table class="table table-bordered" id="table-list-pasien">
                    <thead>
                        <tr class="info">
                            <th>No</th>
                            <th>Nomor Antrian</th>
                            <th>Registrasi</th>
                            <th>Rekam Medis</th>
                            <th>Nama Pasien</th>
                            <th>Poliklinik</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="target_body_tracer">
                        @php
                            $n = 0;
                            $tracer = '';
                            if(!$perjanjian){
                                $tracer = 'tracer';
                            }
                        @endphp
                        @foreach($list as $key => $l)
                            <tr class="{{ $tracer }} {{ $l->DiPrint != '' ? 'warning' : ''}}" id="{{ $l->Regno }}" data-regno="{{ $l->Regno }}" data-status="{{ $l->DiPrint != null ? '2' : '1' }}">
                                <td>{{ ++$n }}</td>
                                <td>{{ $l->NomorUrut }}</td>
                                <td>{{ $l->Regno }}</td>
                                <td>{{ $l->Medrec }}</td>
                                <td>{{ $l->Firstname }}</td>
                                <td>{{ $l->NMPoli }}</td>
                                <td>
                                    <button onclick="load_preview('{{ $l->Regno }}');" class="btn-print btn btn-xs btnPrintOne"><i class="fa fa-print"></i></button>
                                </td>
                            </tr>
                            <script>push_to_array('{{ $l->Regno }}')</script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    console.clear();
    function append_element(l) {
        status = l.DiPrint != null ? '2' : '1';
        label = status != '1' ? 'warning' : '';
        trappend = '<tr class="tracer '+label+'" id="'+l.Regno+'" data-regno="'+l.Regno+'" data-status="'+status+'">'+
                    '<td>'+tbl_no+'</td>'+
                    '<td>'+l.NomorUrut+'</td>'+
                    '<td>'+l.Regno+'</td>'+
                    '<td>'+l.Medrec+'</td>'+
                    '<td>'+l.Firstname+'</td>'+
                    '<td>'+l.NMPoli+'</td>'+
                    '<td><button onclick="load_preview(\''+l.Regno+'\');" class="btn-print btn btn-xs btnPrintOne"><i class="fa fa-print"></i></button>'+
                    '</td></tr>';
        return trappend;
    }
    var tbl_no = "{{ $n != 0 ? $n : 0 }}";
    function append_data(data){
        regno = data.regno !== null ? data.regno : '';
        if(regno != ''){
            $.ajax({
                url: "{{ route('tracer-print-one') }}",
                type: "GET",
                data: {Regno:regno,way:'data'},
                dataType:"JSON",
                success:function(resp){
                    // console.log(resp);
                    data = resp.data;
                    if(resp.stat){
                        if(!arr_append[data.Regno]){
                            ++tbl_no;
                            arr_append[data.Regno] = true;
                            $("#target_body_tracer").append(append_element(data)).fadeIn(3000);
                        }
                    }
                },
            });
        }
    }
</script>
@endsection