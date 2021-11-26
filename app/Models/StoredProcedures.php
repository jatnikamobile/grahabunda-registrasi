<?php

namespace App\Models;

use Auth;
use Illuminate\Support\Facades\DB;

class StoredProcedures
{
	public static function stpnet_AddNewRujukanBPJS_REGxhos($data)
	{
		$sp = 'stpnet_AddNewRujukanBPJS_REGxhos';
		$parameters = [
			'nosep'         => $data['nosep']         ?? '',
			'tglrujukan'    => $data['tglrujukan']    ?? '',
			'kdrujukan'     => $data['kdrujukan']     ?? '',
			'nmrujukan'     => $data['nmrujukan']     ?? '',
			'kdicd'         => $data['kdicd']         ?? '',
			'diagnosa'      => $data['diagnosa']      ?? '',
			'kdpoli'        => $data['kdpoli']        ?? '',
			'nmpoli'        => $data['nmpoli']        ?? '',
			'jnspelayanan'  => $data['jnspelayanan']  ?? '',
			'tiperujukan'   => $data['tiperujukan']   ?? '',
			'norujukan'     => $data['norujukan']     ?? '',
			'nopeserta'     => $data['nopeserta']     ?? '',
			'medrec'        => $data['medrec']        ?? '',
			'firstname'     => $data['firstname']     ?? '',
			'sex'           => $data['sex']           ?? '',
			'bod'           => $data['bod']           ?? '',
			'jenispeserta'  => $data['jenispeserta']  ?? '',
			'kelas'         => $data['kelas']         ?? '',
			'kdasalrujukan' => $data['kdasalrujukan'] ?? '',
			'nmasalrujukan' => $data['nmasalrujukan'] ?? '',
			'catatan'       => $data['catatan']       ?? '',
			'validuser'     => $data['validuser']     ?? '',
		];

		return self::executeStoredProcedure($sp, $parameters);
	}

	public static function executeStoredProcedure($storedProcedure, $parameters)
	{
		DB::connection('main')->statement("EXEC [$storedProcedure] ".join(', ', array_map(function($param) {
			return '@'.$param.'=?';
		}, array_keys($parameters))), array_values($parameters));
	}

	public static function executeStoredProcedure2($storedProcedure, $parameters)
	{
		return DB::connection('main')->statement("EXEC [$storedProcedure] ".join(', ', array_map(function($param) {
			return '@'.$param.'=?';
		}, array_keys($parameters))), array_map(function($i) { return $i ?: ''; }, array_values($parameters)));
	}

	public static function stpnet_AddNewRegistrasiBPJS_REGxhos($data)
	{
		$sex = $data['KdSex'] == 'L' ? 'Laki-laki' : 'Perempuan';
        if ($data['KdTuju'] == '1') {
            $data['KdTuju'] = 'RI';
        }
        if ($data['KdTuju'] == '2') {
            $data['KdTuju'] = 'RJ';
        }
        if ($data['KdTuju'] == '3') {
            $data['KdTuju'] = 'RM';
        }
        $validuser = Auth::user()['NamaUser'];
        $date = $data['Regdate'].' '.$data['Regtime'];

		$sp = 'spwe_AddNewRegistrasiBPJS_REGxhos';
		$parameters = [
			'regno' => $data['Regno'],
            'medrec' => $data['Medrec'],
            'firstname' => $data['Firstname'],
            'regdate' => $data['Regdate'],
            'regtime' => $date,
            'kdcbayar' => $data['KdCbayar'],
            'kdjaminan' => $data['Penjamin'],
            'kdperusahaan' => '',
            'nopeserta' => $data['noKartu'],
            'kdtuju' => $data['KdTuju'],
            'kdpoli' => $data['KdPoli'],
            'kdbangsal' => '',
            'kdkelas' => '',
            'nottidur' => '',
            'kddoc' => $data['DocRS'],
            'kunjungan' => $data['Kunjungan'],
            'validuser' => $validuser,
            'sex' => $sex,
            'umurthn' => $data['UmurThn'],
            'umurbln' => $data['UmurBln'],
            'umurhari' => $data['UmurHari'],
            'bod' => $data['Bod'],
            'nomorurut' => $data['NomorUrut'],
            'statusreg' => 1,
            'kategori' => $data['KategoriPasien'],
            'nosep' => $data['NoSep'],
            'kdicd' => $data['DiagAw'],
            'kdsex' => $data['KdSex'],
            'groupunit' => $data['GroupUnit'],
            'kdicdbpjs' => $data['DiagAw'],
            'bodbpjs' => $data['Bod'],
            'pisat' => $data['pisat'],
            'keterangan' => $data['Keterangan'],
            'catatan' => $data['catatan'],
            'tglrujuk' => $data['RegRujuk'],
            'nokontrol' => $data['nokontrol'],
            'norujuk' => $data['NoRujuk'],
            'kdrujukan' => $data['Ppk'],
            'nmrujukan' => $data['noPpk'],
            'kdrefpeserta' => $data['kodePeserta'],
            'nmrefpeserta' => $data['Peserta'],
            'nmkelas' => $data['JatKelas'],
            'notifsep' => $data['NotifSep'],
            'kdkasus' => $data['KasKe'],
            'lokasikasus' => '',
            'nikktp' => $data['NoIden'],
            'statpeserta' => $data['statusPeserta'],
            'kdstatpeserta' => $data['Faskes'],
            'asalrujuk' => $data['asalRujukan'],
            'phone' => $data['Notelp'],
            'kdcob' => $data['Cob'],
            'nmcob' => '',
            'kdjaminanbpjs' => $data['KategoriPasien'],
            'prolanis' => $data['Prolanis'],
            'idregold' => $data['id_old'],
            'perjanjian' => $data['Perjanjian'],
            'kddpjp' => $data['KdDPJP'],
            'regnumber' => 0,
            'sequalNum' => 0,
		];
		// dd($parameters);
		return self::executeStoredProcedure2($sp, $parameters);	
	}

