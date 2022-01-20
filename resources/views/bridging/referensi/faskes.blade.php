<div class="row">
	<div class="col-sm-12">
		<form id="form-faskes" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-8">
					<div class="input-group">
						<span class="input-group-addon" style="border: none; background: white;">
							Kode atau nama faskes:
						</span>
						<span>
							<input name="term" type="text" class="">
						</span>
						<span>
							<select class="input-md" name="faskes">
								<option disabled="disabled" value="">- Jenis Faskes -</option>
								<option value="1">Faskes 1</option>
								<option value="2">Faskes 2 / RS</option>
							</select>
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
		<table id="table-faskes" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th style="width: 180px;">Kode</th>
					<th>Faskes</th>
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
		$('#form-faskes').submit(function(ev) {
			ev.preventDefault();
			let $btn = $(this).find('button[type=submit]');
			let content = $btn.html();

			$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

			$.get('{{ route('vclaim.faskes') }}', {
				term: $(this).find('[name=term]').val(),
				faskes: $(this).find('[name=faskes]').val(),
			})
			.always(function() {
				$btn.html(content).removeAttr('disabled');
			})
			.fail(function() {
				alert('[ERR] Tidak ada response dari server');
			})
			.done(function(res) {
				if(!res || !res.faskes) {
					return alert('[ERR] Tidak ada response dari server');
				}
				else if(!res.faskes) {
					return alert(res.metaData.message);
				}

				let data = res.faskes;
				$('#table-faskes tbody').html('');
				data.forEach(function(item) {
					$('#table-faskes tbody').append(`
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