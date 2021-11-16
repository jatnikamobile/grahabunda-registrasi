@extends('layouts.main')
@section('title','Mutasi Pasien Umum | Modul Registrasi')
@section('register_umum','active')
@section('mutasi_ps_umum','active')
@section('header','Mutasi Pasien Umum')
@section('subheader','Form Data')
@section('content')
<section>
    <div>
        <a href="{{route('reg-umum-mutasi')}}" class="btn btn-warning btn-sm"><i class="fa fa-angle-left"></i> List Pasien Mutasi</a>
        {{-- <a href="{{route('reg-bpjs-daftar')}}" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Cari Registrasi</a> --}}
        <button type="button" id="btn-cari-reg" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Cari Registrasi</button>
    </div>
    <hr>
    <form action="{{route('reg-umum-mutasi.form-post')}}" method="post" id="form-mutasi" class="row">
        {{ csrf_field() }}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <form method="get">
                <p><u>Group Control</u></p>
                <div class="form-group">
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">No Registrasi: </span>
                        <input type="text" name="Regno" id="Regno" value="{{ @$edit->regno }}" />
                        <button type="submit" class="btn btn-info btn-sm" id="btnCari" style="margin-left: 10px;"><i class="ace-icon fa fa-search"></i>Cari</button>
                    </div>
                </div>
            </form>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Status Pasien</u></p>
                <!-- Tanggal Mutasi -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tanggal Mutasi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="Regdate" id="Regdate" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->regdate) ? date('Y-m-d',strtotime($edit->regdate)) : date('Y-m-d') }}"/>
                    </div>
                </div>
                <!-- Jam Mutasi -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jam Registrasi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="time" name="Regtime" id="Regtime" class="form-control input-sm col-xs-6 col-sm-6" value="<?= date('H:i') ?>"/>
                    </div>
                </div>
                <!-- Nomor RM -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> No Rekam Medis</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Medrec" id="Medrec" class="form-control input-sm" style="width: 150px;" readonly value="{{ @$edit->medrec }}"/>
                        <button type="button" class="btn btn-info btn-sm" id="Keyakinan" style="margin-left: 10px;" data-toggle="modal" data-target=".bd-example-modal-lg-keyakinan"><i class="ace-icon fa fa-plus"></i>Keyakinan</button>
                    </div>
                </div>
                <!-- Nama Pasien -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5" readonly required value="{{ @$edit->firstname }}"/>
                    </div>
                </div>
                <!-- Kategori Pasien -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kategori Pasien</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Kategori" id="Kategori" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->kategori) ? $edit->kategori : '1' }}">{{ isset($edit->nmkategori) ? @$edit->nmkategori : 'UMUM' }}</option>
                        </select>
                    </div>
                </div>
                <!-- Jenis Kelamin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Jenis Kelamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <!-- <input type="text" name="Pod" class="form-control input-sm col-xs-10 col-sm-5" id="Pod"/> -->
                        <div class="radio">
                            <label>
                                <input name="KdSex" type="radio" class="ace" value="L"  {{ isset($edit->kdsex) && strtolower(strtoupper($edit->kdsex)) == 'l' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Laki - Laki</span>
                            </label>
                            <label>
                                <input name="KdSex" type="radio" class="ace" value="P"  {{ isset($edit->kdsex) && strtolower(strtoupper($edit->kdsex)) == 'p' ? 'checked' : '' }}/>
                                <span class="lbl">&nbsp; Perempuan</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Status Pengobatan</u></p>
                <!-- Cara Bayar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Cara Bayar</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select type="text" name="KdCbayar" id="cara_bayar" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                            <option value="01" selected="selected">Cash</option>
                        </select>
                    </div>
                </div>
                <!-- Nama Penjamin -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Penjamin</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="NMPenjamin" id="NMPenjamin" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="">-= Nama Penjamin =-</option>
                        </select>
                    </div>
                </div>
                <!-- Nama Perusahaan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Perusahaan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="NMPerusahaan" id="NMPerusahaan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="">-= Nama Perusahaan =-</option>
                        </select>
                    </div>
                </div>
                <!-- Nama No Peserta -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">No Peserta/Asuransi</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoPeserta" id="NoPeserta" class="form-control input-sm col-xs-10 col-sm-5" value="{{ @$edit->nopeserta }}"/>
                    </div>
                </div>
                <!-- Tanggal Rujukan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Tanggal Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="date" name="TglRujuk" id="TglRujuk" class="form-control input-sm col-xs-6 col-sm-6" value="{{ isset($edit->tglrujuk) ? date('Y-m-d',strtotime($edit->tglrujuk)) : date('Y-m-d') }}"/>
                    </div>
                </div>
                <!-- Nomor Rujukan -->
                <div class="form-group">
                    <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nomor Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <input type="text" name="NoRujuk" id="NoRujuk" class="form-control input-sm col-xs-6 col-sm-6" value="{{ @$edit->norujuk }}"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <p><u>Dokter Pengirim</u></p>
                <!-- Dokter Luar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Dokter Luar</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Dokluar" id="Dokluar" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="">-= Dokter Luar =-</option>
                        </select>
                    </div>
                </div>
                <!-- Nama Poli / SMF -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Poli / SMF</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="KdPoli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->kdpoli) ? $edit->kdpoli : '' }}">{{ isset($edit->nmpoli) ? @$edit->nmpoli : '-= Poli =-' }}</option>
                        </select>
                    </div>
                </div>
                <!-- Dokter Rumah Sakit -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Dokter Rumah Sakit</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="DocRS" id="Dokter" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->kddocrs) ? $edit->kddocrs : '' }}">{{ isset($edit->nmdocrs) ? @$edit->nmdocrs : '-= Dokter Rumah Sakit =-' }}</option>
                        </select>
                        <input type="hidden" name="nmDocRs" id="nmDocRs" value="{{ @$edit->nmdocrs }}">
                        <div class="checkbox" style="display: table-cell;padding-left: 10px;">
                            <label>
                                <input type="checkbox" name="dpjp-only">
                                <span class="lbl">Dokter DPJP</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Asal Rujukan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Asal Rujukan</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="AsalRujuk" id="AsalRujuk" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="">-= Asal Rujukan =-</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                <p><u>Ruang Perawatan</u></p>
                <!-- Ruang Rawat -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Ruang Rawat</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                     
                          <select name="oBangsal" id="oBangsal" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            @if(isset($edit))
                                    <option value="{{ @$edit->kdbangsal }}{{ @$edit->kdkelas }}" 
                                        {{ isset($edit->nmbangsal) && @$edit->nmbangsal == @$edit->nmbangsal ? 'selected' : '-= Ruang Rawat =-'}}>
                                        {{ @$edit->nmkelas }} - {{ @$edit->nmbangsal }}
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
                        <input type="text" name="Bangsal" id="bangsal" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->kdkelas }}" />
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Kode Kelas</span>
                        <input type="text" name="Kelas" id="kelas" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->kdbangsal }}" />
                    </div>
                </div>
                <!-- No Kamar -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Pilih Kamar</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Kamar" id="Kamar" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            @if(isset($edit))
                                <option value="{{ isset($edit->nokamar) ? $edit->nokamar : '' }}">{{ @$edit->nokamar }} - {{@$edit->nottidur}}</option>
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
                        <input type="text" name="TempatTidur" id="TempatTidur" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->nottidur }}" />
                    </div>
                </div>
                <!-- Dokter Yang Merawat -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Dokter Yang Merawat</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Docmerawat" id="DokterRawat" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->kddocrawat) ? $edit->kddocrawat : '' }}">{{ isset($edit->nmdoc) ? @$edit->nmdoc : '-= Dokter Yang Merawat =-' }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Diagnosa Awal -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Diagnosa Awal</label>
                    <div class="input-group col-sm-9">
                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                        <select name="Diagnosa" id="Diagnosa" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                            <option value="{{ isset($edit->kdicd) ? $edit->kdicd : '' }}">{{ isset($edit->diagnosa) ? @$edit->diagnosa : '-= Diagnosa Awal =-' }}</option>
                        </select>
                        <input type="hidden" name="NmDiagnosa" id="NmDiagnosa" value="{{ @$edit->diagnosa }}">
                    </div>
                </div>
            </div>
            <input type="hidden" name="change_keyakinan" id="change_keyakinan">
            <input type="submit" name="submit" id="submit" class="btn btn-success" value="Simpan" />
        </div>
    </form>
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
                                <label class="col-sm-3 control-label no-padding-right">Medrec</label>
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
    <div class="modal fade modal-loading" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-loading">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>
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
                                       <p><u>Data Pasien</u></p>
                        <div class="form-group">
                            <!-- No RM -->
                            <label class="col-sm-3 control-label no-padding-right">No Rekam Medis</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="ke_NoRM" id="ke_NoRM" class="form-control input-sm col-xs-6 col-sm-6" readonly value="{{ @$edit->medrec }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Nama Pasien -->
                            <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="ke_Firstname" id="ke_Firstname" class="form-control input-sm col-xs-6 col-sm-6" readonly placeholder="Nama Pasien" value="{{ @$edit->firstname }}" />
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
</section>
@endsection
@section('script')
<script>
    $('#tes').on('click', function() {
        alert($('#oBangsal').val());
        console.log($('#oBangsal').val());
    });
    $(document).ready(function(){
        $('#sidebar').addClass('menu-min');
    });
    $(".select2").select2();
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
    // =====================================
    $("#GroupUnit").on("change",function(){
        // console.log();
        load_unit(this.value);
    });
    function load_unit(id_group_unit=''){
        $.ajax({
            type:'POST',
            // Master_pasien/load_unit,
            url:"{{route('reg-umum-mutasi')}}",
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

    $("#form-mutasi").on("submit",function(e){
        e.preventDefault();
        let loading = $('.modal-loading');

        var send = {
            Regno : $("#Regno").val(),
            medrec : $("#Medrec").val(),
            kategori : $('#Kategori').val(),
            regdate : $("#Regdate").val(),
            poli : $("#poli").val(),
        }
        if ($('#pengobatan').val() == '') {
            alert('Pilih Tujuan!');
        } else if($('#poli').val() == '') {
            alert('Pilih Poli!');
        } else if($('#Dokter').val() == '') {
            alert('Pilih Dokter!');
        } else if(($('input[name=KdSex]:checked').length) <= 0 ) {
            alert('Pilih jenis kelamin Pasien');
        } else {
            @if(!isset($edit))
            var value = {
                Regno : $("#Regno").val(),
                Regdate : $("#Regdate").val(),
                Regtime : $("#Regtime").val(),
                Medrec : $("#Medrec").val(),
                Firstname : $("#Firstname").val(),
                Kategori : $("#Kategori").val(),
                KdSex : $('input[name=KdSex]:checked').val(),
                KdCbayar : $('#cara_bayar').val(),
                NMPerusahaan : $('#NMPerusahaan').val(),
                NMPenjamin : $('#NMPenjamin').val(),
                NoPeserta : $('#NoPeserta').val(),
                TglRujuk : $('#TglRujuk').val(),
                NoRujuk : $('#NoRujuk').val(),
                DocRS : $('#Dokter').val(),
                nmDocRs : $("#nmDocRs").val(),
                KdPoli : $('#poli').val(),
                Kelas : $('#kelas').val(), 
                Bangsal : $('#bangsal').val(),
                Bed : $('#Bed').val(),
                TempatTidur : $('#TempatTidur').val(),
                Docmerawat : $('#DokterRawat').val(),
                Diagnosa : $('#Diagnosa').val(),
                NmDiagnosa : $("#NmDiagnosa").val()
            }
            $.ajax({
                type:"GET",
                url:"{{route('api.cek-mutasi-pasien')}}",
                data:send,
                success(resp){
                    if(resp.status){
                        $.ajax({
                            url:"{{ route('reg-umum-mutasi.form-post') }}",
                            type:"post",
                            dataType:"json",
                            data: value,
                            beforeSend(){
                            },
                            success:function(response)
                            {
                                console.log(response);
                                loading.modal('hide');
                                push_mutasi(value);
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
            var value = {
                Regno : $("#Regno").val(),
                Regdate : $("#Regdate").val(),
                Regtime : $("#Regtime").val(),
                Medrec : $("#Medrec").val(),
                Firstname : $("#Firstname").val(),
                Kategori : $("#Kategori").val(),
                KdSex : $('input[name=KdSex]:checked').val(),
                KdCbayar : $('#cara_bayar').val(),
                NMPerusahaan : $('#NMPerusahaan').val(),
                NMPenjamin : $('#NMPenjamin').val(),
                NoPeserta : $('#NoPeserta').val(),
                TglRujuk : $('#TglRujuk').val(),
                NoRujuk : $('#NoRujuk').val(),
                DocRS : $('#Dokter').val(),
                nmDocRs : $("#nmDocRs").val(),
                KdPoli : $('#poli').val(),
                Kelas : $('#kelas').val(), 
                Bangsal : $('#bangsal').val(),
                Bed : $('#Bed').val(),
                TempatTidur : $('#TempatTidur').val(),
                Docmerawat : $('#DokterRawat').val(),
                Diagnosa : $('#Diagnosa').val(),
                NmDiagnosa : $("#NmDiagnosa").val()
            }
            $.ajax({
                url:"{{ route('reg-umum-mutasi.form-post') }}",
                type:"post",
                dataType:"json",
                data: value,
                beforeSend(){
                },
                success:function(response)
                {
                    console.log(response);
                    loading.modal('hide');
                    push_mutasi(value);
                    alert(response.message);
                }
            });
            @endif
        }
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
    $('#DokterRawat').select2({
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

    $('#Kamar').select2({

        templateResult: function(item) {

            if(item.loading) {
                return item.text;
            }
            // console.log(item.text.substring(item.text.length - 1, item.text.length));
            if(item.text.substr(item.text.length - 1,1) == '1') {
                return `<p style="color: red;">${item.text}</p>`;
            }
            else {
                return `<p>${item.text}</p>`;
            }
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        }
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

    $('#Diagnosa').on("change",function(){
        $.ajax({
            url:"{{ route('api.select2.search-icd') }}",
            type:"get",
            // dataType:"json",
            data:{
                kdicd: $('#Diagnosa').val(),
            },
            success:function(response)
            {
                $("#NmDiagnosa").val(response);
            }
        });
    });

    $('#Dokter').on("change",function(){
        text = $("#Dokter option:selected").text();
        $("#nmDocRs").val(text);
    });

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
    
    $('#oBangsal').on("select2:select", function(){
        $('#Kamar').empty();
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
                console.log(response);
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

                $('#Bed').val(''); 
                $('#TempatTidur').val('');
                // $('#Bed').val(item.text.substr(item.length -5, 1));
                // $('#Bed').val(response.data.ttnomor);
                loading.modal('hide');
            }
        });
    });

    $('#btnCari').on("click", function(ev){
        ev.preventDefault();
        let btn = $('#btnCari');
        let oldText = btn.html();
        btn.html('<i class="fa fa-spin fa-spinner"></i> ' + btn.text());
        $.ajax({
            url:"{{ route('mutasi-umum') }}",
            type:"get",
            dataType:"json",
            data:{
                Regno: $('#Regno').val(),
            },
            success:function(response)
            {
                if(response.status){
                    var today = new Date();
                    btn.prop('disabled', false);
                    btn.html(oldText);

                    $('#Firstname').val(response.data.Firstname.toUpperCase());
                    $('#NoPeserta').val(response.data.NoPeserta);
                    $('#Medrec').val(response.data.Medrec);
                    $('#NoRujuk').val(response.data.NoRujuk);
                    var $kategori = $("<option selected></option>").val(response.data.Kategori).text(response.data.NmKategori);
                    $('#Kategori').append($kategori).trigger('change');

                    var $cara_bayar = $("<option selected></option>").val(response.data.KdCbayar).text(response.data.NMCbayar);
                    $('#cara_bayar').append($cara_bayar).trigger('change');

                    var $dRumahSakit = $("<option selected></option>").val(response.data.KdDoc).text(response.data.NmDoc);
                    $('#Dokter').append($dRumahSakit).trigger('change');

                    var $poli = $("<option selected></option>").val(response.data.KdPoli).text(response.data.NMPoli);
                    $('#poli').append($poli).trigger('change');

                    var $rujukan = $("<option selected></option>").val(response.data.KdRujukan).text(response.data.NmRujukan);
                    $('#AsalRujuk').append($rujukan).trigger('change');

                    var $penjamin = $("<option selected></option>").val(response.data.KdJaminan).text(response.data.NMJaminan);
                    $('#NMPenjamin').append($penjamin).trigger('change');

                    var $perusahaan = $("<option selected></option>").val(response.data.KDPerusahaan).text(response.data.NMPerusahaan);
                    $('#NMPerusahaan').append($perusahaan).trigger('change');

                    $('#Notelp').val(response.data.Phone);
                    $("input[name=KdSex][value=" + response.data.KdSex.toUpperCase() + "]").attr('checked', 'checked');

                    // Modal Keyakinan dan Nilai-nilai
                    $('#ke_Firstname').val(response.data.Firstname.toUpperCase());
                    $('#ke_NoRM').val(response.data.Medrec);
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
    });


    $('#bd-example-modal-lg-caripasien').submit(function(ev)  {
        ev.preventDefault();
        $.ajax({
            url: "{{ route('reg-umum-mutasi.find-register') }}",
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
                    $('#change_keyakinan').val('Y');
                    $('.bd-example-modal-lg-keyakinan').modal('hide');
                }
            });
        } else {
            alert('No Rekam Medic kosong!');
        }
    });
</script>
@endsection