    public static function stp_UpdateRadiologiAcc_REGxhos($data)
    {   
        $validuser = Auth::user()['NamaUser'];
        $sp = 'spwe_UpdateRadiologiAcc_REGxhos';
        // print_r();die();
        $parameters = [
            'NoTrans'=> $data['notrans'],
            'Tanggal'=> $data['rad']->Tanggal,
            'Jam'=> $data['rad']->Jam,
            'Regno'=> $data['regno'],
            'RegDate'=>$data['rad']->RegDate ,
            'MedRec'=> $data['rad']->MedRec,
            'Firstname'=> $data['rad']->Firstname,
            'Sex'=> $data['rad']->Sex,
            'KdBangsal'=> $data['rad']->KdBangsal,
            'KdKelas'=> $data['rad']->KdKelas,
            'KdDoc'=> $data['rad']->KdDoc,
            'KdPoli'=> $data['rad']->KdPoli,
            'KdCbayar'=> $data['rad']->KdCbayar,
            'TotalBiaya'=> $data['rad']->TotalBiaya,
            'Shift'=> $data['rad']->Shift,
            'ValidUser'=> $validuser,
            'Kategori'=> $data['rad']->Kategori,
            'UmurThn'=> $data['rad']->UmurThn,
            'UmurBln'=> $data['rad']->UmurBln,
            'UmurHari'=> $data['rad']->UmurHari,
            'nstatus'=> $data['rad']->nstatus,
            'Tanda'=> $data['rad']->Tanda,
            'Catt_rad' => $data['rad']->Catt_rad
        ];
        // dd($parameters);
        return self::executeStoredProcedure2($sp, $parameters); 
    }

    public static function stp_UpdateLaboratoriumAcc_REGxhos($data)
    {   
        $validuser = Auth::user()['NamaUser'];
        $sp = 'spwe_UpdateLaboratoriumAcc_REGxhos';
        // print_r();die();
        $parameters = [
            'NoTrans'=> $data['notrans'],
            'Tanggal'=> $data['rad']->Tanggal,
            'Jam'=> $data['rad']->Jam,
            'Regno'=> $data['regno'],
            'RegDate'=>$data['rad']->RegDate ,
            'MedRec'=> $data['rad']->MedRec,
            'Firstname'=> $data['rad']->Firstname,
            'Sex'=> $data['rad']->Sex,
            'KdBangsal'=> $data['rad']->KdBangsal,
            'KdKelas'=> $data['rad']->KdKelas,
            'KdDoc'=> $data['rad']->KdDoc,
            'KdPoli'=> $data['rad']->KdPoli,
            'KdCbayar'=> $data['rad']->KdCbayar,
            'TotalBiaya'=> $data['rad']->TotalBiaya,
            'Shift'=> $data['rad']->Shift,
            'ValidUser'=> $validuser,
            'Kategori'=> $data['rad']->Kategori,
            'UmurThn'=> $data['rad']->UmurThn,
            'UmurBln'=> $data['rad']->UmurBln,
            'UmurHari'=> $data['rad']->UmurHari,
            'nstatus'=> $data['rad']->nstatus,
            'Tanda'=> $data['rad']->Tanda,
            'Catt_rad' => $data['rad']->Catt_rad
        ];
        // dd($parameters);
        return self::executeStoredProcedure2($sp, $parameters); 
    }

