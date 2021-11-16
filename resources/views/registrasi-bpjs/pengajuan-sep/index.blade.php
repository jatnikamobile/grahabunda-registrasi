@extends('layouts.main')
@section('title','Pengajuan SEP Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('pengajuan_sep','active')
@section('header','Pengajuan SEP Pasien BPJS')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('reg-bpjs-pengajuan.form')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
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
                                    <th>Tanggal</th>
                                    <th>Nama Pasien</th>
                                    <th>Pelayan</th>
                                    <th>Keterangan</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $l)
                                    <tr>
                                        <td>{{ $l->NoPeserta }}</td>
                                        <td>{{ date('d/m/Y',strtotime($l->Tanggal)) }}</td>
                                        <td>{{ $l->firstname }}</td>
                                        @if($l->Pelayanan == '1')
                                        <td>Rawat Inap</td>
                                        @elseif($l->Pelayanan == '2')
                                        <td>Rawat Jalan</td>
                                        @endif
                                        <td>{{ $l->Keterangan}}</td>
                                        <td>{{ $l->Validuser }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{ $list->links() }}
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
