@extends('layouts.main')
@section('title','Master Dokter | Modul Registrasi')
@section('menu_master_dokter','active')
@section('header','Master Dokter')
@section('content')

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{ route('mst-dok.create') }}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                                <form action="{{ route('mst-dok.index') }}" method="get">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Kode Dokter</label>
                                            <div class="input-group col-sm-9">
                                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                                <input type="text" name="kode_dokter" id="kode_dokter" class="form-control input-sm col-xs-10 col-sm-5" value="{{ old('kode_dokter') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Nama Dokter</label>
                                            <div class="input-group col-sm-9">
                                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                                <input type="text" name="nama_dokter" id="nama_dokter" class="form-control input-sm col-xs-10 col-sm-5" value="{{ old('nama_dokter') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Kode DPJP</label>
                                            <div class="input-group col-sm-9">
                                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                                <input type="text" name="kode_dpjp" id="kode_dpjp" class="form-control input-sm col-xs-10 col-sm-5" value="{{ old('kode_dpjp') }}">
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Cari</button>
                                            <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <hr>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:auto;">
                            <table class="table table-bordered" id="table-list-dokter">
                                <thead>
                                    <tr class="info">
                                        <th>No</th>
                                        <th>Kode Dokter</th>
                                        <th>Kode DPJP</th>
                                        <th>Nama Dokter</th>
                                        <th>Kategori</th>
                                        <th>Spesialis</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Kode Pos</th>
                                        <th>No.Tlp</th>
                                        <th>Poli</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($ft_dokter) > 0)
                                        @foreach ($ft_dokter as $row => $ftd)
                                            <tr>
                                                <td>{{ $row + 1 }}</td>
                                                <td>{{ $ftd->KdDoc }}</td>
                                                <td>{{ $ftd->KdDPJP }}</td>
                                                <td>{{ $ftd->NmDoc }}</td>
                                                <td>{{ $ftd->Kategori }}</td>
                                                <td>{{ $ftd->Spesialis }}</td>
                                                <td>{{ $ftd->Sex }}</td>
                                                <td>{{ $ftd->Address }}</td>
                                                <td>{{ $ftd->KdPos }}</td>
                                                <td>{{ $ftd->Phone }}</td>
                                                <td>{{ $ftd->NmPoli }}</td>
                                                <td>{{ $ftd->Validuser }}</td>
                                                <td>
                                                    <a href="{{ route('mst-dok.edit', ['id' => $ftd->KdDoc]) }}"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:void(0)" onclick="deleteDokter('{{ $ftd->KdDoc }}')"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Dokter</th>
                                        <th>Kode DPJP</th>
                                        <th>Nama Dokter</th>
                                        <th>Kategori</th>
                                        <th>Spesialis</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Kode Pos</th>
                                        <th>No.Tlp</th>
                                        <th>Poli</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>
@endsection

@section('script')
<script>
    $('document').ready(function () {
        $('#table-list-dokter').dataTable()
    })

    function deleteDokter(id) {
        if (confirm('Dokter akan dihapus. Yakin?')) {
            $.ajax({
                url: "{{ route('mst-dok.destroy', ['id' => $ftd->KdDoc]) }}",
                type: 'DELETE',
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'success') {
                        alert('Data berhasil dihapus')
                        location.href = "{{ route('mst-dok.index') }}"
                    } else {
                        alert('Data gagal dihapus. ' + data.message)
                    }
                }
            })
        }
    }
</script>
@endsection