	public static function stpnet_AddNewRegistrasiUmum_REGxhos(array $data)
    {
        $data = (object) $data;
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser;
        $date = $data->Regdate.' '.date('H:i:s');
        $sp = 'stpnet_AddNewRegistrasiUmum_REGxhos';
        $parameters = [
            'regno' => $data->Regno,
            'medrec' => $data->Medrec,
            'firstname' => $data->Firstname,
            'nikktp' => $data->NoIden,
            'regdate' => $data->Regdate,
            'regtime' =>  $date,
            'kunjungan' => $data->Kunjungan,
            'nomorurut' => $data->NoUrut,
            'kdsex' => $data->KdSex,
            'sex' =>  $sex,
            'bod' => $data->Bod,
            'umurthn' => $data->UmurThn,
            'umurbln' => $data->UmurBln,
            'umurhari' => $data->UmurHari,
            'kdtuju' => $data->KdTuju,
            'kdpoli' => $data->KdPoli,
            'kddoc' => $data->kdDoc,
            'kdapasien' => $data->kdRujuk,
            'kddocrujuk' => $data->KdDocRujuk,
            'kdcbayar' => $data->KdCbayar,
            'kdjaminan' => $data->NMPenjamin,
            'kdperusahaan' => $data->NMPerusahaan,
            'nopeserta' => $data->NoPeserta,
            'atasnama' => $data->AtasNama,
            'kategori' => $data->Kategori,
            'groupunit' => $data->GroupUnit,
            'nmunit' => $data->NamaUnit,
            'statusreg' =>  2,
            'validuser' => $validuser,
            'perjanjian' => $data->Perjanjian,
            'idregold' => '',
            'regnumber' => 0,
            'sequalNum' => 0];
        return self::executeStoredProcedure2($sp, $parameters);
    }

	public static function stpnet_AddMasterPasien_REGxhos(array $data)
    {   
        $data = (object) $data;
        $tanggaldaftar = date('Y-m-d H:m:s');
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $sp = 'stpnet_AddMasterPasien_REGxhos';
        $parameters = [
            'medrec' => $data->Medrec,
            'firstname' => $data->Firstname,
            'pod' => $data->Pod,
            'bod' => $data->Bod,
            'umurthn' => $data->UmurThn,
            'umurbln' => $data->UmurBln,
            'sex' => $sex,
            'goldarah' => $data->GolDarah,
            'rhdarah' => $data->RHDarah,
            'warganegara' => $data->WargaNegara,
            'noiden' => $data->NoIden,
            'perkawinan' => $data->Perkawinan,
            'agama' => $data->Agama,
            'pendidikan' => $data->Pendidikan,
            'namaayah' => $data->NamaAyah,
            'namaibu' => $data->NamaIbu,
            'askesno' => $data->NoPeserta,
            'tgldaftar' => $tanggaldaftar,
            'address' => $data->Alamat,
            'city' => $data->NmKabupaten,
            'propinsi' => $data->NmProvinsi,
            'kecamatan' => $data->NmKecamatan,
            'kelurahan' => $data->NmKelurahan,
            'kdpos' => $data->KdPos,
            'phone' => $data->Phone,
            'kategori' => $data->Kategori,
            'nmunit' => $data->Unit,
            'nrpnip' => $data->Nrp,
            'nmkesatuan' => $data->NmKesatuan,
            'nmgol' => $data->NmGol,
            'nmpangkat' => $data->NmPangkat,
            'pekerjaan' => $data->Pekerjaan,
            'nmkorp' => $data->NmKorp,
            'namapj' => $data->NamaPJ,
            'hubunganpj' => $data->HungunganPJ,
            'pekerjaanpj' => $data->PekerjaanPJ,
            'phonepj' => $data->PhonePJ,
            'alamatpj' => $data->AlamatPJ,
            'validuser' => $validuser,
            'GroupUnit' => $data->GroupUnit,
            'GroupPangkat' => $data->GroupPangkat,
            'StatusKelDinas' => '',
            'NamaKelDinas' => $data->NamaKelDinas,
            'kdkelurahan' => $data->Kelurahan,
            'nmsuku' => $data->Suku,
            'kdsex' => $data->KdSex,
            'umurhr' => $data->UmurHari,
            'keyakinan' => $data->KdNilai,
            // 'subunit' => $data->korpUnit,
            'subunit' => null,
            'cotomatis' => '',
            'regnumber' => ''];

        return self::executeStoredProcedure2($sp, $parameters);	
    }

