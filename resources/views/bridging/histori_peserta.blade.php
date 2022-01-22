@extends('layouts.main')
@section('title','Bridging BPJS | Data Histori Pelayanan Peserta')
@section('bridging','active')
@section('histori_peserta','active')
@section('header','Data Histori Pelayanan Peserta')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<form id="form-histori" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-12">
					<div class="input-group">
						<span class="input-group-addon" style="border: none; background: white;">
							No. Kartu Peserta:
						</span>
						<span>
							<input name="no_kartu" type="text" class="">
						</span>
						<span>
							<input placeholder="Dari Tanggal" name="tanggal_mulai" type="text" class="datepicker" value="{{ date('Y-m-d') }}">
						</span>
						<span>
							<input placeholder="Sampai Tanggal" name="tanggal_akhir" type="text" class="datepicker" value="{{ date('Y-m-d') }}">
						</span>

						<span>
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
	<div class="col-sm-12">
		<table id="table-histori" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 180px;">No. Kartu</th>
					<th>No. SEP</th>
					<th>No. Rujukan</th>
					<th>Nama Peserta</th>
					<th>Jenis Pelayanan</th>
					<th>Poli</th>
					<th>Kelas Rawat</th>
					<th>Diagnosa</th>
					<th>PPK Pelayanan</th>
					<th>Tanggal SEP</th>
					<th>Tanggal Pulang</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="11">Tidak ada data</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
(function() {
	$('#form-histori [name=tanggal_mulai]').datepicker({format: 'yyyy-mm-dd'});
	$('#form-histori [name=tanggal_akhir]').datepicker({format: 'yyyy-mm-dd'});
	$('#form-histori').submit(function(ev) {
		ev.preventDefault();

		if (!$(this).find('[name=no_kartu]').val()) {
			alert('Nomor Kartu Harus Diisi')
		} else {
			let $btn = $(this).find('button[type=submit]');
			let content = $btn.html();

			$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

			$.get('{{ route('vclaim.histori_peserta') }}', {
				no_kartu: $(this).find('[name=no_kartu]').val(),
				tanggal_mulai: $(this).find('[name=tanggal_mulai]').val(),
				tanggal_akhir: $(this).find('[name=tanggal_akhir]').val(),
			})
			.always(function() {
				$btn.html(content).removeAttr('disabled');
			})
			.fail(function() {
				alert('[ERR] Gagal mendapatkan data dari server');
			})
			.done(function(res) {
				if ('metaData' in res) {
					if (res.metaData.code == 201) {
						return alert(res.metaData.message);
					}
				}

				let data = res.histori;
				$('#table-histori tbody').html('');
				data.forEach(function(item) {
					$('#table-histori tbody').append(`
						<tr>
							<td>${item.noKartu}</td>
							<td>${item.noSep}</td>
							<td>${item.noRujukan}</td>
							<td>${item.namaPeserta}</td>
							<td>${item.jnsPelayanan == 1 ? 'Rawat Inap' : (item.jnsPelayanan == 2 ? 'Rawat Jalan' : '')}</td>
							<td>${item.poli}</td>
							<td>${item.kelasRawat}</td>
							<td>${item.diagnosa}</td>
							<td>${item.ppkPelayanan}</td>
							<td>${item.tglPlgSep}</td>
							<td>${item.tglSep}</td>
						</tr>
						`);
				});
			});
		}
	});
})();
</script>
@endsection