@extends('layouts.main')
@section('title','Bridging BPJS | Potensi Suplesi Jasa Raharja')
@section('bridging','active')
@section('suplesi','active')
@section('header','Potensi Suplesi Jasa Raharja')

@section('content')
<div class="row">
	<div class="col-sm-12">
		<form id="form-suplesi" class="form-horizontal" action="" method="get">
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
							<input placeholder="Tgl. pelayanan" name="tanggal" type="text" class="datepicker" value="{{ date('Y-m-d') }}">
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
		<table id="table-suplesi" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 180px;">No. Registrasi</th>
					<th>No. SEP</th>
					<th>No. SEP Awal</th>
					<th>No. Surat Jaminan</th>
					<th>Tanggal Kejadian</th>
					<th>Tanggal SEP</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="6">Tidak ada data</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
(function() {
	$('#form-suplesi [name=tanggal]').datepicker({format: 'yyyy-mm-dd'});
	$('#form-suplesi').submit(function(ev) {
		ev.preventDefault();
		let $btn = $(this).find('button[type=submit]');
		let content = $btn.html();

		$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

		$.get('{{ route('vclaim.potensi_suplesi') }}', {
			no_kartu: $(this).find('[name=no_kartu]').val(),
			tanggal: $(this).find('[name=tanggal]').val(),
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

			let data = res.list;
			$('#table-suplesi tbody').html('');
			data.forEach(function(item) {
				$('#table-suplesi tbody').append(`
					<tr>
						<td>${item.noRegister}</td>
						<td>${item.noSep}</td>
						<td>${item.noSepAwal}</td>
						<td>${item.noSuratJaminan}</td>
						<td>${item.tglKejadian}</td>
						<td>${item.tglSep}</td>
					</tr>
					`);
			});
		});
	});
})();
</script>
@endsection