    public static function stpnet_AddMutasiPasienBPJS_REGxhos(array $data)
    {
        $data = (object) $data;
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $sp = 'stpnet_AddMutasiPasienBPJS_REGxhos';
        $parameters = [
            'regno' => $data->Regno,
            'medrec' => $data->Medrec,
            'firstname' => $data->Firstname,
            'regdate' => $data->Regdate,
            'regtime' => $data->Regdate.' '.$data->Regtime,
            'kdcbayar' => $data->KdCbayar,
            'kdjaminan' => $data->Penjamin,
            'kdperusahaan' => '',
            'nopeserta' => $data->noKartu,
            'kdtuju' => $data->KdTuju,
            'kdpoli' => $data->KdPoli,
            'kdbangsal' => $data->kelas,
            'kdkelas' => $data->bangsal,
            'nokamar' => $data->Bed,
            'nottidur' => $data->TempatTidur,
            'kddocrawat' => $data->DocRawat,
            'kddocrs' => $data->DocRS,
            'nmdocrs' => $data->NmDoc,
            'jtkdkelas' => $data->JatKelas,
            'jtnmkelas' => 'Kelas '.$data->JatKelas,
            'validuser' => $validuser,
            'kdsex' => $data->KdSex,
            'sex' => $sex,
            'umurthn' => $data->UmurThn,
            'umurbln' => $data->UmurBln,
            'umurhari' => $data->UmurHari,
            'bod' => $data->Bod,
            'kategori' => $data->KategoriPasien,
            'nosep' => $data->NoSep,
            'kdicd' => $data->DiagAw,
            'diagnosa' => $data->NmDiagnosa,
            'pisat' => $data->pisat,
            'keterangan' => $data->Keterangan,
            'tglrujuk' => $data->RegRujuk,
            'norujuk' => $data->NoRujuk,
            'kdrujukan' => $data->noPpk,
            'nmrujukan' => $data->Ppk,
            'kdrefpeserta' => $data->kodePeserta,
            'nmrefpeserta' => $data->Peserta,
            'notifsep' => $data->NotifSep,
            'kdkasus' => $data->KasKe,
            'lokasikasus' => '',
            'nikktp' => $data->NoIden,
            'statpeserta' => $data->statusPeserta,
            'kdstatpeserta' => '',
            'asalrujuk' => $data->asalRujukan,
            'phone' => $data->Notelp,
            'kdcob' => $data->Cob,
            'nmcob' => '',
            'kdjaminanbpjs' => '',
            'catatan' => $data->catatan];
        return self::executeStoredProcedure2($sp, $parameters);
    }

    public static function stpnet_AddMutasiPasienUmum_REGxhos(array $data)
    {
        $data = (object) $data;
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $sp = 'stpnet_AddMutasiPasienUmum_REGxhos';
        $parameters = [
        'regno'      => $data->Regno,
        'regdate'    => $data->Regdate,
        'regtime'    => $data->Regdate.' '.$data->Regtime,
        'medrec'     => $data->Medrec,
        'firstname'  => $data->Firstname,
        'kategori'   => $data->Kategori,
        'kdsex'      => $data->KdSex,
        'sex'        => $sex,
        'kdcbayar'   => $data->KdCbayar,
        'kdperusahaan' => $data->NMPerusahaan,
        'kdjaminan'  => $data->NMPenjamin,
        'nopeserta'  => $data->NoPeserta,
        'tglrujuk'   => $data->TglRujuk,
        'norujuk'    => $data->NoRujuk,
        'kddocrujuk' => '',
        'kddocrs'    => $data->DocRS,
        'nmdocrs'    => $data->nmDocRs,
        'kdpoli'     => $data->KdPoli,
        'kdapasien'  => '',
        'kdbangsal'  => $data->Kelas,
        'kdkelas'    => $data->Bangsal,
        'nokamar'    => $data->Bed,
        'nottidur'   => $data->TempatTidur,
        'kddocrawat' => $data->Docmerawat,
        'kdicd'      => $data->Diagnosa,
        'diagnosa'   => $data->NmDiagnosa,
        'validuser'  => $validuser];
        return self::executeStoredProcedure2($sp, $parameters);
    }


    public static function stpnet_UpdateCaraBayar_REGxhos($data)
    {
        $sp = 'stpnet_UpdateCaraBayar_REGxhos';
        $parameters = [
            'regno'         => $data['regno'],
            'KdCbayar'    => $data['carabayar'] ,
            'Kategori'     => $data['kategori'] ,
        ];

        return self::executeStoredProcedure2($sp, $parameters);
    }

    public function stpnet_UpdateDokterPasien_REGxhos($data)
    {
        $sp = 'stpnet_UpdateDokterPasien_REGxhos';
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $parameters = [
            'Regno'       => $data['regno'], 
            'KdDocBefore' => $data['register']->KdDoc, 
            'KdDocUpdate' => $data['dokter_pil'], 
            'Keterangan'  => 'Update Dokter Rawat Jalan dengan kode poli '.$data['poli'],
            'ValidUser'   => $validuser
        ];

        return self::executeStoredProcedure2($sp, $parameters);
    }
}