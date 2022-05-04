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
