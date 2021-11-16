@extends('layouts.main')
@section('title','Bridging BPJS | Daftar Klaim')
@section('bridging','active')
@section('daftar_klaim','active')
@section('header','Monitoring Klaim')

@section('content')
<section>
	<div class="row">
		<div class="col-md-12">
			<form id="form" class="form-horizontal" action="" method="get">
				<div class="form-group">
					<div class="col-sm-8">
						<div class="input-group">
							<span class="input-group-addon" style="border: none; background: white;">
								Tanggal SEP
							</span>
							<span>
								<input name="tanggal_sep" type="text" class="" style="width: 100%;" value="{{ date('Y-m-d') }}">
							</span>
							<span class="input-group-addon" style="border: none; background: white;">
								Jenis Pelayanan
							</span>
							<span>
								<select name="pelayanan" class="input-md" style="width: 90%;">
									<option disabled="disabled" value="">- Jenis Pelayanan -</option>
									<option value="1">Rawat Inap</option>
									<option value="2">Rawat Jalan</option>
								</select>
							</span>
							<span class="input-group-addon" style="border: none; background: white;">
								Status
							</span>
							<span>
								<select name="status" class="input-md" style="width: 90%;">
									<option disabled="disabled" value="">- Status -</option>
									<option value="1">Proses Verifikasi</option>
									<option value="2">Pending Verifikasi</option>
									<option value="3">Klaim</option>
								</select>
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
							<th>Nomor Kartu</th>
							<th>Nomor RM</th>
							<th>Nama Pasien</th>
							<th>No FPK</th>
							<th>Kelas Rawat</th>
							<th>Nama Poli</th>
							<th>Status</th>
							<th>Tanggal SEP</th>
							<th>Tanggal Pulang</th>
							<th>Kode INA-CBG</th>
							<th>Nama INA-CBG</th>
							<th>Biaya Pengajuan</th>
							<th>Biaya Disetujui</th>
							<th>Biaya Grouper</th>
							<th>Biaya Tarif RS</th>
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
	$('[name=tanggal_sep]').datepicker({format: 'yyyy-mm-dd'});
	$('#form').submit(function(ev) {
		ev.preventDefault();
		let $btn = $(this).find('button[type=submit]');
		let content = $btn.html();

		$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

		$.get('{{ route('vclaim.monitoring_klaim') }}', {
			tanggal_sep: $(this).find('[name=tanggal_sep]').val(),
			pelayanan: $(this).find('[name=pelayanan]').val(),
			status: $(this).find('[name=status]').val(),
		})
		.always(function() {
			$btn.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Tidak ada response dari server');
		})
		.done(function(res) {
			if(!res || !res.metaData) {
				return alert('[ERR] Tidak ada response dari server');
			}
			else if(res.metaData.code != 200) {
				return alert(res.metaData.message);
			}

			let data = res.response.klaim;
			$('#table tbody').html('');
			data.forEach(function(item) {
				$('#table tbody').append(`
					<tr>
						<td>${item.noSEP || ''}</td>
						<td>${item.peserta.noKartu || ''}</td>
						<td>${item.peserta.noMR || ''}</td>
						<td>${item.peserta.nama || ''}</td>
						<td>${item.noFPK || ''}</td>
						<td>${item.kelasRawat || ''}</td>
						<td>${item.poli || ''}</td>
						<td>${item.status || ''}</td>
						<td>${item.tglSep || ''}</td>
						<td>${item.tglPulang || ''}</td>
						<td>${item.Inacbg.kode || ''}</td>
						<td>${item.Inacbg.nama || ''}</td>
						<td>${item.biaya.byPengajuan || ''}</td>
						<td>${item.biaya.bySetujui || ''}</td>
						<td>${item.biaya.byGrouper || ''}</td>
						<td>${item.biaya.byTarifRS || ''}</td>
						<td>${item.biaya.byTopup || ''}</td>
					</tr>
					`);
			});
		});
	});
})();
</script>
@endsection