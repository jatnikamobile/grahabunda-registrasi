@extends('layouts.main')
@section('title','Beranda | Modul Registrasi')
@section('menu_beranda','active')
@section('header','Beranda')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Selamat Datang {{ Auth::user()->DisplayName == '' ? Auth::user()->NamaUser : Auth::user()->DisplayName }}</div>
        </div>
        @if(@Auth::user()->oLevel == 2)
        <h2>Informasi tanggal {{ $dateSearch }}</h2>
        <button type="button" id="btn-keyakinan" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".modal-informasi">Tambah Informasi</button>
        <form id="cariTanggal">
	        <span>Lihat Tanggal :</span>
	        <input type="date" name="tanggal" id="tanggal" value="<?=Request::input('tanggal') !== null ? Request::input('tanggal') : date('Y-m-d')?>">
	        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
        </form>
        <table border="1" class="table table-bordered">
        	<thead>
	        	<th>Keterangan</th>
	        	<th>Tanggal</th>
	        	<th>User</th>
	        </thead>
	        <tbody>
	        	@foreach($data as $l)
	        	<tr>
	        		<td>{{ $l->Informasi }}</td>
	        		<td>{{ $l->Tanggal }}</td>
	        		<td>{{ $l->ValidUser }}</td>
	        	</tr>
	        	@endforeach
	        </tbody>
        </table>
        @else
        <h2>Informasi tanggal {{ $date }}</h2>
        <ul>
        	@foreach($data as $l)
        	<li><h2>{{ $l->Informasi }}</h2></li>
        	@endforeach
        </ul>
        @endif
        
    </div>
</div>
<div class="modal fade modal-informasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-informasi">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            	<div class="modal-header">
            		<p><u>Informasi</u></p>
            	</div>
                <div class="modal-body">
                	<form id="tambahInformasi">
	                    <span>Keterangan</span>
	                    <input type="text" name="informasi" id="informasi" class="form-control">
	                    <span>Tanggal</span><br>
	                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}">
	                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
	$(document).ready(function(){
		console.log('Have a nice day:) by Mediantara');
	});

	$('#tambahInformasi').submit(function(ev) {
		$.ajax({
			url:"{{ route('post_infrmasi') }}",
			type:"post",
			dataType:"json",
			data:{
				informasi: $('#informasi').val(),
				tanggal: $('#date').val(),
			},
			success: function(response)
			{
				alert('Berhasil disimpan');
			}
		});
	});

	$('#cariTanggal').submit(function(ev) {
		$.ajax({
			url:"{{ route('beranda') }}",
			type:"get",
			dataType:"json",
			data:{
				tanggal: $('#tanggal').val()
			},
			success: function(response)
			{
				console.log(response);
			}
		});
	});
</script>
@endsection