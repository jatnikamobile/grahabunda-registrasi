@extends('layouts.main')
@section('title','Surat Kontrol | Rubah Kategori')
@section('menu-min','menu-min')
@section('menu_rubah_kategori','active')
@section('header','Rubah Kategori')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <!-- <div class="panel-heading">
            </div> -->
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                        <form action="{{Request::url()}}" method="get">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">No Registrasi</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" required name="regno" id="regno" class="form-control input-sm col-xs-10 col-sm-5" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Kategori Pasien</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select type="text" required name="KategoriPasien" id="Kategori" style="width:50%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Cara Bayar</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select type="text" required name="KdCbayar" id="cara_bayar" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                        </select>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Ubah</button>
                                    <a href="{{Request::url()}}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
        $('#Kategori').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.kategori-pasien')}}",
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
                        item.id = item.KdKategori;
                        item.text = item.NmKategori;
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
                   ${item.NmKategori}
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
    $('#cara_bayar').select2({
        ajax: {
            // api/get_ppk
            url:"{{ route('api.select2.cara_bayar') }}",
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
                        item.id = item.KDCbayar;
                        item.text = item.NMCbayar;
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
                    ${item.NMCbayar}
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
    });
</script>
@endsection