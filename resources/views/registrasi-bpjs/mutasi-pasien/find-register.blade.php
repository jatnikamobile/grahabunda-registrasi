<table class="table table-bordered table-hover" id="table-list-cari-pasien">
        <thead>
            <tr>
                <th>No Registrasi</th>
                <th>Tgl Registrasi</th>
                <th>No Rekam Medis</th>
                <th>Nama Pasien</th>
                <th>No Peserta</th>
                <th>Kategori</th>
                <th>TglLahir</th>
                <th>Sex</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>KodePos</th>
                <th>Telp</th>
            </tr>
        </thead>
        <tbody>
        @php
        $n = $list->perPage() * ($list->currentPage() -1);
        @endphp
        @foreach($list as $key => $l)
            <tr data-regno="{{ $l->Regno }}" id="pasien_{{ $l->Regno }}" ondblclick="get_data('#'+this.id)" style="cursor:pointer;">
                {{-- <td>{{ ++$n }}</td> --}}
                <td>{{ $l->Regno }}</td>
                <td>{{ date('d-m-Y',strtotime($l->Regdate)) }}</td>
                <td>{{ $l->Medrec }}</td>
                <td>{{ $l->Firstname }}</td>
                <td>{{ $l->NoPeserta }}</td>
                <td>{{ $l->NmKategori }}</td>
                <td>{{ date('d-m-Y',strtotime($l->Bod)) }}</td>
                <td>{{ $l->Sex }}</td>
                <td>{{ $l->Address }}</td>
                <td>{{ $l->City }}</td>
                <td>{{ $l->KdPos }}</td>
                <td>{{ $l->Phone }}</td>
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
                    medrec: $('[name=pa_Medrec]').val(),
                    notelp: $('[name=pa_Phone]').val(),
                    nama: $('[name=pa_Firstname]').val(),
                    alamat: $('[name=pa_Address]').val(),
                    nopeserta: $('[name=pa_noPeserta]').val(),
                    tgl_lahir: $('[name=pa_Tgl_lahir]').val(),
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
            $('#Regno').val(data.regno);
            $('.bd-example-modal-lg-pasien').modal('hide');
            $('#btnCari').click();
        }
    </script>