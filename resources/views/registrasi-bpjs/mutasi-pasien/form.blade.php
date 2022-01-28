@extends('layouts.main')
@section('title','Mutasi Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('mutasi_bpjs','active')
@section('header','Mutasi Pasien BPJS')
@section('subheader','Form Data')
@section('content')
<section>
    <div>
        <a href="{{route('reg-bpjs-mutasi')}}" class="btn btn-warning btn-sm"> List Pasien Mutasi</a>
        <a href="{{route('reg-bpjs-detailsep')}}" class="btn btn-warning btn-sm"> Detail SEP Peserta</a>
        <button type="button" id="btn-cari" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-pasien" style="width: 150px; height: 34px;">Cari Data Pasien</button>
        <button type="button" id="btn-cari-pasien" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-rujukan" style="width: 150px; height: 34px; display: none;">Cari Rujukan</button>
        <div class="pull-right">
            <button type="button" id="btn-cari-update-pulang" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-update-pulang" style="width: 180px; height: 34px;">Update tanggal pulang</button>
            <button type="button" id="btn-keyakinan" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-keyakinan" style="width: 170px; height: 34px;">Tambah Keyakinan</button>
        </div>
    </div>
    <hr>
    <form id="form-psn-bpjs">
        {{ csrf_field() }}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <form method="get" id="search_regno">
                    <div class="form-group">
                        <div class="input-group col-sm-9">
                            <span class="input-group-addon" id="" style="border:none;background-color:transparent;">No Registrasi: </span>
                            <input type="text" name="Regno" id="Regno" value="{{ @$edit->Regno }}" required />
                            <button type="submit" class="btn btn-info btn-sm" id="btnCari" style="margin-left: 10px;"><i class="ace-icon fa fa-search"></i>Cari</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Status Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="StatusRujuk" type="radio" class="ace" value="0" checked />
                                <span class="lbl">&nbsp; Non Rujukan</span>
                            </label>
                            <label>
                                <input name="StatusRujuk" type="radio" class="ace" value="1"/>
                                <span class="lbl">&nbsp; Faskes 1</span>
                            </label>
                            <label>
                                <input name="StatusRujuk" type="radio" class="ace" value="2"/>
                                <span class="lbl">&nbsp; Faskes 2(Rumah Sakit)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Data Pasien</u></p>
                <!-- Nomor RM -->
                <form method="get">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> No Rekam Medis</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Medrec" id="Medrec" class="form-control input-sm" value="{{ @$edit->Medrec }}" readonly />
                    </div>
                </div>
                </form>
                <!-- Nama Pasien -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" readonly value="{{ @$edit->Firstname }}" required />
                    </div>
                </div>
                <!-- No Peserta BPJS -->
                <form method="get" id="search_no_peserta">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> No Peserta BPJS</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="noKartu" class="form-control input-sm" id="noKartu" value="{{ @$edit->NoPeserta }}"/>
                        <!-- Tgl Daftar -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Daftar</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="TglDaftar" id="TglDaftar" class="form-control input-sm col-xs-6 col-sm-6" readonly/>
                    </div>
                </div>
                </form>
                <!-- Tanggal Daftar -->
                <form method="get" id="search_nik">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">NIK KTP</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoIden" class="form-control input-sm" id="NoIden" value="{{ @$edit->nikktp }}"/>
                        <!-- Tanggal Registrasi -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Registrasi</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="Regdate" id="Regdate" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->Regdate) ? date('Y-m-d',strtotime($edit->Regdate)) : date('Y-m-d') }}"/>
                    </div>
                </div>
                </form>
                <!-- No Rujukan -->
                <form method="get" id="search_noRujukan">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoRujuk" class="form-control input-sm" id="NoRujuk" value="{{ @$edit->NoRujuk }}"/>
                        <!-- Jam Registrasi -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Jam Registrasi</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="time" name="Regtime" id="Regtime" class="form-control input-sm col-xs-6 col-sm-6" value="<?= date('H:i') ?>"/>
                    </div>
                </div>
                </form>
                <!-- No Surat Kontrol -->
                <form method="get" id="search_nosurat">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No Surat Kontrol</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoSuratKontrol" class="form-control input-sm" id="NoSuratKontrol" value="{{ $edit->NoKontrol ? $edit->NoKontrol : @$edit->no_spri }}"/>
                        <!-- Tanggal Registrasi -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Rujukan</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="RegRujuk" id="RegRujuk" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->TglRujuk) ? date('Y-m-d',strtotime($edit->TglRujuk)) : date('Y-m-d') }}"/>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Status Pasien</u></p>
                <!-- Tanggal Lahir -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tgl Lahir</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="Bod" id="Bod" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->Bod) ? date('Y-m-d',strtotime($edit->Bod)) : '' }}"/>
                        <!-- Input Umur -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Umur (t/b/h)</span>
                        <!-- Input Umur Tahun -->
                        <input type="text" name="UmurThn" id="UmurThn" class="form-control input-sm col-xs-6 col-sm-3" readonly value="{{ @$edit->UmurThn }}"/>
                        <!-- Input Umur Bulan -->
                        <span class="input-group-addon no-border-right no-border-left" id="">/</span>
                        <input type="text" name="UmurBln" id="UmurBln" class="form-control input-sm col-xs-6 col-sm-3" readonly value="{{ @$edit->UmurBln }}"/>
                        <!-- Input Umur Hari -->
                        <span class="input-group-addon no-border-right no-border-left" id="">/</span>
                        <input type="text" name="UmurHari" id="UmurHari" class="form-control input-sm col-xs-6 col-sm-3" readonly value="{{ @$edit->UmurHari }}"/>
                    </div>
                </div>
                <!-- Jenis Kelmin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jenis Kelamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
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
                <!-- Kategori Pasien -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kategori Pasien</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="KategoriPasien" id="Kategori" style="width:50%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->Kategori) ? $edit->Kategori : '2' }}">{{ isset($edit->NmKategori) ? @$edit->NmKategori : 'BPJS' }}</option>
                        </select>
                        <button type="button" id="btn-cari" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-lg-update-kategori" style="width: 170px; height: 34px; right: 0;">Update Kategori</button>
                    </div>
                </div>
                <!-- No Telepon -->
                <div class="form-group">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">No Telepon</label>
                        <div class="input-group col-sm-9">
                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                            <input type="text" name="Notelp" id="Notelp" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->Phone }}"/>
                        </div>
                    </div>
                </div>
                <!-- Jatah Kelas -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jatah Kelas</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="JatKelas" id="jatah_kelas" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
                            @if(isset($edit))
                            <option value="{{ $edit->jtkdkelas }}">Kelas {{ $edit->jtkdkelas }}</option>
                            <option value="1">Kelas 1</option>
                            <option value="2">Kelas 2</option>
                            <option value="3">Kelas 3</option>
                            @else
                            <option value="">-= Kelas =-</option>
                            <option value="1">Kelas 1</option>
                            <option value="2">Kelas 2</option>
                            <option value="3">Kelas 3</option>
                            @endif
                        </select>
                        <input type="hidden" name="nmJatahKelas" id="nmJatahKelas">
                    </div>
                </div>
                <!-- PISAT -->
                <div class="form-group">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">PISAT</label>
                        <div class="input-group col-sm-9">
                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                            <input type="text" name="pisat" id="pisat" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->Pisat }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Status Pengobatan</u></p>
                <!-- Tujuan Pelayanan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tujuan Pelayanan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select readonly="readonly" name="KdTuju" id="pengobatan" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
                            <option value="1">Rawat Inap</option>
                        </select>
                    </div>
                </div>
                <!-- Nama Poli / SMF -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Poli / SMF</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="KdPoli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdPoli) ? $edit->KdPoli : '' }}">{{ isset($edit->NMPoli) ? @$edit->NMPoli : '-= Poli =-' }}</option>
                        </select>
                        <input type="hidden" name="KdPoliBpjs">
                    </div>
                </div>
                <!-- Nama Dokter -->
                <div class="form-group">
                    <label class="col-md-3 control-label no-padding-right">Nama Dokter</label>
                    <div class="input-group col-md-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="DocRS" id="Dokter" style="width:100%;" class="form-control input-sm select2">
                            <option value="{{ isset($edit->KdDocRS) ? $edit->KdDocRS : '' }}">{{ isset($edit->NmDocRS) ? @$edit->NmDocRS : '-= Dokter =-' }}</option>
                        </select>
                        <input type="hidden" name="NmDoc" id="NmDoc" value="{{ @$edit->NmDocRS }}">
                        <div class="checkbox" style="display: table-cell;padding-left: 10px;">
                            <label>
                                <input type="checkbox" name="dpjp-only">
                                <span class="lbl">Dokter DPJP</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Poli Eksekutif -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Poli Eksekutif</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="eksekutif" type="radio" class="ace" value="0"  {{ isset($edit->PoliEksekutif) && strtolower(strtoupper($edit->PoliEksekutif)) == '0' ? 'checked' : 'checked' }}/>
                                <span class="lbl">&nbsp; Tidak</span>
                            </label>
                            <label>
                                <input name="eksekutif" type="radio" class="ace" value="1" {{ isset($edit->PoliEksekutif) && strtolower(strtoupper($edit->PoliEksekutif)) == '1' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Ya</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Katarak -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Katarak</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="Katarak" type="radio" class="ace" value="0" {{ isset($edit->Katarak) && strtolower(strtoupper($edit->Katarak)) == '0' ? 'checked' : 'checked' }} />
                                <span class="lbl">&nbsp; Tidak</span>
                            </label>
                            <label>
                                <input name="Katarak" type="radio" class="ace" value="1" {{ isset($edit->Katarak) && strtolower(strtoupper($edit->Katarak)) == '1' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Ya</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- COB -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">COB</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="Cob" type="radio" class="ace" value="0" checked />
                                <span class="lbl">&nbsp; Tidak</span>
                            </label>
                            <label>
                                <input name="Cob" type="radio" class="ace" value="1"/>
                                <span class="lbl">&nbsp; Ya</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Asal Rujukan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Asal Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="Faskes" type="radio" class="ace" value="1" {{ isset($edit->AsalRujuk) && strtolower(strtoupper($edit->AsalRujuk)) == '1' ? 'checked' : 'checked' }} />
                                <span class="lbl">&nbsp; Faskes 1</span>
                            </label>
                            <label>
                                <input name="Faskes" type="radio" class="ace" value="2" {{ isset($edit->AsalRujuk) && strtolower(strtoupper($edit->AsalRujuk)) == '2' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Faskes 2</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- PPK -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">PPK</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Ppk" id="Ppk" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->kdrujukan) ? $edit->kdrujukan : '' }}">{{ isset($edit->nmrujukan) ? @$edit->nmrujukan : '-= PPK =-' }}</option>
                        </select>
                        <input type="hidden" name="noPpk" id="noPpk" value="{{ @$edit->nmrujukan }}">
                    </div>
                </div>
                <!-- Kasus Kecelakaan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kasus Kecelakaan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="KasKe" id="Kecelaakan1" type="radio" class="ace" value="0" {{ isset($edit->KdKasus) && strtolower(strtoupper($edit->KdKasus)) == '0' ? 'checked' : 'checked' }}/>
                                <span class="lbl">&nbsp; Bukan Kecelakaan lalu lintas [BKLL]</span>
                            </label><br>
                            <label>
                                <input name="KasKe" id="Kecelaakan2" type="radio" class="ace" value="1" {{ isset($edit->KdKasus) && strtolower(strtoupper($edit->KdKasus)) == '1' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; KLL dan bukan kecelakaan Kerja [BKK]</span>
                            </label><br>
                            <label>
                                <input name="KasKe" id="Kecelaakan3" type="radio" class="ace" value="2" {{ isset($edit->KdKasus) && strtolower(strtoupper($edit->KdKasus)) == '2' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; KLL dan KK</span>
                            </label><br>
                            <label>
                                <input name="KasKe" id="Kecelaakan4" type="radio" class="ace" value="3" {{ isset($edit->KdKasus) && strtolower(strtoupper($edit->KdKasus)) == '3' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; KK</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Penjamin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Penjamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Penjamin" id="NMPenjamin" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" >
                            <option value="{{ isset($edit->KdJaminan) ? $edit->KdJaminan : '' }}">{{ isset($edit->NMJaminan) ? @$edit->NMJaminan : '-= Penjamin =-' }}</option>
                        </select>
                    </div>
                </div>
                <!-- Tgl Kejadian -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tgl Kejadian</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="RegdKej" id="RegdKej" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ isset($edit->TglKejadian) ? date('Y-m-d',strtotime($edit->TglKejadian)) : date('Y-m-d') }}" />
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Keterangan</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Keterangan" class="form-control input-sm" id="Keterangan" readonly value="{{ @$edit->Keterangan }}" />
                    </div>
                </div>
                <!-- Suplesi -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Suplesi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="Suplesi" type="radio" class="ace" value="0" {{ isset($edit->Sumplesi) && strtolower(strtoupper($edit->Sumplesi)) == '0' ? 'checked' : 'checked' }}/>
                                <span class="lbl">&nbsp; Tidak</span>
                            </label>
                            <label>
                                <input name="Suplesi" type="radio" class="ace" value="1" {{ isset($edit->Sumplesi) && strtolower(strtoupper($edit->Sumplesi)) == '0' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Ya</span>
                            </label>
                        </div>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">No SEP Suplesi:</span>
                        <input type="text" name="NoSepSup" class="form-control input-sm" id="NoSepSup" readonly value="{{ @$edit->NoSuplesi }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <!-- Input Provinsi -->
                    <label class="col-sm-3 control-label no-padding-right">Provinsi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="Provinsi" id="Provinsi" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" disabled>
                            <option value="">-= Provinsi =-</option>
                        </select>
                        <input type="hidden" name="NmProvinsi" id="NmProvinsi">
                    </div>
                </div>
                <div class="form-group">
                    <!-- Input Kota / Kabupaten -->
                    <label class="col-sm-3 control-label no-padding-right">Kabupaten</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="Kabupaten" id="Kabupaten" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" disabled>
                            <option value="" style="text-align:center;">-= Kabupaten =-</option>
                        </select>
                        <input type="hidden" name="NmKabupaten" id="NmKabupaten">
                    </div>
                </div>
                <div class="form-group">
                    <!-- Input Kecamatan -->
                    <label class="col-sm-3 control-label no-padding-right">Kecamatan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="Kecamatan" id="Kecamatan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" disabled>
                            <option value="" style="text-align:center;">-= Kecamatan =-</option>
                        </select>
                        <input type="hidden" name="NmKecamatan" id="NmKecamatan">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                <p><u>Status Pembayaran</u></p>
                <!-- Cara Bayar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Cara Bayar</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="KdCbayar" id="cara_bayar" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                            @if(isset($edit))
                        <option value="{{$edit->KdCbayar}}">{{$edit->NMCbayar}}</option>

                            @else
                            <option value="02">BPJS</option>

                            @endif

                        </select>
                    </div>
                </div>
                <!-- Peserta -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Peserta</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Peserta" id="Peserta" class="form-control input-sm col-xs-10 col-sm-5" readonly value="{{ @$edit->NmRefPeserta }}" />
                        <input type="hidden" name="kodePeserta" id="kodePeserta" class="form-control input-sm col-xs-10 col-sm-5" readonly value="{{ @$edit->KdRefPeserta }}" />
                    </div>
                </div>
                <!-- Status Peserta -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Status Peserta</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="statusPeserta" id="statusPeserta" class="form-control input-sm col-xs-10 col-sm-5" readonly value="{{ @$edit->StatPeserta }}" />
                    </div>
                </div>
                <!-- Ruang Rawat -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Ruang Rawat</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="oBangsal" id="oBangsal" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            @if(isset($edit))
                                    <option value="{{ @$edit->KdBangsal }}{{ @$edit->KdKelas }}" 
                                        {{ isset($edit->NmBangsal) && @$edit->NmBangsal == @$edit->NmBangsal ? 'selected' : '-= Ruang Rawat =-'}}>
                                        {{ @$edit->NMKelas }} - {{ @$edit->NmBangsal }}
                                    </option>
                                @foreach($ruang as $data)
                                    <option value="{{ $data->Kdbangsal }}{{ $data->kdkelas }}">{{ $data->nmkelas }} - {{ $data->nmbangsal }}</option>
                                @endforeach
                            @else
                            <option value="">-= Ruang Rawat =-</option>
                                @foreach($ruang as $data)
                                    <option value="{{ $data->Kdbangsal }}{{ $data->kdkelas }}">{{ $data->nmkelas }} - {{ $data->nmbangsal }}</option>
                                @endforeach
                            @endif
                        </select>
                        
                    </div>
                </div>
                <!-- Kelas -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kode Ruangan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Bangsal" id="bangsal" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->KdKelas }}" />
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Kode Kelas</span>
                        <input type="text" name="Kelas" id="kelas" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->KdBangsal }}" />
                    </div>
                </div>
                <!-- No Kamar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Pilih Kamar</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Kamar" id="Kamar" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            @if(isset($edit))
                                <option value="{{ isset($edit->nokamar) ? $edit->nokamar : '' }}">{{ @$edit->nokamar }} - {{@$edit->NoTTidur}}</option>
                            @else
                                <option value="">-= Pilih Kamar =-</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No Kamar</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Bed" id="Bed" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->nokamar }}" />
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tempat Tidur</span>
                        <input type="text" name="TempatTidur" id="TempatTidur" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->NoTTidur }}" />
                    </div>
                </div>
                <!-- Dokter Yang Merawat -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Dokter Yg Merawat</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="DocYgMerawat" id="DocYgMerawat" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdDocRawat) ? $edit->KdDocRawat : '' }}">{{ isset($edit->NmDoc) ? $edit->NmDoc : '-= Dokter Yang Merawat =-' }}</option>
                        </select>
                    </div>
                </div>
                <!-- Diagnosa Awal -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Diagnosa Awal</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="DiagAw" id="Diagnosa" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdIcd) ? $edit->KdIcd : '' }}">{{ isset($edit->DIAGNOSA) ? @$edit->DIAGNOSA : '-= Diagnosa Awal =-' }}</option>
                        </select>
                        <input type="hidden" name="NmDiagnosa" id="NmDiagnosa" value="{{ @$edit->DIAGNOSA }}">
                    </div>
                </div>
                <!-- Catatan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Catatan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <textarea class="form-control input-sm col-xs-10 col-sm-5" name="catatan" id="catatan">{{ @$edit->catatan }}</textarea>
                    </div>
                </div>
                <!-- No SEP -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No SEP</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoSep" id="NoSep" class="form-control input-sm col-sm-2" value="{{ @$edit->nosep }}" />
                        <button type="button" class="btn btn-success" id="createsep" style="margin-left: 10px;">
                            <i class="ace-icon fa fa-plus"></i>Create SEP
                        </button>
                    </div>
                </div>
                <!-- Notifikasi SEP -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Notifikasi SEP</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NotifSep" id="NotifSep" class="form-control input-sm col-xs-10 col-sm-5" value="{{ @$edit->notifsep }}"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <input type="hidden" name="change_keyakinan" id="change_keyakinan">
        <button type="submit" name="submit" id="submit" class="btn btn-success">Simpan</button>
        <button type="button" name="printsep" id="printsep" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print SEP</button>
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
    <div class="modal fade bd-example-modal-lg-pasien" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="exampleModalLabel">Cari Data Pasien</h5>
                    </div><hr>
                    <form method="get" id="bd-example-modal-lg-caripasien">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Rekam Medis</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Medrec" id="pa_Medrec" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Phone</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Phone" id="pa_Phone" class="form-control input-sm col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Firstname" id="pa_Firstname" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Alamat</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Address" id="pa_Address" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Tanggal Lahir</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="date" name="pa_Tgl_lahir" id="pa_Tgl_lahir" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Tanggal Registrasi</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="date" name="date1" id="date1" style="width: 40%" />
                                    <span class="" id="" style="background-color:white; margin-right: 10px;">&nbsp;s/d&nbsp;</span>
                                    <input type="date" name="date2" id="date2" style="width: 40%" />
                                </div>
                            </div>
                        </div>
                        <div class="pull-right"><button type="submit" class="btn btn-info btn-sm" name="cari_pasien"><i class="fa fa-search"></i> Cari</button></div>
                    </form>
                </div>
                <div class="modal-body">
                    <div style="overflow:auto;" id="target_cari_pasien"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Print -->
    <div class="modal fade" id="modalPrintSurat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Pasien</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="targetPrint"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
