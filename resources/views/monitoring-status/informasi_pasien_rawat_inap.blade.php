@extends('layouts.main')
@section('title','Informasi Pasien Rawat Inap | Modul Registrasi')
@section('monitoring_status','active')
@section('informasi_pasien_dirawat','active')
@section('header','Informasi Pasien Rawat Inap')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <section>
                    <div class="input-group col-sm-12">
                        <form action="{{Request::url()}}" method="get">
                            <input type="text" name="Firstname" id="Firstname" placeholder="Nama" style="margin-right: 10px;" value="<?= Request::input('Firstname') !== null ? Request::input('Firstname') : Request::input('Firstname') ?>" />
                            <input type="text" name="Alamat" id="Alamat" placeholder="Alamat" value="<?= Request::input('Alamat') !== null ? Request::input('Alamat') : Request::input('Alamat') ?>"/>
                            <input type="hidden" name="date1" id="date1" style="margin-left: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>"/>
                            <select name="Bangsal" id="Bangsal" style="width: 250px;">
                                <option value="<?= Request::input('Bangsal') !== null ? Request::input('Bangsal') : Request::input('Bangsal') ?>">-= Ruang Rawat =-</option>
                            </select>
                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                            <div class="pull-right"><a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a></div>
                        </form>
                    </div>
                    <table class="table table-bordered" id="table-list-pasien" style="margin-top: 10px;">
                        <thead>
                            <tr class="info">
                                <th>No</th>
                                <th>No.Reg</th>
                                <th>RM</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Msk</th>
                                <th>R. Rawat</th>
                                <th>Kelas</th>
                                <th>No Kamar</th>
                                <th>Bed</th>
                                <th>Dokter</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $n = ($list->currentPage() - 1) * $list->perPage();
                            @endphp
                            @foreach($list as $key => $l)
                                <td>{{ ++$n }}</td>
                                <td>{{ $l->regno }}</td>
                                <td>{{ $l->medrec }}</td>
                                <td>{{ $l->firstname }}</td>
                                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                                <td>{{ $l->nmbangsal }}</td>
                                <td>{{ $l->nmkelas }}</td>
                                <td>{{ $l->nokamar }}</td>
                                <td>{{ $l->nottidur }}</td>
                                <td>{{ $l->nmdoc }}</td>
                                <td>{{ $l->alamat }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>No.Reg</th>
                                <th>RM</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Msk</th>
                                <th>R. Rawat</th>
                                <th>Kelas</th>
                                <th>No Kamar</th>
                                <th>Bed</th>
                                <th>Dokter</th>
                                <th>Alamat</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $list->appends(['date1'=>Request::input('date1'),'Firstname'=>Request::input('Firstname'),'Alamat'=>Request::input('Alamat'),'Bangsal'=>Request::input('Bangsal')])->links() }}
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
    $('#Bangsal').select2({
        ajax: {
            url:"{{route('api.select2.bangsal')}}",
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
                        item.id = item.KdBangsal;
                        item.text = item.NmBangsal;
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
                    ${item.NmBangsal}
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