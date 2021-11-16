@extends('layouts.main')
@section('title','Rujukan Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('rujukan_pasien','active')
@section('header','Rujukan Pasien BPJS')
@section('subheader','Form Data')
@section('content')
<section>
	<div>
		<a href="{{route('reg-bpjs-rujukan')}}" class="btn btn-warning btn-sm"> Kembali</a>
	</div>
	<hr>
	<form action="{{route('reg-bpjs-rujukan.create')}}" method="post" class="row">
		{{ csrf_field() }}
		<input type="hidden" name="NoPeserta">
		<input type="hidden" name="Medrec">
		<input type="hidden" name="NmPpk">
		<input type="hidden" name="NmPoli">
		<input type="hidden" name="Diagnosa">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p><u>Status Pasien</u></p>
				<!-- Nomor SEP -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> No SEP</label>
					<div class="input-group col-sm-4">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<?php $readonly = $is_edit ? 'readonly="readonly"' : ''; ?>
						<input type="text" name="NoSep" class="form-control" id="NoSep" value="{{ $rujukan->NoSep }}" <?= $readonly ?> />
						<?php if(!$is_edit): ?>
						<span class="input-group-btn">
							<button class="btn btn-sm btn-default" type="button" id="cariSep">
								<i class="ace-icon fa fa-search bigger-110"></i>
								Cari
							</button>
						</span>
						<?php endif; ?>
					</div>
				</div>
				<!-- Tanggal Rujukan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Tanggal Rujukan</label>
					<div class="input-group col-sm-4">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="date" name="TglRujukan" id="TglRujukan" value="{{ $rujukan->TglRujukan ? $rujukan->TglRujukan->format('Y-m-d') : date('Y-m-d') }}" class="form-control input-sm col-xs-6 col-sm-6">
					</div>
				</div>
				<!-- Nama Pasien -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> Nama Pasien</label>
					<div class="input-group col-sm-4">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="Firstname" class="form-control input-sm" id="Firstname" readonly="readonly" value="{{ $rujukan->Firstname ?: '' }}" />
					</div>
				</div>
				<!-- Jenis Kelamin -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Jenis Kelamin</label>
					<div class="input-group col-sm-6">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="Sex" class="form-control input-sm" id="Sex" readonly="readonly" value="{{ $rujukan->Sex ?: '' }}" />
						<!-- Tanggal Lahir -->
						<span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Lahir</span>
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="TglLahir" id="TglLahir" class="form-control input-sm col-xs-6 col-sm-6" readonly="readonly" value="{{ $rujukan->Bod ?: '' }}" />
					</div>
				</div>
				<!-- Jenis Peserta -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Jenis Peserta</label>
					<div class="input-group col-sm-4">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="JenisPeserta" class="form-control input-sm" id="JenisPeserta" readonly="readonly" value="{{ $rujukan->JenisPeserta ?: '' }}"/>
					</div>
				</div>
				<!-- Hak Kelas -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Hak Kelas</label>
					<div class="input-group col-sm-4">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="HakKelas" class="form-control input-sm" id="HakKelas" readonly="readonly" value="{{ $rujukan->Kelas ?: '' }}"/>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p><u>Status Rujukan</u></p>
				<!-- PPK Dirujuk -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">PPK Dirujuk</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="Ppk" id="Ppk" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
							<?php if($rujukan->KdRujukan): ?>
							<option value="{{ $rujukan->KdRujukan }}">{{ $rujukan->NmRujukan }}</option>
							<?php endif; ?>
						</select>
						<input type="hidden" name="NmPpk" value="{{ $rujukan->NmRujukan }}">
					</div>
				</div>
				<!-- Diagnosa Rujukan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Diagnosa Rujukan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="DiagRujuk" id="DiagRujuk" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
							<?php if($rujukan->KdICD): ?>
							<option value="{{ $rujukan->KdICD }}">{{ $rujukan->Diagnosa }}</option>
							<?php endif; ?>
						</select>
					</div>
				</div>
				<!-- Poli Rujukan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Poli Rujukan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="KdPoli" id="KdPoli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
							<?php if($rujukan->KdPoli): ?>
							<option value="{{ $rujukan->KdPoli }}">{{ $rujukan->NmPoli }}</option>
							<?php endif; ?>
						</select>
					</div>
				</div>
				<!-- Jenis Pelayanan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Jenis Pelayanan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<div class="radio">
							<label>
								<?php $selected = $rujukan->JnsPelayanan == 1 ? 'checked="checked"' : '';?>
								<input name="JenisPelayanan" type="radio" class="ace" value="1" <?= $selected ?>/>
								<span class="lbl">&nbsp; Rawat Inap</span>
							</label>
							<label>
								<?php $selected = $rujukan->JnsPelayanan == 2 ? 'checked="checked"' : '';?>
								<input name="JenisPelayanan" type="radio" class="ace" value="2" <?= $selected ?>/>
								<span class="lbl">&nbsp; Rawat Jalan</span>
							</label>
						</div>
					</div>
				</div>
				<!-- Tipe Rujukan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Tipe Rujukan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<div class="radio">
							<label>
								<?php $selected = $rujukan->TipeRujukan == 0 ? 'checked="checked"' : '';?>
								<input name="TipeRujukan" type="radio" class="ace" value="0" <?= $selected ?>/>
								<span class="lbl">&nbsp; Penuh</span>
							</label>
							<label>
								<?php $selected = $rujukan->TipeRujukan == 1 ? 'checked="checked"' : '';?>
								<input name="TipeRujukan" type="radio" class="ace" value="1" <?= $selected ?>/>
								<span class="lbl">&nbsp; Partial</span>
							</label>
							<label>
								<?php $selected = $rujukan->TipeRujukan == 2 ? 'checked="checked"' : '';?>
								<input name="TipeRujukan" type="radio" class="ace" value="2" <?= $selected ?>/>
								<span class="lbl">&nbsp; Rujuk Balik</span>
							</label>
						</div>
					</div>
				</div>
				<!-- Catatan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Catatan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<textarea class="form-control input-sm col-xs-6 col-sm-6" name="Catatan" id="Catatan">{{ $rujukan->Catatan }}</textarea>
					</div>
				</div>
				<!-- Nomor Rujukan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Nomor Rujukan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<?php $readonly = $is_edit ? 'readonly="readonly"' : ''; ?>
						<input type="text" name="NoRujukan" id="NoRujukan" class="form-control input-sm col-sm-2" value="{{ $rujukan->NoRujukan }}" <?= $readonly ?> />
						<?php if(!$is_edit): ?>
						<button type="button" id="btn-create-rujukan" class="btn btn-success" style="width: 170px; height: 34px;">Create Rujukan</button>
						<?php endif; ?>
					</div>
				</div>
				<!-- Keterangan -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Keterangan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<textarea class="form-control input-sm col-xs-6 col-sm-6" name="Keterangan" id="Keterangan">{{ $rujukan->Catatan }}</textarea>
					</div>
				</div>
			</div>
		</div>
		<input type="submit" name="submit" id="submit" class="btn btn-success" value="Simpan" />
	</form>
</section>
@endsection

@section('script')
<script>
	$(document).ready(function(){
		$('#sidebar').addClass('menu-min');
	});

	let dataPeserta = null;

	const select2Bpjs = {
		ajax: { dataType: 'json', },
		templateResult: function(item) { return item.loading ? item.text : `<p>${item.text}</p>`; },
		escapeMarkup: function(markup) { return markup; },
		templateSelection: function(item) { return item.text; },
	};

	function select2VClaimResponse(data, params, success) {

		if(!params.term) {
			return {
				results: [{text: 'Silahkan ketik dahulu', loading: true}],
				pagination: {more: false}
			};
		}
		if(!data || !data.metaData) {
			return {
				results: [{text: '[ERR] Tidak ada respon dari server', loading: true}],
				pagination: {more: false}
			};
		}

		if(data.metaData.code != 200) {
			return {
				results: [{text: data.metaData.message, loading: true}],
				pagination: {more: false}
			};
		}

		return success(data, params);
	}

	$('[name=TipeRujukan]').on('input', function(ev) {
		let tipeRujukan = $(this).val();
		if(tipeRujukan == 2) {
			$('#Ppk').html(`<option selected="selected" value="${dataPeserta.provUmum.kdProvider}">
				${dataPeserta.provUmum.nmProvider}
			</option>`);
		}
		else {
			$('#Ppk').html('');
		}
	});

	$('#Ppk').select2($.extend(true, select2Bpjs, {
		ajax: {
			url: function() {
				return $('[name=TipeRujukan]:checked').val() == 2 ? 'javascript:;' : '{{ route('vclaim.faskes') }}';
			},
			data: function(params) {
				return $.extend(params, { faskes: $('[name=TipeRujukan]:checked').val() == 2 ? 1 : 2 });
			},
			processResults: function(data, params) {
				return select2VClaimResponse(data, params, function(data, params) {
					return {
						results: data.response.faskes.map(function(item) {
							return $.extend(item, {
								id: item.kode,
								text: item.nama,
							});
						}),
						pagination: {more: false},
					};
				});
			}
		}
	}));

	$('#Ppk').on('select2:select', function(ev) {
		let data = ev.params.data;
		$('[name=NmPpk]').val(data.nama);
	});

	$('#KdPoli').on('select2:select', function(ev) {
		let data = ev.params.data;
		$('[name=NmPoli]').val(data.nama);
	});

	$('#DiagRujuk').on('select2:select', function(ev) {
		let data = ev.params.data;
		$('[name=Diagnosa]').val(data.nama);
	});

	$('#KdPoli').select2($.extend(true, select2Bpjs, {
		ajax: {
			url: '{{ route('vclaim.poli') }}',

			processResults: function(data, params) {
				return select2VClaimResponse(data, params, function(data, params) {
					return {
						results: data.response.poli.map(function(item) {
							return $.extend(item, {
								id: item.kode,
								text: item.nama,
							});
						}),
						pagination: {more: false},
					};
				});
			}
		}
	}));

	$('#DiagRujuk').select2($.extend(true, select2Bpjs, {
		ajax: {
			url: '{{ route('vclaim.diagnosa') }}',

			processResults: function(data, params) {
				return select2VClaimResponse(data, params, function(data, params) {
					return {
						results: data.response.diagnosa.map(function(item) {
							return $.extend(item, {
								id: item.kode,
								text: item.nama,
							});
						}),
						pagination: {more: false},
					};
				});
			}
		}
	}));

	$('#cariSep').click(function(ev) {

		let noSep = $('#NoSep').val().trim();

		let $this = $(this);
		let content = $this.html();
		$this.html(`<i class="fa fa-spin fa-spinner"></i> Cari`).attr('disabled', 'disabled');

		$.get('{{ route('vclaim.sep') }}', {no_sep: noSep})
		.fail(function() {
			alert('Gagal mendapatkan detail SEP');
		})
		.always(function() {
			$this.html(content).removeAttr('disabled');
		})
		.done(function(res) {
			if(!res || !res.metaData) {
				return alert('[ERR] Tidak ada respon dari server');
			}
			else if(res.metaData.code != 200) {
				return alert(res.metaData.message);
			}

			let data = res.response;

			$('#Firstname').val(data.peserta.nama);
			$('#Sex').val(data.peserta.kelamin == 'L' ? 'Laki-laki' : (data.peserta.kelamin == 'P' ? 'Perempuan' : ''));
			$('#TglLahir').val((new Date(data.peserta.tglLahir)).toLocaleDateString('en-US'));
			$('#JenisPeserta').val(data.peserta.jnsPeserta);
			$('#HakKelas').val(data.peserta.hakKelas);
			$('[name=Medrec]').val(data.peserta.noMr);
			$('[name=NoPeserta]').val(data.peserta.noKartu);
			$('[name=JenisPelayanan][value='+ (data.jnsPelayanan == 'Rawat Jalan' ? 2 : 1) +']').prop('checked', true);

			$.get('{{ route('vclaim.cari_peserta_by_bpjs') }}', {no_kartu: data.peserta.noKartu})
			.done(function(res) {
				if(!res || !res.metaData || res.metaData.code != 200) return;
				dataPeserta = res.response.peserta;
			});
		});
	});

	$('#btn-create-rujukan').click(function(ev) {

		let $this = $(this);
		let content = $this.html();
		$this.html(`<i class="fa fa-spin fa-spinner"></i> Create Rujukan`).attr('disabled', 'disabled');

		$.post('{{ route('vclaim.create-rujukan') }}', {
			NoSep: $('#NoSep').val(),
			TglRujukan: $('#TglRujukan').val(),
			Ppk: $('#Ppk').val(),
			JenisPelayanan: $('[name=JenisPelayanan]:checked').val(),
			Catatan: $('#Catatan').val(),
			DiagRujuk: $('#DiagRujuk').val(),
			TipeRujukan: $('[name=TipeRujukan]:checked').val(),
			KdPoli: $('#KdPoli').val(),
		})
		.always(function() {
			$this.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('Gagal membuat rujukan');
		})
		.done(function(res) {
			if(!res || !res.metaData) {
				return alert('[ERR] Tidak ada respon dari server');
			}
			else if(res.metaData.code != 200) {
				return alert(res.metaData.message);
			}

			let data = res.response;

			$('#NoRujukan').val(data.rujukan.noRujukan);
		});
	});

	$('#NoSep').keypress(function(ev) {
		if(ev.key == 'Enter') {
			ev.preventDefault();
			$('#cariSep').click();
		}
	});
</script>
@endsection