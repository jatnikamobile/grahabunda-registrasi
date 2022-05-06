<script src="/js/ws-client.js"></script>
<script type="text/javascript">
var perjanjian = "{{ $perjanjian ?: false }}"
var debug = "{{ $debug ?: false }}"
var time = 1;   
var arr_append = new Array();
var data_print = new Array();
var cancel_print = new Array();
var poli = "{{ Request::input('Poli') }}"
var date1 = "{{ Request::input('date1') }}"
var ws = new AntrianWS("{{ config('ws.host') }}:{{ config('ws.port') }}", 'tracer', 1, function(data) {
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
            <tr class="{{ $tracer }} {{ empty($l->DiPrint) ? 'danger' : ''}}" id="{{ $l->Regno }}" data-regno="{{ $l->Regno }}" data-status="{{ $l->DiPrint != null ? '2' : '1' }}">
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
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        // console.clear();
        var interval = 0;
        setInterval(function(){ $('#resynBtn').click(); console.log(interval++)}, 60000);

    });
    var tbl_no = "{{ $n != 0 ? $n : 0 }}";
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
                            // if(!debug){
                                print_tracer(data.Regno);
                            // }
                        }
                    }
                },
            });
        }
    }

    function print_tracer(regno) {
        setTimeout(function() {
            load_preview(regno);
            $("#"+regno).addClass("warning")
            document.getElementById(regno).scrollIntoView();
        }, 3500 * time);
        time++;
    }

    $("#resynBtn").on("click",function(){
        let btn = $('#resynBtn');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-refresh"></i> ' + btn.text());
        btn.prop('disabled', true);
        $.ajax({
            url: "{{ route('tracer-list') }}",
            type: "GET",
            data: {date1:date1,poli:poli,way:"data"},
            dataType:"JSON",
            success:function(resp){
                if(resp.stat){
                    data = resp.list;
                    data.forEach(d => {
                        if(!arr_append[d.Regno]){
                            ++tbl_no;
                            arr_append[d.Regno] = true;
                            $("#target_body_tracer").append(append_element(d)).fadeIn(3000);
                            print_tracer(d.Regno);
                        }
                    });
                }
                btn.prop('disabled', false);
                btn.html(oldText);
            },
        });
    });
</script>