<div class="row">
	<div class="col-sm-12">
		<form id="form-ruang-rawat" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-6">
					<div class="input-group">
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
		<table id="table-ruang-rawat" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 180px;">Kode</th>
					<th>Ruang Rawat</th>
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
		$('#form-ruang-rawat').submit(function(ev) {
			ev.preventDefault();
			let $btn = $(this).find('button[type=submit]');
			let content = $btn.html();

			$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

			$.get('{{ route('vclaim.ruang_rawat') }}')
			.always(function() {
				$btn.html(content).removeAttr('disabled');
			})
			.fail(function() {
				alert('[ERR] Tidak ada response dari server');
			})
			.done(function(res) {
				if('metaData' in res) {
					return alert(res.metaData.message);
				}

				let data = res.list;
				$('#table-ruang-rawat tbody').html('');
				data.forEach(function(item) {
					$('#table-ruang-rawat tbody').append(`
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