@extends('layouts.main')
@section('title','Registrasi Pasien BPJS | Modul Registrasi')
@section('bpjs','active')
@section('daftar_bpjs','active')
@section('header','Registrasi Pasien BPJS')
@section('subheader','Form Data')
@section('content')
<script src="<?=asset('public/js/ws-client.js')?>"></script>
<script>
  // init web shocket
  let ws = new AntrianWS("{{ config('ws.host') }}:{{ config('ws.port') }}", 'tracer', 1, function(data) {
    // if(data.type == 'broadcast') { console.log(data);}
  });
  ws.init();
  
  // send data web shocket
  function push_print(regno) {
    if(ws) { ws.broadcast( {command: 'print', parameters: {regno: regno}},{ tracer:1 }); };
  }
</script>
<section>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a href="{{route('reg-bpjs-daftar')}}" class="btn btn-warning btn-sm"> List Pasien</a>
        <a href="{{route('reg-bpjs-detailsep')}}" class="btn btn-warning btn-sm"> Detail SEP Peserta</a>
        <button type="button" id="btn-cari-pasien" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-caripasien" style="width: 150px; height: 34px;">Cari Data Pasien</button>
        <a href="{{ route('mst-psn.form') }}" class="btn btn-primary btn-sm"><small>Pasien Baru</small></a>
        <button type="button" id="btn-cari-pasien" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-rujukan" style="width: 150px; height: 34px; display: none;">Cari Rujukan</button>
        <button type="button" id="btn-cari-rujukan" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg" style="width: 170px; height: 34px; display: none;">List Registrasi Online</button>
        {{-- <button class="btn btn-sm btn-round btn-info" id="send_data"><i class="fa fa-upload"></i></button> --}}
        <div class="pull-right">
            <button type="button" id="btn-keyakinan" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-keyakinan" style="width: 170px; height: 34px;">Tambah Keyakinan</button>
            <button type="button" id="btn-histori" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg-histori" style="width: 150px; height: 34px;">Histori Pasien</button>
        </div>
        <hr>
    </div>
    <hr>
    <form action="{{ route('reg-bpjs-daftar.form-post') }}" method="post" class="row" id="form-psn-bpjs">
        {{ csrf_field() }}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> No Registrasi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
                        <input type="text" name="Regno" class="form-control input-sm col-sm-5" id="Regno" readonly value="{{ @$edit->Regno }}"/>
                        <div class="checkbox" style="display: table-cell;padding-left: 10px;">
                            <label>
                                <input type="checkbox" id="Perjanjian" {{ isset($edit->Perjanjian) && strtolower(strtoupper($edit->Perjanjian)) == 'true' ? 'checked' : '' }}>
                                <span class="lbl">Pasien Perjanjian</span>
                            </label>
                        </div>

                        <div class="checkbox" style="display: table-cell;padding-left: 15px;">
                            <label>
                                <input type="checkbox" id="fam_tracing">
                                <span class="lbl">Tracing Keluarga Pasien</span>
                            </label>
                        </div>
                    </div>
                </div>
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="loading_home"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Data Pasien</u></p>
                <!-- Nomor RM -->
                <form method="get">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> No Rekam Medis</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
                        <input type="text" name="Medrec" id="Medrec" value="{{ @$edit->Medrec }}"/>
                        <button type="submit" class="btn btn-info btn-sm" id="btnCari" style="margin-left: 10px;">
                            <i class="ace-icon fa fa-search"></i>Cari
                        </button>
                    </div>
                </div>
                </form>
                <!-- Nama Pasien -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
                        <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" readonly value="{{ @$edit->Firstname }}"/>
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
                        <input type="date" name="TglDaftar" id="TglDaftar" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ isset($edit->TglDaftar) ? date('Y-m-d',strtotime($edit->TglDaftar)) : '' }}"/>
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
                <!-- Asal Rujukan -->
                <div class="form-group">
                    <label class="col-md-3 control-label no-padding-right">Rujukan Dari</label>
                    <div class="input-group col-md-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="rujukan_dari" id="rujukan_dari" style="width:100%;" class="form-control">
                            <option value="">-= Rujukan Dari =-</option>
                            @foreach ($kelompok_rujukan as $kr)
                                <option value="{{ $kr->I_KelompokRujukan }}" {{ isset($edit->rujukan_dari) && @$edit->rujukan_dari == $kr->I_KelompokRujukan ? 'selected' : '-= Kunjungan =-'}}>{{ $kr->N_KelompokRujukan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
                        <input type="text" name="NoSuratKontrol" class="form-control input-sm" id="NoSuratKontrol" value="{{ @$edit->NoKontrol }}"/>
                        <!-- Tanggal Registrasi -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Rujukan</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="RegRujuk" id="RegRujuk" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->TglRujuk) ? date('Y-m-d',strtotime($edit->TglRujuk)) : date('Y-m-d') }}"/>
                    </div>
                </div>
                </form>
                <div class="form-group">
                    <label class="col-md-3 control-label no-padding-right">Dokter Pengirim/DPJP</label>
                    <div class="input-group col-md-9">
                        <span class="input-group-addon" id="" style="border:none; background-color: transparent;">:</span>
                        <select name="DokterPengirim" id="DokterPengirim" style="width:100%;" class="form-control input-sm select2" readonly="readonly">
                            <option value="{{ isset($edit->dpjpKdDPJP) ? $edit->dpjpKdDPJP : '' }}">{{ isset($edit->dpjpNmDoc) ? @$edit->dpjpNmDoc : '-= Dokter Pengirim =-' }}</option>
                        </select>
                    </div>
                </div>
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
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No. Urut</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NomorUrut" id="NomorUrut" readonly="readonly" value="{{ @$edit->NomorUrut }}">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Kunjungan</span>
                        <select type="text" name="Kunjungan" id="Kunjungan" style="width:100%;" class="form-control">
                            <option value="">-= Kunjungan =-</option>
                            @foreach (['Lama','Baru'] as $wn)
                            <option value="{{ $wn }}" {{ isset($edit->Kunjungan) && @$edit->Kunjungan == $wn ? 'selected' : '-= Kunjungan =-'}}>{{ $wn }}</option>
                            @endforeach
                        </select>
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
                            <option value="{{ $edit->NmKelas }}">Kelas {{ $edit->NmKelas }}</option>
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
                        <input type="hidden" name="NmKelas" id="NmKelas">
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
                        <select name="KdTuju" id="pengobatan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" readonly="readonly">
                            <option value="2">Rawat Jalan BPJS</option>
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
                            <option value="{{ isset($edit->KdDoc) ? $edit->KdDoc : '' }}">{{ isset($edit->NmDoc) ? @$edit->NmDoc : '-= Dokter =-' }}</option>
                        </select>
                        <div class="checkbox" style="display: table-cell;padding-left: 10px;">
                            <label>
                                <input type="checkbox" name="dpjp-only">
                                <span class="lbl">SIP</span>
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
                            <option value="{{ isset($edit->KdRujukan) ? $edit->KdRujukan : '' }}">{{ isset($edit->NmRujukan) ? @$edit->NmRujukan : '-= PPK =-' }}</option>
                        </select>
                        <input type="hidden" name="noPpk" id="noPpk" value="{{ @$edit->NmRujukan }}">
                        <input type="hidden" name="kodeoPpk" id="kodePpk" value="">
                        <input type="hidden" name="I_Rujukan" id="I_Rujukan" value="">
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
                                <span class="lbl">&nbsp; Tidak</span>
                            </label>
                            <label>
                                <input name="KasKe" id="Kecelaakan2" type="radio" class="ace" value="1" {{ isset($edit->KdKasus) && strtolower(strtoupper($edit->KdKasus)) == '1' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Ya</span>
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
                            <option value="">- Penjamin -</option>
                            <option value="1">1. Jasa Raharja</option>
                            <option value="2">2. BPJS Ketenagakerjaan</option>
                            <option value="3">3. TASPEN</option>
                            <option value="4">4. ASABRI</option>
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
                                <input name="Suplesi" type="radio" class="ace" value="0" {{ isset($edit->Suplesi) && strtolower(strtoupper($edit->Suplesi)) == '0' ? 'checked' : 'checked' }}/>
                                <span class="lbl">&nbsp; Tidak</span>
                            </label>
                            <label>
                                <input name="Suplesi" type="radio" class="ace" value="1" {{ isset($edit->Suplesi) && strtolower(strtoupper($edit->Suplesi)) == '0' ? 'checked' : '' }}/>
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
                        <input type="hidden" name="NmPropinsi" id="NmPropinsi">
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
                            <option value="02" selected="selected">BPJS</option>
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
                <!-- Dinsos -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Dinsos</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Dinsos" id="Dinsos" class="form-control input-sm col-xs-10 col-sm-5" readonly />
                    </div>
                </div>
                <!-- No SKTM -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No SKTM</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoSktm" id="NoSktm" class="form-control input-sm col-xs-10 col-sm-5" readonly />
                    </div>
                </div>
                <!-- Prolanis PRB -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Prolanis PRB</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Prolanis" id="Prolanis" class="form-control input-sm col-xs-10 col-sm-5" readonly />
                    </div>
                </div>
                <!-- Diagnosa Awal -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Diagnosa Awal</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="DiagAw" id="Diagnosa" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                            @if(isset($edit) && isset($edit->KdICD))
                            <option value="{{ $edit->KdICD }}" selected="selected">{{ $edit->DIAGNOSA }}</option>
                            @else
                            <option value="">-= Diagnosa =-</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!-- Catatan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Catatan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <textarea class="form-control input-sm col-xs-10 col-sm-5" name="catatan" id="catatan">{{ @$edit->Catatan }}</textarea>
                    </div>
                </div>
                <!-- No SEP -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No SEP</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoSep" id="NoSep" class="col-xs-6" value="{{ @$edit->NoSep }}"/>
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
                        <input type="text" name="NotifSep" id="NotifSep" class="form-control input-sm col-xs-10 col-sm-5" value="{{ @$edit->NotifSEP }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <input type="hidden" name="change_keyakinan" id="change_keyakinan">
        <input type="hidden" name="regold" id="regold" value="{{ @$edit->IdRegOld }}">
        <button type="submit" name="submit" id="submit" class="btn btn-success">Simpan</button>
        <button type="button" name="printsep" id="printsep" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print SEP</button>
        <button type="button" name="printslip" id="printslip" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print Slip</button>
        <button type="button" name="printlabel" id="printlabel" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print Label</button>
        <button type="button" name="printkeyakinan" id="printkeyakinan" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print Keyakinan</button>
    </form>
    <!-- MODAL CARI PASIEN -->
    <div class="modal fade bd-example-modal-lg-caripasien"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                    <input type="text" name="pa_Medrec" id="pa_Medrec" class="form-control input-sm col-xs-10 col-sm-5" />
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
                                <label class="col-sm-3 control-label no-padding-right">No BPJS</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_noPeserta" id="pa_noPeserta" class="form-control input-sm col-xs-10 col-sm-5"/>
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
                                <label class="col-sm-3 control-label no-padding-right">Tanggal Daftar</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="date" name="date1" id="date1" style="width: 40%" />
                                    <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
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
    </div><!-- MODAL CARI PASIEN -->
    <!-- HISTORI PASIEN -->
    <div class="modal fade bd-example-modal-lg-histori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Histori Pasien <span id="nama-message"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div style="overflow:auto;" id="target_table">
                        <table class="table table-bordered" id="table-histori">
                            <thead>
                                <tr>
                                    <th>No Sep</th>
                                    <th>RI/RJ</th>
                                    <th>Poli</th>
                                    <th>Tgl SEP</th>
                                    <th>No Rujukan</th>
                                    <th>Diagnosa</th>
                                    <th>PPK Perujuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="11">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- HISTORI PASIEN -->
    <!-- MODAL CARI RUJUKAN -->
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
    </div><!-- MODAL LIST REGSITRASI ONLINE -->
    <!-- MODAL KEYAKINAN -->
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
    </div><!-- MODAL KEYAKINAN -->
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
    <!-- MODAL UPDATE KATEGORI -->
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
                                <input type="text" name="kat_NoRM" id="kat_NoRM" class="form-control input-sm col-xs-6 col-sm-6" readonly  value="{{ @$edit->Medrec }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Nama Pasien -->
                            <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="kat_Firstname" id="kat_Firstname" class="form-control input-sm col-xs-6 col-sm-6" readonly placeholder="Nama Pasien" value="{{ @$edit->Firstname }}" />
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
    </div><!-- MODAL UPDATE KATEGORI -->
</section>
@endsection
@section('script')
<script>
    $('[name=KasKe]').on('change', function(ev,xv){
        if($(this).val() == '1'){
            $('#Keterangan').removeAttr('readonly');
            $('#NoSepSup').removeAttr('readonly');
            $('#RegdKej').removeAttr('readonly');
            $('#Suplesi').prop('disabled', false);
            $('#Provinsi').prop('disabled', false);
            $('#Kabupaten').prop('disabled', false);
            $('#Kecamatan').prop('disabled', false);
        }else{
            $('#Keterangan').attr('readonly','readonly');
            $('#NoSepSup').attr('readonly','readonly');
            $('#RegdKej').attr('readonly','readonly');
            $('#Suplesi').prop('disabled', true);
            $('#Provinsi').prop('disabled', true);
            $('#Kabupaten').prop('disabled', true);
            $('#Kecamatan').prop('disabled', true);
        }
    });

    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
        $('[name=KdPoliBpjs]').val('');
        // setKodePoli('24', 'UGD');

        polirujukan = 'UGD';
        $('#DokterPengirim').prop('readonly', false);
    });
    $(".select2").select2();
    // =====================================
    $("#GroupUnit").on("change",function(){
        // console.log();
        load_unit(this.value);
    });
        
    // $("#send_data").on("click",function(){
    //     cek = [
    //         { regno : '00939742'},
    //         { regno : '00940398'},
    //         { regno : '00939757'},
    //         { regno : '00939768'}
    //     ];
    //     //00940398, 00939757, 00939768
    //     // var regno = '00939742';
    //     cek.forEach(c => {
    //         push_print(c.regno);
    //     });
    // });
    function load_unit(id_group_unit=''){
        $.ajax({
            type:'POST',
            // Master_pasien/load_unit
            url:"{{route('reg-bpjs-daftar')}}",
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

    $('#Provinsi').select2($.extend(true, baseSelect2, {
        ajax: {
            url: '{{ route('vclaim.propinsi') }}',
            processResults: function(data, params) {
                return select2VClaimResponse(data, params, function(data, params) {
                    return {
                        results: data.response.list.map(function(item) {
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

    // ====================================

    $('#Kabupaten').select2($.extend(true, baseSelect2, {
        ajax: {
            url: '{{ route('vclaim.kabupaten') }}',
            data: function(params) {
                return $.extend(params, {
                    propinsi: $('#Provinsi').val(),
                });
            },
            processResults: function(data, params) {
                return select2VClaimResponse(data, params, function(data, params) {
                    return {
                        results: data.response.list.map(function(item) {
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

    $('#Kecamatan').select2($.extend(true, baseSelect2, {
        ajax: {
            url: '{{ route('vclaim.kecamatan') }}',
            data: function(params) {
                return $.extend(params, {
                    kabupaten: $('#Kabupaten').val(),
                });
            },
            processResults: function(data, params) {
                return select2VClaimResponse(data, params, function(data, params) {
                    return {
                        results: data.response.list.map(function(item) {
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

    // ==============================================================
    const select2Bpjs = {
        ajax: { dataType: 'json', },
        templateResult: function(item) { return item.loading ? item.text : `<p>${item.text}</p>`; },
        escapeMarkup: function(markup) { return markup; },
        templateSelection: function(item) { return item.text; },
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

    $('#Ppk').on("change",function(){ 
        text = $("#Ppk option:selected").text();
        $("#noPpk").val(text);
    });

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

    $('#pengobatan').select2({
        ajax: {
            // api/get_ppk
            url:"{{ route('api.select2.pengobatan') }}",
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
                        item.id = item.KDTuju;
                        item.text = item.NMTuju;
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

            return `<p>${item.NMTuju}</p>`;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });
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
    let kdPoli = '';

    function setKodePoli(k, kb) {
        kdPoli = k;
        $('[name=KdPoliBpjs]').val(kb);
    }

    $('#poli').on('select2:select', function(ev) {
        let data = ev.params.data;
        kdPoli = data.KDPoli;
        $('[name=KdPoliBpjs]').val(data.KdBPJS);;
    });

    $('#Dokter').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.dokter')}}",
            dataType: 'json',
            data: function(params) {
                return $.extend(params, {
                    kdPoli: kdPoli,
                    bpjs: $('#pengobatan').val(),
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

    let KdDPJP = null;
    $('#DokterPengirim').on('select2:select', function(ev){
        KdDPJP = ev.params.data.KdDPJP;
    });

    $('#rujukan_dari').select2();

    let polirujukan = null;
    $('#DokterPengirim').select2({
        ajax: {
            // api/get_ppk
            url:function(){ 
                return polirujukan ? "{{route('api.select2.dokter')}}" : "javascript:;";
            },
            dataType: 'json',
            data: function(params) {
                return $.extend(params, {
                    KdPoliBpjs: polirujukan ? polirujukan.kode : '',
                    dpjpOnly: 1,
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
        var text = $("#jatah_kelas option:selected").text();
        console.log(text);
        $("#NmKelas").val(text);
    });

    $('HGNMPenjamin').select2({
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

    $('#bd-example-modal-lg-caripasien').submit(function(ev)  {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('reg-bpjs-daftar.find-pasien') }}",
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
                            if (response.data.peserta.mr.noMR == null) {
                                alert("No Rekam Medik tidak ada!");
                            } else {
                                $('#Medrec').val(response.data.peserta.mr.noMR);
                                $('#Kunjungan').val('Lama');
                                $('#Notelp').val(response.data.peserta.mr.noTelepon);
                                $('#kat_NoRM').val(response.data.peserta.mr.noMR);
                                $('#kat_Firstname').val(response.data.peserta.nama);
                                get_kategori_pasien_master(response.data.peserta.mr.noMR);
                            }
                            // alert(response.data.peserta.mr.noMR);

                            $('#Firstname').val(response.data.peserta.nama);
                            $('#NoIden').val(response.data.peserta.nik);
                            $('#pisat').val(response.data.peserta.pisa);

                            $('#jatah_kelas').val(response.data.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.peserta.tglCetakKartu);

                            $('#Bod').val(response.data.peserta.tglLahir).trigger('change');

                            var $ppk = $("<option selected></option>").val(response.data.peserta.provUmum.kdProvider).text(response.data.peserta.provUmum.nmProvider);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.peserta.provUmum.nmProvider);

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

                            $('[name=KdPoliBpjs]').val('');
                            setKodePoli('24', 'UGD');

                            polirujukan = 'UGD';
                            if (response.data) {
                                $('#DokterPengirim').prop('readonly', false);
                            }

                            // Panggil histori
                            get_histori($('#noKartu').val());
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
                                // $('#btnCari').click();
                                $('#Kunjungan').val('Lama');
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                                $('#kat_NoRM').val(response.data.rujukan.peserta.mr.noMR);
                                $('#kat_Firstname').val(response.data.rujukan.peserta.nama);
                                get_kategori_pasien_master(response.data.rujukan.peserta.mr.noMR);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);

                            // var $kelas = $("<option selected></option>").val(response.data.rujukan.peserta.hakKelas.kode).text(response.data.rujukan.peserta.hakKelas.keterangan);
                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.peserta.tglCetakKartu);
                            $('#RegRujuk').val(response.data.rujukan.tglKunjungan);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir).trigger('change');

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.provPerujuk.kode).text(response.data.rujukan.provPerujuk.nama);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.rujukan.provPerujuk.nama);
                            $('#kodePpk').val(response.data.rujukan.provPerujuk.kode);

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);
                            $('#kodePeserta').val(response.data.rujukan.peserta.jenisPeserta.kode);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            if (response.data.asalFaskes != null) {
                                $("input[name=Faskes][value=" + response.data.asalFaskes + "]").attr('checked', 'checked');
                            }

                            var $pelayanan = $("<option selected></option>").val(response.data.rujukan.pelayanan.kode).text(response.data.rujukan.pelayanan.nama);
                            $('#pengobatan').append($pelayanan).trigger('change');

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change');

                            var $poli = $("<option selected></option>").val(response.data.poli_local.KDPoli).text(response.data.poli_local.NMPoli);
                            $('#poli').append($poli).trigger('change');
                            $('[name=KdPoliBpjs]').val(response.data.poli_local.KdBPJS);
                            setKodePoli(response.data.poli_local.KDPoli, response.data.poli_local.KdBPJS);

                            polirujukan = response.data.rujukan.poliRujukan;
                            if (response.data.rujukan.poliRujukan.kode) {
                                $('#DokterPengirim').prop('readonly', false);
                            }

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);
                            $('#NoRujuk').val(response.data.rujukan.noKunjungan);

                            // Panggil histori
                            get_histori($('#noKartu').val());
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
                                // $('#btnCari').click();
                                $('#Kunjungan').val('Lama');
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                                $('#kat_NoRM').val(response.data.rujukan.peserta.mr.noMR);
                                $('#kat_Firstname').val(response.data.rujukan.peserta.nama);
                                get_kategori_pasien_master(response.data.rujukan.peserta.mr.noMR);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);

                            // var $kelas = $("<option selected></option>").val(response.data.rujukan.peserta.hakKelas.kode).text(response.data.rujukan.peserta.hakKelas.keterangan);
                            // $('#jatah_kelas').append($kelas).trigger('change');
                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.peserta.tglCetakKartu);
                            $('#RegRujuk').val(response.data.rujukan.tglKunjungan);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir).trigger('change');

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.provPerujuk.kode).text(response.data.rujukan.provPerujuk.nama);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.rujukan.provPerujuk.nama);
                            $('#kodePpk').val(response.data.rujukan.provPerujuk.kode);

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);
                            $('#kodePeserta').val(response.data.rujukan.peserta.jenisPeserta.kode);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            if (response.data.asalFaskes != null) {
                                $("input[name=Faskes][value=" + response.data.asalFaskes + "]").attr('checked', 'checked');
                            }

                            var $pelayanan = $("<option selected></option>").val(response.data.rujukan.pelayanan.kode).text(response.data.rujukan.pelayanan.nama);
                            $('#pengobatan').append($pelayanan).trigger('change');

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change');

                            var $poli = $("<option selected></option>").val(response.data.poli_local.KDPoli).text(response.data.poli_local.NMPoli);
                            $('#poli').append($poli).trigger('change');
                            $('[name=KdPoliBpjs]').val(response.data.poli_local.KdBPJS);
                            setKodePoli(response.data.poli_local.KDPoli, response.data.poli_local.KdBPJS);

                            polirujukan = response.data.rujukan.poliRujukan;
                            if (response.data.rujukan.poliRujukan.kode) {
                                $('#DokterPengirim').prop('readonly', false);
                            }

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);
                            $('#NoRujuk').val(response.data.rujukan.noKunjungan);

                            // Panggil histori
                            get_histori($('#noKartu').val());
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
                    console.log(response);
                    if(response.data){

                        if (response.data.peserta.mr.noMR == null) {
                            alert("No Rekam Medik tidak ada!");
                        }else{
                            $('#Medrec').val(response.data.peserta.mr.noMR);
                            // $('#btnCari').click();
                            $('#Kunjungan').val('Lama');
                            $('#Notelp').val(response.data.peserta.mr.noTelepon);
                            $('#kat_NoRM').val(response.data.peserta.mr.noMR);
                            $('#kat_Firstname').val(response.data.peserta.nama);
                            get_kategori_pasien_master(response.data.peserta.mr.noMR);
                        }

                        $('#Firstname').val(response.data.peserta.nama);
                        $('#NoIden').val(response.data.peserta.nik);
                        $('#noKartu').val(response.data.peserta.noKartu);
                        $('#pisat').val(response.data.peserta.pisa);

                        $('#jatah_kelas').val(response.data.peserta.hakKelas.kode);

                        $('#TglDaftar').val(response.data.peserta.tglCetakKartu);

                        $('#Bod').val(response.data.peserta.tglLahir).trigger('change');

                        var $ppk = $("<option selected></option>").val(response.data.peserta.provUmum.kdProvider).text(response.data.peserta.provUmum.nmProvider);
                        $('#Ppk').append($ppk).trigger('change');
                        $('#noPpk').val(response.data.peserta.provUmum.nmProvider);

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
                        $('[name=KdPoliBpjs]').val('');
                        setKodePoli('24', 'UGD');

                        polirujukan = 'UGD';
                        if (response.data) {
                            $('#DokterPengirim').prop('readonly', false);
                        }

                        // Panggil histori
                        get_histori(response.data.peserta.noKartu);
                        loading.modal('hide');
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
                                // $('#btnCari').click();
                                $('#Kunjungan').val('Lama');
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                                $('#kat_NoRM').val(response.data.rujukan.peserta.mr.noMR);
                                $('#kat_Firstname').val(response.data.rujukan.peserta.nama);
                                get_kategori_pasien_master(response.data.rujukan.peserta.mr.noMR);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);
                            $('#noKartu').val(response.data.rujukan.peserta.noKartu);
                            $(`input[name=Faskes][value=${response.data.asalFaskes}]`).prop('checked', true);

                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.peserta.tglCetakKartu);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir).trigger('change');
                            $('#RegRujuk').val(response.data.rujukan.tglKunjungan);

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.provPerujuk.kode).text(response.data.rujukan.provPerujuk.nama);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.rujukan.provPerujuk.nama);
                            $('#kodePpk').val(response.data.rujukan.provPerujuk.kode);

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            var $poli = $("<option selected></option>").val(response.data.poli_local.KDPoli).text(response.data.poli_local.NMPoli);
                            $('#poli').append($poli).trigger('change');
                            $('[name=KdPoliBpjs]').val(response.data.poli_local.KdBPJS);
                            setKodePoli(response.data.poli_local.KDPoli, response.data.poli_local.KdBPJS);

                            polirujukan = response.data.rujukan.poliRujukan;
                            if (response.data.rujukan.poliRujukan.kode) {
                                $('#DokterPengirim').prop('readonly', false);
                            }

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change');

                            var $pengobatan = $("<option selected></option>").val(response.data.rujukan.pelayanan.kode).text(response.data.rujukan.pelayanan.nama);
                            $('#pengobatan').append($pengobatan).trigger('change');                        

                            // Panggil histori
                            get_histori(response.data.rujukan.peserta.noKartu);
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
                                // $('#btnCari').click();
                                $('#Kunjungan').val('Lama');
                                $('#Notelp').val(response.data.rujukan.peserta.mr.noTelepon);
                                $('#kat_NoRM').val(response.data.rujukan.peserta.mr.noMR);
                                $('#kat_Firstname').val(response.data.rujukan.peserta.nama);
                                get_kategori_pasien_master(response.data.rujukan.peserta.mr.noMR);
                            }

                            $('#Firstname').val(response.data.rujukan.peserta.nama);
                            $('#NoIden').val(response.data.rujukan.peserta.nik);
                            $('#pisat').val(response.data.rujukan.peserta.pisa);
                            $('#noKartu').val(response.data.rujukan.peserta.noKartu);
                            $('#RegRujuk').val(response.data.rujukan.tglKunjungan);
                            $(`input[name=Faskes][value=${response.data.asalFaskes}]`).prop('checked', true);

                            $('#jatah_kelas').val(response.data.rujukan.peserta.hakKelas.kode);

                            $('#TglDaftar').val(response.data.rujukan.peserta.tglCetakKartu);

                            $('#Bod').val(response.data.rujukan.peserta.tglLahir).trigger('change');

                            var $ppk = $("<option selected></option>").val(response.data.rujukan.provPerujuk.kode).text(response.data.rujukan.provPerujuk.nama);
                            $('#Ppk').append($ppk).trigger('change');
                            $('#noPpk').val(response.data.rujukan.provPerujuk.nama);
                            $('#kodePpk').val(response.data.rujukan.provPerujuk.kode);

                            $('#statusPeserta').val(response.data.rujukan.peserta.statusPeserta.keterangan);

                            $('#Peserta').val(response.data.rujukan.peserta.jenisPeserta.keterangan);

                            if (response.data.rujukan.peserta.sex != null) {
                                $("input[name=KdSex][value=" + response.data.rujukan.peserta.sex.toUpperCase() + "]").attr('checked', 'checked');
                            }

                            var $poli = $("<option selected></option>").val(response.data.poli_local.KDPoli).text(response.data.poli_local.NMPoli);
                            $('#poli').append($poli).trigger('change');
                            $('[name=KdPoliBpjs]').val(response.data.poli_local.KdBPJS);
                            setKodePoli(response.data.poli_local.KDPoli, response.data.poli_local.KdBPJS);

                            polirujukan = response.data.rujukan.poliRujukan;
                            if (response.data.rujukan.poliRujukan.kode) {
                                $('#DokterPengirim').prop('readonly', false);
                            }

                            $('#Dinsos').val(response.data.rujukan.peserta.informasi.dinsos);
                            $('#NoSktm').val(response.data.rujukan.peserta.informasi.noSKTM);
                            $('#Prolanis').val(response.data.rujukan.peserta.informasi.prolanisPRB);

                            var $diagnosa = $("<option selected></option>").val(response.data.rujukan.diagnosa.kode).text(response.data.rujukan.diagnosa.nama);
                            $('#Diagnosa').append($diagnosa).trigger('change');

                            var $pengobatan = $("<option selected></option>").val(response.data.rujukan.pelayanan.kode).text(response.data.rujukan.pelayanan.nama);
                            $('#pengobatan').append($pengobatan).trigger('change');                        
                            // Panggil histori
                            get_histori(response.data.rujukan.peserta.noKartu);
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
                    var bpjs_data = response.bpjs_data.response;
                    var register_data = response.register;
                    var master_ps_data = response.master_ps;
                    var kategori_data = response.kategori;
                    var dokter_data = response.dokter;
                    var poli_data = response.poli;

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
                    $('#NoRujuk').val(bpjs_data.NoRujukan.provPerujuk.noRujukan);
                    $('#RegRujuk').val(bpjs_data.NoRujukan.provPerujuk.tglRujukan.substring(0,10));

                    var $kategori = $("<option selected></option>").val(kategori_data.KdKategori).text(kategori_data.NmKategori);
                    $('#Kategori').append($kategori).trigger('change');

                    var $dokter = $("<option selected></option>").val(dokter_data.KdDoc).text(dokter_data.NmDoc);
                    $('#Dokter').append($dokter).trigger('change');

                    var $poli = $("<option selected></option>").val(poli_data.KdPoli).text(poli_data.NMPoli);
                    $('#poli').append($poli).trigger('change');
                    // setKodePoli(response.KdPoli, response.KdPoliBpjs);

                    if (master_ps_data.KdSex != null) {
                        $("input[name=KdSex][value=" + master_ps_data.KdSex.toUpperCase() + "]").attr('checked', 'checked');
                    }

                    $('#Kunjungan').val('Lama');

                    // Masukan buat update kategori
                    $('#kat_NoRM').val(master_ps_data.Medrec);
                    $('#kat_Firstname').val(master_ps_data.Firstname);
                    $('#kat_NoPeserta').val(master_ps_data.AskesNo);
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
        $.ajax({
            url:"{{ route('detail-pasien') }}",
            type:"get",
            dataType:"json",
            data:{
                Medrec: $('#Medrec').val(),
            },
            error: function(response){
                btn.prop('disabled', false);
                btn.html(oldText);
                alert('Gagal menambahkan/server down, Silahkan coba lagi');
            },
            success:function(response)
            {
                if(response.status){
                    var today = new Date();
                    btn.prop('disabled', false);
                    btn.html(oldText);

                    $('#Firstname').val(response.data.Firstname.toUpperCase());
                    $('#Notelp').val(response.data.Phone);
                    $('#Bod').val(response.data.Bod.substring(0,10));
                    $('#TglDaftar').val(response.data.TglDaftar.substring(0,10));
                    $('#NoIden').val(response.data.NoIden);
                    $('#Sex').val(response.data.Sex);
                    $('#UmurHari').val(response.data.UmurHr);
                    $('#UmurBln').val(response.data.UmurBln);
                    $('#UmurThn').val(response.data.UmurThn);
                    $('#noKartu').val(response.data.AskesNo);

                    var $kategori = $("<option selected></option>").val(response.data.Kategori).text(response.data.NmKategori);
                    $('#Kategori').append($kategori).trigger('change');

                    if (response.data.KdSex != null) {
                        $("input[name=KdSex][value=" + response.data.KdSex.toUpperCase() + "]").attr('checked', 'checked');
                    }

                    if(response.register == null){
                        $('#Kunjungan').val('Baru');
                    }else{
                        $('#Kunjungan').val('Lama');
                    }

                    // Masukan buat update kategori
                    $('#kat_NoRM').val(response.data.Medrec);
                    $('#kat_Firstname').val(response.data.Firstname);
                    $('#kat_NoPeserta').val(response.data.AskesNo);
                    var $ka_kategori = $("<option selected></option>").val(response.data.Kategori).text(response.data.NmKategori);
                    $('#kat_Kategori').append($ka_kategori).trigger('change');

                    var $groupUnit = $("<option selected></option>").val(response.data.GroupUnit).text(response.data.GroupUnit);
                    $('#GroupUnit').append($groupUnit).trigger('change');

                    var $unit = $("<option selected></option>").val(response.data.NmUnit).text(response.data.NmUnit);
                    $('#Unit').append($unit).trigger('change');

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

                    // tambahan
                    // if ($('#noKartu').val().length == 13) {
                    //     $.ajax({
                    //         url:"{{ route('peserta-kartu-bpjs') }}",
                    //         type:"get",
                    //         dataType:"json",
                    //         data:{
                    //             nopeserta: $('#noKartu').val(),
                    //         },
                    //         success:function(response)
                    //         {
                    //             console.log(response);
                    //             if(response.data){
                    //                 $('#pisat').val(response.data.peserta.pisa);

                    //                 $('#jatah_kelas').val(response.data.peserta.hakKelas.kode);

                    //                 $('#statusPeserta').val(response.data.peserta.statusPeserta.keterangan);

                    //                 $('#Peserta').val(response.data.peserta.jenisPeserta.keterangan);
                    //                 $('#kodePeserta').val(response.data.peserta.jenisPeserta.kode);
                    //                 $('#Dinsos').val(response.data.peserta.informasi.dinsos);
                    //                 $('#NoSktm').val(response.data.peserta.informasi.noSKTM);
                    //                 $('#Prolanis').val(response.data.peserta.informasi.prolanisPRB);

                    //                 // get histori peserta
                    //                 $.get('{{ route('vclaim.histori_peserta') }}', {
                    //                     no_kartu: $('#noKartu').val(),
                    //                     tanggal_mulai: '1990-01-01',
                    //                     tanggal_akhir: '2024-01-01',
                    //                 })
                    //                 .always(function() {
                                        
                    //                 })
                    //                 .fail(function() {
                    //                     alert('[ERR] Gagal mendapatkan data dari server');
                    //                 })
                    //                 .done(function(res) {
                    //                     if(!res || !res.metaData) {
                    //                         return alert('Tidak ada respon dari server');
                    //                     }
                    //                     else if(res.metaData.code != 200) {
                    //                         return alert('Histori: ' + res.metaData.message);
                    //                     }
                    //                     console.log(res);

                    //                     let data = res.response.histori;
                    //                     $('#table-histori tbody').html('');
                    //                     data.forEach(function(item) {
                    //                         $('#table-histori tbody').append(`
                    //                             <tr>
                    //                                 <td>${item.noSep}</td>
                    //                                 <td>${item.jnsPelayanan == 1 ? 'Rawat Inap' : (item.jnsPelayanan == 2 ? 'Rawat Jalan' : '')}</td>
                    //                                 <td>${item.poli}</td>
                    //                                 <td>${item.tglSep}</td>
                    //                                 <td>${item.noRujukan}</td>
                    //                                 <td>${item.diagnosa}</td>
                    //                                 <td>${item.ppkPelayanan}</td>
                    //                             </tr>
                    //                             `);
                    //                     });
                    //                 });
                    //             }
                    //         }
                    //     })
                    // }
                }else{
                    btn.prop('disabled', false);
                    btn.html(oldText);
                    alert('Pasien tidak ada!');
                }
            }
        })
    });

    let janji = null;
    $('#Perjanjian').click(function() {
        janji = $('#Perjanjian').prop('checked');
    });

    let fam_tracing = null;
    $('#fam_tracing').click(function() {
        fam_tracing = $('#fam_tracing').prop('checked');
    });

    $("#submit").on("click",function(e){
        e.preventDefault();
        let btn = $('#submit');
        let oldText = btn.html();
        // btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        // btn.prop('disabled', true);

        let loading = $('.modal-loading');
        loading.modal('show');

        var h2 = $('#Regdate').val();
        var selisih = (Number(new Date(h2)) - Number(new Date())) / (60 * 60 * 24 * 1000);
        var rekammedis = $('#Medrec').val();
        
        if ($('#pengobatan').val() == '') {
            alert('Pilih Tujuan!');
        } else if($('#poli').val() == '') {
            alert('Pilih Poli!');
        } else if($('#Dokter').val() == '') {
            alert('Pilih Dokter!');
        } else if($('#Medrec').val() == '') {
            alert('No Rekam Medis Kosong!');
        } else if($('#Kategori').val() == '') {
            alert('Silahkan pilih kategori atau segera update kategori');
        } else if(($('input[name=KdSex]:checked').length) <= 0 ) {
            alert('Pilih jenis kelamin Pasien');
        } else if($('#poli').val() == '39' && $('#cara_bayar').val() != '04'){
            alert('Cara Bayar Harus COVID19 !');
            btn.prop('disabled', false);
            btn.html(oldText);
            loading.modal('hide');
        } else if($('#poli').val() == '39' && $('#Kategori').val() != '3'){
            alert('Khusus Poli COVID19 Kategori Pasien Harus Jaminan Lain !');
            btn.prop('disabled', false);
            btn.html(oldText);
            loading.modal('hide');
        } else{
            var send = {
                medrec : rekammedis,
                regno : $("#Regno").val(),
                regdate : $("#Regdate").val(),
                poli : $('#poli').val(),
                kategori : $('#Kategori').val(),
                cbayar : $('#cara_bayar').val(),
                nosep: $('#NoSep').val(),
            }
            $.ajax({
                url:'{{ route("api.cek-sep-pasien") }}',
                type:'get',
                dataType:'json',
                data:send,
                success(resp){
                    if(resp.stat){
                        @if(!isset($edit))
                            if (selisih <= 8) {
                                $.ajax({
                                    type:"GET",
                                    url:"{{route('api.cek-regis-pasien')}}",
                                    data:send,
                                    success(resp){
                                        if(resp.status){
                                            // $("#form-psn-bpjs").submit();
                                            $.ajax({
                                                url:"{{ route('reg-bpjs-daftar.form-post') }}",
                                                type:"post",
                                                dataType:"json",
                                                data:{
                                                    rujukan_dari: $('#rujukan_dari').val(),
                                                    Regno: $('#Regno').val(),
                                                    // Medrec: rekammedis.substring(0,6),
                                                    Medrec: rekammedis,
                                                    Firstname: $('#Firstname').val(),
                                                    Regdate: $('#Regdate').val(),
                                                    Regtime: $('#Regtime').val(),
                                                    KdCbayar: $('#cara_bayar').val(),
                                                    Penjamin: $('[name=Penjamin]').val(),
                                                    noKartu: $('#noKartu').val(),
                                                    KdTuju: $('#pengobatan').val(),
                                                    KdPoli: $('#poli').val(),
                                                    DocRS: $('#Dokter').val(),
                                                    Kunjungan: $('#Kunjungan').val(),
                                                    UmurThn: $('#UmurThn').val(),
                                                    UmurBln: $('#UmurBln').val(),
                                                    UmurHari: $('#UmurHari').val(),
                                                    Bod: $('#Bod').val(),
                                                    NomorUrut: $('#NomorUrut').val(),
                                                    KategoriPasien: $('#Kategori').val(),
                                                    NoSep: $('#NoSep').val(),
                                                    DiagAw: $('#Diagnosa').val(),
                                                    KdSex: $('input[name=KdSex]:checked').val(),
                                                    pisat: $('#pisat').val(),
                                                    GroupUnit: $('#GroupUnit').val(),
                                                    Keterangan: $('#Keterangan').val(),
                                                    NoRujuk: $('#NoRujuk').val(),
                                                    RegRujuk: $('#RegRujuk').val(),
                                                    noPpk: $('#noPpk').val(),
                                                    Ppk: $('#Ppk').val(),
                                                    kodePeserta: $('#kodePeserta').val(),
                                                    Peserta: $('#Peserta').val(),
                                                    JatKelas: $('#jatah_kelas').val(),
                                                    NotifSep: $('#NotifSep').val(),
                                                    KasKe: $('input[name=KasKe]:checked').val(),
                                                    NoIden: $('#NoIden').val(),
                                                    statusPeserta: $('#statusPeserta').val(),
                                                    Faskes: $('input[name=Faskes]:checked').val(),
                                                    Notelp: $('#Notelp').val(),
                                                    Cob: $('input[name=Cob]:checked').val(),
                                                    Keyakinan: $('#change_keyakinan').val(),
                                                    Prolanis: $('#Prolanis').val(),
                                                    Perjanjian: janji,
                                                    Fam_trace: fam_tracing,
                                                    asalRujukan: $('[name=Faskes]').val(),
                                                    KdDPJP: $('#DokterPengirim').val(),
                                                    kdrujuk: $('#NoRujuk').val(),
                                                    nokontrol: $('#NoSuratKontrol').val(),
                                                    idregold: $('[name=regold]').val(),
                                                    catatan: $('#catatan').val(),
                                                },
                                                // error: function(response){
                                                //     alert('Gagal menambahkan/server down, Silahkan coba lagi');
                                                //     loading.modal('hide');
                                                //     btn.prop('disabled', false);
                                                //     btn.html(oldText);
                                                // },
                                                success:function(response)
                                                {
                                                    pesan = response.message + "\n" +
                                                            "Pasien " + response.data.Firstname + "\n" +
                                                            "Antrian aplikasi baru " + response.data.NomorUrut + "\n" ;
                                                    alert(pesan);
                                                    registerApiRujukan(response.data.Regno);
                                                    console.log(response);
                                                    loading.modal('hide');
                                                    $('#Regno').val(response.data.Regno);
                                                    $('#NomorUrut').val(response.data.NomorUrut);
                                                    // alert('sedang dalam perbaikan 30mnt/ selain fisio terapi pasien masuk');
                                                    btn.prop('disabled', false);
                                                    $("#submit").hide();
                                                    btn.html(oldText);
                                                    loading.modal('hide');
                                                    if (fam_tracing == null) {
                                                        push_print(response.data.Regno);
                                                    }
                                                }
                                            });
                                        }else{
                                            loading.modal('hide');
                                            pesan = "Pasien Telah Terdaftar pada \n" +
                                                    "Tanggal :" + resp.data.Regdate + "\n" +
                                                    "di Poli :" + resp.data.NMPoli + "\n" +
                                                    "Dengan no Reg :" + resp.data.Regno + "\n" +
                                                    "Dokter :" + resp.data.NmDoc + "\n" +
                                                    "*Untuk mengkonfirmasi pendaftaran Klik icon pensil pada list pasien atau" + "\n" +
                                                    "*Bila ingin mengganti poli silahkan klik icon pensil pada list pasien";
                                            alert(pesan);
                                            btn.prop('disabled', false);
                                            btn.html(oldText);
                                        }  
                                    }
                                });
                            } else {
                                alert('Pendaftaran lebih dari 7 hari');
                            }
                        @else
                            let nourut = '';
                            $.ajax({
                                type:"get",
                                url:"{{route('api.cek-nomor-urut')}}",
                                data:{
                                    regno:$('#Regno').val(),
                                    kdpoli:$('#poli').val(),
                                    regdate:$('#Regdate').val()
                                },
                                success(resp){
                                    if(resp.status){
                                        nourut = $('#NomorUrut').val();
                                    }
                                    $.ajax({
                                        url:"{{ route('reg-bpjs-daftar.form-post') }}",
                                        type:"post",
                                        dataType:"json",
                                        data:{
                                            rujukan_dari: $('#rujukan_dari').val(),
                                            Regno: $('#Regno').val(),
                                            // Medrec: rekammedis.substring(0,6),
                                            Medrec: rekammedis,
                                            Firstname: $('#Firstname').val(),
                                            Regdate: $('#Regdate').val(),
                                            Regtime: $('#Regtime').val(),
                                            KdCbayar: $('#cara_bayar').val(),
                                            Penjamin: $('[name=Penjamin]').val(),
                                            noKartu: $('#noKartu').val(),
                                            KdTuju: $('#pengobatan').val(),
                                            KdPoli: $('#poli').val(),
                                            DocRS: $('#Dokter').val(),
                                            NomorUrut: nourut,
                                            Kunjungan: $('#Kunjungan').val(),
                                            UmurThn: $('#UmurThn').val(),
                                            UmurBln: $('#UmurBln').val(),
                                            UmurHari: $('#UmurHari').val(),
                                            Bod: $('#Bod').val(),
                                            KategoriPasien: $('#Kategori').val(),
                                            NoSep: $('#NoSep').val(),
                                            DiagAw: $('#Diagnosa').val(),
                                            KdSex: $('input[name=KdSex]:checked').val(),
                                            pisat: $('#pisat').val(),
                                            GroupUnit: $('#GroupUnit').val(),
                                            Keterangan: $('#Keterangan').val(),
                                            NoRujuk: $('#NoRujuk').val(),
                                            RegRujuk: $('#RegRujuk').val(),
                                            noPpk: $('#noPpk').val(),
                                            Ppk: $('#Ppk').val(),
                                            kodePeserta: $('#kodePeserta').val(),
                                            Peserta: $('#Peserta').val(),
                                            JatKelas: $('#jatah_kelas').val(),
                                            NotifSep: $('#NotifSep').val(),
                                            KasKe: $('input[name=KasKe]:checked').val(),
                                            NoIden: $('#NoIden').val(),
                                            statusPeserta: $('#statusPeserta').val(),
                                            Faskes: $('input[name=Faskes]:checked').val(),
                                            Notelp: $('#Notelp').val(),
                                            Cob: $('input[name=Cob]:checked').val(),
                                            Keyakinan: $('#change_keyakinan').val(),
                                            Prolanis: $('#Prolanis').val(),
                                            Perjanjian: janji,
                                            asalRujukan: $('[name=Faskes]').val(),
                                            KdDPJP: $('#DokterPengirim').val(),
                                            nokontrol: $('#NoSuratKontrol').val(),
                                            idregold: $('[name=regold]').val(),
                                            catatan: $('#catatan').val(),
                                        },error: function(response){
                                            alert('Gagal menambahkan/server down, Silahkan coba lagi');
                                            loading.modal('hide');
                                            btn.prop('disabled', false);
                                            btn.html(oldText);
                                        },
                                        success:function(response)
                                        {
                                            pesan = response.message + "\n" +
                                                    "Pasien " + response.data.Firstname + "\n" +
                                                    "Antrian aplikasi baru " + response.data.NomorUrut + "\n" +
                                                    "Antrian aplikasi lama " + response.result;
                                            alert(pesan);
                                            registerApiRujukan(response.data.Regno);
                                            console.log(response);
                                            loading.modal('hide');
                                            $('#Regno').val(response.data.Regno);
                                            $('#NomorUrut').val(response.data.NomorUrut);
                                            
                                            $("#submit").hide();
                                            btn.prop('disabled', false);
                                            btn.html(oldText);
                                            if (fam_tracing == null) {
                                                push_print(response.data.Regno);
                                            }
                                            // pesan = response.message + "\n" +
                                            //         "Pasien " + response.data.Firstname + "\n"
                                            // alert(pesan);
                                        }
                                    });
                                }
                            });
                        @endif
                    }else{
                        pesan = "Maaf. NoSep telah digunakan oleh : "+ "\n" +
                                " - No RM - " + resp.data.Medrec + "\n" +
                                " - Nama Pasien - " + resp.data.Firstname + "\n" +
                                " - No Registrasi - " + resp.data.Regno + "\n" +
                                " - Tgl Registrasi - " + resp.data.Regdate + "\n" +
                                " - Poli - " + resp.data.NMPoli;
                        alert(pesan);
                        loading.modal('hide');
                        btn.prop('disabled', false);
                        btn.html(oldText);
                    }
                }
            });
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
                url:"{{ route('reg-bpjs-daftar.print-sepasien') }}",
                type:"get",
                dataType:"html",
                data:{
                    Regno: $('#Regno').val(),
                },
                beforeSend(){
                    loading.modal('show');
                },error: function(response){
                        alert('Gagal, Silahkan coba lagi');
                        loading.modal('hide');
                    },
                success:function(data)
                {

                    // let w = window.open('', 'myWindow', 'width=295,height=270,menubar=no,status=no,location=no,scrollbars=no');
                    // w.document.write(data);
                    // w.document.close();
                    // w.focus();
                    
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

    $('#createsep').on("click", function(){
        let btn = $('#createsep');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        btn.prop('disabled', true);
        let loading = $('.modal-loading');
        let nosurat = $('#NoSuratKontrol').val();
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
                    noSurat: nosurat.substring(0, 6),
                    kodeDPJP: $('#DokterPengirim').val(),
                    noTelp: $('#Notelp').val(),
                },
                success:function(response)
                {
                    loading.modal('hide');
                    if(response.metaData.code != '200'){
                        $('#NotifSep').val(response.metaData.message);
                        alert(response.metaData.message);
                    }else{
                        alert(response.metaData.message);
                        $('#NoSep').val(response.data.sep.noSep);
                        $('#NotifSep').val(response.metaData.message);
                        $("#submit").click();
                    }
                }
            });
        }
        loading.modal('hide');
        btn.prop('disabled', false);
        btn.html(oldText);
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
                    Kategori: $('#kat_Kategori').val(),
                    NoIden: $('#NoIden').val()
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

    $('#printkeyakinan').on("click", function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        if ($('#Medrec').val() != '') {
            $.ajax({
                url:"{{ route('keyakinan-print') }}",
                type:"get",
                dataType:"html",
                data:{
                    medrec: $('#Medrec').val(),
                },
                success: function(response)
                {
                    loading.modal('hide');
                    var w = window.open();
                    w.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(response)+"'></iframe>");
                    // $(w.document.body).html(response);
                }
            });
        } else {
            alert('No Rekam Medis kosong!');
            loading.modal('hide');
        }
        loading.modal('hide');
    });

    $('#printslip').on("click", function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        if ($('#Regno').val() != '') {
            $.ajax({
                url:"{{ route('file-status-keluar-slip') }}",
                type:"get",
                dataType:"html",
                data:{
                    noRegno: $('#Regno').val(),
                },
                success: function(response)
                {
                    loading.modal('hide');
                    var w = window.open();
                    // $(w.document.body).html(response);

                    // window.open(response);
                    w.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(response)+"'></iframe>");
                    // $(w.document.body).html("<iframe src='data:application/pdf;base64, " + encodeURI(response)+"'></iframeresponse");
                }
            });
        } else {
            alert('No Registrasi kosong!');
            loading.modal('hide');
        }
        loading.modal('hide');
    });

    $('#printlabel').on("click", function(ev) {
        ev.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');
        if ($('#Regno').val() != '') {
            $.ajax({
                url:"{{ route('file-status-keluar-label') }}",
                type:"get",
                dataType:"html",
                data:{
                    RegnoStatus: $('#Regno').val(),
                },
                success: function(response)
                {
                    $('#modalPrintSurat').modal('show');
                    $('#targetPrint').html(response);
                    setTimeout(function () {
                        $('#targetPrint').printElement();
                    }, 1000);
                }
            });
        } else {
            alert('No Registrasi kosong!');
            loading.modal('hide');
        }
        loading.modal('hide');
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

    function get_histori(no_kartu_pasien) {
        // get histori peserta
        $.get('{{ route('vclaim.histori_peserta') }}', {
            no_kartu: no_kartu_pasien,
            tanggal_mulai: '1990-01-01',
            tanggal_akhir: '2024-01-01',
        })
        .always(function() {
            
        })
        .fail(function() {
            alert('[ERR] Gagal mendapatkan data dari server');
        })
        .done(function(res) {
            if(!res || !res.metaData) {
                return alert('Tidak ada respon dari server');
            }
            else if(res.metaData.code != 200) {
                return alert('Histori: ' + res.metaData.message);
            }
            console.log(res);

            let data = res.response.histori;
            $('#table-histori tbody').html('');
            data.forEach(function(item) {
                $('#table-histori tbody').append(`
                    <tr>
                        <td>${item.noSep}</td>
                        <td>${item.jnsPelayanan == 1 ? 'Rawat Inap' : (item.jnsPelayanan == 2 ? 'Rawat Jalan' : '')}</td>
                        <td>${item.poli}</td>
                        <td>${item.tglSep}</td>
                        <td>${item.noRujukan}</td>
                        <td>${item.diagnosa}</td>
                        <td>${item.ppkPelayanan}</td>
                    </tr>
                    `);
            });
        });
    }

    function get_kategori_pasien_master(rekam_medis) {

        $.get('{{ route('api.cek-kategori') }}', {
            medrec: rekam_medis
        })
        .always(function() {
            
        })
        .fail(function() {
            alert('[ERR] Gagal mendapatkan data dari server');
        })
        .done(function(res) {
            console.log(res);
            var $kategori = $("<option selected></option>").val(res.data.Kategori).text(res.data.NmKategori);
            $('#kat_Kategori').append($kategori).trigger('change');

            var $groupunit = $("<option selected></option>").val(res.data.GroupUnit).text(res.data.GroupUnit);
            $('#GroupUnit').append($groupunit).trigger('change');

            var $unit = $("<option selected></option>").val(res.data.NmUnit).text(res.data.NmUnit);
            $('#Unit').append($unit).trigger('change');
        });
    }

    function registerApiRujukan(regno) {
        $.ajax({
            url: "{{ config('app.api_db_url') }}/api/master/rujukan",
            type: 'POST',
            dataType: 'JSON',
            data: {
                I_KelRujukan: 1,
                N_Rujukan: $('#noPpk').val(),
                C_PPKRujukan: $('#kodeoPpk').val(),
            },
            success: function (data_rujukan) {
                if (data_rujukan.status == 'success') {
                    $('#I_Rujukan').val(data_rujukan.I_Rujukan)
                    registerApiKunjungan(data_rujukan.rujukan, regno)
                    console.log('Post data API Rujukan berhasil.');
                }
            }
        });
    }

    function registerApiKunjungan(rujukan, regno) {
        $.ajax({
            url: "{{ config('app.api_db_url') }}/api/master/kunjungan",
            type: 'POST',
            dataType: 'JSON',
            data: {
                rujukan_dari: $('#rujukan_dari').val(),
                poli: $('#poli').val(),
                // I_Kunjungan: 'RJ-' + regno,
                // I_RekamMedis: rekammedis.substring(0,6),
                I_RekamMedis: $('#Medrec').val(),
                // I_Bagian: 2,
                I_Unit: $('#poli').val(),
                I_UrutMasuk: $('#NomorUrut').val(),
                D_Masuk: $('#Regdate').val() + ' ' + $('#Regtime').val(),
                // D_Keluar: $('#Regdate').val(),
                C_Pegawai: $('#Dokter').val(),
                I_Penerimaan: 0,
                I_Rujukan: rujukan.I_Rujukan,
                N_DokterPengirim: $('#DokterPengirim').val(),
                N_Diagnosa: $('#Diagnosa').val(),
                // N_Tindakan: N_Tindakan,
                // N_Terapi: N_Terapi,
                I_Kontraktor: $('#Kategori').val(),
                // N_PenanggungJwb: N_PenanggungJwb,
                // Telp_PenanggungJwb: Telp_PenanggungJwb,
                // A_PenanggungJwb: A_PenanggungJwb,
                // I_StatusBaru: I_StatusBaru,
                // I_Kontrol: I_Kontrol,
                I_StatusKunjungan: 1,
                C_Shift: 1,
                I_Entry: 'system',
                D_Entry: $('#Regdate').val(),
                // I_StatusPasien: I_StatusPasien,
                N_PasienLuar: $('#Firstname').val(),
                // A_PasienLuar: A_PasienLuar,
                // JK_PasienLuar: JK_PasienLuar,
                Umur_tahun: $('#UmurThn').val(),
                Umur_bulan: $('#UmurBln').val(),
                Umur_hari: $('#UmurHari').val(),
                // I_KunjunganAsal: I_KunjunganAsal,
                // I_IjinPulang: I_IjinPulang,
                // IsBayi: IsBayi,
                // IsOpenMedrek: IsOpenMedrek,
                // I_StatusObservasi: I_StatusObservasi,
                // I_MasukUlang: I_MasukUlang,
                // D_Masuk2: D_Masuk2,
                // D_Keluar2: D_Keluar2,
                // I_Urut: I_Urut,
                // I_StatusPenanganan: I_StatusPenanganan,
                // I_SKP: I_SKP,
                // catatan: catatan,
                // KD_RujukanSEP: KD_RujukanSEP,
                // tgl_lahirPLuar: tgl_lahirPLuar,
                // tempatLahirPLuar: tempatLahirPLuar,
                // Pulang: Pulang,
                // I_EntryUpdate: I_EntryUpdate,
                // n_AsalRujukan: n_AsalRujukan,
            },
            success: function(data) {
                if (data.status == 'success') {
                    console.log('Post data API Kunjungan berhasil.');
                }
            }
        });
    }
</script>
@endsection