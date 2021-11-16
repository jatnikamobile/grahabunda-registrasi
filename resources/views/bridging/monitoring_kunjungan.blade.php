@extends('layouts.main')
@section('title','Bridging BPJS | Daftar Kunjungan')
@section('bridging','active')
@section('daftar_kunjungan','active')
@section('header','Monitoring Kunjungan')

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
								<input name="tanggal_sep" type="text" class="" style="width: 100%;" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
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
			<table id="table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 180px;">Nomor SEP</th>
						<th>Nomor Kartu</th>
						<th>Nama Pasien</th>
						<th>Nama Poli</th>
						<th>Kelas Rawat</th>
						<th>Diagnosa</th>
						<th>Jenis Pelayanan</th>
						<th>Tanggal SEP</th>
						<th>Tanggal Pulang</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="9">
							Tidak ada data
						</td>
					</tr>
				</tbody>
			</table>
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

		$.get('{{ route('vclaim.monitoring_kunjungan') }}', {
			tanggal_sep: $(this).find('[name=tanggal_sep]').val(),
			pelayanan: $(this).find('[name=pelayanan]').val(),
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

			let data = res.response.sep;
			$('#table tbody').html('');
			data.forEach(function(item) {
				$('#table tbody').append(`
					<tr>
						<td>${item.noSep || ''}</td>
						<td>${item.noKartu || ''}</td>
						<td>${item.nama || ''}</td>
						<td>${item.poli || ''}</td>
						<td>${item.kelasRawat || ''}</td>
						<td>${item.diagnosa || ''}</td>
						<td>${item.jnsPelayanan || ''}</td>
						<td>${item.tglSep || ''}</td>
						<td>${item.tglPlgSep || ''}</td>
					</tr>
					`);
			});
		});
	});
})();
</script>
@endsection