@extends('layouts.main')
@section('title','Beranda | Modul Registrasi')
@section('menu_beranda','active')
@section('header','Beranda')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"><button class="btn btn-sm btn-round btn-info" id="send_data"><i class="fa fa-upload"></i></button></div>
        </div>
    </div>
</div>

<script src="<?=asset('/js/ws-client.js')?>"></script>
<script>
  // init web shocket
  let ws = new AntrianWS("{{ config('ws.host') }}:{{ config('ws.port') }}", 'tracer', 1, function(data) {
    // if(data.type == 'broadcast') { console.log(data);}
  });
  ws.init();
  
  // send data web shocket
  function push_print(regno) {
    if(ws) { ws.broadcast( {command: 'print', parameters: {regno: regno}},{ tracer:1 }); };
  }

  $("#send_data").on("click",function(){
    //00940398, 00939757, 00939768
    var regno = '00939742';
    push_print(regno);
  });
</script>
@endsection