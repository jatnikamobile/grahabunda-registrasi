@extends('layouts.main')
@section('title','Monitoring Status Belum Kembali | Modul Registrasi')
@section('monitoring_status','active')
@section('file_status_belum_kembali','active')
@section('header','Monitoring Status Belum Kembali')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="{{route('file-status-belum-kembali-print',['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Poli'=>Request::input('Poli')])}}" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-print"></i> Print</a>
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
                            <input type="text" name="Regno" id="Regno" placeholder="No Registrasi" style="margin-right: 10px;" value="<?= Request::input('Regno') !== null ? Request::input('Regno') : Request::input('Regno') ?>"/>
                            <input type="text" name="Medrec" id="Medrec" placeholder="No Rekam Medis" value="<?= Request::input('Medrec') !== null ? Request::input('Medrec') : Request::input('Medrec') ?>"/>
                            <input type="text" name="Firstname" id="Firstname" placeholder="Nama" value="<?= Request::input('Firstname') !== null ? Request::input('Firstname') : Request::input('Firstname') ?>"/>
                            <select name="Poli" id="Poli" style="width: 150px;">
                                <option value="<?= Request::input('Poli') !== null ? Request::input('Poli') : Request::input('Poli') ?>">-= Poli =-</option>
                            </select>
                            <input type="date" name="date1" id="date1" style="margin-left: 10px;" value="<?=Request::input('date1') !== null ? Request::input('date1') : date('Y-m-d')?>" />
                            <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                            <input type="date" name="date2" id="date2" style="margin-left: 10px;" value="<?=Request::input('date2') !== null ? Request::input('date2') : date('Y-m-d')?>" />
                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i></button>
                            <div class="pull-right"><a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a></div>
                        </form>
                    </div>
                    <table class="table table-bordered" id="table-list-pasien" style="margin-top: 10px;">
                        <thead>
                            <tr class="info">
                                <th>No.Reg</th>
                                <th>RM</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Reg</th>
                                <th>Jam Reg</th>
                                <th>Tgl Klr</th>
                                <th>Jam Klr</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Bayar</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $key => $l)
                                <td>{{ $l->regno }}</td>
                                <td>{{ $l->medrec }}</td>
                                <td>{{ $l->firstname }}</td>
                                <td>{{ date('d/m/Y',strtotime($l->regdate)) }}</td>
                                <td>{{ substr($l->regtime,11,5) }}</td>
                                @if($l->tanggalkeluar == '')
                                <td></td>
                                <td></td>
                                @else
                                <td>{{ date('d/m/Y',strtotime($l->tanggalkeluar)) }}</td>
                                <td>{{ substr($l->jamkeluar,11,5) }}</td>
                                @endif
                                <td>{{ $l->nmpoli }}</td>
                                <td>{{ $l->nmdoc }}</td>
                                <td>{{ $l->nmtuju }}</td>
                                <td>{{ $l->nmcbayar }}</td>
                                <td>{{ $l->validuser }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.Reg</th>
                                <th>RM</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Reg</th>
                                <th>Jam Reg</th>
                                <th>Tgl Klr</th>
                                <th>Jam Klr</th>
                                <th>Poli</th>
                                <th>Dokter</th>
                                <th>Tujuan</th>
                                <th>Bayar</th>
                                <th>User</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $list->appends(['date1'=>Request::input('date1'),'date2'=>Request::input('date2'),'Firstname'=>Request::input('Firstname'),'Medrec'=>Request::input('Medrec'),'Regno'=>Request::input('Regno'),'Poli'=>Request::input('Poli')])->links() }}
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
    $('#Poli').select2({
        ajax: {
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