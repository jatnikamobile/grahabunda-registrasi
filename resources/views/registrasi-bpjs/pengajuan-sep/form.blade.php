@extends('layouts.main')
@section('title','Pengajuan SEP Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('pengajuan_sep','active')
@section('header','Pengajuan SEP Pasien BPJS')
@section('subheader','Form Data')
@section('content')
<section>
	<div>
		<a href="{{route('reg-bpjs-pengajuan')}}" class="btn btn-warning btn-sm"> Kembali</a>
		<button type="button" id="btn-cari" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-nomor-sep" style="width: 150px; height: 34px;">Cari Nomor Peserta</button>
	</div>
	<hr>
	<form action="{{route('reg-bpjs-pengajuan.create')}}" method="post" class="row" id="form">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-8">
				<p><u>Form Pengajuan SEP</u></p>
				<!-- Tanggal SEP -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Tanggal SEP</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="tanggal_sep" id="tanggal_sep" class="form-control input-sm col-xs-6 col-sm-6" value="{{ date('Y-m-d') }}" required="required">
					</div>
				</div>
				<!-- Nomor Peserta/BPJS -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> No Peserta/BPJS</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="no_peserta" class="form-control input-sm" id="no_peserta" required="required"/>
						<span class="input-group-btn">
							<button type="button" id="btn-cari-peserta" class="btn btn-xs btn-primary">
								<i class="fa fa-search"></i>
								Cari
							</button>
						</span>
					</div>
				</div>
				<!-- Nama Pasien -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> Nama Pasien</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="nama_pasien" class="form-control input-sm" id="nama_pasien" required="required"/>
					</div>
				</div>
				<!-- Jenis Pelayanan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Jenis Pelayanan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="pelayanan" id="pelayanan" class="form-control input-sm col-xs-6 col-sm-6" required="required">
							<option value="" disabled="disabled">-= Jenis Pelayanan =-</option>
							<option value="1">Rawat Inap</option>
							<option value="2">Rawat Jalan</option>
						</select>
					</div>
				</div>
				<!-- Keterangan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> Keterangan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="keterangan" class="form-control input-sm" id="keterangan"/>
					</div>
				</div>
			</div>
		</div>
		<button type="button" id="btn-pengajuan" class="btn btn-success" value="pengajuan">
			<i class="fa fa-save"></i>
			Pengajuan SEP
		</button>
		<button type="button" id="btn-approval" class="btn btn-success" value="approval">
			<i class="fa fa-save"></i>
			Approval SEP
		</button>
		<span id="post-message"></span>
	</form>
	<div class="modal fade bd-example-modal-lg-nomor-sep" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Cari Nomor SEP</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div style="overflow:auto;" id="target_table">
						<table class="table table-bordered" id="table-list-pasien">
							<thead>
								<tr>
									<th>No Registrasi</th>
									<th>Tgl Registrasi</th>
									<th>No Rekam Medis</th>
									<th>Nama Pasien</th>
									<th>No SEP</th>
									<th>No Kartu</th>
									<th>Nama Dokter</th>
									<th>Nama Poli</th>
								</tr>
							</thead>
						</table>
					</div>
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
	});

(function() {
	$('[name=tanggal_sep]').datepicker({format: 'yyyy-mm-dd'});

	$('#btn-cari-peserta').click(function(ev) {
		let $this = $(this);
		let content = $this.html();
		$this.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

		$.get('{{ route('vclaim.cari_peserta_by_bpjs') }}', {
			no_kartu: $('[name=no_peserta]').val(),
			tanggal_sep: $('[name=tanggal_sep]').val(),
		})
		.always(function() {
			$this.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Gagal mengambil data dari server');
		})
		.done(function(res) {
			if(!res || !res.metaData) {
				return alert('[ERR] Gagal mengambil data dari server');
			}
			else if(res.metaData.code != 200) {
				return alert(res.metaData.message);
			}

			let data = res.response.peserta;

			$('[name=nama_pasien]').val(data.nama);
		});
	});

	$('[name=no_peserta]').keypress(function(ev) {
		if(ev.key == 'Enter') {
			ev.preventDefault();
			$('#btn-cari-peserta').click();
		}
	});

	$('#btn-pengajuan').click(function(ev) {
		ev.preventDefault();
		let $btn = $(this);
		let content = $btn.html();
		$btn.html('<i class="fa fa-spin fa-spinner"></i> Pengajuan SEP').attr('disabled', 'disabled');

		$.post('{{ route('vclaim.pengajuan-sep') }}', {
			no_peserta: $('[name=no_peserta]').val(),
			tanggal_sep: $('[name=tanggal_sep]').val(),
			pelayanan: $('[name=pelayanan]').val(),
			keterangan: $('[name=keterangan]').val(),
		})
		.always(function() {
			$btn.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Gagal mengirim data ke server');
		})
		.done(function(res) {
			console.log(res);
			if(!res || !res.metaData) {
				return alert('Tidak ada respon dari server');
			}

			$('#post-message').text(res.metaData.message);
			if (res.metaData.message == 'Sukses') {
				$.post('{{ route('reg-bpjs-pengajuan.create') }}', {
					no_peserta: $('[name=no_peserta]').val(),
					tanggal_sep: $('[name=tanggal_sep]').val(),
					pelayanan: $('[name=pelayanan]').val(),
					keterangan: $('[name=keterangan]').val(),
				})
				.always(function() {
					// $btn.html(content).removeAttr('disabled');
				})
				.fail(function() {
					// alert('[ERR] Gagal mengirim data ke server');
				})
				.done(function(res) {
					console.log(res);
				});
			}
		});
	});

	$('#btn-approval').click(function(ev) {
		ev.preventDefault();
		let $btn = $(this);
		let content = $btn.html();
		$btn.html('<i class="fa fa-spin fa-spinner"></i> Approval SEP').attr('disabled', 'disabled');

		$.post('{{ route('vclaim.approval-sep') }}', {
			no_peserta: $('[name=no_peserta]').val(),
			tanggal_sep: $('[name=tanggal_sep]').val(),
			pelayanan: $('[name=pelayanan]').val(),
			keterangan: $('[name=keterangan]').val(),
		})
		.always(function() {
			$btn.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Gagal mengirim data ke server');
		})
		.done(function(res) {
			console.log(res);
			if(!res || !res.metaData) {
				return alert('Tidak ada respon dari server');
			}

			$('#post-message').text(res.metaData.message);
		});
	});

	$('#form').submit(function(ev) {
		ev.preventDefault();
	});
})();
</script>
@endsection