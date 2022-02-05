@extends('layouts.main')
@section('title','Master Pasien | Form Data | Modul Registrasi')
@section('menu_master_ps','active')
@section('header','Master Pasien')
@section('subheader','Form Data')
@section('content')
<section>
	<div>
		<a href="{{ route('mst-psn') }}" class="btn btn-warning btn-sm"><i class="fa fa-angle-left"></i> Kembali</a>
	</div>
	<hr>
	<form action="{{route('mst-psn.form-post')}}" method="post" class="row" id="simpan_pasien">
		{{ csrf_field() }}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<!-- Nomor RM -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"> *No Rekam Medis</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						@if(isset($edit))
							<input type="text" name="Medrec" id="Medrec" value="{{ @$edit->Medrec }}"/>
							<button type="button" name="PrintKartu" id="PrintKartu" class="btn btn-primary" target="_blank" style="margin-left: 10px;"><i class="fa fa-print"></i> Print Kartu</button>
						@else
							<input type="text" name="Medrec" class="" id="Medrec" readonly/>
							<button type="button" name="PrintKartu" id="PrintKartu" class="btn btn-primary" target="_blank" style="margin-left: 10px;"><i class="fa fa-print"></i> Print Kartu</button>
						@endif
					</div>
				</div>
				<div class="form-group">
					<!-- Input Nomor Peserta / BPJS -->
					<label class="col-sm-3 control-label no-padding-right">Nomor Peserta/BPJS</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="NoPeserta" id="NoPeserta" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->AskesNo }}" onkeydown="getPesertaBpjs(this, event)"/>
						<input type="hidden" name="kelas_bpjs" id="kelas_bpjs">
						<input type="hidden" name="jenis_peserta" id="jenis_peserta">
					</div>
				</div>
				<!-- Nama Pasien -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">*Nama Pasien</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" required value="{{ @$edit->Firstname }}"/>
					</div>
				</div>
				<!-- Tempat Laihr -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Tempat Lahir</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="Pod" id="Pod" class="form-control input-sm col-xs-10 col-sm-5" value="{{ @$edit->Pod }}"/>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Tanggal Lahir -->
					<label class="col-sm-3 control-label no-padding-right">*Tanggal Lahir</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="date" name="Bod" id="Bod" class="form-control input-sm col-xs-6 col-sm-6"  value="{{ isset($edit->Bod) ? date('Y-m-d',strtotime($edit->Bod)) : '' }}" required />
						<!-- Input Umur Tahun -->
						<span class="input-group-addon" id="" style="border:none;background-color:white;">Umur (t/b/h)</span>
						<input type="text" name="UmurThn" id="UmurThn" class="form-control input-sm col-xs-6 col-sm-3" readonly value="{{ @$edit->UmurThn }}" />
						<!-- Input Umur Bulan -->
						<span class="input-group-addon no-border-right no-border-left" id="">/</span>
						<input type="text" name="UmurBln" id="UmurBln" class="form-control input-sm col-xs-6 col-sm-3" readonly value="{{ @$edit->UmurBln }}" />
						<!-- Input Umur Hari -->
						<span class="input-group-addon no-border-right no-border-left" id="">/</span>
						<input type="text" name="UmurHari" id="UmurHari" class="form-control input-sm col-xs-6 col-sm-3" readonly value="{{ @$edit->UmurHr }}" />
					</div>
				</div>
				<!-- Jenis Kelmin -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">*Jenis Kelamin</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<!-- <input type="text" name="Pod" class="form-control input-sm col-xs-10 col-sm-5" id="Pod"/> -->
						<div class="radio">
							<label>
								<input name="KdSex" type="radio" class="ace" value="L"  {{ isset($edit->KdSex) && strtolower(strtoupper($edit->KdSex)) == 'l' ? 'checked' : '' }}/>
								<span class="lbl">&nbsp; Laki - Laki</span>
							</label>
							<label>
								<input name="KdSex" type="radio" class="ace" value="P"  {{ isset($edit->KdSex) && strtolower(strtoupper($edit->KdSex)) == 'p' ? 'checked' : '' }}/>
								<span class="lbl">&nbsp; Perempuan</span>
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Golongan Darah -->
					<label class="col-sm-3 control-label no-padding-right">Golongan Darah</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="GolDarah" id="GolDarah" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
							<option value="">-= Golongan Darah =-</option>
							@foreach (['A','B','AB','O','BELUM DIKETAHUI'] as $g)
							<option value="{{$g}}" {{ isset($edit->GolDarah) && @$edit->GolDarah == $g ? 'selected' : ''}}>{{$g}}</option>
							@endforeach
						</select>
						<!-- Input RH Darah -->
						<span class="input-group-addon" id="" style="border:none;background-color:white;">RH</span>
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="RHDarah" id="RHDarah" style="width:50%;" class="select2">
							<option value="">-= RH =-</option>
							@foreach (['+','-'] as $rh)
							<option value="{{$rh}}" {{ isset($edit->RHDarah) && @$edit->RHDarah == $rh ? 'selected' : ''}}>{{$rh}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<!-- Keyakinan dan nilai-nilai -->
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Keyakinan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="KdNilai" id="KdNilai" style="width:50%;" onchange="showDiv('btn-keyakinan', this)" class="form-control select2 input-sm col-xs-6 col-sm-6">
							<option value="">-= Keyakinan dan nilai =-</option>
							@foreach (['Ya','Tidak'] as $ke)
							<option value="{{ $ke }}" {{ isset($edit->Keyakinan) && @$edit->Keyakinan == $ke ? 'selected' : ''}}>{{ $ke }}</option>
							@endforeach
						</select>
						<button type="button" id="btn-keyakinan" class="btn btn-primary" style="display: none;" data-toggle="modal" data-target=".bd-example-modal-lg">+</button>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Kewarganegaraan -->
					<label class="col-sm-3 control-label no-padding-right">Kewarganegaraan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="WargaNegara" id="WargaNegara" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
							<option value="">-= Warga Negara =-</option>
							@foreach (['WNI','WNA'] as $wn)
							<option value="{{ $wn }}" {{ isset($edit->WargaNegara) && @$edit->WargaNegara == $wn ? 'selected' : '-= Warga Negara =-'}}>{{ $wn }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Kewarganegaraan -->
						<!-- Input Nomor Identitas / KTP -->
					<label class="col-sm-3 control-label no-padding-right">Jenis Identitas</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="JenisIdentitas" id="JenisIdentitas" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
							<option value="">-= Jenis Identitas =-</option>
							<option value="0">KTP</option>
							<option value="1">SIM</option>
							<option value="2">KTM</option>
							<option value="3">Paspor</option>
							<option value="4">KITAS</option>
							<option value="6">KIA</option>
							<option value="7">Lain-lain</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Kewarganegaraan -->
						<!-- Input Nomor Identitas / KTP -->
					<label class="col-sm-3 control-label no-padding-right">No Identitas</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="NoIden" id="NoIden" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->NoIden }}" onkeydown="getPesertaBpjsNIK(this, event)" required>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Suku -->
					<label class="col-sm-3 control-label no-padding-right">Suku</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Suku" id="Suku" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->NmSuku) ? $edit->NmSuku : ''}}">{{ isset($edit->NmSuku) ? @$edit->NmSuku : '-= Suku =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Suku -->
					<label class="col-sm-3 control-label no-padding-right">Perkawinan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Perkawinan" id="Perkawinan" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->Perkawinan) ? $edit->Perkawinan : ''}}">{{ isset($edit->Perkawinan) ? @$edit->Perkawinan : '-= Perkawinan =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Agma -->
					<label class="col-sm-3 control-label no-padding-right">Agama</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Agama" id="Agama" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->Agama) ? $edit->Agama : ''}}">{{ isset($edit->Agama) ? @$edit->Agama : '-= Agama =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Pendidikan -->
					<label class="col-sm-3 control-label no-padding-right">Pendidikan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Pendidikan" id="Pendidikan" class="form-control input-sm col-xs-6 col-sm-6" style="width:100%;">
							<option value="{{ isset($edit->Pendidikan) ? $edit->Pendidikan : ''}}">{{ isset($edit->Pendidikan) ? @$edit->Pendidikan : '-= Pendidikan =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Nama Ayah -->
					<label class="col-sm-3 control-label no-padding-right">Nama Ayah</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="NamaAyah" id="NamaAyah" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->NamaAyah }}" />
					</div>
				</div>
				<div class="form-group">
					<!-- Input Nama Ibu -->
					<label class="col-sm-3 control-label no-padding-right">Nama Ibu</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="NamaIbu" id="NamaIbu" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->NamaIbu }}" />
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="form-group">
					<!-- Kategori Pasien -->
					<label class="col-sm-3 control-label no-padding-right">Kategori Pasien</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="Kategori" id="Kategori" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6" required>
							<option value="{{ isset($edit->Kategori) ? $edit->Kategori : ''}}">{{ isset($edit->NmKategori) ? @$edit->NmKategori : '-= Kategori =-'}}</option>
						</select>
					</div>
				</div>
				<input type="hidden" name="GroupUnit" value="379">
				<input type="hidden" name="Unit" value="382">
				{{-- <div class="form-group">
					<!-- Input Group Unit -->
					<label class="col-sm-3 control-label no-padding-right">Group Unit</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="GroupUnit" id="GroupUnit" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" required>
							<option value="{{ isset($edit->GroupUnit) ? $edit->GroupUnit : ''}}">{{ isset($edit->GroupUnit) ? @$edit->GroupUnit : '-= GroupUnit =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Unit</label>
					<div class="input-group col-sm-9">
						<!-- Input Unit -->
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="Unit" id="Unit" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6 select2" required>
							<option value="{{ isset($edit->NmUnit) ? $edit->NmUnit : ''}}">{{ isset($edit->NmUnit) ? @$edit->NmUnit : '-= Unit =-'}}</option>
						</select>
						<span class="input-group-addon" id="" style="border:none;background-color:white;">&emsp;</span>
						<select name="korpUnit" id="korpUnit" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6 select2">
							<option value="">-= Sub Unit =-</option>
							<option value="{{ isset($edit->SubUnit) ? $edit->SubUnit : ''}}">{{ isset($edit->SubUnit) ? @$edit->SubUnit : '-= Unit =-'}}</option>
						</select>
					</div>
				</div> --}}
				<div class="form-group">
					<!-- Input Nama Keluarga Dinas -->
					<label class="col-sm-3 control-label no-padding-right">Nama Kel Dinas</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="NamaKelDinas" id="NamaKelDinas" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->NamaKelDinas }}"/>
						<!-- Input NRP / NIP -->
						<span class="input-group-addon" id="" style="border:none;background-color:white;">NRP / NIP</span>
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="Nrp" id="Nrp" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->NrpNip }}"/>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Kesatuan -->
					<label class="col-sm-3 control-label no-padding-right">Kesatuan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="NmKesatuan" id="NmKesatuan" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->NmKesatuan }}"/>
						<!-- <select name="NmKesatuan" id="NmKesatuan" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->NmKesatuan) ? $edit->NmKesatuan : ''}}">{{ isset($edit->NmKesatuan) ? $edit->NmKesatuan : '-= Kesatuan =-'}}</option>
						</select> -->
					</div>
				</div>
				<div class="form-group">
					<!-- Input Pangkat -->
					<label class="col-sm-3 control-label no-padding-right">Pangkat</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="GroupPangkat" id="GroupPangkat" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->GroupPangkat) ? $edit->GroupPangkat : ''}}">{{ isset($edit->GroupPangkat) ? $edit->GroupPangkat : '-= Group Pangkat =-'}}</option>
						</select>
						<span class="input-group-addon" id="" style="border:none;background-color:white;">&emsp;</span>
						<select name="NmPangkat" id="NmPangkat" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->NmPangkat) ? $edit->NmPangkat : ''}}">{{ isset($edit->NmPangkat) ? $edit->NmPangkat : '-= Pangkat =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Golongan -->
					<label class="col-sm-3 control-label no-padding-right">Golongan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="NmGol" id="NmGol" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->NmGol) ? $edit->NmGol : ''}}">{{ isset($edit->NmGol) ? $edit->NmGol : '-= Golongan =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Pekerjaan -->
					<label class="col-sm-3 control-label no-padding-right">Pekerjaan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select name="Pekerjaan" id="Pekerjaan" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
							<option value="{{ isset($edit->Pekerjaan) ? $edit->Pekerjaan : ''}}">{{ isset($edit->Pekerjaan) ? $edit->Pekerjaan : '-= Pekerjaan =-'}}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<!-- Input Korp -->
					<label class="col-sm-3 control-label no-padding-right">Korp</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" class="form-control input-sm" name="NmKorp" id="NmKorp" value="{{ @$edit->NmKorp }}">
					</div>
				</div>
				<div class="form-group">
					<!-- Tanggal Daftar -->
					<label class="col-sm-3 control-label no-padding-right">Tanggal Daftar</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="date" name="TglDaftar" id="TglDaftar" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->TglDaftar) ? date('Y-m-d',strtotime($edit->TglDaftar)) : date('Y-m-d') }}" readonly/>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<p><u>Alamat Pasien</u></p>
				<div class="form-group">
					<!-- Input Kelurahan -->
					<label class="col-sm-3 control-label no-padding-right">Kelurahan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Kelurahan" id="Kelurahan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
							<option value="{{ isset($edit->KdKelurahan) ? $edit->KdKelurahan : ''}}">{{ isset($edit->Kelurahan) ? $edit->Kelurahan : '-= Kelurahan =-'}}</option>
						</select>
						<input type="hidden" name="NmKelurahan" id="NmKelurahan" value="{{ @$edit->Kelurahan }}">
					</div>
				</div>
				<div class="form-group">
					<!-- Input Kecamatan -->
					<label class="col-sm-3 control-label no-padding-right">Kecamatan</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Kecamatan" id="Kecamatan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
							<option value="{{ isset($edit->Kecamatan) ? $edit->Kecamatan : ''}}">{{ isset($edit->Kecamatan) ? $edit->Kecamatan : '-= Kecamatan =-'}}</option>
						</select>
						<input type="hidden" name="NmKecamatan" id="NmKecamatan" value="{{ @$edit->Kecamatan }}">
					</div>
				</div>
				<div class="form-group">
					<!-- Input Kota / Kabupaten -->
					<label class="col-sm-3 control-label no-padding-right">Kabupaten/Kota</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Kabupaten" id="Kabupaten" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
							<option value="{{ isset($edit->City) ? $edit->City : ''}}">{{ isset($edit->City) ? $edit->City : '-= Kabupaten/Kota =-'}}</option>
						</select>
						<input type="hidden" name="NmKabupaten" id="NmKabupaten" value="{{ @$edit->City }}">
					</div>
				</div>
				<div class="form-group">
					<!-- Input Provinsi -->
					<label class="col-sm-3 control-label no-padding-right">Provinsi</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<select type="text" name="Provinsi" id="Provinsi" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
							<option value="{{ isset($edit->Propinsi) ? $edit->Propinsi : ''}}">{{ isset($edit->Propinsi) ? $edit->Propinsi : '-= Propinsi =-'}}</option>
						</select>
						<input type="hidden" name="NmProvinsi" id="NmProvinsi" value="{{ @$edit->Propinsi }}">
					</div>
				</div>
				<div class="form-group">
					<!-- Alamat -->
					<label class="col-sm-3 control-label no-padding-right">Alamat</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="Alamat" id="Alamat" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->Address }}" />
					</div>
				</div>
				<div class="form-group">
					<!-- Kode Pos -->
					<label class="col-sm-3 control-label no-padding-right">Kode Pos</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="KdPos" id="KdPos" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->KdPos }}" />
						<!-- Input Nomor Telepon -->
						<span class="input-group-addon" id="" style="border:none;background-color:white;">No. Telepon</span>
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="Phone" id="Phone" class="form-control input-sm col-xs-6 col-sm-6" required value="{{ @$edit->Phone }}" />
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
				<p><u>Penanggung Jawab</u></p>
				<div class="form-group">
					<!-- Nama Penanggung Jawab -->
					<label class="col-sm-3 control-label no-padding-right">Nama</label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="NamaPJ" id="NamaPJ" class="form-control input-sm col-xs-6 col-sm-6" required  value="{{ @$edit->NamaPJ }}" />
					</div>
				</div>
				<div class="form-group">
					<!-- Pekerjaan Penanggung Jawab -->
					<label class="col-sm-3 control-label no-padding-right">Pekerjaan </label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="PekerjaanPJ" id="PekerjaanPJ" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->PekerjaanPJ }}" />
					</div>
				</div>
				<div class="form-group">
					<!-- Kontak Penanggung Jawab -->
					<label class="col-sm-3 control-label no-padding-right">Kontak </label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="PhonePJ" id="PhonePJ" class="form-control input-sm col-xs-6 col-sm-6" required  value="{{ @$edit->PhonePJ }}" />
					</div>
				</div>
				<div class="form-group">
					<!-- Pekerjaan Penanggung Jawab -->
					<label class="col-sm-3 control-label no-padding-right">Hubungan </label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="HungunganPJ" id="HungunganPJ" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->HubunganPJ }}" />
					</div>
				</div>
				<div class="form-group">
					<!-- Alamat Penanggung Jawab -->
					<label class="col-sm-3 control-label no-padding-right">Alamat </label>
					<div class="input-group col-sm-9">
						<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
						<input type="text" name="AlamatPJ" id="AlamatPJ" class="form-control input-sm col-xs-6 col-sm-6" required  value="{{ @$edit->AlamatPJ }}" />
					</div>
				</div>
			</div>
		</div>
		<input type="submit" name="simpan" id="simpan" class="btn btn-success" value="Simpan" />
		<button type="button" name="printDetail" id="printDetail" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print Detail Pasien</button>
	</form>
	<div class="modal fade modal-loading" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-loading">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Keyakinan dan Nilai-nilai</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<form method="post">
						<p><u>Data Pasien</u></p>
						<div class="form-group">
							<!-- No RM -->
							<label class="col-sm-3 control-label no-padding-right">No RM</label>
							<div class="input-group col-sm-3">
								<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
								<input type="text" name="ke_NoRM" id="ke_NoRM" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->Medrec }}" />
							</div>
						</div>
						<div class="form-group">
							<!-- Nama Pasien -->
							<label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
							<div class="input-group col-sm-9">
								<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
								<input type="text" name="ke_Firstname" id="ke_Firstname" class="form-control input-sm col-xs-6 col-sm-6" readonly placeholder="Nama Pasien" value="{{ @$edit->Firstname }}" />
							</div>
						</div>
						<div class="form-group">
							<!-- Tanggal Transaksi -->
							<label class="col-sm-3 control-label no-padding-right">Tanggal Transaksi</label>
							<div class="input-group col-sm-3">
								<span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
								<input type="date" readonly name="TglTransaksi" id="TglTransaksi" class="form-control input-sm col-xs-6 col-sm-6" value="<?=date('Y-m-d')?>"/>
							</div>
						</div>
						<p><u>Keyakinan dan Nilai-nilai</u></p>
						<div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">1. Pantang Hari/Pulang</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <!-- <input type="text" name="Pod" class="form-control input-sm col-xs-10 col-sm-5" id="Pod"/> -->
                                <div class="radio">
                                    <label>
                                        <input name="pantang" type="radio" class="ace" value="1" {{ isset($edit->phcek) && strtolower(strtoupper($edit->phcek)) == '1' ? 'checked' : 'checked' }} />
                                        <span class="lbl">&nbsp; Tidak</span>
                                    </label>
                                    <label>
                                        <input name="pantang" type="radio" class="ace" value="2" {{ isset($edit->phcek) && strtolower(strtoupper($edit->phcek)) == '2' ? 'checked' : '' }}/>
                                        <span class="lbl">&nbsp; Ya</span>
                                    </label>
                                </div>
                                <input type="text" name="pantangNote" id="pantangNote" class="form-control input-sm col-sm-3" value="{{ @$edit->phnote }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">2. Pantang tindakan</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <!-- <input type="text" name="Pod" class="form-control input-sm col-xs-10 col-sm-5" id="Pod"/> -->
                                <div class="radio">
                                    <label>
                                        <input name="tindakan" type="radio" class="ace" value="1" {{ isset($edit->ptcek) && strtolower(strtoupper($edit->ptcek)) == '1' ? 'checked' : 'checked' }} />
                                        <span class="lbl">&nbsp; Tidak</span>
                                    </label>
                                    <label>
                                        <input name="tindakan" type="radio" class="ace" value="2" {{ isset($edit->ptcek) && strtolower(strtoupper($edit->ptcek)) == '2' ? 'checked' : '' }}/>
                                        <span class="lbl">&nbsp; Ya</span>
                                    </label>
                                </div>
                                <input type="text" name="tindakanNote" id="tindakanNote" class="form-control input-sm col-sm-3" value="{{ @$edit->ptnote }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">3. Pantang Makan</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <!-- <input type="text" name="Pod" class="form-control input-sm col-xs-10 col-sm-5" id="Pod"/> -->
                                <div class="radio">
                                    <label>
                                        <input name="makan" type="radio" class="ace" value="1" {{ isset($edit->pmcek) && strtolower(strtoupper($edit->pmcek)) == '1' ? 'checked' : 'checked' }} />
                                        <span class="lbl">&nbsp; Tidak</span>
                                    </label>
                                    <label>
                                        <input name="makan" type="radio" class="ace" value="2" {{ isset($edit->pmcek) && strtolower(strtoupper($edit->pmcek)) == '2' ? 'checked' : '' }}/>
                                        <span class="lbl">&nbsp; Ya</span>
                                    </label>
                                </div>
                                <input type="text" name="makanNote" id="makanNote" class="form-control input-sm col-sm-3" value="{{ @$edit->pmnote }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">4. Pantang Perawatan oleh lawan jenis</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <!-- <input type="text" name="Pod" class="form-control input-sm col-xs-10 col-sm-5" id="Pod"/> -->
                                <div class="radio">
                                    <label>
                                        <input name="pantangPerawatan" type="radio" class="ace" value="1" {{ isset($edit->ppcek) && strtolower(strtoupper($edit->ppcek)) == '1' ? 'checked' : 'checked' }} />
                                        <span class="lbl">&nbsp; Tidak</span>
                                    </label>
                                    <label>
                                        <input name="pantangPerawatan" type="radio" class="ace" value="2" {{ isset($edit->ppcek) && strtolower(strtoupper($edit->ppcek)) == '2' ? 'checked' : '' }}/>
                                        <span class="lbl">&nbsp; Ya</span>
                                    </label>
                                </div>
                                <input type="text" name="pantangPerawatanNote" id="pantangPerawatanNote" class="form-control input-sm col-sm-3" value="{{ @$edit->ppnote }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right">Lain - lain</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="lain" id="lain" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->lain }}" />
                            </div>
                        </div>
						<input type="submit" name="submit" id="simpan_keyakinan" class="btn btn-success" value="Simpan" />
					</form>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="form_type" id="form_type">
