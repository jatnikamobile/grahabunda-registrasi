@extends('layouts.main')
@section('title','Update Tanggal Pulang Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('pengajuan_sep','active')
@section('header','Update Tanggal Pulang Pasien BPJS')
@section('content')
<section>
	<div>
		<a href="{{route('update-tanggal-pulang-list')}}" class="btn btn-warning btn-sm"> Kembali</a>
	</div>
	<hr>
	<form action="{{route('update-tanggal-pulang-save')}}" method="post" class="row" id="form">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-8">
				<p><u>Form Update Tanggal Pulang</u></p>
				<!-- Nomor SEP -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Nomor SEP</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="no_sep" id="no_sep" class="form-control input-sm col-xs-6 col-sm-6" value="" required="required">
					</div>
				</div>
				<!-- Status Pulang -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Status Pulang</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="status_pulang" id="status_pulang" class="form-control input-sm col-xs-6 col-sm-6" required="required">
							<option>-= Pilih Status Pulang =-</option>
                            <option value="1">Atas Persetujuan Dokter</option>
                            <option value="3">Atas Permintaan Sendiri</option>
                            <option value="4">Meninggal</option>
                            <option value="5">Lain-lain</option>
						</select>
					</div>
				</div>
				<!-- Nomor Surat Meninggal -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Nomor Surat Meninggal</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="no_surat_meninggal" id="no_surat_meninggal" class="form-control input-sm col-xs-6 col-sm-6" value="">
					</div>
				</div>
				<!-- Tanggal Meninggal -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Tanggal Meninggal</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="date" name="tanggal_meninggal" id="tanggal_meninggal" class="form-control input-sm col-xs-6 col-sm-6" value="">
					</div>
				</div>
				<!-- Tanggal Pulang -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Tanggal Pulang</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="date" name="tanggal_pulang" id="tanggal_pulang" class="form-control input-sm col-xs-6 col-sm-6" value="">
					</div>
				</div>
				<!-- No LP Manual -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">No LP Manual</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="no_lp_manual" id="no_lp_manual" class="form-control input-sm col-xs-6 col-sm-6" value="">
					</div>
				</div>
			</div>
		</div>
		<button type="submit" id="btn-pengajuan" class="btn btn-success" value="pengajuan">
			<i class="fa fa-save"></i>
			Update Tanggal Pulang
		</button>
	</form>
</section>
@endsection
@section('script')
<script>
$('document').ready(function () {
	$('#status_pulang').select2();
})
</script>
@endsection