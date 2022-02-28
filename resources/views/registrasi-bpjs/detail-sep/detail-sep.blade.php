@extends('layouts.main')
@section('title','Detil SEP Peserta | Modul Registrasi')
@section('bpjs','active')
@section('detail_sep','active')
@section('header','Detail SEP Peserta')
@section('subheader','Form Data')
@section('content')
<section>
    <div>
        <button type="button" id="btn-cari" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-nomor-sep" style="width: 150px; height: 34px;">Cari SEP</button>
        <button type="button" id="btn-list" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-list-deleted-sep" style="width: 150px; height: 34px;">List Deleted SEP</button>
    </div>
    <hr>
    <form method="get" class="row">
        {{ csrf_field() }}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Nomor SEP -->
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right"> No SEP</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="noSep" id="noSep"/>
                        <button type="submit" class="btn btn-info btn-sm" id="btnCari" style="margin-left: 10px;">
                            <i class="ace-icon fa fa-search"></i>Cari
                        </button>
                        <div class="pull-right">
                            <button type="button" class="btn btn-warning btn-sm" id="deleteSep">
                            <i class="fa fa-waring"></i>Hapus SEP
                        </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <p><u>Status Pelayanan</u></p>
                <!-- Jenis Pelayanan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jenis Pelayanan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="jenisPelayanan" class="form-control input-sm" id="jenisPelayanan" readonly />
                    </div>
                </div>
                <!-- Kelas Rawat -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kelas Rawat</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="kelasRawat" class="form-control input-sm" id="kelasRawat" readonly />
                    </div>
                </div>
                <!-- Penjamin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Penjamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="penjamin" class="form-control input-sm" id="penjamin" readonly />
                    </div>
                </div>
                <!-- Diagnosa -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Diagnosa</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="diagnosa" class="form-control input-sm" id="diagnosa" readonly />
                    </div>
                </div>
                <!-- Catatan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Catatan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="catatan" class="form-control input-sm" id="catatan" readonly />
                    </div>
                </div>
                <input type="hidden" name="user" id="user" value="{{ Auth::user()->DisplayName == '' ? Auth::user()->NamaUser : Auth::user()->DisplayName }}" />
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <p><u>Identitas Peserta</u></p>
                <!-- No RM -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No Rekam Medis</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="noRm" class="form-control input-sm" id="noRm" readonly />
                    </div>
                </div>
                <!-- Nama Peserta -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Peserta</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Firstname" class="form-control input-sm" id="Firstname" readonly />
                    </div>
                </div>
                <!-- No Kartu -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No Kartu</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="noKartu" class="form-control input-sm" id="noKartu" readonly />
                    </div>
                </div>
                <!-- Tanggal Lahir -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tanggal Lahir</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="tglLahir" id="tglLahir" class="form-control input-sm col-xs-6 col-sm-6" readonly>
                    </div>
                </div>
                <!-- Jenis Kelamin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jenis Kelamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="jenisKelamin" class="form-control input-sm" id="jenisKelamin" readonly />
                    </div>
                </div>
                <!-- Kelas -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kelas</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="kelas" class="form-control input-sm" id="kelas" readonly />
                    </div>
                </div>
                <!-- Nama Asuransi -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Asuransi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="nmAsuransi" class="form-control input-sm" id="nmAsuransi" readonly />
                    </div>
                </div>
                <!-- Nama Poli -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Poli</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="poli" class="form-control input-sm" id="poli" readonly />
                    </div>
                </div>
                <!-- Poli Eksekutif -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Poli Eksekutif</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="poliEksekutif" class="form-control input-sm" id="poliEksekutif" readonly />
                    </div>
                </div>
                <!-- Tgl SEP -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tgl SEP</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="tglSep" class="form-control input-sm" id="tglSep" readonly />
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade bd-example-modal-lg-nomor-sep"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="exampleModalLabel">Cari SEP Pasien</h5>
                    </div><hr>
                    <form method="get" id="bd-example-modal-lg-nomor-sep">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Medrec</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Medrec" id="pa_Medrec" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Firstname" id="pa_Firstname" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Tanggal Daftar</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="date" name="date1" id="date1" style="width: 40%" />
                                    <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                                    <input type="date" name="date2" id="date2" style="width: 40%" />
                                </div>
                            </div>
                        </div>
                        <div class="pull-right"><button type="submit" class="btn btn-info btn-sm" name="cari_pasien"><i class="fa fa-search"></i> Cari</button></div>
                    </form>
                </div>
                <div class="modal-body">
                    <div style="overflow:auto;" id="target_cari_pasien"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade bd-example-modal-lg-list-deleted-sep"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="exampleModalLabel">List Deleted SEP Pasien</h5>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="table-list-deleted-sep">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No SEP</th>
                                <th>Deleted Date</th>
                                <th>Deleted By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($list_deleted) > 0)
                                @foreach ($list_deleted as $row => $ld)
                                    <tr>
                                        <td>{{ $row + 1 }}</td>
                                        <td>{{ $ld->no_sep }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($ld->deleted_date)) }}</td>
                                        <td>{{ $ld->user }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
        $('#table-list-deleted-sep').dataTable();
    });

    $('#bd-example-modal-lg-nomor-sep').submit(function(ev)  {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('reg-bpjs-findsep') }}",
            type: "PUT",
            // dataType:"json",
            data: {
                _method : 'PUT',
                medrec: $('[name=pa_Medrec]').val(),
                nama: $('[name=pa_Firstname]').val(),
                date1: $('[name=date1]').val(),
                date2: $('[name=date2]').val()
            },
            beforeSend(){
                $('#target_cari_pasien').html('<div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success: function(response){
                $('#target_cari_pasien').html(response);
            }
        });
    });

    $('#deleteSep').on('click', function(ev) {
        ev.preventDefault();
        let btn = $('#deleteSep');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        btn.prop('disabled', true);
        if ($('#noSep').val() != '') {
            $.ajax({
                url:"{{ route('api.delete_sep') }}",
                type:"post",
                dataType:"json",
                data:{
                    noSep: $('#noSep').val(),
                    user: $('#user').val()
                },
                success:function(response)
                {
                    console.log(response);
                    if(response.data != false){
                        btn.prop('disabled', false);
                        btn.html(oldText);
                        $('#jenisPelayanan').val('');
                        $('#kelasRawat').val('');
                        $('#penjamin').val('');
                        $('#diagnosa').val('');
                        $('#catatan').val('');
                        $('#noRm').val(''.noMr);
                        $('#Firstname').val(''.nama);
                        $('#noKartu').val(''.noKartu);
                        $('#tglLahir').val(''.tglLahir);
                        $('#jenisKelamin').val(''.kelamin);
                        $('#kelas').val(''.hakKelas);
                        $('#nmAsuransi').val(''.asuransi);
                        $('#poli').val('');
                        $('#poliEksekutif').val('');
                        $('#tglSep').val('');
                        pesan = "Nomor SEP " + response.data + " dihapus";
                        alert(pesan);
                    }else{
                        btn.prop('disabled', false);
                        btn.html(oldText);
                        if ('message' in response) {
                            alert(response.message);
                        } else {
                            alert('Nomor SEP tidak ditemukan!');
                        }
                    }
                    location.reload()
                }
            })
        } else {
            btn.prop('disabled', false);
            btn.html(oldText);
            alert('Gagal hapus detail SEP!');
            $('.bd-example-modal-lg-caripasien').modal('hide');
        }
    });

    $('#btnCari').on("click", function(ev){
        ev.preventDefault();
        let btn = $('#btnCari');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        btn.prop('disabled', true);
        if ($('#noSep').val() != '') {
            $.ajax({
                url:"{{ route('api.get_sep') }}",
                type:"get",
                dataType:"json",
                data:{
                    noSep: $('#noSep').val(),
                },
                success:function(response)
                {
                    if('noSep' in response.data){
                        btn.prop('disabled', false);
                        btn.html(oldText);

                        $('#jenisPelayanan').val(response.data.jnsPelayanan);
                        $('#kelasRawat').val(response.data.kelasRawat);
                        $('#penjamin').val(response.data.penjamin);
                        $('#diagnosa').val(response.data.diagnosa);
                        $('#catatan').val(response.data.catatan);
                        $('#noRm').val(response.data.peserta.noMr);
                        $('#Firstname').val(response.data.peserta.nama);
                        $('#noKartu').val(response.data.peserta.noKartu);
                        $('#tglLahir').val(response.data.peserta.tglLahir);
                        $('#jenisKelamin').val(response.data.peserta.kelamin);
                        $('#kelas').val(response.data.peserta.hakKelas);
                        $('#nmAsuransi').val(response.data.peserta.asuransi);
                        $('#poli').val(response.data.poli);
                        $('#poliEksekutif').val(response.data.poliEksekutif);
                        $('#tglSep').val(response.data.tglSep);
                    }else{
                        btn.prop('disabled', false);
                        btn.html(oldText);
                        alert('Tidak ada SEP!');
                    }
                }
            })
        } else {
            btn.prop('disabled', false);
            btn.html(oldText);
            alert('Gagal cari detail SEP!');
            $('.bd-example-modal-lg-caripasien').modal('hide');
        }
    });
</script>
@endsection