<!-- end Modal Print-->
    <div class="modal fade bd-example-modal-lg-rujukan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Rujukan Pasien BPJS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div style="overflow:auto;" id="target_table">
                        <table class="table table-bordered" id="table-list-pasien">
                            <thead>
                                <tr>
                                    <th>No Rujukan</th>
                                    <th>Nama Pasien</th>
                                    <th>No Peserta</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kode</th>
                                    <th>Diagnosa</th>
                                    <th>Nama Poli</th>
                                    <th>Pelayanan</th>
                                    <th>Tgl Kunjungan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List Registrasi Online</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div style="overflow:auto;" id="target_table">
                        <table class="table table-bordered" id="table-list-pasien">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Registrasi</th>
                                    <th>No Rekam Medis</th>
                                    <th>Nama Pasien</th>
                                    <th>Tgl Berobat</th>
                                    <th>Jam Datang</th>
                                    <th>Jenis Kelamin</th>
                                    <th>KdPoli</th>
                                    <th>Nama Poli</th>
                                    <th>Kategori</th>
                                    <th>No KTP</th>
                                    <th>Tgl Lahir</th>
                                    <th>No BPJS</th>
                                    <th>Status Kawin</th>
                                    <th>Alamat</th>
                                    <th>Kelurahan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg-update-kategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <p><u>Data Pasien</u></p>
                        <div class="form-group">
                            <!-- No RM -->
                            <label class="col-sm-3 control-label no-padding-right">No Rekam Medis</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="kat_NoRM" id="kat_NoRM" class="form-control input-sm col-xs-6 col-sm-6" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Nama Pasien -->
                            <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="kat_Firstname" id="kat_Firstname" class="form-control input-sm col-xs-6 col-sm-6" readonly placeholder="Nama Pasien" />
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Kategori Pasien -->
                            <label class="col-sm-3 control-label no-padding-right">Kategori Pasien</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <select type="text" name="kat_Kategori" id="kat_Kategori" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                    <option value="">-= Kategori Pasien =-</option>
                                </select>
                                <input type="hidden" name="kat_nmKategori" id="kat_nmKategori">
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Group Unit -->
                            <label class="col-sm-3 control-label no-padding-right">Group Unit</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <select type="text" name="GroupUnit" id="GroupUnit" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                    <option value="">-= GroupUnit =-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Input Unit -->
                            <label class="col-sm-3 control-label no-padding-right">Unit</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <select name="Unit" id="Unit" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6 select2">
                                    <option value="">-= Unit =-</option>
                                    <optgroup id="optUnit"></optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- No Peserta/BPJS -->
                            <label class="col-sm-3 control-label no-padding-right">No Peserta/BPJS</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="kat_NoPeserta" id="kat_NoPeserta" class="form-control input-sm col-xs-6 col-sm-6"/>
                            </div>
                        </div>
                        <input type="submit" name="submit" id="update_kategori" class="btn btn-success" value="Update" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg-update-pulang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Tanggal Pulang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="updatePulang">
                        <div class="form-group">
                            <!-- No SEP -->
                            <label class="col-sm-3 control-label no-padding-right">No SEP</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="pulangNoSep" id="pulangNoSep" class="form-control input-sm col-xs-3 col-sm-3"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Tanggal Pulang -->
                            <label class="col-sm-3 control-label no-padding-right">Tanggal Pulang</label>
                            <div class="input-group col-sm-6">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="date" name="pulangRegdate" id="pulangRegdate" class="form-control input-sm col-xs-6 col-sm-6" value="<?=date('Y-m-d')?>"/>
                                <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                <input type="time" name="pulangRegtime" id="pulangRegtime" class="form-control input-sm col-xs-6 col-sm-6" value="<?=date('H:i:s')?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Catatan -->
                            <label class="col-sm-3 control-label no-padding-right">Catatan</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <textarea class="form-control input-sm col-xs-6 col-sm-6" name="pulangCatatan" id="pulangCatatan"></textarea>
                            </div>
                        </div>
                        <input type="submit" name="updateTanggalPulang" id="updateTanggalPulang" class="btn btn-success" value="Simpan" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg-keyakinan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keyakinan dan Nilai-nilai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <p><u>Data Pasien</u></p>
                        <div class="form-group">
                            <!-- No RM -->
                            <label class="col-sm-3 control-label no-padding-right">No Rekam Medis</label>
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
                                <input type="text" name="ke_Firstname" id="ke_Firstname" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->Firstname }}" placeholder="Nama Pasien" />
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
                        <input type="submit" name="simpan_keyakinan" id="simpan_keyakinan" class="btn btn-success" value="Simpan" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    let kdPoli = '';
    let KdDPJP = null;
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
    });
    // ====================================
    function load_unit(id_group_unit=''){
        $.ajax({
            type:'POST',
            //Master_pasien/load_unit
            url:"{{route('reg-bpjs-mutasi')}}",
            data:{id_group_unit:id_group_unit},
            dataType:"JSON",
            beforeSend:function(){
                $("#optUnit").html("Memuat ...");
            },
            success:function(resp){
                if(resp != ''){
                    $("#optUnit").html(resp);
                }else{
                    $("#optUnit").empty();
                }
            }
        });
    }

    const select2Bpjs = {
        ajax: { dataType: 'json', },
        templateResult: function(item) { return item.loading ? item.text : `<p>${item.text}</p>`; },
        escapeMarkup: function(markup) { return markup; },
        templateSelection: function(item) { return item.text; },
    };

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

    function select2VClaimResponse(data, params, success) {

        if(!params.term) {
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

    function push_mutasi(data){
         $.ajax({
            url:"http://192.168.136.252:81/modul_rawat_inap/api/push_mutasi",
            type:"get",
            dataType:"json",
            data:data,
            success:function(response){
                console.log(response);
            }
        });
    }
    
    // =====================================
    $(".select2").select2();
    $('[name=KasKe]').on('change', function(ev,xv){
        if($(this).val() == '0'){
            $('#Keterangan').attr('readonly','readonly');
            $('#NoSepSup').attr('readonly','readonly');
            $('#RegdKej').attr('readonly','readonly');
            $('#Suplesi').prop('disabled', true);
            $('#Provinsi').prop('disabled', true);
            $('#Kabupaten').prop('disabled', true);
            $('#Kecamatan').prop('disabled', true);
        }else{
            $('#Keterangan').removeAttr('readonly');
            $('#NoSepSup').removeAttr('readonly');
            $('#RegdKej').removeAttr('readonly');
            $('#Suplesi').prop('disabled', false);
            $('#Provinsi').prop('disabled', false);
            $('#Kabupaten').prop('disabled', false);
            $('#Kecamatan').prop('disabled', false);
        }
    });

    $("#GroupUnit").on("change",function(){
        // console.log();
        load_unit(this.value);
    });
    
    $('#Ppk').on('change', function() {
        text = $("#Ppk option:selected").text();
        $('#noPpk').val(text);
    });

    $('#Diagnosa').on('change', function() {
        text = $("#Diagnosa option:selected").text();
        $('#NmDiagnosa').val(text);
    });

    $('#poli').on('select2:select', function(ev) {
        let data = ev.params.data;
        kdPoli = data.KDPoli;
        $('[name=KdPoliBpjs]').val(data.KdBPJS);;
    });
    
    // ==============================================================

    $('#Dokter').on('change', function() {
        text = $("#Dokter option:selected").text();
        $('#NmDoc').val(text);
    });
    
    $('#DocYgMerawat').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.dokter')}}",
            dataType: 'json',
            data: function(params) {
                return $.extend(params, {
                    kdPoli: kdPoli,
                    dpjpOnly: document.getElementsByName('dpjp-only')[0].checked ? 1 : 0,
                });
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KdDoc;
                        item.text = item.NmDoc;
                        return item;
                    }),
                    pagination: {
                        more: data.next_page_url
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
                    ${item.NmDoc} - ${item.KdDPJP}
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

    $('#Dokter').on('select2:select', function(ev){
        KdDPJP = ev.params.data.KdDPJP;
    });

    $('#kat_Kategori').select2({
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
                   ${item.NmKategori}
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
                   ${item.NmKategori}
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
    
    $('#cara_bayar').select2({
        ajax: {
            // api/get_ppk
            url:"{{ route('api.select2.cara_bayar') }}",
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
                        item.id = item.KDCbayar;
                        item.text = item.NMCbayar;
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
                    ${item.NMCbayar}
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

    $('#jatah_kelas').on('change', function() {
        text = $("#jatah_kelas option:selected").text();
        $('#nmJatahKelas').val(text);
    });

    $('#NMPenjamin').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.penjamin')}}",
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
                        item.id = item.KDJaminan;
                        item.text = item.NMJaminan;
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
                    ${item.NMJaminan}
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
                    ktg : $('#kat_Kategori option:selected').val(),
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
                    ktg : $('#kat_Kategori option:selected').val(),
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

    // Kamar Pasien
    $('#Kamar').on('change', function(){
        let kamar = $('#Kamar').find('option:selected').val();
        // $('#TempatTidur').val(kamar.substr(kamar.length -1, 1));
        $.ajax({
            url: '{{ route('get-bed') }}',
            type: 'get',
            dataType: 'json',
            data:{
                kode: kamar
            },
            success:function(response)
            {
                console.log(response);
                $('#Bed').val(response.nokamar);
                $('#TempatTidur').val(response.ttnomor);
            }
        });
        // $('#Bed').val(kamar.substr(3, 3));
        // $('#Bed').val(kamar);
    });

    $('#oBangsal').on("change", function(){
        let loading = $('.modal-loading');
        loading.modal('show');
        let kelas = $('#oBangsal').find('option:selected').val();
        $('#kelas').val(kelas.substring(0,2));
        $('#bangsal').val(kelas.substring(2));
        $.ajax({
            url:"{{ route('mutasi-umum-bed') }}",
            type:"get",
            dataType:"json",
            data:{
                kelas: $('#bangsal').val(),
            },
            beforeSend(){
                loading.modal('show');
            },
            success:function(response)
            {
                $('#Kamar').empty();
                $('#Kamar').append('<option value="">-= Pilih Kamar =-</option>');
                let map = response.data.map(function (item) {
                    item.id = item.tanda==1?'': item.ttcode;
                    item.text = `${item.nokamar} - ${item.ttnomor} - ${item.tanda}`;
                    return item;
                });

                map.forEach(function(item) {
                    let newOption = new Option(item.text, item.id, false, false);
                    $('#Kamar').append(newOption);
                });

                $('#Kamar').trigger('change');
                $('#Kamar option[value=""]').attr('disabled', 'disabled');
                // $('#Bed').val(item.text.substr(item.length -5, 1));
                // $('#Bed').val(response.data.ttnomor);
                loading.modal('hide');
            }
        });
    });

    $('#search_nosurat').submit(function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        $.ajax({
            url:"{{ route('reg-bpjs-daftar.find-surat') }}",
            type:"get",
            dataType:"json",
            data:{
                nosurat: $('#NoSuratKontrol').val(),
            },
            success:function(response){
                if (response.status == 'success') {
                    var data = response.data;
                    var bpjs_data = response.data.bpjs_data.response;
                    var register_data = response.data.register;
                    var master_ps_data = response.data.master_ps;
                    var kategori_data = response.data.kategori;
                    var dokter_data = response.data.dokter;
                    var poli_data = response.data.poli;

                    $('#Medrec').val(master_ps_data.Medrec);
                    $('#Firstname').val(master_ps_data.Firstname.toUpperCase());
                    $('#Notelp').val(master_ps_data.Phone);
                    $('#Bod').val(master_ps_data.Bod.substring(0,10));
                    $('#TglDaftar').val(master_ps_data.TglDaftar.substring(0,10));
                    $('#NoIden').val(master_ps_data.NoIden);
                    $('#Sex').val(master_ps_data.Sex);
                    $('#UmurHari').val(master_ps_data.UmurHr);
                    $('#UmurBln').val(master_ps_data.UmurBln);
                    $('#UmurThn').val(master_ps_data.UmurThn);
                    $('#NoRujuk').val(bpjs_data.sep.provPerujuk.noRujukan);
                    $('#RegRujuk').val(bpjs_data.sep.provPerujuk.tglRujukan.substring(0,10));

                    var $kategori = $("<option selected></option>").val(kategori_data.KdKategori).text(kategori_data.NmKategori);
                    $('#Kategori').append($kategori).trigger('change');

                    var $dokter = $("<option selected></option>").val(dokter_data.KdDoc).text(dokter_data.NmDoc);
                    $('#Dokter').append($dokter).trigger('change');

                    var $poli = $("<option selected></option>").val(poli_data.KdPoli).text(poli_data.NmPoli);
                    $('#poli').append($poli).trigger('change');
                    // setKodePoli(response.KdPoli, response.KdPoliBpjs);

                    $('#jatah_kelas').val(register_data.NmKelas);

                    var $diagnosa = $("<option selected></option>").val(register_data.KdICDBPJS).text(bpjs_data.sep.diagnosa);
                    $('#Diagnosa').append($diagnosa).trigger('change');

                    if (master_ps_data.KdSex != null) {
                        $("input[name=KdSex][value=" + master_ps_data.KdSex.toUpperCase() + "]").attr('checked', 'checked');
                    }

                    $('#Kunjungan').val('Lama');

                    // Masukan buat update kategori
                    $('#kat_NoRM').val(master_ps_data.Medrec);
                    $('#kat_Firstname').val(master_ps_data.Firstname);
                    $('#kat_NoPeserta').val(master_ps_data.AskesNo);
                    $('#noKartu').val(master_ps_data.AskesNo);
                    var $ka_kategori = $("<option selected></option>").val(kategori_data.Kategori).text(kategori_data.NmKategori);
                    $('#kat_Kategori').append($ka_kategori).trigger('change');

                    // var $groupUnit = $("<option selected></option>").val(register_data.GroupUnit).text(register_data.GroupUnit);
                    // $('#GroupUnit').append($groupUnit).trigger('change');

                    // var $unit = $("<option selected></option>").val(response.NmUnit).text(response.NmUnit);
                    // $('#Unit').append($unit).trigger('change');

                    // Tambah Keyakinan
                    $('#ke_NoRM').val(master_ps_data.Medrec);
                    $('#ke_Firstname').val(master_ps_data.Firstname);
                    // $('input[name=pantang][value=' + response.phcek + ']').attr('checked', 'checked');
                    // $('#pantangNote').val(response.phnote);
                    // $('input[name=tindakan][value=' + response.ptcek + ']').attr('checked', 'checked');
                    // $('#tindakanNote').val(response.ptnote);
                    // $('input[name=makan][value=' + response.pmcek + ']').attr('checked', 'checked');
                    // $('#makanNote').val(response.pmnote);
                    // $('input[name=pantangPerawatan][value=' + response.ppcek + ']').attr('checked', 'checked');
                    // $('#pantangPerawatanNote').val(response.ppnote);
                    // $('#lain').val(response.lain);
                } else {
                    alert(response.message);
                }
                loading.modal('hide');
            }
        })
        loading.modal('hide');
    });

    $('#btnCari').on("click", function(ev){
        ev.preventDefault();
        let btn = $('#btnCari');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        btn.prop('disabled', true);
        let loading = $('.modal-loading');
        loading.modal('show');
        $.ajax({
            url:"{{ route('mutasi-bpjs') }}",
            type:"get",
            dataType:"json",
            data:{
                Regno: $('#Regno').val(),
            },
            beforeSend(){
                loading.modal('show');
            },
            success:function(response)
            {
                console.log(response);
                if(response.status){
                    var today = new Date();
                    btn.prop('disabled', false);
                    btn.html(oldText);

                    if (response.data == null) {
                        alert('Pasien tidak ditemukan');
                    }

                    $('#Firstname').val(response.data.Firstname.toUpperCase());
                    $('#noKartu').val(response.data.NoPeserta);
                    $('#Medrec').val(response.data.Medrec);
                    $('#NoIden').val(response.data.nikktp);
                    $('#NoRujuk').val(response.data.NoRujuk);
                    $('#NoSuratKontrol').val(response.data.NoKontrol);
                    $('#Regdate').val(response.data.Regdate.substring(0,10));
                    $('#Regtime').val(response.data.Regtime.substring(11,16));
                    $('#Bod').val(response.data.Bod.substring(0,10));
                    $('#TglDaftar').val(response.data.TglDaftar ? response.data.TglDaftar.substring(0,10) : response.data.Regdate.substring(0,10));
                    $('#pisat').val(response.data.Pisat);
                    $('#RegRujuk').val(response.data.TglRujuk.substring(0,10));
                    KdDPJP = response.data.KdDPJP;
                    $('#UmurHari').val(response.data.UmurHari);
                    $('#UmurBln').val(response.data.UmurBln);
                    $('#UmurThn').val(response.data.UmurThn);
                    $('#statusPeserta').val(response.data.StatPeserta);
                    $('#jatah_kelas').val(response.data.NmKelas);
                    $('#Notelp').val(response.data.Phone);
                    $('#Peserta').val(response.data.NmRefPeserta);

                    var $kategori = $("<option selected></option>").val(response.data.Kategori).text(response.data.NmKategori);
                    $('#Kategori').append($kategori).trigger('change');

                    var $cara_bayar = $("<option selected></option>").val(response.data.KdCbayar).text(response.data.NMCbayar);
                    $('#cara_bayar').append($cara_bayar).trigger('change');

                    var $dRumahSakit = $("<option selected></option>").val(response.data.KdDoc).text(response.data.NmDoc);
                    $('#Dokter').append($dRumahSakit).trigger('change');

                    var $poli = $("<option selected></option>").val(response.data.KdPoli).text(response.data.NMPoli);
                    $('#poli').append($poli).trigger('change');

                    var $ppk = $("<option selected></option>").val(response.data.KdRujukan).text(response.data.NmRujukan);
                    $('#Ppk').append($ppk).trigger('change');

                    if (response.data.KdSex != null) {
                        $("input[name=KdSex][value=" + response.data.KdSex.toUpperCase() + "]").attr('checked', 'checked');
                    }

                    $("input[name=Faskes][value=" + response.data.AsalRujuk + "]").attr('checked', 'checked');

                    // Update Kategori
                    $('#kat_NoRM').val(response.data.Medrec);
                    $('#kat_Firstname').val(response.data.Firstname);
                    $('#kat_NoPeserta').val(response.data.NoPeserta);
                    var $ka_kategori = $("<option selected></option>").val(response.data.Kategori).text(response.data.NmKategori);
                    $('#kat_Kategori').append($ka_kategori).trigger('change');

                    var $groupUnit = $("<option selected></option>").val(response.data.GroupUnit).text(response.data.GroupUnit);
                    $('#GroupUnit').append($groupUnit).trigger('change');

                    var $unit = $("<option selected></option>").val(response.data.NmUnit).text(response.data.NmUnit);
                    $('#Unit').append($unit).trigger('change');

                    var $diagnosa = $("<option selected></option>").val(response.data.KdICD).text(response.data.DIAGNOSA);
                    $('#Diagnosa').append($diagnosa).trigger('change')

                    var $dok_rawat = $("<option selected></option>").val(response.data.KdDoc).text(response.data.NmDoc);
                    $('#DocYgMerawat').append($dok_rawat).trigger('change')
                    
                    // Tambah Keyakinan
                    $('#ke_NoRM').val(response.data.Medrec);
                    $('#ke_Firstname').val(response.data.Firstname);
                    $('input[name=pantang][value=' + response.data.phcek + ']').attr('checked', 'checked');
                    $('#pantangNote').val(response.data.phnote);
                    $('input[name=tindakan][value=' + response.data.ptcek + ']').attr('checked', 'checked');
                    $('#tindakanNote').val(response.data.ptnote);
                    $('input[name=makan][value=' + response.data.pmcek + ']').attr('checked', 'checked');
                    $('#makanNote').val(response.data.pmnote);
                    $('input[name=pantangPerawatan][value=' + response.data.ppcek + ']').attr('checked', 'checked');
                    $('#pantangPerawatanNote').val(response.data.ppnote);
                    $('#lain').val(response.data.lain);
                }else{
                    btn.prop('disabled', false);
                    btn.html(oldText);
                    alert('Pasien tidak ditemukan');
                }
            }
        })
        loading.modal('hide');
    });

    $('#updateTanggalPulang').on('click', function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        var fullDate = new Date();
        if ($('#pulangNoSep').val() == '') {
            alert('Nomor SEP kosong');
        } else if ($('#pulangNoSep').val() == '-') {
            alert('Nomor SEP kosong');
        } else if ($('#pulangRegdate').val() <= fullDate) {
            alert('Tanggal pulang lebih kecil dari hari ini');
        } else {
            $.ajax({
                url:"{{ route('api.update.pulang') }}",
                type:"put",
                dataType:"json",
                data:{
                    noSep: $('#pulangNoSep').val(),
                    tglPulang: $('#pulangRegdate').val(),
                    waktuPulang: $('#pulangRegtime').val(),
                    catatan: $('#pulangCatatan').val()
                },
                beforeSend(){
                    loading.modal('show');
                },
                success:function(response)
                {
                    console.log(response);
                    alert(response.metaData.message)
                }
            });
        }
        loading.modal('hide');
    });

    $('#kat_Kategori').on("change",function(){
        text = $("#kat_Kategori option:selected").text();
        $("#kat_nmKategori").val(text);
    });

    $('#update_kategori').on("click", function(ev) {
        ev.preventDefault();
        if ($('#kat_NoRM').val() != '') {
            $.ajax({
                url:"{{ route('reg-bpjs-daftar.update-kategori') }}",
                type:"post",
                dataType:"json",
                data:{
                    Medrec: $('#kat_NoRM').val(),
                    askesno: $('#kat_NoPeserta').val(),
                    groupunit: $('#GroupUnit').val(),
                    nmunit: $('#Unit').val(),
                    Kategori: $('#kat_Kategori').val()
                }
            });
            alert('Berhasil diupdate');
            var $kat_kategori = $("<option selected></option>").val($('#kat_Kategori').val()).text($('#kat_nmKategori').val());
            $('#Kategori').append($kat_kategori).trigger('change');
            $('#noKartu').val($('#kat_NoPeserta').val());
            $('.bd-example-modal-lg-update-kategori').modal('hide');
        } else {
            alert('No Rekam Medic tidak boleh kosong');
        }
    });

    $('#printsep').on("click", function() {
        let loading = $('.modal-loading');
        loading.modal('show');
        if ($('#Regno').val() == '') {
            alert('Simpan terlebih dahulu');
            loading.modal('hide');
        }else if ($('#NoSep').val() == '') {
            alert('No SEP Kosong');
            loading.modal('hide');
        }else {
            $.ajax({
                url:"{{ route('reg-bpjs-daftar.print-sep-rawat-inap') }}",
                type:"get",
                dataType:"html",
                data:{
                    Regno: $('#Regno').val(),
                },
                beforeSend(){
                    loading.modal('show');
                },
                success:function(data)
                {
                    $('#modalPrintSurat').modal('show');
                    $('#targetPrint').html(data);
                    setTimeout(function () {
                        $('#targetPrint').printElement();
                    }, 1000);
                    // var w = window.open();
                    // w.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(data)+"'></iframe>");
                    // $(w.document.body).html(data);
                    // window.open(data);
                    // w.html();
                }
            });
        }
        loading.modal('hide');
    });

    $("#submit").on("click",function(ev){
        ev.preventDefault();
        let loading = $('.modal-loading');
        var send = {
            medrec : $("#Medrec").val(),
            kategori : $('#Kategori').val(),
            regdate : $("#Regdate").val(),
            poli : $("#poli").val(),
        }

        if ($('#pengobatan').val() == '') {
            alert('Pilih Tujuan!');
        } else if($('#Regno').val() == '') {
            alert('Nomor Registrasi tidak diisi');
        } else if($('#poli').val() == '') {
            alert('Pilih Poli!');
        } else if($('#Dokter').val() == '') {
            alert('Pilih Dokter!');
        } else if(($('input[name=KdSex]:checked').length) <= 0 ) {
            alert('Pilih jenis kelamin Pasien');
        } else {
            var send = {
                Regno: $('#Regno').val(),
                Medrec: $('#Medrec').val(),
                Firstname: $('#Firstname').val(),
                Regdate: $('#Regdate').val(),
                Regtime: $('#Regtime').val(),
                KdCbayar: $('#cara_bayar').val(),
                Penjamin: $('[name=Penjamin]').val(),
                noKartu: $('#noKartu').val(),
                KdTuju: $('#pengobatan').val(),
                KdPoli: $('#poli').val(),
                DocRS: $('#Dokter').val(),
                NmDoc: $('#NmDoc').val(),
                UmurThn: $('#UmurThn').val(),
                UmurBln: $('#UmurBln').val(),
                UmurHari: $('#UmurHari').val(),
                Bod: $('#Bod').val(),
                KategoriPasien: $('#Kategori').val(),
                NoSep: $('#NoSep').val(),
                DiagAw: $('#Diagnosa').val(),
                NmDiagnosa: $('#NmDiagnosa').val(),
                KdSex: $('input[name=KdSex]:checked').val(),
                pisat: $('#pisat').val(),
                Keterangan: $('#Keterangan').val(),
                NoRujuk: $('#NoRujuk').val(),
                RegRujuk: $('#RegRujuk').val(),
                Ppk: $('#noPpk').val(),
                noPpk: $('#Ppk').val(),
                kodePeserta: $('#kodePeserta').val(),
                Peserta: $('#Peserta').val(),
                JatKelas: $('#jatah_kelas').val(),
                nmJatahKelas: $('#nmJatahKelas').val(),
                NotifSep: $('#NotifSep').val(),
                KasKe: $('input[name=KasKe]:checked').val(),
                NoIden: $('#NoIden').val(),
                statusPeserta: $('#statusPeserta').val(),
                Faskes: $('input[name=Faskes]:checked').val(),
                Notelp: $('#Notelp').val(),
                Cob: $('input[name=Cob]:checked').val(),
                bangsal: $('#bangsal').val(),
                kelas: $('#kelas').val(),
                Bed: $('#Bed').val(),
                TempatTidur: $('#TempatTidur').val(),
                DocRawat: $('#DocYgMerawat').val(),
                Keyakinan: $('#change_keyakinan').val(),
                asalRujukan: $('[name=Faskes]:checked').val(),
                noSurat: $('#NoSuratKontrol').val(),
                catatan: $('#catatan').val()
            }
            @if(!isset($edit))
            $.ajax({
                type:"GET",
                url:"{{route('api.cek-mutasi-pasien')}}",
                data:send,
                success(resp){
                    if(resp.status){
                        // $("#form-psn-bpjs").submit();
                        $.ajax({
                            url:"{{ route('reg-bpjs-mutasi.post') }}",
                            type:"post",
                            dataType:"json",
                            data:send,
                            success:function(response)
                            {
                                console.log(response);
                                loading.modal('hide');
                                // push_mutasi(send);
                                alert(response.message);
                            }
                        });
                        // alert("Berhasil input");
                    }else{
                        loading.modal('hide');
                        pesan = "Pasien Telah Terdaftar Unutuk \n" +
                                "Tanggal :" + resp.data.Regdate.substring(0,10) + "\n" +
                                "No. Reg :" + resp.data.Regno + "\n" +
                                "Poli :" + resp.data.NMPoli + "\n" +
                                "Dokter :" + resp.data.NmDoc;
                        alert(pesan);
                    }  
                }
            });
            @else
            $.ajax({
                url:"{{ route('reg-bpjs-mutasi.post') }}",
                type:"post",
                dataType:"json",
                data:send,
                success:function(response)
                {
                    console.log(response);
                    loading.modal('hide');
                    // push_mutasi(send);
                    alert(response.message);
                }
            });
            @endif
        }
        loading.modal('hide');
    });

    $('#createsep').on('click', function () {
        let btn = $('#createsep');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        btn.prop('disabled', true);
        let loading = $('.modal-loading');
        loading.modal('show');
        if ($('#Medrec').val() == '') {
            alert('No Rekam Medis Kosong');
        } else if ($('#noKartu').val() == '') {
            alert('No Kartu Kosong');
        } else if(($('input[name=KdSex]:checked').length) <= 0 ) {
            alert('Silahkan pilih jenis kelamin');
        } else if($('#jatah_kelas').val() == '') {
            alert('Silahkan pilih jatah kelas');
        } else if($('#Notelp').val() == '') {
            alert('No Telepon kosong');
        } else {
            $.ajax({
                url:"{{ route('api.sep_post') }}",
                type:"post",
                dataType:"json",
                data:{
                    type: 'spri',
                    Regno: $('#Regno').val(),
                    noMR: $('#Medrec').val(),
                    noKartu: $('#noKartu').val(),
                    tglSep: $('#Regdate').val(),
                    ppkPelayanan: $('#Ppk').val(),
                    jnsPelayanan: $('#pengobatan').val(),
                    klsRawat: $('#jatah_kelas').val(),
                    asalRujukan: $('[name=Faskes]:checked').val(),
                    tglRujukan: $('#RegRujuk').val(),
                    noRujukan: $('#NoRujuk').val(),
                    ppkRujukan: $('#Ppk').val(),
                    catatan: $('#catatan').val(),
                    diagAwal: $('#Diagnosa').val(),
                    tujuan: $('[name=KdPoli]').val(),
                    eksekutif: $('#eksekutif').val(),
                    cob: $('[name=Cob]').val(),
                    katarak: $('[name=Katarak]').val(),
                    lakaLantas: $('[name=KasKe]:checked').val(),
                    penjamin: $('[name=Penjamin]').val(),
                    tglKejadian: $('#RegdKej').val(),
                    keterangan: $('#Keterangan').val(),
                    suplesi: $('[name=Suplesi]').val(),
                    noSepSuplesi: $('#NoSepSup').val(),
                    kdPropinsi: $('#Provinsi').val(),
                    kdKabupaten: $('#Kabupaten').val(),
                    kdKecamatan: $('#Kecamatan').val(),
                    noSurat: $('#NoSuratKontrol').val(),
                    kodeDPJP: $('#Dokter').val(),
                    noTelp: $('#Notelp').val(),
                },
                beforeSend(){
                    loading.modal('show');
                },
                success:function(response)
                {
                    // alert('Response is: '.response);
                    console.log(response);
                    if(response.metaData.code != '200'){
                        alert(response.metaData.message);
                        $('#NotifSep').val(response.metaData.message);
                    }else{
                        alert(response.metaData.message);
                        $('#NoSep').val(response.data.sep.noSep);
                        $('#NotifSep').val(response.metaData.message);
                        // $('#NotifSep').val(metaData.data.message);
                        loading.modal('hide');
                    }
                }
            });
        }
        loading.modal('hide');
        btn.prop('disabled', false);
        btn.html(oldText);
    });

    $('#simpan_keyakinan').on("click", function(ev) {
        ev.preventDefault();
        if ($('#ke_NoRM').val() != '') {
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
                    ppnote: $('#pantangPerawatanNote').val(),
                    lain: $('[name=lain]').val()
                },
                success: function(response)
                {
                    alert('Berhasil disimpan');
                    $('#change_keyakinan').val('Ya');
                    $('.bd-example-modal-lg-keyakinan').modal('hide');
                }
            });
        } else {
            alert('No Rekam Medic kosong!');
        }
    });

    $('#bd-example-modal-lg-caripasien').submit(function(ev)  {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('reg-bpjs-daftar.find-register') }}",
            type: "PUT",
            // dataType:"json",
            data: {
                _method : 'PUT',
                medrec: $('[name=pa_Medrec]').val(),
                notelp: $('[name=pa_Phone]').val(),
                nama: $('[name=pa_Firstname]').val(),
                alamat: $('[name=pa_Address]').val(),
                nopeserta: $('[name=pa_noPeserta]').val(),
                tgl_lahir: $('[name=pa_Tgl_lahir]').val(),
                date1: $('[name=date1]').val(),
                date2: $('[name=date2]').val()
            },
            beforeSend(){
                $('#target_cari_pasien').html('<div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success: function(response){
                $('#target_cari_pasien').html(response);
            }
        });
    });

    $('#search_nik').submit(function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        if ($('#NoIden').val().length == 16) {
            $.ajax({
                url:"{{ route('peserta-nik') }}",
                type:"get",
                dataType:"json",
                data:{
                    nik: $('#NoIden').val(),
                },
                beforeSend(){
                    loading.modal('show');
                },
                success:function(response)
                {
                    loading.modal('hide');
                    console.log(response);
                    if(response.data){

                        if (response.data.peserta.mr.noMR == null) {
                            alert("No Rekam Medik tidak ada!");
                        }else{
                            $('#Medrec').val(response.data.peserta.mr.noMR);
                            $('#Notelp').val(response.data.peserta.mr.noTelepon);
                        }

                        $('#Firstname').val(response.data.peserta.nama);
                        $('#NoIden').val(response.data.peserta.nik);
                        $('#noKartu').val(response.data.peserta.noKartu);
                        $('#pisat').val(response.data.peserta.pisa);
                        $('#jatah_kelas').val(response.data.peserta.hakKelas.kode);

                        $('#TglDaftar').val(response.data.peserta.tglCetakKartu);

                        $('#Bod').val(response.data.peserta.tglLahir);

                        var $ppk = $("<option selected></option>").val(response.data.peserta.provUmum.kdProvider).text(response.data.peserta.provUmum.nmProvider);
                        $('#Ppk').append($ppk).trigger('change');

                        $('#statusPeserta').val(response.data.peserta.statusPeserta.keterangan);

                        $('#Peserta').val(response.data.peserta.jenisPeserta.keterangan);

                        if (response.data.peserta.sex != null) {
                            $("input[name=KdSex][value=" + response.data.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                        }
                        var $penjamin = $("<option selected></option>").val(response.data.peserta.cob.noAsuransi).text(response.data.peserta.cob.nmAsuransi);
                        $('#Penjamin').append($penjamin).trigger('change');

                        $('#Dinsos').val(response.data.peserta.informasi.dinsos);
                        $('#NoSktm').val(response.data.peserta.informasi.noSKTM);
                        $('#Prolanis').val(response.data.peserta.informasi.prolanisPRB);
                        
                    }else{
                        alert('Pasien tidak ada!');
                    }
                }
            })
        } else if($('#NoIden').val().length < 16) {
            loading.modal('hide');
            alert('Nik kurang dari 16 digit');
        } else {
            loading.modal('hide');
            alert('Nik lebih dari 16 digit');
        }
        loading.modal('hide');
    });

    $('#search_noRujukan').submit(function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        var getdata = $('input[name=StatusRujuk]:checked').val();
        if (getdata == '1') {
            if ($('#NoRujuk').val().length == 19) {
                $.ajax({
                    url: "{{ route('peserta-rujukan') }}",
                    type:"get",
                    dataType:"json",
                    data:{
                        noRujukan: $('#NoRujuk').val(),
                    },
                    beforeSend(){
                        loading.modal('show');
                    },
                    success:function(response)
                    {
                        console.log(response);
                        loading.modal('hide');
                        if(response.data){

                            if (response.data.rujukan.peserta.mr.noMR == null) {
                                alert("No Rekam Medik tidak ada!");
                            }else{
                                $('#Medrec').val(response.data.rujukan.peserta.mr.noMR);
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);
                            $('#noKartu').val(response.data.rujukan.peserta.noKartu);
                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.peserta.tglCetakKartu);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir);
                            $('#RegRujuk').val(response.data.rujukan.peserta.tglTMT);

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.peserta.provUmum.kdProvider).text(response.data.rujukan.peserta.provUmum.nmProvider);
                            $('#Ppk').append($ppk).trigger('change');

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change')                       
                            
                        }else{
                            loading.modal('hide');
                            alert('Pasien tidak ada!');
                        }
                    }
                });
            } else if($('#NoRujuk').val().length < 19) {
                loading.modal('hide');
                alert('No Rujukan kurang dari 19 dikit');
            } else{
                loading.modal('hide');
                alert('Gagal');
            }
        } else if (getdata == '2') {
            if ($('#NoRujuk').val().length == 19) {
                $.ajax({
                    url: "{{ route('peserta-rujukan-rs') }}",
                    type:"get",
                    dataType:"json",
                    data:{
                        noRujukan: $('#NoRujuk').val(),
                    },
                    beforeSend(){
                        loading.modal('show');
                    },
                    success:function(response)
                    {
                        console.log(response);
                        loading.modal('hide');
                        console.log(response);
                        if(response.data){

                            if (response.data.rujukan.peserta.mr.noMR == null) {
                                alert("No Rekam Medik tidak ada!");
                            }else{
                                $('#Medrec').val(response.data.rujukan.peserta.mr.noMR);
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);
                            $('#noKartu').val(response.data.rujukan.peserta.noKartu);
                            $('#RegRujuk').val(response.data.rujukan.peserta.tglTMT);
                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.peserta.tglCetakKartu);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir);

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.peserta.provUmum.kdProvider).text(response.data.rujukan.peserta.provUmum.nmProvider);
                            $('#Ppk').append($ppk).trigger('change');

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change');                 
                            
                        }else{
                            loading.modal('hide');
                            alert('Pasien tidak ada!');
                        }
                    }
                });
            } else if($('#NoRujuk').val().length < 19) {
                loading.modal('hide');
                alert('No Rujukan kurang dari 19 dikit');
            } else{
                loading.modal('hide');
                alert('Gagal');
            }
        } else {
            alert('Pilih terlebih dahulu status rujukan');
        }
        loading.modal('hide');
    });

    $('#search_no_peserta').submit(function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        var getdata = $('input[name=StatusRujuk]:checked').val();
        if (getdata == '0') {
            if ($('#noKartu').val().length == 13) {
                $.ajax({
                    url:"{{ route('peserta-kartu-bpjs') }}",
                    type:"get",
                    dataType:"json",
                    data:{
                        nopeserta: $('#noKartu').val(),
                    },
                    beforeSend(){
                        loading.modal('show');
                    },
                    success:function(response)
                    {
                        console.log(response);
                        if(response.data){
                            loading.modal('hide');
                            if (response.data.peserta.mr.noMR == null) {
                                alert("No Rekam Medik tidak ada!");
                                
                            }else{
                                $('#Medrec').val(response.data.peserta.mr.noMR);
                                $('#Notelp').val(response.data.peserta.mr.noTelepon);
                            }

                            $('#Firstname').val(response.data.peserta.nama);
                            $('#NoIden').val(response.data.peserta.nik);
                            $('#pisat').val(response.data.peserta.pisa);
                            $('#jatah_kelas').val(response.data.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.peserta.tglCetakKartu);

                            $('#Bod').val(response.data.peserta.tglLahir);

                            var $ppk = $("<option selected></option>").val(response.data.peserta.provUmum.kdProvider).text(response.data.peserta.provUmum.nmProvider);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.peserta.provUmum.kdProvider);

                            $('#statusPeserta').val(response.data.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.peserta.jenisPeserta.keterangan);
                            $('#kodePeserta').val(response.data.peserta.jenisPeserta.kode);

                            if (response.data.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            $('#Dinsos').val(response.data.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.peserta.informasi.prolanisPRB);
                            var $penjamin = $("<option selected></option>").val(response.data.peserta.cob.noAsuransi).text(response.data.peserta.cob.nmAsuransi);
                            $('#Penjamin').append($penjamin).trigger('change');
                        } else {
                            loading.modal('hide');
                            alert("Gagal");

                        }
                    }
                })
            } else if($('#noKartu').val().length < 13) {
                loading.modal('hide');
                alert('No Kartu BPJS kurang dari 13 digit!');
            } else {
                loading.modal('hide');
                alert('No Kartu BPJS lebih dari 13 digit!');
            }
        } else if(getdata == '1') {
            if ($('#noKartu').val().length == 13) {
                $.ajax({
                    url:"{{ route('peserta-rujukan-no-kartu-pcare') }}",
                    type:"get",
                    dataType:"json",
                    data:{
                        nopeserta: $('#noKartu').val(),
                    },
                    beforeSend(){
                        loading.modal('show');
                    },
                    success:function(response)
                    {
                        console.log(response);
                        if(response.data){
                            if (response.data.rujukan.peserta.mr.noMR == null) {
                                alert("No Rekam Medik tidak ada!");
                                
                            }else{
                                $('#Medrec').val(response.data.rujukan.peserta.mr.noMR);
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);
                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.tglKunjungan);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir);

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.provPerujuk.kode).text(response.data.rujukan.provPerujuk.nama);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.rujukan.provPerujuk.kode);

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);
                            $('#kodePeserta').val(response.data.rujukan.peserta.jenisPeserta.kode);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            if (response.data.asalFaskes != null) {
                                $("input[name=Faskes][value=" + response.data.asalFaskes + "]").attr('checked', 'checked');
                            }

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change');

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);
                            $('#NoRujuk').val(response.data.rujukan.noKunjungan);
                        } else {
                            loading.modal('hide');
                            alert("Gagal");

                        }
                    }
                })
            } else if($('#noKartu').val().length < 13) {
                loading.modal('hide');
                alert('No Kartu BPJS kurang dari 13 digit!');
            } else {
                loading.modal('hide');
                alert('No Kartu BPJS lebih dari 13 digit!');
            }
        } else if(getdata == '2') {
            if ($('#noKartu').val().length == 13) {
                $.ajax({
                    url:"{{ route('peserta-rujukan-no-kartu-rs') }}",
                    type:"get",
                    dataType:"json",
                    data:{
                        nopeserta: $('#noKartu').val(),
                    },
                    beforeSend(){
                        loading.modal('show');
                    },
                    success:function(response)
                    {
                        console.log(response);
                        if(response.data){
                            if (response.data.rujukan.peserta.mr.noMR == null) {
                                alert("No Rekam Medik tidak ada!");
                                
                            }else{
                                $('#Medrec').val(response.data.rujukan.peserta.mr.noMR);
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);
                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.tglKunjungan);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir);

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.provPerujuk.kode).text(response.data.rujukan.provPerujuk.nama);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.rujukan.provPerujuk.kode);

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);
                            $('#kodePeserta').val(response.data.rujukan.peserta.jenisPeserta.kode);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            if (response.data.asalFaskes != null) {
                                $("input[name=Faskes][value=" + response.data.asalFaskes + "]").attr('checked', 'checked');
                            }

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change');

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);
                            $('#NoRujuk').val(response.data.rujukan.noKunjungan);
                        } else {
                            loading.modal('hide');
                            alert("Gagal");

                        }
                    }
                })
            } else if($('#noKartu').val().length < 13) {
                loading.modal('hide');
                alert('No Kartu BPJS kurang dari 13 digit!');
            } else {
                loading.modal('hide');
                alert('No Kartu BPJS lebih dari 13 digit!');
            }
        }
        loading.modal('hide');
    });

    $('#search_regno').submit(function(ev) {
        ev.preventDefault();
    });

     // Ngitung Umur
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
            data: function(params) {
                return $.extend(params, {
                    provinsi : $('#Provinsi option:selected').val(),
                });
            },
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
        }
    }));

    $('#Kecamatan').select2($.extend(true, baseSelect2, {
        ajax: {
            url: "{{ route('api.select2.kecamatan') }}",
            data: function(params) {
                return $.extend(params, {
                    kabupaten : $('#Kabupaten option:selected').val(),
                });
            },
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
        }
    }));

    $('#Ppk').select2($.extend(true, select2Bpjs, {
        ajax: {
            url: '{{ route('vclaim.faskes') }}',
            data: function(params) {
                return $.extend(params, { faskes: $("input[name=Faskes]:checked").val() });
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

    $('#Diagnosa').select2($.extend(true, baseSelect2, {
        ajax: {
            url:"{{ route('api.select2.icd') }}",
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        return $.extend(item, {
                            id: item.KDICD,
                            text: `${item.KDICD} - ${item.DIAGNOSA}`,
                        });
                    }),
                    pagination: { more: data.next_page_url }
                }
            },
        },
    }));

    $('#poli').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.poli')}}",
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
                        item.id = item.KDPoli;
                        item.text = item.NMPoli;
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
                    ${item.NMPoli}
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

    $('#Dokter').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.dokter')}}",
            dataType: 'json',
            data: function(params) {
                return $.extend(params, {
                    kdPoli: kdPoli,
                    dpjpOnly: document.getElementsByName('dpjp-only')[0].checked ? 1 : 0,
                });
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KdDoc;
                        item.text = item.NmDoc;
                        return item;
                    }),
                    pagination: {
                        more: data.next_page_url
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
                    ${item.NmDoc} - ${item.KdDPJP}
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
</script>
@endsection