</section>
@endsection
@section('script')
<script>
	$(document).ready(function(){
		$('#sidebar').addClass('menu-min');

		let form_type = $('#Medrec').val() ? 'update' : 'insert'
		$('#form_type').val(form_type)
	});
	$(".select2").select2();
	// ====================================
	// ==============================================================
	$('#simpan_keyakinan').on("click", function(ev) {
		ev.preventDefault();
		$.ajax({
			url:"{{ route('keyakinan-post') }}",
			type:"post",
			dataType:"json",
			data:{
				medrec: $('#ke_NoRM').val(),
				phcek: $('input[name=pantang]:checked').val(),
				phnote: $('#pantangNote').val(),
				ptcek: $('input[name=tindakan]:checked').val(),
				ptnote: $('#tindakanNote').val(),
				pmcek: $('input[name=makan]:checked').val(),
				pmnote: $('#makanNote').val(),
				ppcek: $('input[name=pantangPerawatan]:checked').val(),
				ppnote: $('#pantangPerawatanNOte').val(),
				lain: $('[name=lain]').val()
			},
			success: function(response)
			{
				alert('Berhasil disimpan');
			}
		})
		$('.bd-example-modal-lg').modal('hide');
	});

	function getPesertaBpjs(el, ev) {
		if (ev.keyCode == 13) {
			ev.preventDefault()
			let loading = $('.modal-loading');

			$.ajax({
				url:"{{ route('peserta-kartu-bpjs') }}",
				type:"get",
				dataType:"json",
				data:{
					nopeserta: el.value,
				},
				beforeSend(){
					loading.modal('show');
				},
				success:function(response)
				{
					let data_peserta = response.data.peserta
					console.log(data_peserta);
					$('#NoIden').val(data_peserta.nik)
					$('#kelas_bpjs').val(data_peserta.hakKelas.kode);
					$('#jenis_peserta').val(data_peserta.jenisPeserta.keterangan);
					$('#Firstname').val(data_peserta.nama)
					$('#Bod').val(data_peserta.tglLahir)
					$('#Bod').change()
					$('input[name=KdSex]').filter('[value="'+ data_peserta.sex +'"]').attr('checked', true)
					loading.modal('hide');
				}
			})
		}
	}

	function getPesertaBpjsNIK(el, ev) {
		if (ev.keyCode == 13) {
			ev.preventDefault()
			let loading = $('.modal-loading');

			$.ajax({
				url:"{{ route('peserta-nik') }}",
				type:"get",
				dataType:"json",
				data:{
					nik: el.value,
				},
				beforeSend(){
					loading.modal('show');
				},
				success:function(response)
				{
					let data_peserta = response.data.peserta
					console.log(data_peserta);
					$('#NoPeserta').val(data_peserta.noKartu)
					$('#kelas_bpjs').val(data_peserta.hakKelas.kode);
					$('#jenis_peserta').val(data_peserta.jenisPeserta.keterangan);
					$('#Firstname').val(data_peserta.nama)
					$('#Bod').val(data_peserta.tglLahir)
					$('#Bod').change()
					$('input[name=KdSex]').filter('[value="'+ data_peserta.sex +'"]').attr('checked', true)
					loading.modal('hide');
				}
			})
		}
	}

	function registerApiPasien() {
		$.ajax({
			url: "{{ config('app.api_db_url') }}/api/master/pasien",
			type: 'POST',
			dataType: 'JSON',
			data: {
				I_RekamMedis: $('[name=Medrec]').val(),
				N_Pasien: $('[name=Firstname]').val(),
				N_Keluarga: $('[name=NamaPJ]').val(),
				D_Lahir: $('[name=Bod]').val(),
				A_Lahir: $('[name=Pod]').val(),
				A_Rumah: $('[name=Alamat]').val(),
				I_Telepon: $('[name=Phone]').val(),
				I_Kelurahan: $('#Kelurahan').val(),
				Kota: $('[name=NmKabupaten]').val(),
				I_Agama: $('[name=Agama]').val(),
				C_Sex: $('input[name=KdSex]:checked').val(),
				C_WargaNegara: $('[name=WargaNegara]').val(),
				I_Pendidikan: $('[name=Pendidikan]').val(),
				I_Pekerjaan: $('[name=Pekerjaan]').val(),
				C_StatusKawin: $('[name=Perkawinan]').val(),
				I_GolDarah:  $('[name=GolDarah]').val(),
				// I_JenisIdentitas: I_JenisIdentitas,
				I_NoIdentitas: $('[name=NoIden]').val(),
				// Kd_Asuransi: Kd_Asuransi,
				// C_Asuransi: C_Asuransi,
				C_KodePos: $('[name=KdPos]').val(),
				I_SukuBangsa: $('[name=Suku]').val(),
				// I_Jabatan: I_Jabatan,
				// Pemegang_Asuransi: Pemegang_Asuransi,
				// I_Entry: I_Entry,
				D_Entry: '{{ date('Y-m-d H:i:s') }}',
				// IsCetak: IsCetak,
				// Foto: Foto,
				// N_Foto: N_Foto,
				// E_Foto: E_Foto,
			},
			success: function (data) {
				//
			}
		});
	}

	$('#simpan_pasien').submit(function(ev) {
		ev.preventDefault();
		let loading = $('.modal-loading');
        loading.modal('show');
        
        let btn = $('#simpan');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        btn.prop('disabled', true);
		var getdata = $('input[name=KdSex]:checked').val();
		if ($('#Firstname').val() == '') {
			alert('Nama Pasien tidak boleh kosong');
		} else if ($('#UmurThn').val() == '')  {
			alert('Tanggal lahir Pasien tidak boleh kosong');
		} else if(($('input[name=KdSex]:checked').length) <= 0 ) {
			alert('Pilih jenis kelamin Pasien');
		} else if ($('#Firstname').val() != '' && $('#UmurThn').val() != '' && $('#Phone').val() != '')  {
			$.ajax({
                url:"{{ route('mst-psn.form-post') }}",
                type:"post",
                dataType:"json",
                data:{
                	Medrec: $('[name=Medrec]').val(),
					Firstname: $('[name=Firstname]').val(),
					Pod: $('[name=Pod]').val(),
					Bod: $('[name=Bod]').val(),
					UmurThn: $('[name=UmurThn]').val(),
					UmurBln: $('[name=UmurBln]').val(),
					UmurHari: $('[name=UmurHari]').val(),
					Pod: $('[name=Pod]').val(),
					KdSex: $('input[name=KdSex]:checked').val(),
					GolDarah: $('[name=GolDarah]').val(),
					RHDarah: $('[name=RHDarah]').val(),
					KdNilai: $('[name=KdNilai]').val(),
					WargaNegara: $('[name=WargaNegara]').val(),
					JenisIdentitas: $('[name=JenisIdentitas]').val(),
					NoIden: $('[name=NoIden]').val(),
					Suku: $('[name=Suku]').val(),
					Perkawinan: $('[name=Perkawinan]').val(),
					Agama: $('[name=Agama]').val(),
					Pendidikan: $('[name=Pendidikan]').val(),
					NamaAyah: $('[name=NamaAyah]').val(),
					NamaIbu: $('[name=NamaIbu]').val(),
					Kategori: $('[name=Kategori]').val(),
					GroupUnit: $('[name=GroupUnit]').val(),
					Unit: $('[name=Unit]').val(),
					korpUnit: $('[name=korpUnit]').val(),
					NamaKelDinas: $('[name=NamaKelDinas]').val(),
					Nrp: $('[name=Nrp]').val(),
					NmKesatuan: $('[name=NmKesatuan]').val(),
					GroupPangkat: $('[name=GroupPangkat]').val(),
					NmPangkat: $('[name=NmPangkat]').val(),
					NmGol: $('[name=NmGol]').val(),
					Pekerjaan: $('[name=Pekerjaan]').val(),
					NmKorp: $('[name=NmKorp]').val(),
					NoPeserta: $('[name=NoPeserta]').val(),
					TglDaftar: $('[name=TglDaftar]').val(),
					NmKelurahan: $('[name=NmKelurahan]').val(),
					Kelurahan: $('#Kelurahan').val(),
					NmKecamatan: $('[name=NmKecamatan]').val(),
					NmKabupaten: $('[name=NmKabupaten]').val(),
					NmProvinsi: $('[name=NmProvinsi]').val(),
					Alamat: $('[name=Alamat]').val(),
					KdPos: $('[name=KdPos]').val(),
					Phone: $('[name=Phone]').val(),
					NamaPJ: $('[name=NamaPJ]').val(),
					PekerjaanPJ: $('[name=PekerjaanPJ]').val(),
					PhonePJ: $('[name=PhonePJ]').val(),
					HungunganPJ: $('[name=HungunganPJ]').val(),
					AlamatPJ: $('[name=AlamatPJ]').val(),
					kelas_bpjs: $('[name=kelas_bpjs]').val(),
					jenis_peserta: $('[name=jenis_peserta]').val(),
					form_type: $('[name=form_type]').val(),
                },beforeSend(){
	                loading.modal('show');
	            },error: function(response){
                    alert('Gagal menambahkan/server down, Silahkan coba lagi');
                    loading.modal('hide');
                    btn.prop('disabled', false);
                    btn.html(oldText);
                },
                success:function(response)
                {
                    console.log(response);
                    alert(response.message);
                    $('#Medrec').val(response.data.Medrec);
					loading.modal('hide');
                    btn.prop('disabled', false);
                    btn.html(oldText);

					// registerApiPasien();
                }
            });
		}
		btn.prop('disabled', false);
        btn.html(oldText);
	});

	$('#PrintKartu').on('click', function(ev) {
		ev.preventDefault();
		let loading = $('.modal-loading');
        if ($('#Medrec').val() != '') {
        	loading.modal('show');
            $.ajax({
                url:"{{ route('mst-psn.print-kartu2') }}",
                type:"get",
                dataType:"html",
                data:{
                    Medrec: $('#Medrec').val(),
                },
                success: function(response)
                {
                    loading.modal('hide');
                    var w = window.open();
                    // $(w.document.body).html(response);
                    w.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(response)+"'></iframe>");
                }
            });
        } else {
            alert('No Rekam Medis kosong!');
        }
        loading.modal('hide');
	});

	$('#printDetail').on('click', function(ev) {
		ev.preventDefault();
		let loading = $('.modal-loading');
        if ($('#Medrec').val() != '') {
        	loading.modal('show');
            $.ajax({
                url:"{{ route('mst-psn.print') }}",
                type:"get",
                dataType:"html",
                data:{
                    Medrec: $('#Medrec').val(),
                },
                success: function(response)
                {
                    loading.modal('hide');
                    var w = window.open();
                    $(w.document.body).html(response);
                    // w.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(response)+"'></iframe>");
                }
            });
        } else {
            alert('No Rekam Medis kosong!');
        }
        loading.modal('hide');
	});

	function showDiv(divId, element)
	{
		document.getElementById(divId).style.display = element.value == 'Ya' ? 'block' : 'none';
	}
	$('#Suku').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.suku')}}",
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NmSuku;
						item.text = item.NmSuku;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
					${item.KdSuku} - ${item.NmSuku}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#Agama').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.agama')}}",
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NmAgama;
						item.text = item.NmAgama;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
					${item.KdAgama} - ${item.NmAgama}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#Perkawinan').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.perkawinan')}}",
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NmKawin;
						item.text = item.NmKawin;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
				   ${item.KdKawin} - ${item.NmKawin}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#Pendidikan').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.pendidikan')}}",
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NmDidik;
						item.text = item.NmDidik;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
				   ${item.KdDidik} - ${item.NmDidik}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#Kategori').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.kategori-pasien')}}",
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.KdKategori;
						item.text = item.NmKategori;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
				   ${item.KdKategori} - ${item.NmKategori}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#GroupUnit').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.group-unit')}}",
			dataType: 'json',
			data: function(params) {
				return {
					ktg : $('#Kategori option:selected').val(),
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.GroupUnit;
						item.text = item.GroupUnit;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},
		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
				   ${item.GroupUnit}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#Unit').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.unit-kategori')}}",
			dataType: 'json',
			data: function(params) {
				return {
					ktg : $('#Kategori option:selected').val(),
					group_ktg : $('#GroupUnit option:selected').val(),
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NmUnit;
						item.text = item.NmUnit;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},
		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}
			return `
				<p>
				   ${item.NmUnit}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});

	let gorengan = '';
	$('#Unit').on('change', function() {
		$('#korpUnit').html("<option value=''>-= Sub Unit =-</option>");
		if ($('#GroupUnit option:selected').text() == 'DINAS') {
			// var list = document.getElementById("korpUnit");
			$('#korpUnit').html("<option value=''>-= Sub Unit =-</option><option value='SUAMI'>SUAMI</option><option value='ISTRI'>ISTRI</option><option value='ANAK 1'>ANAK 1</option><option value='ANAK 2'>ANAK 2</option><option value='ANAK 3'>ANAK 3</option>");
		}

		if ($('#Unit option:selected').text() == "KELUARGA AU") {
			gorengan = 'TNI AU';
			// $('#Unit').val(text).change(text);
		} else {
			gorengan = $('#Unit option:selected').val();
		}
	});

	// $('#NmKesatuan').select2({
	// 	ajax: {
	// 		// api/get_ppk
	// 		url:"{{route('api.select2.kesatuan')}}",
	// 		dataType: 'json',
	// 		data: function(params) {
	// 			return {
	// 				angkatan : gorengan,
	// 				q: params.term,
	// 				offset: (params.page || 0) * 20
	// 			};
	// 		},
	// 		processResults: function(data, params) {
	// 			return {
	// 				results: data.data.map(function(item){
	// 					item.id = item.NmKeSatuan;
	// 					item.text = item.NmKeSatuan;
	// 					return item;
	// 				}),
	// 				pagination: {
	// 					more: data.has_next
	// 				}
	// 			}
	// 		},
	// 	},
	// 	templateResult: function(item) {
	// 		if(item.loading) {
	// 			return item.text;
	// 		}

	// 		return `
	// 			<p>
	// 			   ${item.NmKeSatuan}
	// 			</p>
	// 		`;
	// 	},
	// 	escapeMarkup: function(markup) {
	// 		return markup;
	// 	},
	// 	templateSelection: function(item) {
	// 		return item.text;
	// 	},
	// });
	$('#GroupPangkat').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.group-pangkat')}}",
			dataType: 'json',
			data: function(params) {
				return {
					angkatan : gorengan,
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.GroupPangkat;
						item.text = item.GroupPangkat;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},
		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
				   ${item.GroupPangkat}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#NmPangkat').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.pangkat')}}",
			dataType: 'json',
			data: function(params) {
				return {
					angkatan : gorengan,
					group : $('#GroupPangkat option:selected').val(),
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NmPangkat;
						item.text = item.NmPangkat;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},
		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
				   ${item.NmPangkat}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#NmGol').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.golongan')}}",
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NAMAGOL;
						item.text = item.NAMAGOL;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
					${item.NAMAGOL}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});
	$('#Pekerjaan').select2({
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.pekerjaan')}}",
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term,
					offset: (params.page || 0) * 20
				};
			},
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.NmKerja;
						item.text = item.NmKerja;
						return item;
					}),
					pagination: {
						more: data.has_next
					}
				}
			},
		},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `
				<p>
					${item.KdKerja} - ${item.NmKerja}
				</p>
			`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	});


	// $('#NmKorp').select2({
	// 	ajax: {
	// 		// api/get_ppk
	// 		url:"{{route('api.select2.korp')}}",
	// 		dataType: 'json',
	// 		data: function(params) {
	// 			return {
	// 				angkatan : $('#Unit option:selected').val(),
	// 				q: params.term,
	// 				offset: (params.page || 0) * 20
	// 			};
	// 		},
	// 		processResults: function(data, params) {
	// 			return {
	// 				results: data.data.map(function(item){
	// 					item.id = item.KdKorp;
	// 					item.text = item.NmKorp;
	// 					return item;
	// 				}),
	// 				pagination: {
	// 					more: data.has_next
	// 				}
	// 			}
	// 		},
	// 	},

	// 	templateResult: function(item) {
	// 		if(item.loading) {
	// 			return item.text;
	// 		}

	// 		return `
	// 			<p>
	// 				${item.KdKorp} - ${item.NmKorp}
	// 			</p>
	// 		`;
	// 	},
	// 	escapeMarkup: function(markup) {
	// 		return markup;
	// 	},
	// 	templateSelection: function(item) {
	// 		return item.text;
	// 	},
	// });

	const baseSelect2 = {
		ajax: {dataType: 'json'},

		templateResult: function(item) {
			if(item.loading) {
				return item.text;
			}

			return `<p>${item.text}</p>`;
		},
		escapeMarkup: function(markup) {
			return markup;
		},
		templateSelection: function(item) {
			return item.text;
		},
	};

	$('#Provinsi').select2($.extend(true, baseSelect2, {
		ajax: {
			url: "{{ route('api.select2.provinsi') }}",
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item) {

						return $.extend(item, {
							id: item.KdPropinsi,
							text: item.NmPropinsi,
						});
					}),
					pagination: { more: data.next_page_url }
				}
			},
		}
	}));

	$('#Kabupaten').select2($.extend(true, baseSelect2, {
		ajax: {
			url: "{{ route('api.select2.kabupaten') }}",
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item) {

						return $.extend(item, {
							id: item.KdKabupaten,
							text: item.NmKabupaten,
						});
					}),
					pagination: { more: data.next_page_url }
				}
			},
		},
		templateResult: function(item) {
			return item.loading ? item.text : `
			<p>${item.text}</p>
			<small>Kota/Kab. ${item.propinsi.NmPropinsi}</small>`;
		},
	}));

	$('#Kecamatan').select2($.extend(true, baseSelect2, {
		ajax: {
			url: "{{ route('api.select2.kecamatan') }}",
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.KdKecamatan;
						item.text = item.NmKecamatan;
						return item;
					}),
					pagination: { more: data.next_page_url }
				}
			},
		},
		templateResult: function(item) {
			return item.loading ? item.text : `
			<p>${item.text}</p>
			<small>Kota/Kab. ${item.kabupaten.NmKabupaten}</small>`;
		},
	}));

	$('#Kelurahan').select2($.extend(true, baseSelect2, {
		ajax: {
			// api/get_ppk
			url:"{{route('api.select2.kelurahan')}}",
			processResults: function(data, params) {
				return {
					results: data.data.map(function(item){
						item.id = item.KdKelurahan;
						item.text = item.NmKelurahan;
						return item;
					}),
					pagination: { more: data.next_page_url }
				}
			},
		},
		templateResult: function(item) {
			return item.loading ? item.text : `
			<p>${item.text}</p>
			<small>Kec. ${item.kecamatan.NmKecamatan}</small>`;
		},
	}));

	$('#Kelurahan').on('select2:select', function(ev) {
		let data = ev.params.data;
		let district = data.kecamatan;
		let regency = district.kabupaten;
		let province = regency.propinsi;
		$('#Kecamatan').html(`<option selected="selected" value="${district.KdKecamatan}">${district.NmKecamatan}</option>`);
		$('#Kabupaten').html(`<option selected="selected" value="${regency.KdKabupaten}">${regency.NmKabupaten}</option>`);
		$('#Provinsi').html(`<option selected="selected" value="${province.KdPropinsi}">${province.NmPropinsi}</option>`);
		$('#NmKecamatan').val(district.NmKecamatan);
		$("#NmKabupaten").val(regency.NmKabupaten);
		$("#NmProvinsi").val(province.NmPropinsi);
	});

	$('#Kecamatan').on('select2:select', function(ev) {
		let data = ev.params.data;
		let regency = data.kabupaten;
		let province = regency.propinsi;
		$('#Kabupaten').html(`<option selected="selected" value="${regency.KdKabupaten}">${regency.NmKabupaten}</option>`);
		$('#Provinsi').html(`<option selected="selected" value="${province.KdPropinsi}">${province.NmPropinsi}</option>`);
	});

	$('#Kabupaten').on('select2:select', function(ev) {
		let data = ev.params.data;
		let province = data.propinsi;
		$('#Provinsi').html(`<option selected="selected" value="${province.KdPropinsi}">${province.NmPropinsi}</option>`);
	});

	$('#Medrec').on("change", function(){
	});

	$('#Kelurahan').on("change",function(){
		text = $("#Kelurahan option:selected").text();
		$("#NmKelurahan").val(text);
	});

	$('#Kecamatan').on("change",function(){
		text = $("#Kecamatan option:selected").text();
		$("#NmKecamatan").val(text);
	});

	$('#Kabupaten').on("change",function(){
		kabupaten = $("#Kabupaten option:selected").text();
		$("#NmKabupaten").val(kabupaten);
	});

	$('#Provinsi').on("change",function(){
		provinsi = $("#Provinsi option:selected").text();
		$("#NmProvinsi").val(provinsi);
	});

	$('#Bod').on("change",function(){
		var today = new Date();
		var bod = $('#Bod').val();
		var age = "";
		var month = Number(bod.substr(5,2));
		var day = Number(bod.substr(8,2));

		// Get Year
		age = today.getFullYear() - bod.substring(0,4);
		if (today.getMonth() < (month - 1)) {
			age--;
		}
		if (((month - 1) == today.getMonth()) && (today.getDate() < day)) {
			age--;
		}
		$('#UmurThn').val(age);

		// Get Month
		var calMonth = (today.getMonth()+1)-month;
		if ( calMonth < 0) {
			if (calMonth < 0) {
				var generateMonth = calMonth+12;
				$('#UmurBln').val(generateMonth);
			}else{
				$('#UmurBln').val(calMonth);
			}
		}else{
			// var valMonth = today.getMonth() - month;
			
			$('#UmurBln').val(calMonth);
		}

		// Get Day
		var callDay = today.getDate()-day;
		if ( callDay < 0) {
			if (callDay < 0) {
				var generateDay = callDay+30;
				$('#UmurHari').val(generateDay);
			}else{
				$('#UmurHari').val(callDay);
			}
		}else{
			// var valMonth = today.getMonth() - month;
			
			$('#UmurHari').val(callDay);
		}

	});
</script>
@endsection