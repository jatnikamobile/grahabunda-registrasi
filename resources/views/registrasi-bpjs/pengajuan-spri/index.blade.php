@extends('layouts.main')
@section('title','Pengajuan SPRI Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('pengajuan_spri','active')
@section('header','Pengajuan SPRI Pasien BPJS')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('reg-bpjs-pengajuan-spri.form')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <section>
                    <table class="table table-bordered" id="table-list-pasien">
                        <thead>
                            <tr class="info">
                                <th>No Peserta/BPJS</th>
                                <th>Nama Pasien</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Nama Dokter</th>
                                <th>Tanggal Rencana Kontrol</th>
                                <th>No. SPRI</th>
                                <th>Nama Diagnosa</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($pengajuan_spri) > 0)
                                @foreach ($pengajuan_spri as $ps)
                                    <tr>
                                        <td>{{ $ps->no_kartu }}</td>
                                        <td>{{ $ps->nama }}</td>
                                        <td>{{ $ps->kelamin }}</td>
                                        <td>{{ $ps->tanggal_lahir }}</td>
                                        <td>{{ $ps->nama_dokter }}</td>
                                        <td>{{ $ps->tanggal_rencana_kontrol }}</td>
                                        <td>{{ $ps->no_spri }}</td>
                                        <td>{{ $ps->nama_diagnosa }}</td>
                                        <td>
                                            <a href="{{ Route('reg-bpjs-mutasi.form-edit') }}/{{ $ps->fppri ? $ps->fppri->Regno : '' }}" title="Buka form admission"><i class="fa fa-newspaper-o"></i></a>
                                            <a href="javascript:void(0)" title="Hapus SPRI" class="text-danger" onclick="confirmDeleteSPRI('{{ $ps->no_spri }}')"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $pengajuan_spri->links() }}
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function confirmDeleteSPRI(no_spri) {
    swal({
        title: 'SPRI ' + no_spri + ' akan dihapus. Yakin',
        text: "Setelah dihapus, data tidak bisa dikembalikan lagi!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{ Route('reg-bpjs-pengajuan-spri-req') }}",
                type: 'GET',
                dataType: 'JSON',
                data: {
                    action: 'delete-spri',
                    no_spri: no_spri
                },
                success: function (data) {
                    if (data.status == 'success') {
                        swal('SPRI ' + no_spri + ' berhasil dihapus!', {
                            icon: "success",
                        }).then(() => {
                            location.reload()
                        });
                    } else {
                        swal("Error!", data.message, "error");
                    }
                }
            })
        } else {
            swal("Hapus dibatalkan!");
        }
    });
}
</script>
