@extends('layouts.main')
@section('title','Bridging BPJS | Data Klaim Jasa Raharja')
@section('bridging','active')
@section('klaim_jasa_raharja','active')
@section('header','Data Klaim Jasa Raharja')

@section('content')
<section>
	<div class="row">
		<div class="col-md-12">
			<form id="form" class="form-horizontal" action="" method="get">
				<div class="form-group">
					<div class="col-sm-8">
						<div class="input-group">
							<span>
								<select name="pelayanan" class="input-md">
									<option disabled="disabled" value="">- Jenis Pelayanan -</option>
									<option value="1">Rawat Inap</option>
									<option value="2">Rawat Jalan</option>
								</select>
							</span>
							<span>
								<input placeholder="Dari Tanggal" name="tanggal_mulai" type="text" class="datepicker" value="{{ date('Y-m-d') }}">
							</span>
							<span>
								<input placeholder="Sampai Tanggal" name="tanggal_akhir" type="text" class="datepicker" value="{{ date('Y-m-d') }}">
							</span>
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary btn-sm">
									<i class="fa fa-search"></i> Cari
								</button>
							</span>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div style="overflow-x: auto;">
				<table id="table" class="table table-striped table-bordered table-hover" style="overflow: hidden; white-space: nowrap;">
					<thead>
						<tr>
							<th style="width: 180px;">Nomor SEP</th>
							<th>Tanggal SEP</th>
							<th>Tanggal Pulang</th>
							<th>Nomor RM</th>
							<th>Jenis Pelayanan</th>
							<th>Nomor Kartu</th>
							<th>Tanggal Kejadian</th>
							<th>Nomor Register</th>
							<th>Status Dijamin</th>
							<th>Status Dikirim</th>
							<th>Biaya Dijamin</th>
							<th>Plafon</th>
							<th>Jumlah Dibayar</th>
							<th>Biaya Topup</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="17">
								Tidak ada data
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@endsection

@section('script')
<script type="text/javascript">
(function() {
	$('[name=tanggal_mulai]').datepicker({format: 'yyyy-mm-dd'});
	$('[name=tanggal_akhir]').datepicker({format: 'yyyy-mm-dd'});
	$('#form').submit(function(ev) {
		ev.preventDefault();
		let $btn = $(this).find('button[type=submit]');
		let content = $btn.html();

		$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

		$.get('{{ route('vclaim.klaim_jasa_raharja') }}', {
			pelayanan: $(this).find('[name=pelayanan]').val(),
			tanggal_mulai: $(this).find('[name=tanggal_mulai]').val(),
			tanggal_akhir: $(this).find('[name=tanggal_akhir]').val(),
		})
		.always(function() {
			$btn.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Tidak ada response dari server');
		})
		.done(function(res) {
			if ('metaData' in res) {
				if (res.metaData.code == 201) {
					return alert(res.metaData.message);
				}
			}

			let data = res.jaminan;
			$('#table tbody').html('');
			data.forEach(function(item) {
				$('#table tbody').append(`
					<tr>
						<td>${item.sep.noSEP}</td>
						<td>${item.sep.tglSEP}</td>
						<td>${item.sep.tglPlgSEP}</td>
						<td>${item.sep.noMr}</td>
						<td>${item.sep.jnsPelayanan}</td>
						<td>${item.sep.peserta.noKartu}</td>
						<td>${item.jasaRaharja.tglKejadian}</td>
						<td>${item.jasaRaharja.noRegister}</td>
						<td>${item.jasaRaharja.ketStatusDijamin}</td>
						<td>${item.jasaRaharja.ketStatusDikirim}</td>
						<td>${item.jasaRaharja.biayaDijamin}</td>
						<td>${item.jasaRaharja.plafon}</td>
						<td>${item.jasaRaharja.jmlDibayar}</td>
					</tr>
					`);
			});
		});
	});
})();
</script>
@endsection