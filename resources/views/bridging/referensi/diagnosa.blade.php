<div class="row">
	<div class="col-sm-12">
		<form id="form-diagnosa" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon" style="border: none; background: white;">
							Kode atau nama diagnosa:
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
		<table id="table-diagnosa" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 180px;">Kode</th>
					<th>Diagnosa</th>
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
		$('#form-diagnosa').submit(function(ev) {
			ev.preventDefault();
			let $btn = $(this).find('button[type=submit]');
			let content = $btn.html();

			$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

			$.get('{{ route('vclaim.diagnosa') }}', {
				term: $(this).find('[name=term]').val(),
			})
			.always(function() {
				$btn.html(content).removeAttr('disabled');
			})
			.fail(function() {
				alert('[ERR] Tidak ada response dari server');
			})
			.done(function(res) {
				if(!res || !res.diagnosa) {
					return alert('[ERR] Tidak ada response dari server');
				}
				else if(!res.diagnosa) {
					return alert(res.metaData.message);
				}

				let data = res.diagnosa;
				$('#table-diagnosa tbody').html('');
				data.forEach(function(item) {
					$('#table-diagnosa tbody').append(`
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