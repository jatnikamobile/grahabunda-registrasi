<div class="row">
	<div class="col-sm-12">
		<form id="form-dokter-dpjp" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-12">
					<div class="input-group">
						<span class="input-group-addon" style="border: none; background: white;">
							Kode atau nama spesialis:
						</span>
						<span>
							<input name="spesialis" type="text" class="">
						</span>
						<span>
							<select class="input-md" name="pelayanan">
								<option disabled="disabled" value="">- Jenis Pelayanan -</option>
								<option value="1">Rawat Inap</option>
								<option value="2">Rawat Jalan</option>
							</select>
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
		<table id="table-dokter-dpjp" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 180px;">Kode</th>
					<th>Dokter DPJP</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">Tidak ada data</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

@push('script-stack')
<script type="text/javascript">
	(function() {
		$('#form-dokter-dpjp [name=tanggal]').datepicker({format: 'yyyy-mm-dd'});
		$('#form-dokter-dpjp').submit(function(ev) {
			ev.preventDefault();
			let $btn = $(this).find('button[type=submit]');
			let content = $btn.html();

			$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

			$.get('{{ route('vclaim.dokter_dpjp') }}', {
				spesialis: $(this).find('[name=spesialis]').val(),
				tanggal: $(this).find('[name=tanggal]').val(),
				pelayanan: $(this).find('[name=pelayanan]').val(),
			})
			.always(function() {
				$btn.html(content).removeAttr('disabled');
			})
			.fail(function() {
				alert('[ERR] Tidak ada response dari server');
			})
			.done(function(res) {
				if('metaData' in res) {
					if (res.metaData.code == 201) {
						return alert(res.metaData.message);
					}
				}

				let data = res.list;
				$('#table-dokter-dpjp tbody').html('');
				data.forEach(function(item) {
					$('#table-dokter-dpjp tbody').append(`
						<tr>
							<td>${item.kode}</td>
							<td>${item.nama}</td>
						</tr>
						`);
				});
			});
		});
	})();
</script>
@endpush