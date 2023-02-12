@extends('layouts.main')
@section('title','Edit Dokter | Modul Registrasi')
@section('menu_master_dokter','active')
@section('header','Edit Dokter')
@section('content')
<section>
	<div>
		<a href="{{ route('mst-dok.index') }}" class="btn btn-warning btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
	</div>
	<hr>
	<form class="row" id="simpan_dokter">
		{{ csrf_field() }}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kode Dokter</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="kode_dokter" id="kode_dokter" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $ft_dokter->KdDoc }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Dokter</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="nama_dokter" id="nama_dokter" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $ft_dokter->NmDoc }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">SIP Dokter</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="sip_dokter" id="sip_dokter" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $ft_dokter->NoPraktek }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kategori</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="kategori" id="kategori" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="0" {{ $ft_dokter->Kategori == '' ? 'selected' : '' }}>--- Pilih Kategori ---</option>
							<option value="1" {{ $ft_dokter->Kategori == 'Specialis' ? 'selected' : '' }}>Spesialis</option>
							<option value="2" {{ $ft_dokter->Kategori == 'Umum' ? 'selected' : '' }}>Umum</option>
							<option value="3" {{ $ft_dokter->Kategori == 'Gigi' ? 'selected' : '' }}>Gigi</option>
						</select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jenis Kelamin</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="jenis_kelamin" id="jenis_kelamin" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="0" {{ $ft_dokter->Sex == '' ? 'selected' : '' }}>--- Pilih Jenis Kelamin ---</option>
							<option value="1" {{ $ft_dokter->Sex == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
							<option value="2" {{ $ft_dokter->Sex == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
						</select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kode DPJP BPJS</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="kode_dpjp" id="kode_dpjp" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $ft_dokter->KdDPJP }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Alamat</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <textarea type="text" name="alamat" id="alamat" class="form-control input-sm col-xs-6 col-sm-6">{{ $ft_dokter->Address }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kota</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="kota" id="kota" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $ft_dokter->City }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kode POS</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $ft_dokter->KdPos }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Telepon</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="telepon" id="telepon" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $ft_dokter->Phone }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Poli</label>
                    <div class="input-group col-sm-6">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="poli" id="poli" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="0">--- Pilih Poli ---</option>
                            @if (count($poli) > 0)
                                @foreach ($poli as $pl)
                                    <option value="{{ $pl->KDPoli }}" {{ $ft_dokter->KdPoli == $pl->KDPoli ? 'selected' : '' }}>{{ $pl->NMPoli }}</option>
                                @endforeach
                            @endif
						</select>
                    </div>
                </div>
                <input type="submit" name="simpan" id="simpan" class="btn btn-success" value="Simpan" />
            </div>
        </div>
    </form>
</section>
@endsection

@section('script')
<script>
	$(document).ready(function(){
		$('#sidebar').addClass('menu-min');
	});

    $('#simpan_dokter').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            url: "{{ route('mst-dok.update', ['id' => $ft_dokter->KdDoc]) }}",
            type: 'PUT',
            dataType: 'JSON',
            data: {
                kode_dokter: $('#kode_dokter').val(),
                nama_dokter: $('#nama_dokter').val(),
                sip_dokter: $('#sip_dokter').val(),
                kategori: $('#kategori').val(),
                jenis_kelamin: $('#jenis_kelamin').val(),
                kode_dpjp: $('#kode_dpjp').val(),
                alamat: $('#alamat').val(),
                kota: $('#kota').val(),
                kode_pos: $('#kode_pos').val(),
                telepon: $('#telepon').val(),
                poli: $('#poli').val(),
            },
            success: function (data) {
                if (data.status == 'success') {
                    alert('Data berhasil disimpan')
                    location.href = "{{ route('mst-dok.index') }}"
                } else {
                    alert('Data gagal disimpan. ' + data.message)
                }
            }
        })
    })
</script>
@endsection