@extends('layouts.main')
@section('title','Tanggal Pulang Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('menu_tanggal_pulang','active')
@section('header','Tanggal Pulang Pasien BPJS')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('update-tanggal-pulang-create')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
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
                                <th>No SEP</th>
                                <th>Status Pulang</th>
                                <th>No Surat Meninggal</th>
                                <th>Tanggal Meninggal</th>
                                <th>Tanggal Pulang</th>
                                <th>No LP Manual</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($tanggal_pulang) > 0)
                                @foreach ($tanggal_pulang as $tp)
                                    <tr>
                                        <td>{{ $tp->no_sep }}</td>
                                        <td>{{ $tp->status_pulang }}</td>
                                        <td>{{ $tp->no_surat_meninggal }}</td>
                                        <td>{{ $tp->tanggal_meninggal }}</td>
                                        <td>{{ $tp->tanggal_pulang }}</td>
                                        <td>{{ $tp->no_lp_manual }}</td>
                                        <td>{{ $tp->user }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $tanggal_pulang->links() }}
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
