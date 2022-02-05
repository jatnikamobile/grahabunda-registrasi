@extends('layouts.main')
@section('title','Master Pasien | Form Data | Modul Registrasi')
@section('menu_master_ps','active')
@section('header','Master Pasien')
@section('subheader','Sync Data')
@section('content')
<section>
	<div>
		<a href="{{ route('mst-psn') }}" class="btn btn-warning btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
	</div>
	<hr>
	<form class="row" id="sync_pasien">
		{{ csrf_field() }}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					<!-- Input Tanggal -->
					<label class="col-sm-3 control-label no-padding-right">Tanggal</label>
					<div class="input-group col-sm-8">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="date" name="date_from" id="date_from" class="input-sm"  value="{{ $date_from }}" required />
						<span class="input-group-addon" id="" style="border:none;background-color:white;">s/d</span>
						<input type="date" name="date_to" id="date_to" class="input-sm"  value="{{ $date_to }}" required />
                        <input type="button" name="mulai" id="mulai" class="btn btn-success" style="margin-left: 10px" value="Mulai" />
					</div>
				</div>
			</div>
		</div>
	</form>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="overflow:auto;">
        <table class="table table-bordered" id="table-list-pasien">
            <thead>
                <tr class="info">
                    <th width="20%">Rekam Medis</th>
                    <th width="30%">Nama Pasien</th>
                    <th width="30%">Tanggal Entry</th>
                    <th width="20%">Status</th>
                </tr>
            </thead>
            <tbody id="table-sync"></tbody>
        </table>
    </div>

	<div class="modal fade modal-loading" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-loading">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
$(document).ready(function(){
    $('#sidebar').addClass('menu-min');
});

function doSync(date_from, date_to) {
    let loading = $('.modal-loading');
    let uri = "{{ route('api.api-db.sync-pasien') }}"
    
    let data = {
        params: {
            action: 'sync-data',
            date_from: date_from,
            date_to: date_to
        }
    }
    
    loading.modal('show');
    axios.get(uri, data).then(response => {
        if (response.data.status == 'success') {
            let arr_pasien = response.data.arr_pasien
            let row = ''

            if (arr_pasien.length > 0) {
                arr_pasien.forEach(pasien => {
                    if (pasien.status == 'success' || pasien.status == 'already exists') {
                        row += '<tr class="info"><td>'+ pasien.medrec +'</td><td>'+ pasien.nama +'</td><td>'+ pasien.tanggal +'</td><td>'+ pasien.status +'</td></tr>';
                    } else {
                        row += '<tr class="info"><td>'+ pasien.medrec +'</td><td colspan="3">'+ pasien.message +'</td></tr>';
                    }
                });
            }

            $('#table-sync').html(row)
        }
        loading.modal('hide');
    })
}

$('#mulai').on('click', function () {
    let date_from = $('#date_from').val()
    let date_to = $('#date_to').val()
    doSync(date_from, date_to);
})
</script>
@endsection