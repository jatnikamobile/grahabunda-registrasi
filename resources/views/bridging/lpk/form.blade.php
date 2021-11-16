@extends('layouts.main')
@section('title','Bridging BPJS | Lembar Pengajuan Klaim')
@section('bridging','active')
@section('lembar_pk','active')
@section('header','Lembar Pengajuan Klaim')
@section('content')

<style type="text/css">
	.desc-table {
		border-collapse: collapse;
	}

	.desc-table td, .desc-table th {
		border-bottom: 1px solid #ddd;
		padding: 8px 5px;
	}

	#tbl-diagnosa .primary-secondary:before {
		content: 'Sekunder';
		padding-left: 10px;
	}

	#tbl-diagnosa tr:first-child .primary-secondary:before {
		content: 'Primer'
	}
</style>

<section>
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title">Form Lembar Pengajuan Klaim</h4>

			<span class="widget-toolbar">

				<a href="#" data-action="collapse">
					<i class="ace-icon fa fa-chevron-up"></i>
				</a>
			</span>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<form id="form" action="{{ route('bridging.lpk-store') }}" method="POST">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-5">
							<label>Nomor SEP</label>
							<div class="input-group">
								<input class="form-control input-sm" type="text" name="no_sep">
								<span class="input-group-btn">
									<button id="btn-search" class="btn btn-primary btn-xs">
										<i class="fa fa-search"></i> Cari
									</button>
								</span>
							</div>

							<div class="space space-4"></div>

							<label>Nomor RM</label>
							<input class="form-control input-sm" type="text" name="no_rm" readonly="readonly">

							<div class="space space-4"></div>

							<label>Nomor Kartu</label>
							<input class="form-control input-sm" type="text" name="no_kartu" readonly="readonly">

							<div class="space space-4"></div>

							<label>Nama Pasien</label>
							<input class="form-control input-sm" type="text" name="nama_pasien" readonly="readonly">

							<label>Instalasi</label>
							<input class="form-control input-sm" type="text" name="instalasi" readonly="readonly">
						</div>
						<div class="col-md-5 col-md-offset-1">
							<label>Tanggal Masuk</label>
							<input class="form-control input-sm date-picker" type="text" name="tanggal_masuk" readonly="readonly">

							<div class="space space-4"></div>

							<label>Tanggal Keluar</label>
							<input class="form-control input-sm date-picker" type="text" name="tanggal_keluar">

							<div class="space space-4"></div>

							<label>Poli</label>
							<select class="select2 form-control input-sm" name="poli"></select>

							<div class="space space-4"></div>

							<label>DPJP</label>
							<select class="select2 form-control input-sm" name="dpjp"></select>

							<div class="space space-4"></div>

							<label>Jaminan</label>
							<select class="form-control input-sm" name="jaminan">
								<option value="1">JKN</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">
							<h3 class="header smaller lighter blue">
								<small>Perawatan</small>
							</h3>
						</div>
						<div class="col-md-5 col-md-offset-1">
							<h3 class="header smaller lighter blue">
								<small>Rencana &amp; Tindak Lanjut</small>
							</h3>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">

							<label>Ruang Rawat</label>
							<select class="select2 form-control input-sm" name="ruang_rawat"></select>

							<div class="space space-4"></div>

							<label>Kelas</label>
							<select class="select2 form-control input-sm" name="kelas"></select>

							<div class="space space-4"></div>

							<label>Spesialistik</label>
							<select class="select2 form-control input-sm" name="spesialistik"></select>

							<div class="space space-4"></div>

							<label>Cara Keluar</label>
							<select class="select2 form-control input-sm" name="cara_keluar"></select>

							<div class="space space-4"></div>

							<label>Kondisi Pulang</label>
							<select class="select2 form-control input-sm" name="kondisi_pulang"></select>
						</div>

						<div class="col-md-5 col-md-offset-1">

							<label>Tindak Lanjut</label>
							<select class="form-control input-sm" name="tindak_lanjut">
								<option value="1">Diperbolehkan Pulang</option>
								<option value="2">Pemeriksaan Penunjang</option>
								<option value="3">Dirujuk Ke</option>
								<option value="4">Kontrol Kembali</option>
							</select>

							<div class="space space-4"></div>

							<label>Poli</label>
							<select class="select2 form-control input-sm" name="tindak_lanjut_poli"></select>

							<div class="space space-4"></div>

							<label>PPK Rujukan</label>
							<select class="select2 form-control input-sm" name="ppk_rujukan"></select>

							<div class="space space-4"></div>

							<label>Tanggal Kontrol</label>
							<input type="text" name="tanggal_kontrol" class="form-control input-sm date-picker">
							
						</div>
					</div>

					<div class="row">
						<div class="col-md-10">
							<h3 class="header smaller lighter blue">
								<small>Diagnosa &amp; Prosedur</small>
							</h3>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div id="icd-options">
								<div class="row">
									<div class="col-md-8 col-sm-12">
										<div class="widget-main">
											<div style="margin-top: 30px;">
												<label>Diagnosa (ICD-10)</label>
												<select name="diagnosa" class="form-control input-sm select2" style="width: 100%;">
												</select>
												<table style="width: 100%;" class="desc-table" id="tbl-diagnosa">
												</table>
											</div>
											<div style="margin-top: 30px;">
												<label>Prosedur (ICD-9 CM)</label>
												<select name="procedure" class="form-control input-sm select2" style="width: 100%;">
												</select>
												<table style="width: 100%;" class="desc-table" id="tbl-procedure">
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-10">
							<div class="pull-right">
								<button type="submit" class="btn btn-sm btn-primary">
									<i class="fa fa-save"></i> Simpan
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

