@extends('layouts.main')
@section('title','Registrasi Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('daftar_bpjs','active')
@section('header','Registrasi Pasien BPJS')
@section('subheader','Form Data')
@section('content')

<div class="form-group" style="margin-top: 50px">
    <label class="col-sm-1 control-label text-right no-padding-right" style="margin-top: 8px">Masukan Kode Booking</label>
    <div class="input-group col-sm-9">
        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
        <input type="text" name="regno" id="regno"/>
        <button type="submit" class="btn btn-info btn-sm" style="margin-left: 10px;" onclick="daftar()">Daftar</button>
        <div class="invalid-feedback text-danger hide" id="rekammedis-validation">
            No Rekam Medis Kosong!
        </div>
    </div>
</div>

@endsection

<script>
function daftar() {
    let regno = $('#regno').val()
    let uri = "{{ route('reg-bpjs-daftar.form-edit') }}/" + regno

    location.href = uri
}
</script>