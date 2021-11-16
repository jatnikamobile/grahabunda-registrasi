<table class="table table-bordered table-hover" id="table-list-cari-pasien">
    <thead>
        <tr>
            <th>Regno</th>
            <th>Tgl Registrasi</th>
            <th>No Rekam Medis</th>
            <th>Nama Pasien</th>
            <th>No SEP</th>
            <th>No Kartu</th>
            <th>Dokter</th>
            <th>Poli</th>
        </tr>
    </thead>
    <tbody>
    @foreach($list as $key => $l)
        <tr data-medrec="{{ $l->NoSep }}" id="pasien_{{ $l->NoSep }}" ondblclick="get_data('#'+this.id)" style="cursor:pointer;">
            <td>{{ $l->Regno }}</td>
            <td>{{ date('d-m-Y',strtotime($l->Regdate)) }}</td>
            <td>{{ $l->Medrec }}</td>
            <td>{{ $l->Firstname }}</td>
            <td>{{ $l->NoSep }}</td>
            <td>{{ $l->NoPeserta }}</td>
            <td>{{ $l->NmDoc }}</td>
            <td>{{ $l->NMPoli }}</td>
        </tr>
    @endforeach
    </tbody>
    {{ $list->links() }}
</table>

<script>
    $(".pagination li a").on("click",function(e){
        e.preventDefault();
        // var tanggal = $("#TanggalTransaksi").val() != '' ? $("#TanggalTransaksi").val() : '';
        var uri = this.href;
        $.ajax({
            url: uri,
            type: "POST",
            data: {
                _method:'PUT',
                nama: $('[name=pa_Firstname]').val(),
                medrec: $('[name=pa_Medrec]').val(),
                date1: $('[name=date1]').val(),
                date2: $('[name=date2]').val()
            },
            beforeSend:function(){
                $('#target_cari_pasien').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(resp){
                $('#target_cari_pasien').html(resp);
            },
        });
    });
    
    function get_data(node){
        var data = $(node).data();
        console.log(data);
        $('#NoSep').val(data.NoSep);
        $('.bd-example-modal-lg-caripasien').modal('hide');
        $('#btnCari').click();
    }
</script>