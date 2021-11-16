<table class="table table-bordered" id="table-list-pasien">
    <thead>
        <tr class="info">
            <th rowspan="2" style="text-align: center;">No</th>
            <th rowspan="2" style="text-align: center;">Rekam Medis</th>
            <th rowspan="2" style="text-align: center;">Registrasi</th>
            <th rowspan="2" style="text-align: center;">Nama</th>
            <th rowspan="2" style="text-align: center;">Poliklinik</th>
            <th colspan="8" style="text-align: center;">Status</th>
        </tr>
        <tr class="info">
            <th style="text-align: center;">Print</th>
            <th style="text-align: center;">User</th>
            <th style="text-align: center;">Keluar</th>
            <th style="text-align: center;">User</th>
            <th style="text-align: center;">Terima</th>
            <th style="text-align: center;">User</th>
        </tr>
    </thead>
    <tbody>
        @php
            $n = $list->perPage() * ($list->currentPage() -1);
        @endphp
        @foreach($list as $key => $l)
            <tr>
                <td>{{ ++$n }}</td>
                <td>{{ $l->Medrec }}</td>
                <td>{{ $l->Regno }}</td>
                <td>{{ $l->Firstname }}</td>
                <td>{{ $l->NMPoli }}</td>
                <td>{{ $l->DiPrint }}</td>
                <td>{{ $l->UserPrint }}</td>
                <td>{{ $l->Dikeluarkan }}</td>
                <td>{{ $l->UserKeluar }}</td>
                <td>{{ $l->Diterima }}</td>
                <td>{{ $l->UserTerima }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Rekam Medis</th>
            <th style="text-align: center;">Registrasi</th>
            <th style="text-align: center;">Nama</th>
            <th style="text-align: center;">Poliklinik</th>
            <th style="text-align: center;">Print</th>
            <th style="text-align: center;">User</th>
            <th style="text-align: center;">Keluar</th>
            <th style="text-align: center;">User</th>
            <th style="text-align: center;">Terima</th>
            <th style="text-align: center;">User</th>
        </tr>
    </tfoot>
    {{ $list->links() }}
</table>

<script>
    $(".pagination li a").on("click",function(e){
        e.preventDefault();
        var uri = this.href;
        $.ajax({
            url: uri,
            type: "POST",
            data: {
                _method:'PUT',
                date1: $('[name=date1]').val(),
                date2: $('[name=date2]').val()
            },
            beforeSend:function(){
                $('#table-status').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(resp){
                $('#table-status').html(resp);
            },
        });
    });
</script>