@extends('layouts.main')
@section('title','Registrasi Pasien Umum | Modul Registrasi')
@section('register_umum','active')
@section('daftar_ps_umum','active')
@section('header','Registrasi Pasien Umum')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('reg-umum-daftar.form')}}" class="btn btn-success btn-sm">Tambah Data <i class="fa fa-plus"></i></a>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <section>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                        <form action="{{Request::url()}}" method="get">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">No Registrasi</label>
                                    <div class="input-group col-sm-5">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Regno" id="Regno" class="form-control input-sm" value="<?= Request::input('Regno') !== null ? Request::input('Regno') : Request::input('Regno') ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Rekam Medis</label>
                                    <div class="input-group col-sm-5">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Medrec" id="Medrec" class="form-control input-sm" value="<?= Request::input('Medrec') !== null ? Request::input('Medrec') : Request::input('Medrec') ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" value="<?= Request::input('Firstname') !== null ? Request::input('Firstname') : Request::input('Firstname') ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Poli</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Poli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="<?= Request::input('Poli') !== null ? Request::input('Poli') : Request::input('Poli') ?>">-= Poli =-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Berdasarkan Daftar</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="date1" id="date1" style="margin-right: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>"/>
                                        <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                                        <input type="date" name="date2" id="date2" style="margin-left: 10px;" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d')?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i>Cari</button>
                                <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                            </div>

                        </form>
                    </div>
                    <div class="col-sm-12"><hr></div>
                    <div style="overflow:auto;" class="col-sm-12">
                        <table class="table table-bordered" id="table-list-pasien" style="margin-top: 10px;">
                            <thead>
                                <tr class="info">
                                    <th>No</th>
                                    <th>No.Reg</th>
                                    <th>RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Registrasi</th>
                                    <th>Sex</th>
                                    <th>Kunjungan</th>
                                    <th>Cara Bayar</th>
                                    <th>Tujuan</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Kategori</th>
                                    <th>Perjanjian</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $n = $list->perPage() * ($list->currentPage() -1);
                                @endphp
                                @foreach($list as $key => $l)
                                @if($l->Deleted != '')
                                <tr class="danger">
                                @else
                                <tr>
                                @endif
                                    <td>{{ ++$n }}</td>
                                    <td>{{ $l->Regno }}</td>
                                    <td>{{ $l->Medrec }}</td>
                                    <td>{{ $l->Firstname }}</td>
                                    <td>{{ date('d/m/Y',strtotime($l->Regdate)) }}</td>
                                    <td>{{ $l->Sex }}</td>
                                    <td>{{ $l->Kunjungan }}</td>
                                    <td>{{ $l->NmKategori }}</td>
                                    <td>{{ $l->NMTuju }}</td>
                                    <td>{{ $l->NMPoli }}</td>
                                    <td>{{ $l->NmDoc }}</td>
                                    <td>{{ $l->NmKategori }}</td>
                                    @if($l->Perjanjian == 'true')
                                    <td>Perjanjian {{ date('d/m/Y',strtotime($l->Regdate)) }}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>{{ $l->ValidUser }}</td>
                                    @if($l->Deleted != '')
                                    <!-- <tr class="danger"> -->
                                        <td></td>
                                    @else
                                    <td><a href="{{ route('reg-umum-daftar.print-slip', ['noRegno'=>$l->Regno]) }}" target="_blank" title="Print Slip"><i class="fa fa-print"></i></a>
                                        <a href="{{ route('reg-umum-daftar.edit', [$l->Regno]) }}" title="Edit Pasien"> <i class="fa fa-pencil green"></i>
                                        </a>
                                        <a href="{{ route('reg-bpjs-daftar.form-edit', [$l->Regno]) }}" title="Pindah ke BPJS"><i class="fa fa-exchange orange"></i>
                                        </a>
                                        <a href="{{ route('mst-psn.form-delete') }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{$l->Regno}}').submit();" title="Hapus Pasien"> <i class="fa fa-trash red"></i>
                                        </a>
                                        <form id="delete-form-{{$l->Regno}}" action="{{ route('reg-umum-daftar-delete') }}" method="POST" style="display: none;">
                                        {{ method_field('DELETE') }} {{ csrf_field() }}
                                        <input type="hidden" name="Regno" id="Regno" value="{{$l->Regno}}">
                                       </form><!-- Delete Form -->
                                    </td>
                                    @endif
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'nama'=>Request::input('nama'),'poli'=>Request::input('poli'),'regno'=>Request::input('regno')])->links()}}    
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
    });
    $(".select2").select2();
    
    $('#poli').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.poli')}}",
            dataType: 'json',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KDPoli;
                        item.text = item.NMPoli;
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                    ${item.NMPoli}
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });
</script>
@endsection