<div class="row">
	<div class="col-sm-12">
		<form id="form-ruang-rawat" class="form-horizontal" action="" method="get">
			<div class="form-group">
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-btn">
							<a id="btn-tambah" class="btn btn-success btn-sm" href="{{ route('bridging.lpk-create') }}">
								<i class="fa fa-plus"></i> Tambah LPK
							</a>
						</span>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5 class="widget-title">
					<i class="ace-icon fa fa-search"></i>
					Pencarian
				</h5>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<form id="form-list">
						<div class="row">
							<div class="col-sm-6">
								<label>No RM</label>
								<input type="text" name="no_rm" class="form-control input-sm">

								<label>Nama Pasien</label>
								<input type="text" name="nama_pasien" class="form-control input-sm">
							</div>
							<div class="col-sm-6">
								<label>Tanggal Registrasi</label>
								<input type="text" name="tanggal_mulai" class="form-control input-sm">

								<label>s/d Tanggal</label>
								<input type="text" name="tanggal_akhir" class="form-control input-sm">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="pull-right">
									<button type="submit" class="btn btn-sm btn-primary" style="margin-top: 10px;">
										<i class="fa fa-search"></i> Cari
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<table id="table-list" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>No SEP</th>
					<th>No Kartu</th>
					<th>No RM</th>
					<th>Nama Pasien</th>
					<th>Tgl Masuk</th>
					<th>Tgl Keluar</th>
					<th>User</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="7">
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
	$('#form-list [name=tanggal_mulai]').datepicker({format: 'yyyy-mm-dd'});
	$('#form-list [name=tanggal_akhir]').datepicker({format: 'yyyy-mm-dd'});
	$('#form-list').submit(function(ev) {
		ev.preventDefault();

		let $btn = $(this).find('button[type=submit]');
		let content = $btn.html();
		$btn.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

		$.get('{{ route('bridging.lpk-list') }}', {
			no_rm: $('#form-list [name=no_rm]').val(),
			nama_pasien: $('#form-list [name=nama_pasien]').val(),
			tanggal_mulai: $('#form-list [name=tanggal_mulai]').val(),
			tanggal_akhir: $('#form-list [name=tanggal_akhir]').val(),
		})
		.always(function() {
			$btn.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Gagal mendapatkan data dari server');
		})
		.success(function(res) {
			if(!res || res.length == 0) {
				return alert('Tidak ada data');
			}

			console.log(res);
		});
	});
})( window );
</script>
@endpush