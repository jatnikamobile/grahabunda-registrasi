<div class="row">
	<div class="col-sm-12">
		<form id="form-data" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon" style="border: none; background: white;">
							Tanggal:
						</span>
						<span>
							<input name="tanggal" type="text" class="datepicker">
						</span>
						<span>
							<select class="input-md" name="pelayanan">
								<option disabled="disabled" value="">- Jenis Pelayanan -</option>
								<option value="1">Rawat Inap</option>
								<option value="2">Rawat Jalan</option>
							</select>
						</span>
						<span class="input-group-btn">
							<button id="btn-tambah" type="submit" class="btn btn-primary btn-sm">
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
		<table id="table-data" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>No SEP</th>
					<th>No Kartu</th>
					<th>No RM</th>
					<th>Nama Pasien</th>
					<th>Jenis Kelamin</th>
					<th>Tanggal Lahir</th>
					<th>Pelayanan</th>
					<th>Tanggal Masuk</th>
					<th>Tanggal Keluar</th>
					<th>DPJP</th>
					<th>Diagnosa</th>
					<th>Prosedur</th>
					<th>Cara Keluar</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="13">
						Tidak ada data
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

@push('script-stack')
<script type="text/javascript">
(function( window ) {
	$('#form-data [name=tanggal]').datepicker({format: 'yyyy-mm-dd'});
	$('#form-data').submit(function(ev) {
		ev.preventDefault();

		let $btn = $(this).find('button[type=submit]');
		let content = $btn.html();
		$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

		$.get('{{ route('vclaim.lembar_pk') }}', {
			tanggal: $('#form-data [name=tanggal]').val(),
			pelayanan: $('#form-data [name=pelayanan]').val(),
		})
		.always(function() {
			$btn.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Gagal mendapatkan data dari server');
		})
		.success(function(res) {
			if(!res || !res.metaData) {
				return alert('[ERR] Gagal mendapatkan data dari server');
			}
			else if(res.metaData.code != 200) {
				return alert(res.metaData.message);
			}

			let data = res.response.lpk.list;
			if(data.length == 0) {
				return alert('[ERR] Tidak ada data');
			}

			data.forEach(function(item) {
				let diagnosa = item.diagnosa.list.map(function(d) {
					return `Level ${d.level}: ${d.list.kode} - ${d.list.nama}`;
				}).join('<br>');

				let procedure = item.procedure.list.map(function(p) {
					return `${p.list.kode} - ${p.list.nama}`;
				}).join('<br>');

				$('#table-data tbody').append(`
					<tr>
						<td>${item.noSep}</td>
						<td>${item.peserta.noKartu}</td>
						<td>${item.peserta.noMR}</td>
						<td>${item.peserta.nama}</td>
						<td>${item.peserta.kelamin == 'L' ? 'Laki-laki' : (item.peserta.kelamin == 'P' ? 'Perempuan' : '')}</td>
						<td>${item.jnsPelayanan == 1 ? 'Rawat Inap' : (item.jnsPelayanan == 2 ? 'Rawat Jalan' : '')}</td>
						<td>${item.tglMasuk}</td>
						<td>${item.tglKeluar}</td>
						<td>${item.DPJP.dokter.kode} - ${item.DPJP.dokter.nama}</td>
						<td>${diagnosa}</td>
						<td>${item.perawatan.caraKeluar.nama}</td>
					</tr>
					`);
			});
		});
	});
})( window );
</script>
@endpush