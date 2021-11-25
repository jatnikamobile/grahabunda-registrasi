@extends('layouts.main')
@section('title','Registrasi Pasien Umum | Modul Registrasi')
@section('register_umum','active')
@section('daftar_ps_umum','active')
@section('header','Registrasi Pasien Umum')
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
    <div>
        <div class="float-sm-left">
            <a href="{{route('reg-umum-daftar')}}" class="btn btn-warning btn-sm"><i class="fa fa-angle-left"></i> List Pasien</a>
            <button type="button" id="btn-keyakinan" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Cari Data Pasien</button>
            <a href="{{ route('mst-psn.form') }}" class="btn btn-primary btn-sm"><small>Pasien Baru</small></a>
            {{-- <button class="btn btn-sm btn-round btn-info" id="send_data"><i class="fa fa-upload"></i></button> --}}
        </div>
    </div>
    <hr>
    <form action="{{route('reg-umum-daftar.form-post')}}" method="post" class="row" id="form-psn-umum">
        {{ csrf_field() }}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <p><u>Group Control</u></p>
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> No Registrasi</label>
                <div class="input-group col-sm-3">
                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                    <input type="text" name="Regno" class="form-control input-sm" id="Regno" readonly value="{{ @$edit->Regno }}"/>
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
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Data Pasien</u></p>
                <!-- Nomor RM -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*No Rekam Medis</label>
                    <form id="formCari" class="form-inline">
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Medrec" id="Medrec" value="{{ @$edit->Medrec }}"/>
                        <button type="submit" class="btn btn-info btn-sm" id="btnCari" style="margin-left: 10px;">
                            <i class="ace-icon fa fa-search"></i>Cari
                        </button>
                    </div>
                    </form>
                </div>
                <!-- Nama Pasien -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Nama Pasien</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" readonly value="{{ @$edit->Firstname }}"/>
                    </div>
                </div>
                <!-- NIK KTP / PASSPORT -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">NIK KTP / PASSPORT</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoIden" class="form-control input-sm" id="NoIden" value="{{ @$edit->nikktp }}"/>
                    </div>
                </div>
                <!-- Tanggal Daftar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tanggal Registrasi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="Regdate" id="Regdate" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->Regdate) ? date('Y-m-d',strtotime($edit->Regdate)) : date('Y-m-d') }}"/>
                    </div>
                </div>
                <!-- Jam Daftar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jam Registrasi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="time" name="Regtime" id="Regtime" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->Regtime) ? date('H:i',strtotime($edit->Regtime)) : date('H:i') }}" />
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Status Kunjungan</u></p>
                <!-- Status Kunjungan -->
                <div class="form-group">
                    <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kunjungan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="Kunjungan" id="Kunjungan" style="width:100%;" class="form-control">
                            <option value="">-= Kunjungan =-</option>
                            @foreach (['Lama','Baru'] as $wn)
                            <option value="{{ $wn }}" {{ isset($edit->Kunjungan) && @$edit->Kunjungan == $wn ? 'selected' : '-= Kunjungan =-'}}>{{ $wn }}</option>
                            @endforeach
                        </select>
                        <!-- Input NRP / NIP -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">No Urut</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoUrut" id="NoUrut" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->NomorUrut }}"/>
                    </div>
                </div>
                <!-- Jenis Kelmin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Jenis Kelamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <div class="radio">
                            <label>
                                <input name="KdSex" type="radio" class="ace" value="L" {{ isset($edit->KdSex) && strtolower(strtoupper($edit->KdSex)) == 'l' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Laki-Laki</span>
                            </label>
                            <label>
                                <input name="KdSex" type="radio" class="ace" value="P" {{ isset($edit->KdSex) && strtolower(strtoupper($edit->KdSex)) == 'p' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Perempuan</span>
                            </label>
                        </div>
                        <input type="hidden" name="Sex" id="Sex" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->Sex }}"/>
                    </div>
                </div>
                <!-- Tanggal Lahir -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Tgl Lahir</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="Bod" id="Bod" class="form-control input-sm col-xs-6 col-sm-6 datetimepicker" value="{{ isset($edit->Bod) ? date('Y-m-d',strtotime($edit->Bod)) : date('Y-m-d') }}"/>
                    </div>
                </div>
                <!-- Input Tanggal Lahir -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Umur (t/b/h)</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
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
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Status Pengobatan</u></p>
                <!-- Tujuan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Tujuan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="KdTuju" id="pengobatan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            @if(@$edit->KdTuju != '')
                            <option value="{{ isset($edit->KdTuju) ? $edit->KdTuju : ''}}">{{ isset($edit->NMTuju) ? @$edit->NMTuju : '-= Tujuan =-'}}</option>
                            @else
                            <option value="RJ">RAWAT JALAN</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!-- Nama Poli / SMF -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Nama Poli / SMF</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="KdPoli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdPoli) ? $edit->KdPoli : ''}}">{{ isset($edit->NMPoli) ? @$edit->NMPoli : '-= Poli =-'}}</option>
                        </select>
                        <input type="hidden" name="KdPoliBpjs">
                    </div>
                </div>
                <!-- Nama Dokter -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Nama Dokter</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="kdDoc" id="Dokter" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdDoc) ? $edit->KdDoc : ''}}">{{ isset($edit->NmDoc) ? @$edit->NmDoc : '-= Dokter =-'}}</option>
                        </select>
                        <div class="checkbox" style="display: table-cell;padding-left: 10px;">
                            <label>
                                <input type="checkbox" name="dpjp-only">
                                <span class="lbl">Dokter SIP</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Asal Rujukan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Asal Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="kdRujuk" id="KdRujuk" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdRujuk) ? $edit->KdRujuk : ''}}">{{ isset($edit->NMApasien) ? @$edit->NMApasien : '-= Asal Rujukan =-'}}</option>
                        </select>
                    </div>
                </div>
                <!-- Dokter Rujukan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Dokter Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="KdDocRujuk" id="Dokter" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="">-= Dokter Rujukan =-</option>
                            <option value="BAD">BELUM ADA DOKTER</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                <p><u>Status Pembayaran</u></p>
                <!-- Cara Bayar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Cara Bayar</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="KdCbayar" id="cara_bayar" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdCbayar) ? $edit->KdCbayar : ''}}">{{ isset($edit->NMCbayar) ? @$edit->NMCbayar : '-= Cara Bayar =-'}}</option>
                        </select>
                    </div>
                </div>
                <!-- Nama Penjamin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Penjamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="NMPenjamin" id="NMPenjamin" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdJaminan) ? $edit->KdJaminan : ''}}">{{ isset($edit->NMJaminan) ? @$edit->NMJaminan : '-= Nama Jaminan =-'}}</option>
                            
                        </select>
                    </div>
                </div>
                <!-- Nama Perusahaan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Perusahaan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="NMPerusahaan" id="NMPerusahaan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->KdPerusahaan) ? $edit->KdPerusahaan : ''}}">{{ isset($edit->NMPerusahaan) ? @$edit->NMPerusahaan : '-= Nama Perusahaan =-'}}</option>
                        </select>
                    </div>
                </div>
                <!-- Nama No Peserta -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No Peserta</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoPeserta" id="NoPeserta" class="form-control input-sm col-xs-10 col-sm-5" value="{{ @$edit->NoPeserta }}"/>
                    </div>
                </div>
                <!-- Atas Nama -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Atas Nama</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="AtasNama" id="AtasNama" class="form-control input-sm col-xs-10 col-sm-5" value="{{ @$edit->AtasNama }}"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <p><u>Kategori Pasien</u></p>
                <!-- Kategori Pasien -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Kategori Pasien</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Kategori" id="Kategori" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->Kategori) ? $edit->Kategori : ''}}">{{ isset($edit->NmKategori) ? @$edit->NmKategori : '-= Kategori =-'}}</option>
                        </select>
                    </div>
                </div>
                <!-- Status Pembayaran -->
                <div class="form-group">
                    <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">*Group Unit</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="GroupUnit" id="GroupUnit" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" required>
                        <option value="{{ isset($edit->GroupUnit) ? $edit->GroupUnit : ''}}">{{ isset($edit->GroupUnit) ? @$edit->GroupUnit : '-= GroupUnit =-'}}</option>
                        </select>
                        <!-- Input NRP / NIP -->
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">*Nama Unit</span>
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="NamaUnit" id="Unit" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->NmUnit) ? $edit->NmUnit : ''}}">{{ isset($edit->NmUnit) ? @$edit->NmUnit : '-= Unit =-'}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="regold" id="regold" value="{{ @$edit->IdRegOld }}">
        <button type="submit" name="submit" id="submit" class="btn btn-success">Simpan</button>
        <button type="button" name="printlabel" id="printlabel" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Print Label</button>
        <button type="button" name="printSlip" id="printSlip" class="btn btn-primary" target="_blank" style="display:none;"><i class="fa fa-print"></i> Print Slip</button>
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
    </div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
        if($('#Regno').val() != ''){
            $("#printSlip").css("display","");
        }else{
            $("#printSlip").css("display","none");
        }
    });
    $(".select2").select2();
    // =====================================
    
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

            return `
                <p>
                    ${item.NMTuju}
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
    $('#Dokter').on('select2:select', function(ev){
        KdDPJP = ev.params.data.KdDPJP;
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
    $('#NMPerusahaan').select2({
        ajax: {
            // api/get_ppk
            url:"{{route('api.select2.perusahaan')}}",
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
                        item.id = item.KDPerusahaan;
                        item.text = item.NMPerusahaan;
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
                    ${item.NMPerusahaan}
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
    $('#KdRujuk').select2({
        ajax: {
            // api/get_ppk
            url:"{{ route('api.select2.asal-pasien') }}",
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
                        item.id = item.KDApasien;
                        item.text = item.NMApasien;
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
                    ${item.NMApasien}
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
    //////////////////////////////////////////
    var $cbayar = $("<option selected></option>").val('01').text('CASH');
    $('#cara_bayar').append($cbayar).trigger('change');

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
                    loading.modal('hide');
                    var w = window.open();
                    // window.open(response);
                    // w.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(response)+"'></iframe>");
                    $(w.document.body).html(response);
                }
            });
        } else {
            alert('No Registrasi kosong!');
            loading.modal('hide');
        }
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
            success:function(response)
            {
                if(response.status){
                    btn.prop('disabled', false);
                    btn.html(oldText);

                    $('#Firstname').val(response.data.Firstname.toUpperCase());
                    $('#NoIden').val(response.data.NoIden);
                    $('#Bod').val(response.data.Bod.substring(0,10));
                    $('#Sex').val(response.data.Sex);
                    
                    $('#UmurThn').val(response.data.UmurThn);
                    $('#UmurBln').val(response.data.UmurBln);
                    $('#UmurHari').val(response.data.UmurHr);

                    var $kategori = $("<option selected></option>").val(response.data.Kategori).text(response.data.NmKategori);
                    $('#Kategori').append($kategori).trigger('change');
                    
                    var $groupUnit = $("<option selected></option>").val(response.data.GroupUnit).text(response.data.GroupUnit);
                    $('#GroupUnit').append($groupUnit).trigger('change');

                    var $unit = $("<option selected></option>").val(response.data.NmUnit).text(response.data.NmUnit);
                    $('#Unit').append($unit).trigger('change');

                    $('#AtasNama').val(response.data.Firstname.toUpperCase());
                    $('#NoPeserta').val(response.data.AskesNo);

                    if (response.data.KdSex != null) {
                        $("input[name=KdSex][value=" + response.data.KdSex.toUpperCase() + "]").attr('checked', 'checked');
                    }else {
                        if (response.register.KdSex != null) {
                            $("input[name=KdSex][value=" + response.register.KdSex.toUpperCase() + "]").attr('checked', 'checked');
                        }
                    }

                    if(response.register == null){
                        $('#Kunjungan').val('Baru');
                    }else{;
                        $('#Kunjungan').val('Lama');
                        // $('#NoUrut').val(response.register.NomorUrut);
                        // $('#Regno').val(response.register.Regno);

                        // var $KdDoc = $("<option selected></option>").val(response.register.KdDoc).text(response.register.NmDoc);
                        // $('#Dokter').append($KdDoc).trigger('change');

                        // var $Tuju = $("<option selected></option>").val(response.register.KdTuju).text(response.register.NMTuju);
                        // $('#pengobatan').append($Tuju).trigger('change');

                        // var $pol = $("<option selected></option>").val(response.register.KdPoli).text(response.register.NMPoli);
                        // $('#poli').append($pol).trigger('change');

                        // var $cbayar = $("<option selected></option>").val(response.register.KdCbayar).text(response.register.NMCbayar);
                        // $('#cara_bayar').append($cbayar).trigger('change');

                        // if (response.register.Kategori == '2') {
                        //     alert("Ini Pasien BPJS");
                        //     var $cbayar = $("<option selected></option>").val('20').text('BPJS');
                        //     $('#cara_bayar').append($cbayar).trigger('change');
                        // }
                    }
                }else{
                    btn.prop('disabled', false);
                    btn.html(oldText);
                    alert('Pasien tidak ditemukan!');
                }
            }
        })
        btn.prop('disabled', false);
        btn.html(oldText);
    });
    $('#bd-example-modal-lg-caripasien').submit(function(ev)  {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('reg-umum-daftar.find-pasien') }}",
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

    let janji = null;
    $('#Perjanjian').click(function() {
        janji = $('#Perjanjian').prop('checked');
    });

    let fam_tracing = null;
    $('#fam_tracing').click(function() {
        fam_tracing = $('#fam_tracing').prop('checked');
    });

    $("#submit").on("click",function(ev){
        ev.preventDefault();
        let loading = $('.modal-loading');
        let btn = $('#submit');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        btn.prop('disabled', true);
        // if ($('#Medrec').val() == '') {
        //     $('#Medrec').focus();
        //     alert('No Rekam Medis kosong!');
        // }

        var h2 = $('#Regdate').val();
        var selisih =  Math.abs(Number(new Date(h2)) - Number(new Date())) / (60 * 24 * 24 * 1000);

        if ($('#pengobatan').val() == '') {
            btn.prop('disabled', false);
            alert('Pilih Tujuan!');
        } else if($('#poli').val() == '') {
            btn.prop('disabled', false);
            alert('Pilih Poli!');
        } else if($('#Dokter').val() == '') {
            btn.prop('disabled', false);
            alert('Pilih Dokter!');
        } else if($('#Medrec').val() == '') {
            btn.prop('disabled', false);
            alert('No Rekam Medis Tidak boleh kosong!');
        } else if($('#Kategori').val() == '') {
            btn.prop('disabled', false);
            alert('Pilih Kategori!');
        } else if($('#GroupUnit').val() == '') {
            btn.prop('disabled', false);
            alert('Pilih GroupUnit!');
        } else if($('#Unit').val() == '') {
            btn.prop('disabled', false);
            alert('Pilih Nama Unit!');
        } else if(selisih >= 18) {
            btn.prop('disabled', false);
            alert('Hari pendaftaran lebih dari 7 hari');
        }else {
            var send = {
                medrec : $("#Medrec").val(),
                regdate : $("#Regdate").val(),
                kategori : $("#cara_bayar").val(),
                poli : $('#poli').val(),
            }
            @if(!isset($edit))
            $.ajax({
                type:"get",
                url:"{{route('api.cek-regis-pasien')}}",
                data:send,
                success(resp){
                    if(resp.status){
                        $.ajax({
                            url:"{{ route('reg-umum-daftar.form-post') }}",
                            type:"post",
                            dataType:"json",
                            data:{
                                Regno: $('[name=Regno]').val(),
                                Medrec: $('[name=Medrec]').val(),
                                Firstname: $('[name=Firstname]').val(),
                                NoIden: $('#NoIden').val(),
                                Regdate: $('[name=Regdate]').val(),
                                Regtime: $('[name=Regtime]').val(),
                                Kunjungan: $('[name=Kunjungan]').val(),
                                NoUrut: $('[name=NoUrut]').val(),
                                KdSex: $('input[name=KdSex]:checked').val(),
                                Sex: $('[name=Sex]').val(),
                                Bod: $('[name=Bod]').val(),
                                UmurThn: $('[name=UmurThn]').val(),
                                UmurBln: $('[name=UmurBln]').val(),
                                UmurHari: $('[name=UmurHari]').val(),
                                KdTuju: $('[name=KdTuju]').val(),
                                KdPoli: $('[name=KdPoli]').val(),
                                kdDoc: $('[name=kdDoc]').val(),
                                kdRujuk: $('[name=kdRujuk]').val(),
                                KdDocRujuk: $('[name=KdCbayar]').val(),
                                KdCbayar: $('[name=KdCbayar]').val(),
                                NMPenjamin: $('[name=NMPenjamin]').val(),
                                NMPerusahaan: $('[name=NMPerusahaan]').val(),
                                NoPeserta: $('[name=NoPeserta]').val(),
                                AtasNama: $('[name=AtasNama]').val(),
                                Kategori: $('[name=Kategori]').val(),
                                GroupUnit: $('[name=GroupUnit]').val(),
                                NamaUnit: $('[name=NamaUnit]').val(),
                                Perjanjian: janji,
                                regold: $('[name=regold]').val()
                            },error: function(response){
                                alert('Gagal menambahkan/server down, Silahkan coba lagi');
                                loading.modal('hide');
                                btn.prop('disabled', false);
                                btn.html(oldText);
                            },
                            success:function(response)
                            {
                                registerApiKunjungan(response.data.Regno);
                                console.log(response);
                                $('#Regno').val(response.data.Regno);
                                $('#NoUrut').val(response.data.NomorUrut);
                                if (fam_tracing == null) {
                                    push_print(response.data.Regno);
                                }

                                if(response.data.Regno !== null){
                                    $("#printSlip").css("display","");
                                }else{
                                    $("#printSlip").css("display","none");
                                }
                                pesan = response.message + "\n" +
                                        "Pasien " + response.data.Firstname + "\n" +
                                        "Antrian aplikasi baru " + response.data.NomorUrut + "\n" +
                                        "Antrian aplikasi lama " + response.result;
                                alert(pesan);
                                loading.modal('hide');
                                btn.prop('disabled', false);
                                btn.html(oldText);
                            }
                        });
                    }else{
                        pesan = "Pasien Telah Terdaftar pada \n" +
                                "Tanggal :" + resp.data.Regdate + "\n" +
                                "di Poli :" + resp.data.NMPoli + "\n" +
                                "Dengan no Reg :" + resp.data.Regno + "\n" +
                                "Dokter :" + resp.data.NmDoc + "\n" +
                                "*Untuk mengkonfirmasi pendaftaran Klik icon pensil pada list pasien atau" + "\n" +
                                "*Bila ingin mengganti poli silahkan klik icon pensil pada list pasien";
                        alert(pesan);
                        loading.modal('hide');
                        btn.prop('disabled', false);
                        btn.html(oldText);
                    }  
                }
            });
            @else
            $.ajax({
                url:"{{ route('reg-umum-daftar.form-post') }}",
                type:"post",
                dataType:"json",
                data:{
                    Regno: $('[name=Regno]').val(),
                    Medrec: $('[name=Medrec]').val(),
                    Firstname: $('[name=Firstname]').val(),
                    Regdate: $('[name=Regdate]').val(),
                    Regtime: $('[name=Regtime]').val(),
                    Kunjungan: $('[name=Kunjungan]').val(),
                    NoUrut: $('[name=NoUrut]').val(),
                    KdSex: $('input[name=KdSex]:checked').val(),
                    Sex: $('[name=Sex]').val(),
                    Bod: $('[name=Bod]').val(),
                    UmurThn: $('[name=UmurThn]').val(),
                    UmurBln: $('[name=UmurBln]').val(),
                    UmurHari: $('[name=UmurHari]').val(),
                    KdTuju: $('[name=KdTuju]').val(),
                    KdPoli: $('[name=KdPoli]').val(),
                    kdDoc: $('[name=kdDoc]').val(),
                    kdRujuk: $('[name=kdRujuk]').val(),
                    KdDocRujuk: $('[name=KdCbayar]').val(),
                    KdCbayar: $('[name=KdCbayar]').val(),
                    NMPenjamin: $('[name=NMPenjamin]').val(),
                    NMPerusahaan: $('[name=NMPerusahaan]').val(),
                    NoPeserta: $('[name=NoPeserta]').val(),
                    AtasNama: $('[name=AtasNama]').val(),
                    Kategori: $('[name=Kategori]').val(),
                    GroupUnit: $('[name=GroupUnit]').val(),
                    NamaUnit: $('[name=NamaUnit]').val(),
                    Perjanjian: janji,
                    regold: $('[name=regold]').val()
                },error: function(response){
                    alert('Gagal menambahkan/server down, Silahkan coba lagi');;
                    loading.modal('hide');
                    btn.prop('disabled', false);
                    btn.html(oldText);
                },
                success:function(response)
                {
                    registerApiKunjungan(response.data.Regno);
                    console.log(response);
                    $('#Regno').val(response.data.Regno);
                    if(response.data.Regno !== null){
                        $("#printSlip").css("display","");
                    }else{
                        $("#printSlip").css("display","none");
                    }
                    if (fam_tracing == null) {
                        push_print(response.data.Regno);
                    }
                    $('#NoUrut').val(response.data.NomorUrut);
                    pesan = response.message + "\n" +
                        "Pasien " + response.data.Firstname + "\n" +
                        "Antrian aplikasi baru " + response.data.NomorUrut + "\n" +
                        "Antrian aplikasi lama " + response.result;
                    loading.modal('hide');
                    alert(pesan);
                    btn.prop('disabled', false);
                    btn.html(oldText);

                }
            });
            @endif
        }
    });

    $("#printSlip").on("click",function(){
        url = "{{ url('RegistrasiUmum/Pendaftaran/PrintSlip?noRegno=') }}"+$("#Regno").val();
        window.open(url,"_blank");
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

    function registerApiKunjungan(regno) {
        $.ajax({
            url: "{{ config('app.api_db_url') }}/api/master/kunjungan",
            type: 'POST',
            dataType: 'JSON',
            data: {
                poli: $('#poli').val(),
                // I_Kunjungan: 'RJ-' + regno,
                // I_RekamMedis: rekammedis.substring(0,6),
                I_RekamMedis: $('#Medrec').val(),
                I_Bagian: 2,
                I_Unit: $('#poli').val(),
                I_UrutMasuk: $('#NomorUrut').val(),
                D_Masuk: $('#Regdate').val() + ' ' + $('#Regtime').val(),
                // D_Keluar: $('#Regdate').val(),
                C_Pegawai: $('#Dokter').val(),
                I_Penerimaan: 0,
                // I_Rujukan: rujukan.I_Rujukan,
                N_DokterPengirim: $('#DokterPengirim').val(),
                N_Diagnosa: $('#Diagnosa').val(),
                // N_Tindakan: N_Tindakan,
                // N_Terapi: N_Terapi,
                I_Kontraktor: 1,
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