@endsection

@section('script')
<script type="text/javascript">
(function(window) {
	$('.date-picker').datepicker({format: 'yyyy-mm-dd'});

	const baseSelect2 = {
		ajax: {dataType: 'json'},
		templateResult: function(item) { return item.loading ? item.text : `<p>${item.text}</p>`; },
		escapeMarkup: function(markup) { return markup; },
		templateSelection: function(item) { return item.text; },
	};

	function select2VClaimResponse(data, params, success, withTerm) {

		withTerm = typeof withTerm === 'undefined' ? true : withTerm;

		if(!params.term && withTerm) {
			return {
				results: [{text: 'Silahkan ketik dahulu', loading: true}],
				pagination: {more: false}
			};
		}
		if(!data || !data.metaData) {
			return {
				results: [{text: '[ERR] Tidak ada respon dari server', loading: true}],
				pagination: {more: false}
			};
		}

		if(data.metaData.code != 200) {
			return {
				results: [{text: data.metaData.message, loading: true}],
				pagination: {more: false}
			};
		}

		return success(data, params);
	}

	$('#form').submit(function(ev) {
		ev.preventDefault();

		let $this = $(this).find('button[type=submit]');
		let content = $this.html();
		$this.html('<i class="fa fa-spin fa-spinner"></i> Simpan').attr('disabled', 'disabled');

		$.post($(this).attr('action'), $(this).serialize())
		.always(function() {
			$this.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Tidak ada response');
		})
		.done(function(res) {
			if(!res || !res.metaData) {
				return alert('[ERR] Tidak ada response');
			}
			else if(res.metaData.code != 200) {
				return alert(res.metaData.message);
			}
		});
	});

	$('#btn-search').click(function(ev) {
		ev.preventDefault();

		let $this = $(this);
		let content = $this.html();
		$this.html('<i class="fa fa-spin fa-spinner"></i> Cari').attr('disabled', 'disabled');

		$.get('{{ route('vclaim.sep') }}', {
			no_sep: $('[name=no_sep]').val(),
		})
		.always(function() {
			$this.html(content).removeAttr('disabled');
		})
		.fail(function() {
			alert('[ERR] Gagal mendapatkan data dari server');
		})
		.done(function(res) {
			if(!res || !res.metaData) alert('[ERR] Gagal mendapatkan data dari server');
			else if(res.metaData.code != 200) alert(res.metaData.message);
			let data = res.response;

			$('[name=no_rm]').val(data.peserta.noMr);
			$('[name=no_kartu]').val(data.peserta.noKartu);
			$('[name=instalasi]').val(data.jnsPelayanan);
			$('[name=nama_pasien]').val(data.peserta.nama);
			$('[name=tanggal_masuk]').datepicker('update', data.tglSep);
			// $('[name=tanggal_masuk]');
			// $('[name=tanggal_masuk]').val(data.tglSep);
		});
	});

	$('[name=no_sep]').keypress(function(ev) {
		if(ev.key == 'Enter') {
			ev.preventDefault();
			$('#btn-search').click();
		}
	});

	$('[name=ruang_rawat]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.ruang_rawat') }}',
			processResults: function(data, params) {
				return {
					results: data.response.list.map(function(item) {
						return $.extend(item, {
							id: item.kode,
							text: item.nama,
						});
					}),
					pagination: {more: false}
				};
			}
		}
	}));

	$('[name=kelas]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.kelas_rawat') }}',
			processResults: function(data, params) {
				return {
					results: data.response.list.map(function(item) {
						return $.extend(item, {
							id: item.kode,
							text: item.nama,
						});
					}),
					pagination: {more: false}
				};
			}
		}
	}));

	$('[name=spesialistik]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.spesialistik') }}',
			processResults: function(data, params) {
				return {
					results: data.response.list.map(function(item) {
						return $.extend(item, {
							id: item.kode,
							text: item.nama,
						});
					}),
					pagination: {more: false}
				};
			}
		}
	}));

	$('[name=cara_keluar]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.cara_keluar') }}',
			processResults: function(data, params) {
				return {
					results: data.response.list.map(function(item) {
						return $.extend(item, {
							id: item.kode,
							text: item.nama,
						});
					}),
					pagination: {more: false}
				};
			}
		}
	}));

	$('[name=kondisi_pulang]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.pasca_pulang') }}',
			processResults: function(data, params) {
				return {
					results: data.response.list.map(function(item) {
						return $.extend(item, {
							id: item.kode,
							text: item.nama,
						});
					}),
					pagination: {more: false}
				};
			}
		}
	}));

	$('[name=poli], [name=tindak_lanjut_poli]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.poli') }}',
			processResults: function(data, params) {
				return select2VClaimResponse(data, params, function(data, params) {
					return {
						results: data.response.poli.map(function(item) {
							return $.extend(item, {
								id: item.kode,
								text: item.nama,
							});
						}),
						pagination: {more: false},
					};
				});
			}
		}
	}));

	$('[name=ppk_rujukan]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.faskes') }}',
			data: function(params) {
				return $.extend(params, { faskes: 2 });
			},
			processResults: function(data, params) {
				return select2VClaimResponse(data, params, function(data, params) {
					return {
						results: data.response.faskes.map(function(item) {
							return $.extend(item, {
								id: item.kode,
								text: item.nama,
							});
						}),
						pagination: {more: false},
					};
				});
			}
		}
	}));

	$('[name=diagnosa]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.diagnosa') }}',
			processResults: function(data, params) {
				return select2VClaimResponse(data, params, function(data, params) {
					return {
						results: data.response.diagnosa.map(function(item) {
							return $.extend(item, {
								id: item.kode,
								text: item.nama,
							});
						}),
						pagination: {more: false},
					};
				});
			}
		}
	}));

	$('[name=procedure]').select2($.extend(true, baseSelect2, {
		ajax: {
			url: '{{ route('vclaim.tindakan') }}',
			processResults: function(data, params) {
				return select2VClaimResponse(data, params, function(data, params) {
					return {
						results: data.response.procedure.map(function(item) {
							return $.extend(item, {
								id: item.kode,
								text: item.nama,
							});
						}),
						pagination: {more: false},
					};
				});
			}
		}
	}));

	$.get('{{ route('vclaim.dokter_dpjp') }}', {pelayanan: 1})
	.done(function(res) {
		data = res.response.list.forEach(function(item) {
			$('[name=dpjp]').append(`<option value="${item.kode}">${item.nama}</option>`);
		});
		$('[name=dpjp]').select2();
	});

	$('[name=diagnosa],[name=procedure]').on('select2:select', function(ev) {

		let data = ev.params.data;

		addIcd($(this).attr('name'), {
			code: data.id,
			description: data.text,
		});

		$(this).html('');
	});

	function addIcd(option, item) {

		$('#tbl-' + option).append(`
			<tr code="${item.code}">
				<td>
					<input type="hidden" name="${option}[]" value="${item.code}">
					<div class="pull-right hide-on-final">
						<button class="btn btn-warning btn-minier btn-hapus-icd">
							<i class="fa fa-times"></i> Hapus
						</button>
					</div>
					${item.description}
					<span class="primary-secondary text-muted"></span>
				</td>
			</tr>
			`);
	}

	$('#tbl-procedure, #tbl-diagnosa').on('click', '.btn-hapus-icd', function() {
		$(this).parents('tr[code]').remove();
	});
})( window );
</script>
@endsection