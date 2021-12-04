<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
	function __construct(){
		// Connection used
		$this->connection = 'main';
		// Table Used
		$this->table = 'Register';
		// Table Primary Key
		$this->primaryKey = 'Regno';
		// Type of Primary Key Table
		$this->keyType = 'string';

		$this->timestamps = false;
		// 
		$this->fillable = [
			'Regno', 'Medrec', 'Firstname', 'Sex', 'Kunjungan', 'rujukan_dari'];
		// 
		$this->hidden = [];
	}

	public function updateSepOnly($data){
		$data = (object) $data;
		DB::connection('main')->table('Register')->where('Regno', $data->Regno)
            ->update([
                'NoSep' => $data->NoSep,
               'KdICD' => $data->DiagAw
            ]);
        return $data;
	}

	public function get_register($medrec,$regdate='',$kdpoli='')
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Sex, Register.KdSex,
									   TBLcarabayar.NMCbayar, Register.KdTuju, Register.NoRujuk, Register.TglRujuk, TBLTpengobatan.NMTuju,
									   Register.KdRujukan, Register.NmRujukan, Register.KdPoli, POLItpp.NMPoli, Register.NomorUrut, Register.NoSep,
									   Register.KdICD, Register.KdJaminan, Register.KdCbayar, TBLJaminan.NMJaminan,
									   Register.KdPerusahaan, Register.NoPeserta, Register.Regdate, Register.KdDoc,
									   FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser"))
					->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					->where("Medrec",$medrec)   
					->where("Regdate",$regdate)   
					->where("Register.KdPoli",$kdpoli)   
					->whereNull("Deleted")
					->orderBy("Register.Regdate", "DESC")->first();
		return $data;
	}

	public function get_one($regno)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Sex, Register.KdSex, Register.AsalRujuk, Register.Catatan, Register.KdDPJP as dpjpKdDPJP, dpjp.NmDoc as dpjpNmDoc, dpjp.KdDPJP as dpjpdokter,
									   TBLcarabayar.NMCbayar, Register.KdTuju, TBLTpengobatan.NMTuju, Register.Regtime, Register.UmurThn,
									   Register.UmurBln, Register.UmurHari, TBLPerusahaan.NMPerusahaan, Register.KdRujuk, Register.KdKasus,
									   TBLAsalpasien.NMApasien, Register.GroupUnit, Register.NmUnit, Register.Pisat, Register.nikktp,
									   Register.NoRujuk, Register.NoKontrol, MasterPS.Phone, TBLICD10.DIAGNOSA, Register.PoliEksekutif, 
									   Register.Katarak, Register.Kunjungan, Register.TglKejadian, Register.Suplesi,
									   Register.NoSuplesi, Register.Bod, Register.NmKelas, Register.Perjanjian, MasterPS.TglDaftar,
									   Register.KdRujukan, Register.NmRujukan, Register.KdPoli, TBLBangsal.NmBangsal, Register.IdRegOld,
									   POLItpp.NMPoli,Register.NomorUrut, Register.KdICD, Register.KdJaminan, MasterPS.Perkawinan,
									   MasterPS.Agama, MasterPS.Keyakinan, MasterPS.Pendidikan, MasterPS.Pekerjaan, MasterPS.WargaNegara,
									   MasterPS.NamaAyah, MasterPS.NamaIbu, MasterPS.PekerjaanPJ, MasterPS.PhonePJ, MasterPS.AlamatPJ,
									   Register.KdCbayar, TBLJaminan.NMJaminan, Register.AtasNama, MasterPS.Address, Register.KdBangsal,
									   Register.KdPerusahaan, Register.NoPeserta, Register.Regdate, Register.KdDoc, Register.Keterangan,
									   Register.StatPeserta, Register.NmRefPeserta, Register.KdRefPeserta, Register.NoSep, Register.NotifSEP,
									   FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.TglRujuk, Register.ValidUser, Register.rujukan_dari,
									   TBLKelas.NMKelas, Register.KdKelas, Register.Kunjungan, fKeyakinan.phcek, fKeyakinan.phnote, fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, fKeyakinan.pmnote, fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain"))
					->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					->leftJoin("fKeyakinan", "Register.Medrec", "=", "fKeyakinan.medrec")
					->leftJoin("TBLICD10", "Register.KdICD", "=", "TBLICD10.KDICD")
					->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					->leftJoin("TBLAsalpasien", "Register.KdRujuk", "=", "TBLAsalpasien.KDApasien")
					->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					->leftJoin("FtDokter as dpjp", "Register.KdDPJP", "=", "dpjp.KdDoc")
					->where("Regno",$regno)
					->orderBy("Register.Regdate", "DESC")->first();
		return $data;
	}

	public function cek_regis_pasien($medrec = "", $regdate = "", $kategori="", $cbayar="", $poli="")
	{
		$data = $this->selectRaw("Register.Regno, Register.Medrec, Register.Firstname, Register.Sex, Register.KdSex,
						Register.KdTuju, Register.NoRujuk, Register.TglRujuk,
						Register.KdRujukan, Register.NmRujukan, Register.KdPoli, POLItpp.NMPoli, Register.NomorUrut,
						Register.KdICD, Register.KdJaminan, Register.KdCbayar,
						Register.KdPerusahaan, Register.NoPeserta, Register.Regdate, Register.KdDoc,
						FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser")
				->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
				->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
				->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
				->whereNull('Register.Deleted')
				->where("Register.Regdate", ">=", $regdate." 00:00:00")
				->where("Register.Regdate", "<=", $regdate." 23:59:59")
				->where("Register.Medrec",$medrec)
				->where("Register.KdCbayar",$cbayar);
				if($kategori == '1' || $kategori == '3'){
					$data->where("Register.KdPoli",$poli);
				}
		return $data->first();
	}
	public function cek_sep_pasien($sep)
	{
		$sep_owner = $this->select([
									'Medrec',
									'Regno',
									'Firstname',
									'Regdate',
									'Kategori',
									'Register.KdPoli',
									'NMPoli',
									'KdCbayar'
								])
								->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
								->where('NoSep', $sep)->first();
		return $sep_owner;
	}
	public function get_mutasi($regno)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Sex, Register.KdSex,
									   TBLcarabayar.NMCbayar, Register.KdTuju, Register.NoRujuk, Register.TglRujuk, TBLTpengobatan.NMTuju,
									   Register.KdRujukan, Register.NmRujukan, Register.KdPoli, POLItpp.NMPoli, Register.NmUnit,
									   Register.KdICD, Register.KdJaminan, Register.KdCbayar, TBLJaminan.NMJaminan, Register.GroupUnit,
									   Register.KdPerusahaan, Register.NoPeserta, Register.Regdate, Register.KdDoc, TBLPerusahaan.NMPerusahaan,
									   FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser, fKeyakinan.phcek, fKeyakinan.phnote, fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, fKeyakinan.pmnote, fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain"))
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("fKeyakinan", "Register.Medrec", "=", "fKeyakinan.medrec")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->where("Register.StatusReg", '2')
					 ->where("Regno",$regno)->first();
		return $data;
	}
	public function get_mutasi_bpjs($regno)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Sex, Register.KdSex, Register.AsalRujuk,
									   TBLcarabayar.NMCbayar, Register.KdTuju, TBLTpengobatan.NMTuju, Register.Regtime, Register.UmurThn,
									   Register.UmurBln, Register.UmurHari, TBLPerusahaan.NMPerusahaan, Register.KdRujuk, Register.KdKasus,
									   TBLAsalpasien.NMApasien, Register.GroupUnit, Register.NmUnit, Register.Pisat, Register.nikktp,
									   Register.NoRujuk, Register.NoKontrol, MasterPS.Phone, TBLICD10.DIAGNOSA, Register.PoliEksekutif, 
									   Register.Katarak, Register.TglKejadian, Register.Suplesi, Register.NoSuplesi, Register.Bod, 
									   Register.NmKelas, Register.KdRujukan, Register.NmRujukan, Register.KdPoli, FtDokter.KdDPJP,
									   POLItpp.NMPoli,Register.NomorUrut, Register.KdICD, Register.KdJaminan, Register.KdKelas, 
									   TBLKelas.NMKelas, MasterPS.TglDaftar, Register.nikktp, Register.NoRujuk, Register.NoKontrol,
									   Register.KdCbayar, TBLJaminan.NMJaminan, Register.AtasNama, Register.KdBangsal, TBLBangsal.NmBangsal,
									   Register.KdPerusahaan, Register.NoPeserta, Register.Regdate, Register.KdDoc, Register.Keterangan,
									   Register.StatPeserta, Register.NmRefPeserta, Register.KdRefPeserta, Register.NoSep, Register.NotifSEP,
									   FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.TglRujuk, Register.ValidUser, 
									   fKeyakinan.phcek, fKeyakinan.phnote, fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, 
									   fKeyakinan.pmnote, fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain"))
					->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					->leftJoin("fKeyakinan", "Register.Medrec", "=", "fKeyakinan.medrec")
					->leftJoin("TBLICD10", "Register.KdICD", "=", "TBLICD10.KDICD")
					->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					->leftJoin("TBLAsalpasien", "Register.KdRujuk", "=", "TBLAsalpasien.KDApasien")
					->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					->where("Regno",$regno)->first();
		return $data;
	}

	public function register($medrec = '', $kategori = '', $groupunit = '', $unit = '', $korpunit = '', $poli = '', $dokter = '', $tujuan = '', $date1 = '', $date2 = '', $pdf = false)
	{
		$data = $this->select(DB::connection('main')->raw("
						Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate,
						Register.Regtime, Register.Sex, Register.NomorUrut, Register.KdJaminan,
						TBLJaminan.NMJaminan, Register.Kunjungan, Register.NoPeserta, Register.AtasNama,
						Register.KdTuju, Register.KdPoli, Register.KdBangsal, TBLBangsal.NmBangsal,
						Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, Register.NoSep,
						Register.Keterangan, Register.Pisat, Register.KdPerusahaan,
						TBLPerusahaan.NMPerusahaan, Register.KdCbayar, TBLcarabayar.NMCbayar,
						TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori,
						Register.ValidUser, Register.Kategori, MasterPS.Address, MasterPS.Bod, MasterPS.Phone, Register.ValidUpdate,
						MasterPS.GroupUnit, MasterPS.NmUnit, MasterPS.SubUnit, Register.Perjanjian, Register.StatusReg, Register.Deleted"))
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->leftjoin("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->where("Register.StatusReg", "!=", '3')
					 ->where("Register.StatusReg", "!=", '4');
					 // ->whereNull("Register.Deleted")->whereNull("MasterPS.Deleted");
		if ($medrec != ''){ $data->where("Register.Medrec", "like", "%".$medrec."%"); }
		if ($kategori != '') { $data->where('Register.Kategori', $kategori); }
		if ($groupunit != '') { $data->where('MasterPS.GroupUnit', $groupunit); }
		if ($unit != '') { $data->where('MasterPS.NmUnit', $unit); }
		if ($korpunit != '') { $data->where('MasterPS.SubUnit', $korpunit); }
		if ($poli != ''){ $data->where("Register.KdPoli", "like", "%".$poli."%"); }
		if ($dokter != ''){ $data->where("Register.KdDoc", $dokter); }
		if ($tujuan != ''){ $data->where("Register.KdTuju", "like", "%".$tujuan."%"); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2); }
		if (!$pdf) {
			$data = $data
						->orderBy("Register.KdPoli", "ASC")
						// ->orderByRaw('CHAR_LENGTH(Register.Nomor, 0, 10)', "ASC")
						->orderBy("Register.NomorUrut", "ASC")
						->orderBy("Register.Regno", "ASC")
						// ->orderBy(DB::raw("LENGTH(Register.NomorUrut, 0, 10), Register.NomorUrut"), "ASC")
						->orderBy("Register.Regtime", "DESC")
						->paginate(10);
		}else{
			$data = $data
						->orderBy("Register.KdPoli", "ASC")
						->orderBy("Register.NomorUrut", "ASC")
						->orderBy("Register.Regno", "ASC")
						// ->orderBy("LENGTH(Register.NomorUrut) AS NomorUrut", "ASC")
						->orderBy("Register.Regtime", "DESC")
						->get();
		}
		return $data;
	}

	public function get_mcu_pasien($date1 = '', $date2 = '', $pdf = false)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Sex, Register.NomorUrut, Register.KdJaminan, TBLJaminan.NMJaminan, Register.Kunjungan, Register.NoPeserta, Register.AtasNama, Register.KdTuju, Register.KdPoli, Register.KdBangsal, TBLBangsal.NmBangsal, Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, Register.NoSep, Register.Keterangan, Register.Pisat, Register.KdPerusahaan, TBLPerusahaan.NMPerusahaan, Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori, MasterPS.Address, MasterPS.Bod, MasterPS.Phone, MasterPS.GroupUnit, MasterPS.NmUnit, MasterPS.SubUnit, MasterPS.McuInstansi, MasterPS.McuUnit"))
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->whereNull("Register.Deleted");
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2.' 23:59:59'); }
		if (!$pdf) {
			$data = $data->orderBy("Register.Regdate", "DESC")->paginate(10);
		}else{
			$data = $data->orderBy("Register.Regdate", "DESC")->get();
		}
		return $data;
	}

	public function get_perjanjian($medrec = '', $date1 = '', $date2 = '', $pdf = false)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, Register.Sex, Register.NomorUrut, Register.KdJaminan, TBLJaminan.NMJaminan, Register.Kunjungan, Register.NoPeserta, Register.AtasNama, Register.KdTuju, Register.KdPoli, Register.KdBangsal, TBLBangsal.NmBangsal, Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, Register.NoSep, Register.Keterangan, Register.Pisat, Register.KdPerusahaan, TBLPerusahaan.NMPerusahaan, Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori, MasterPS.Address, MasterPS.Bod, MasterPS.Phone, MasterPS.GroupUnit, MasterPS.NmUnit, MasterPS.SubUnit, Register.Perjanjian"))
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->whereNull("Register.Deleted")
					 ->where("Register.Perjanjian", "true")
					 ->where("Register.Regdate", ">=", date('Y-m-d'));
		if ($medrec != '') { $data->where("Register.Medrec", $medrec); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2.' 23:59:59'); }
		if (!$pdf) {
			$data = $data->orderBy("Register.Regdate", "DESC")->paginate(10);
		}else{
			$data = $data->orderBy("Register.Regdate", "DESC")->get();
		}
		return $data;
	}

	public function get_all($regno = '', $medrec = '',$nama = '', $poli = '', $date1 = '', $date2 = '',  $notelp = '', $alamat = '', $nopeserta = '', $tgl_lahir = '', $pdf = false)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Sex,
										Register.Kunjungan, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli,
										FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori,
										MasterPS.Address, MasterPS.Bod, MasterPS.Phone, MasterPS.AskesNo, Register.NoPeserta, Register.Perjanjian, Register.Deleted"))
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 // ->whereNull("Register.Deleted")
					 ->where("Register.StatusReg", '2');
		if ($regno != '') { $data->where('Register.Regno', 'like', '%'.$regno.'%'); }
		if ($medrec != '') { $data->where('Register.Medrec', 'like', '%'.$medrec.'%'); }
		if ($nama != '') { $data->where('Register.Firstname', 'like', '%'.$nama.'%'); }
		if ($poli != ''){ $data->where("Register.KdPoli", "like", "%".$poli."%"); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != ''){ $data->where("Register.Regdate", "<=" ,date("Y-m-d", strtotime("+1 day", strtotime($date2)))); }
		if ($alamat != ''){ $data->where("MasterPS.Address", "like", "%".$alamat."%"); }
		if ($tgl_lahir != ''){ $data->where("MasterPS.Bod", $tgl_lahir); }
		if ($notelp != ''){ $data->where("MasterPS.Phone", "like", "%".$notelp."%"); }
		if (!$pdf) {
			$data = $data->orderBy("Register.Regtime", "DESC")->paginate(10);
		}else{
			$data = $data->orderBy("Register.Regtime", "DESC")->get();
		}
		return $data;
	}


	public function get_all_bpjs($regno = '', $medrec = '', $nama = '', $poli = '', $dokter = '', $tujuan = '', $date1 = '', $date2 = '', $pdf = false)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, Register.Sex, Register.NomorUrut, Register.KdJaminan, TBLJaminan.NMJaminan, Register.Kunjungan, Register.NoPeserta, Register.AtasNama, Register.KdTuju, Register.KdPoli, Register.KdBangsal, TBLBangsal.NmBangsal, Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, Register.NoSep, Register.Keterangan, Register.Pisat, Register.KdPerusahaan, TBLPerusahaan.NMPerusahaan, Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori, MasterPS.Address, MasterPS.Bod, MasterPS.Phone, Register.Perjanjian, Register.ValidUpdate, Register.Deleted"))
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 // ->whereNull("Register.Deleted")
					 ->where("Register.StatusReg", '1');
		if ($regno != '') { $data->where('Register.Regno', 'like', '%'.$regno.'%'); }
		if ($medrec != '') { $data->where('Register.Medrec', 'like', '%'.$medrec.'%'); }
		if ($nama != '') { $data->where('Register.Firstname', 'like', '%'.$nama.'%'); }
		if ($poli != ''){ $data->where("Register.KdPoli", "like", "%".$poli."%"); }
		if ($dokter != ''){ $data->where("Register.KdDoc", $dokter); }
		if ($tujuan != ''){ $data->where("Register.KdTuju", "like", "%".$tujuan."%"); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != ''){ $data->where("Register.Regdate", "<=" , $date2.' 23:59:59'); }
		if (!$pdf) {
			$data = $data->orderBy("Register.Regtime", "DESC")->paginate(10);
		}else{
			$data = $data->orderBy("Register.Regtime", "DESC")->get();
		}
		return $data;
	}

	public function update_umum($data)
	{
		$data = (object) $data;
		if ($data->Bangsal != '') {
			DB::connection('main')->table('Register')->where('Regno', $data->Regno)
			->update([
				'KdKelas' => $data->Bangsal
			]);
		}
		if ($data->Diagnosa != '') {
			DB::connection('main')->table('Register')->where('Regno', $data->Regno)
			->update([
				'KdICD' => $data->Diagnosa
			]);
		}
		if ($data->DocRS != '') {
			DB::connection('main')->table('Register')->where('Regno', $data->Regno)
			->update([
				'KdDoc' => $data->DocRS
			]);
		}
		return $data;
	}

	public static function listTracerPerjanjian($tanggal, $poli = NULL)
	{
		$raw_sql = "
			SELECT
				r.Regno, r.Medrec, r.NomorUrut, r.Firstname, r.KdPoli, p.NmPoli, t.DiPrint, r.Perjanjian,
				CONVERT(VARCHAR, r.Regtime, 8) AS Regtime
			FROM Register AS r
			LEFT JOIN POLItpp AS p ON r.KdPoli=p.KdPoli
			LEFT JOIN fTracer AS t ON r.Regno=t.Regno
			JOIN TblKategoriPsn AS k ON r.Kategori=k.KdKategori
			WHERE
				r.Deleted IS NULL
				AND COALESCE(r.Perjanjian, '') != ''
				AND r.Kunjungan='Lama'
				AND r.StatusReg NOT IN (3, 4)
				AND CAST(r.Regdate AS DATE) = :tanggal
		";

		$params = compact('tanggal');

		if(!empty($poli))
		{
			$raw_sql .= " AND r.KdPoli = :poli";
			$params['poli'] = $poli;
		}

		$raw_sql .= ' ORDER BY r.Regtime ASC, r.Regno ASC';

		return DB::select($raw_sql, $params);
	}

	public static function listTracerHarian($tanggal, $poli = NULL, $last_regno = NULL, $last_time = NULL)
	{
		$raw_sql = "
			SELECT
				r.Regno, r.Medrec, r.NomorUrut, r.Firstname, r.KdPoli, p.NmPoli, t.DiPrint, r.Perjanjian,
				CONVERT(VARCHAR, r.Regtime, 8) AS Regtime
			FROM Register AS r
			LEFT JOIN POLItpp AS p ON r.KdPoli=p.KdPoli
			LEFT JOIN fTracer AS t ON r.Regno=t.Regno
			JOIN TblKategoriPsn AS k ON r.Kategori=k.KdKategori
			WHERE
				r.Deleted IS NULL
				-- AND r.Perjanjian = ''
				AND COALESCE(r.Perjanjian, '') = ''
				AND r.Kunjungan='Lama'
				AND r.StatusReg NOT IN (3, 4)
				AND CAST(r.Regdate AS DATE) = :tanggal
		";

		$params = compact('tanggal');

		if(!empty($poli))
		{
			$raw_sql .= " AND r.KdPoli = :poli";
			$params['poli'] = $poli;
		}

		if(!empty($last_regno) && !empty($last_time))
		{
			$raw_sql .= " AND (
				(CONVERT(VARCHAR, r.Regtime, 8) + '#' + r.Regno < :back_cursor AND t.DiPrint IS NULL) OR
				-- (CAST(r.Regtime AS TIME) < :back_cursor AND t.DiPrint IS NULL) OR
				CONVERT(VARCHAR, r.Regtime, 8) + '#' + r.Regno > :front_cursor
			)";
			$params['back_cursor'] = $last_time.'#'.$last_regno;
			// $params['back_cursor'] = $last_time;
			$params['front_cursor'] = $last_time.'#'.$last_regno;
		}

		if($tanggal == date('Y-m-d'))
		{
			$raw_sql .= " AND CAST(r.Regtime AS TIME) <= :regtime";
			$params['regtime'] = date('H:i:s');
		}

		$raw_sql .= ' ORDER BY r.Regtime ASC, r.Regno ASC';

		return DB::select($raw_sql, $params);
	}

	public function tracer($tujuan = '', $poli='', $date1 = '', $date2 = '', $set=0, $perjanjian=false, $pdf = false) 
	{
		$data = $this->selectRaw("Register.Regno, Register.Medrec, Register.Firstname, 
							Register.Regdate, Register.Regtime, Register.Sex, Register.NomorUrut, 
							Register.KdJaminan, TBLJaminan.NMJaminan, Register.Kunjungan,
							Register.NoPeserta, Register.AtasNama, Register.KdTuju, Register.KdPoli,
							Register.KdBangsal, TBLBangsal.NmBangsal, Register.KdKelas, TBLKelas.NMKelas, 
							Register.KdIcd, Register.NoSep, Register.Keterangan, Register.Pisat, 
							Register.KdPerusahaan, TBLPerusahaan.NMPerusahaan, Register.KdCbayar,
							TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, 
							FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori, 
							MasterPS.Address, MasterPS.Bod, MasterPS.Phone, Register.Prn, fTracer.DiPrint")
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->leftJoin("fTracer", "Register.Regno", "=", "fTracer.Regno")
					 ->where("Register.Kunjungan","Lama")
					 ->where("Register.StatusReg", '!=', '3')
					 ->where("Register.StatusReg", '!=', '4')
					 ->whereNull("Register.Deleted");
			$perjanjian == true ? $data->where("Register.Perjanjian", '<>', '') : $data->where("Register.Perjanjian", '');
		if ($tujuan != ''){ $data->where("Register.KdTuju", "like", "%".$tujuan."%"); }
		if ($poli != ''){ $data->where("Register.KdPoli", "like", "%".$poli."%"); }
		if($date1 != '' && $date2 != ''){
			$data->whereBetween("Register.Regdate",[$date1, $date2]);
		}else{
			if ($date1 != '') { $data->where("Register.Regdate", $date1); }
			if ($date2 != '') { $data->where("Register.Regdate", $date2); }
		}
		if($set == 1){
			$data->whereNotNull("fTracer.DiPrint");
		}
		if($set == 2){
			$data->whereNull("fTracer.DiPrint");
		}
		if (!$pdf) {
			$data = $data->orderBy("Register.Regdate", "DESC")->paginate(15);
		}else{
			$data = $data->orderBy("Register.Regno", "ASC")->get();
		}
		return $data;
	}

	public function print_tracer_one($regno,$way='')
	{
		$data = $this->selectRaw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, 
							Register.Regtime, Register.Sex, Register.NomorUrut, Register.KdJaminan, 
							TBLJaminan.NMJaminan, Register.Kunjungan, Register.NoPeserta, Register.AtasNama, 
							Register.KdTuju, Register.KdPoli, Register.KdBangsal, TBLBangsal.NmBangsal, 
							Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, Register.NoSep, 
							Register.Keterangan, Register.Pisat, Register.KdPerusahaan, TBLPerusahaan.NMPerusahaan,
							Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, 
							FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, 
							Register.Kategori, MasterPS.Address, MasterPS.Bod, MasterPS.Phone, fTracer.DiPrint")
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->leftJoin("fTracer", "Register.Regno", "=", "fTracer.Regno")
					 ->whereNull("Register.Deleted")
					 ->where("Register.Regno", $regno);
					 if($way != ''){
						$data->where("Register.Perjanjian", '');
					 }
		return $data->first();
	}

	public function find_register_bpjs($medrec,$phone ,$nama, $alamat, $tgl_lahir, $date1, $date2)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, Register.Sex, Register.NomorUrut, Register.KdJaminan, TBLJaminan.NMJaminan, Register.Kunjungan, Register.NoPeserta, Register.AtasNama, Register.KdTuju, Register.KdPoli, Register.KdBangsal, TBLBangsal.NmBangsal, Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, Register.NoSep, Register.Keterangan, Register.Pisat, Register.KdPerusahaan, TBLPerusahaan.NMPerusahaan, Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori, MasterPS.Address, MasterPS.Bod, MasterPS.Phone"))
					 ->leftJoin("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
					 ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLBangsal", "Register.KdBangsal", "=", "TBLBangsal.KdBangsal")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->whereNull("Register.Deleted");
		if ($phone != '') { $data->where('MasterPS.Phone', 'like', '%'.$phone.'%'); }
		if ($medrec != '') { $data->where('Register.Medrec', 'like', '%'.$medrec.'%'); }
		if ($nama != '') { $data->where('Register.Firstname', 'like', '%'.$nama.'%'); }
		if ($alamat != ''){ $data->where("MasterPS.Address", "like", "%".$alamat."%"); }
		if ($tgl_lahir != '') { $data->where("MasterPS.Bod", "like", "%".$tgl_lahir."%"); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2); }
		$data = $data->orderBy("Register.Regdate", "DESC")->paginate(15);
		return $data;
	}

	public function printPeserta($poli = '', $dokter = '', $tujuan = '', $date1 = '', $date2 = '')
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Kunjungan, Register.KdTuju, Register.KdPoli, Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori"))
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc");
		if ($poli != ''){ $data->where('Register.KdPoli', 'like', '%'.$poli.'%'); }
		if ($dokter != ''){ $data->where('Register.KdDoc', $dokter); }
		if ($tujuan != ''){ $data->where("Register.KdTuju", "like", "%".$tujuan."%"); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2); }
		$data = $data->get();
		return $data;
	}

	public function printPeserta_baru($poli = '', $dokter = '', $tujuan = '', $date1 = '', $date2 = '')
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Kunjungan, Register.KdTuju, Register.KdPoli, Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori"))
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->where("Register.Kunjungan" , "like", "%"."baru"."%");
		if ($poli != ''){ $data->where('Register.KdPoli', 'like', '%'.$poli.'%'); }
		if ($dokter != ''){ $data->where('Register.KdDoc', $dokter); }
		if ($tujuan != ''){ $data->where("Register.KdTuju", "like", "%".$tujuan."%"); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2); }
		$data = $data->get();
		return $data;
	}

	public function printPeserta_lama($poli = '', $dokter = '', $tujuan = '', $date1 = '', $date2 = '')
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Kunjungan, Register.KdTuju, Register.KdPoli, Register.KdCbayar, TBLcarabayar.NMCbayar, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.Kategori"))
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->where("Register.Kunjungan" , "like", "%"."lama"."%");
		if ($poli != ''){ $data->where('Register.KdPoli', 'like', '%'.$poli.'%'); }
		if ($dokter != ''){ $data->where('Register.KdDoc', $dokter); }
		if ($tujuan != ''){ $data->where("Register.KdTuju", "like", "%".$tujuan."%"); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2); }
		$data = $data->get();
		return $data;
	}

	public function get_sep($medrec = '', $nama = '', $date1 = '', $date2 = '')
	{
		 $data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.KdTuju, Register.Firstname, Register.NoSep,
									   Register.KdPoli, POLItpp.NMPoli,Register.KdICD, Register.NoPeserta, Register.Regdate, Register.KdDoc,
									   FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser"))
					->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					->where("Regdate", '<=', date('Y-m-d H:i:s'));
		if ($medrec != '') { $data->where('Register.Medrec', 'like', '%'.$medrec.'%'); }
		if ($nama != '') { $data->where('Register.Firstname', 'like', '%'.$nama.'%'); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2); }
		$data = $data->orderBy("Register.Regdate", "DESC")->paginate(15);
		return $data;
	}

	public function get_file_status_keluar($regno = '', $medrec = '', $date1 = '', $date2 = '', $poli = '', $nama = '', $pdf = false)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, 
									fStatusKeluar.TanggalKeluar, fStatusKeluar.JamKeluar, Register.Kunjungan, POLItpp.NMPoli, 
									FtDokter.NmDoc, TBLTpengobatan.NMTuju, TBLcarabayar.NMCbayar, fStatusKeluar.ValidUser, 
									Register.NomorUrut, TBLBangsal.NmBangsal, Register.ValidUpdate, Register.Prn"))
		->leftJoin("tbltpengobatan", "register.kdtuju", "=", "tbltpengobatan.kdtuju")
		->leftJoin("politpp", "register.kdpoli", "=", "politpp.kdpoli")
		->leftJoin("fstatuskeluar", "register.regno", "=", "fstatuskeluar.regno")
		->leftJoin("tblcarabayar", "register.kdcbayar", "=", "tblcarabayar.kdcbayar")
		->leftJoin("ftdokter", "register.kddoc", "=", "ftdokter.kddoc")
		->leftJoin("tblbangsal", "register.kdbangsal", "=", "tblbangsal.kdbangsal")
		->where("Regdate", '<=', date('Y-m-d H:i:s'))->orderBy("Regdate","DESC");
		if ($regno != '') { $data->where('Register.Regno', 'like', '%'.$regno.'%'); }
		if ($medrec != '') { $data->where('Register.Medrec', 'like', '%'.$medrec.'%'); }
		if ($nama != '') { $data->where('Register.Firstname', 'like', '%'.$nama.'%'); }
		if ($poli != '') { $data->where('POLItpp.NMPoli', 'like', '%'.$poli.'%'); }
		if ($date1 != '') { $data->where("Register.Regdate", ">=", $date1); }
		if ($date2 != '') { $data->where("Register.Regdate", "<=", $date2); }
		if (!$pdf) {
			$data = $data->orderBy("Register.Regno", "DESC")->paginate(15);
		}else{
			$data = $data->orderBy("Register.Regno", "DESC")->get();
		}
		return $data;
	}

	public function get_info_status_keluar($regno)
	{
		// $regno = '00922982';
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, fStatusKeluar. TanggalKeluar, fStatusKeluar.JamKeluar, fStatusKeluar.nStatus, fStatusKeluar.NamaPeminjam, fStatusKeluar.Bagian, fStatusKeluar.Keterangan, Register.Kategori"))
		->leftjoin("fStatusKeluar", "Register.Regno" , "=", "fStatusKeluar.Regno")
		->where("Register.Regno", $regno)
		->orderBy("Register.Regdate", "DESC")->get();
		return $data;
	}

	public function cek_pasien($medrec)
	{
	  $data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Sex, Register.KdSex,
									   TBLcarabayar.NMCbayar, Register.KdTuju, Register.NoRujuk, Register.TglRujuk, TBLTpengobatan.NMTuju,
									   Register.KdRujukan, Register.NmRujukan, Register.KdPoli, POLItpp.NMPoli, Register.NomorUrut,
									   Register.KdICD, Register.KdJaminan, Register.KdCbayar, TBLJaminan.NMJaminan,
									   Register.KdPerusahaan, Register.NoPeserta, Register.Regdate, Register.KdDoc,
									   FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.ValidUser"))
					->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
					->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					->where("Medrec",$medrec)
					->whereNull("Deleted")
					->orderBy("Register.Regdate", "DESC")->first();
		return $data;
	}

	public function print_label($regno)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.KdSex, Register.Bod, Register.UmurThn, Register.UmurBln, Register.UmurHari, TblKategoriPsn.NmKategori, Register.NmUnit"))
		->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
		->where("Register.Regno", $regno)->first();
		return $data;
	}

	public function print_slip($regno)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, Register.Kunjungan, POLItpp.NMPoli, FtDokter.NmDoc, TBLTpengobatan.NMTuju, TBLcarabayar.NMCbayar, Register.NomorUrut, Register.ValidUpdate, Register.Prn"))
			->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
			->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
			->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
			->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
			->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
		->where("Register.Regno", $regno)->first();
		return $data;
	}

	public function print_sep($regno)
	{
		$data = $this->select(DB::connection('main')->raw("Register.Regno, Register.Medrec, Register.Firstname, Register.Regdate, Register.Regtime, Register.Sex, Register.NomorUrut, Register.KdJaminan, TBLJaminan.NMJaminan, Register.NmRujukan, Register.NoPeserta, Register.AtasNama, Register.NmKelas, Register.KdTuju, Register.KdPoli, Register.KdKelas, TBLKelas.NMKelas, Register.KdIcd, TBLICD10.DIAGNOSA, Register.NoSep, Register.Keterangan, TBLTpengobatan.NMTuju, POLItpp.NMPoli, FtDokter.NmDoc, TblKategoriPsn.NmKategori, Register.ValidUser, Register.ValidUpdate, Register.Bod, Register.phone, Register.kdcob, Register.Prolanis, Register.StatPeserta, Register.NmRefPeserta, Register.Catatan, fCetakSEP.Nomor"))
					 ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
					 ->leftJoin("TBLICD10", "Register.KdICD", "=", "TBLICD10.KDICD")
					 ->leftJoin("TBLKelas", "Register.KdKelas", "=", "TBLKelas.KdKelas")
					 ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
					 ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
					 ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
					 ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
					 ->leftJoin("fCetakSEP", "Register.Regno", "=", "fCetakSEP.Regno")
					 ->where("Register.Regno", $regno)->first();
		return $data;
	}

	public function update_antrian($date = '', $poli = '', $regno = '')
	{
	  $no_urut = 1;

	  $cek_no_urut = $this->select(DB::connection('main')->raw('Regno, Regdate, NomorUrut'))->where('KdPoli', $poli)->where('Regdate', '>=',$date.' 00:00:00')->where('Regdate', '<=',$date.' 23:59:59')->orderBy('Regno', 'DESC')->get()->first();
	  if (!empty($cek_no_urut)) {
		$no_urut = $cek_no_urut->NomorUrut+1;
	  }

	  $pasien = $this->select(DB::connection('main')->raw('Regno, Medrec, Firstname, Regdate, Regtime, Sex, NomorUrut, KdJaminan, KdPoli, NomorUrut'))->where('Regno', $regno)->get()->first();
	  if ($pasien->KdPoli != $poli) {
		DB::connection('main')->table('Register')->where('Regno', $regno)
		  ->update([
			  'NomorUrut' => $no_urut
		  ]);
	  }
	  
	  return $no_urut;
	}


	// Jika spwe tidak masuk maka back up insert disini
	public function backup_registrasi_pasien($data)
	{
	  // dd($data);
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
	  $date = $data['Regdate'].' '.$data['Regtime'];
	  $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');

	  // cek nomor urut
	  if ($data['NomorUrut'] == '') {
		$no_urut = 1;
		  $check_nomor_urut = $this->select(DB::connection('main')->raw('Regno, Regdate, NomorUrut'))
		  ->where('KdPoli', $data['KdPoli'])
		  ->where('StatusReg', '!=', '3')
		  ->where('StatusReg', '!=', '4')
		  ->where('Regdate', '>=',$data['Regdate'].' 00:00:00')
		  ->where('Regdate', '<=',$data['Regdate'].' 23:59:59')
		  ->orderBy('NomorUrut', 'DESC')->get()->first();
		  if (!empty($check_nomor_urut)) {
			$no_urut = $check_nomor_urut->NomorUrut+1;
		  }
		$data['NomorUrut'] = $no_urut;
	  }

	  // search noregno
	  if ($data['Regno'] == '') {
		$check_regno = DB::table('fregno')->select('NREGNO')->first();
		$new_regno = $check_regno ? intval($check_regno->NREGNO)+1 : 1;

		if (strlen($new_regno) == 8) {
		  $data['Regno'] = $new_regno;
		} elseif (strlen($new_regno) == 7) {
		  $data['Regno'] = '0'.$new_regno;
		} elseif (strlen($new_regno) == 6) {
		  $data['Regno'] = '00'.$new_regno;
		} elseif (strlen($new_regno) == 5) {
		  $data['Regno'] = '000'.$new_regno;
		} elseif (strlen($new_regno) == 4) {
		  $data['Regno'] = '0000'.$new_regno;
		} elseif (strlen($new_regno) == 3) {
		  $data['Regno'] = '00000'.$new_regno;
		} elseif (strlen($new_regno) == 2) {
		  $data['Regno'] = '000000'.$new_regno;
		} elseif (strlen($new_regno) == 1) {
		  $data['Regno'] = '0000000'.$new_regno;
		} else {
		  $data['Regno'] = '00000001';
		}
		DB::connection('main')->table('fregno')
		->update([
			'NREGNO' => $data['Regno']
		]);
	  } else {
		$update = DB::connection('main')->table('Register')->where('Regno', $data['Regno'])
			  ->update([
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
				'idregold' => '',
				'perjanjian' => $data['Perjanjian'],
				'kddpjp' => $data['KdDPJP'] ]);
		return $update;
	  }

	  $insert = DB::connection('main')->table('Register')
			  ->insert([
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
				  'idregold' => '',
				  'perjanjian' => $data['Perjanjian'],
				  'kddpjp' => $data['KdDPJP'] ]);

	  return $insert;
	}


}
