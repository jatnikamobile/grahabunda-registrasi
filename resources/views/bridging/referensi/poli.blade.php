<div class="row">
	<div class="col-sm-12">
		<form id="form-poli" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon" style="border: none; background: white;">
							Kode atau nama poli:
						</span>
						<input name="term" type="text" class="col-xs-10 col-sm-5 form-control">
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
	<div class="col-sm-12">
		<table id="table-poli" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 180px;">Kode</th>
					<th>Poli</th>
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
		$('#form-poli').submit(function(ev) {
			ev.preventDefault();
			let $btn = $(this).find('button[type=submit]');
			let content = $btn.html();

			$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

			$.get('{{ route('vclaim.poli') }}', {
				term: $(this).find('[name=term]').val(),
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

				let data = res.poli;
				$('#table-poli tbody').html('');
				data.forEach(function(item) {
					$('#table-poli tbody').append(`
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