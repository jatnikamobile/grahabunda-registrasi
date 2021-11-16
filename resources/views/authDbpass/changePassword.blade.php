@extends('layouts.main')
@section('title','Ganti Password | Modul Registrasi')
@section('menu_beranda','active')
@section('header','Ganti Password')
@section('content')
<section>
	<div class="row">
    	<div class="col-md-6">
    		<form id="changePassword">
    			<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Display Name</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="displayName" id="displayName" class="form-control input-sm col-xs-10 col-sm-5" value="{{ Auth::user()->DisplayName }}" />
					</div>
				</div>
    			<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">*Password Dahulu</label>
					<input type="hidden" name="Username" id="Username" value="{{ @Auth::user()->NamaUser }}">
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="password" name="oldPassword" id="oldPassword" class="form-control input-sm col-xs-10 col-sm-5" value="{{ @Auth::user()->Password }}" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">*Password Baru</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="password" name="newPassword" id="newPassword" class="form-control input-sm col-xs-10 col-sm-5" required maxlength="10"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">*Confirm Password</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="password" name="confirmPassword" id="confirmPassword" class="form-control input-sm col-xs-10 col-sm-5" required maxlength="10"/>
					</div>
				</div>
				<button type="submit" class="btn btn-success btn-sm" id="btnChange" name="btnChange"><i class="fa fa-save"></i>  Simpan</button>
    		</form>
    	</div>
    </div>
</section>
@endsection
@section('script')
<script>
	$(document).ready(function(){
		console.log('Have a nice day:) by Mediantara');
	});

	$('#changePassword').submit(function(ev) {
		ev.preventDefault();
		if ($('#newPassword').val() != $('#confirmPassword').val()) {
			alert('Confirm Password tidak sama dengan Password Baru');
		} else {
			$.ajax({
				url:"{{ route('update_password') }}",
				type:"post",
				dataType:"json",
				data:{
					user: $('#Username').val(),
					displayName: $('#displayName').val(),
					oldpassword: $('#oldPassword').val(),
					newPassword: $('#newPassword').val(),
					confirmPassword: $('#confirmPassword').val()
				},
				success: function(response)
				{
					console.log(response);
					if (!response.status) {
						alert(response.message);
					} else {
						alert(response.message);
					}
				}
			});
		}
	});
</script>
@endsection