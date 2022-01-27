@extends('layouts.main')
@section('title','Pengajuan SPRI Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('pengajuan_spri','active')
@section('header','Pengajuan SPRI Pasien BPJS')
@section('subheader','Form Data')
@section('content')
<section>
	<div>
		<a href="{{route('reg-bpjs-pengajuan-spri')}}" class="btn btn-warning btn-sm"> Kembali</a>
	</div>
	<hr>
	<form action="{{route('reg-bpjs-pengajuan-spri.create')}}" method="post" class="row" id="form">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-8">
				<p><u>Form Pengajuan SPRI</u></p>
				<!-- Regno -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Nomor Registrasi</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="regno" id="regno" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $register ? $register->Regno : '' }}" required="required" {{ $register ? 'readonly' : '' }} onchange="getRegData()">
					</div>
				</div>
				<!-- Nomor Peserta -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Nomor Peserta</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="no_kartu" id="no_kartu" class="form-control input-sm col-xs-6 col-sm-6" value="{{ $register ? $register->NoPeserta : '' }}" required="required">
					</div>
				</div>
				<!-- Poli -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> Poli</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="poli" id="poli" class="form-control input-sm col-xs-6 col-sm-6" required="required">
							<option>-= Pilih Poli =-</option>
							@if (count($poli) > 0)
								@foreach ($poli as $pli)
									<option value="{{ $pli->KdBPJS }}" {{ $pli->KDPoli == $register->KdPoli ? 'selected' : '' }}>{{ $pli->NMPoli }}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				<!-- Dokter -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> Dokter</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="dokter" id="dokter" class="form-control input-sm col-xs-6 col-sm-6" required="required">
							<option>-= Pilih Dokter =-</option>
							@if ($dokter)
								@foreach ($dokter as $dok)
									<option value="{{ $dok->KdDPJP }}" {{ $dok->KdDoc == $register->KdDoc ? 'selected' : '' }}>{{ $dok->NmDoc }}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				<!-- Tanggal Rencana Kontrol -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Tanggal Rencana Kontrol</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="date" name="tanggal" class="form-control input-sm" id="poli" required="required"/>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" id="btn-pengajuan" class="btn btn-success" value="pengajuan">
			<i class="fa fa-save"></i>
			Pengajuan SPRI
		</button>
		<span id="post-message"></span>
	</form>
</section>
@endsection
@section('script')
<script>
$('document').ready(function () {
	$('#poli').select2();
                
	$('#poli').on('select2:select', function (e) {
		$.ajax({
			url: '{{ route('reg-bpjs-pengajuan-spri-req') }}',
			type: 'GET',
			dataType: 'JSON',
			data: {
				action: 'get-dokter',
				poli: e.params.data.id
			},
			success: function (data) {
				if ($('#dokter').length > 0) {
					$('#dokter').html(data.data_dokter)
				}
			}
		})
	})

	$('#dokter').select2();

	$('#regno').on('change', function () {
		$.ajax({
			url: "{{ route('reg-bpjs-pengajuan-spri-req') }}",
			type: 'GET',
			data: {
				action: 'get-register',
				Regno: $('#regno').val()
			},
			success: function (data) {
				if (data.status == 'success') {
					let register = data.register
					let poli = data.poli
					let dokter = data.dokter
					let data_dokter = data.data_dokter
					let data_poli = data.data_poli

					let opt_poli = '<option>-= Pilih Poli =-</option>';
					if (poli.length > 0) {
						poli.forEach(pol => {
							opt_poli += '<option value="' + pol.KdBPJS + '" ' + (pol.KDPoli == register.KdPoli ? 'selected' : '') + '>' + pol.NMPoli + '</option>'
						});
					}

					let opt_dok = '<option>-= Pilih Dokter =-</option>';
					if (dokter.length > 0) {
						dokter.forEach(dok => {
							opt_dok += '<option value="' + dok.KdDPJP + '" ' + (dok.KdDoc == register.KdDoc ? 'selected' : '') + '>' + dok.NmDoc + '</option>'
						});
					}
					$('#poli').html(opt_poli);
					$('#dokter').html(opt_dok);
					$('#no_kartu').val(data.register.NoPeserta)
				} else {
					alert('Registrasi tidak ditemukan')
				}
			}
		})
	});
})
</script>
@endsection