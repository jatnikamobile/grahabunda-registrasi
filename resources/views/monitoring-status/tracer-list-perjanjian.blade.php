<script type="text/javascript">
    var perjanjian = "{{ $perjanjian ?: false }}"
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
    <tbody>
        @php
            // if(){
                // $n = $list->perPage() * ($list->currentPage() -1);
            // }else{
                $n = 0;
            // }
            $tracer = '';
            if(!$perjanjian){
                $tracer = 'tracer';
            }
        @endphp
        @foreach($list as $key => $l)
            <tr class="{{ $tracer }} {{ $l->DiPrint != '' ? 'bg-danger' : ''}}" id="{{ $l->Regno }}" data-regno="{{ $l->Regno }}" data-status="{{ $l->DiPrint != null ? '2' : '1' }}">
                <td>{{ ++$n }}</td>
                <td>{{ $l->NomorUrut }}</td>
                <td>{{ $l->Regno }}</td>
                <td>{{ $l->Medrec }}</td>
                <td>{{ $l->Firstname }}</td>
                <td>{{ $l->NMPoli }}</td>
                <td>
                    <button onclick="load_preview_perjanjian('{{ $l->Regno }}');" class="btn-print btn btn-xs btnPrintOne"><i class="fa fa-print"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    var time = 1;
    var data_print = new Array();
    var cancel_print = new Array();
    $(document).ready(function(){
        // if($("tr.tracer").length > 1){
        //     $("tr.tracer").each(function(index) {
        //         var regno = $(this).data('regno');
        //         var status = $(this).data('status');
        //         if(status == '1'){
        //             data_print[index] = regno; 
        //             cancel_print['reg_'+regno] = setTimeout(function() {
        //                 // console.log("print: "+regno);
        //                 load_preview(regno);
        //                 $("#"+regno).addClass("warning");
        //             }, 4000 * time);
        //             time ++;
        //             $("#"+regno).data("status","2");
        //         }
        //         if((index + 1) == $("tr.tracer").length){
        //             setTimeout(function() {
        //                 data_print.forEach(dp => {
        //                     // console.log("cancle print: "+cancel_print['reg_'+dp]);
        //                     clearTimeout(cancel_print['reg_'+dp]);
        //                 });
        //                 load_list(date1,poli,tujuan);
        //             }, 15000 * load_time);
        //         }
        //     });
        // }else{
        //     setTimeout(function() {
        //         load_list(date1,poli,tujuan);
        //     }, 15000 * load_time);
        // }
        // console.log("muatan data ke " + load_time);
        // load_time ++;
    });
    // $('.btnPrintOne').on('click', function(e) {
    //     e.preventDefault();
    //     regno = $(this).data('regno');
    //     load_preview(regno);
    // });
</script>
