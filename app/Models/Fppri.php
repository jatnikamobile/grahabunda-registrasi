<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Fppri extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'FPPRI';
        // Table Primary Key
        $this->primaryKey = 'Regno';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function get_list($regno = '', $medrec = '', $nama = '', $date1 = '', $date2 = '')
    {

    	$data = $this->select(DB::connection('main')->raw("fppri.regno, fppri.medrec, fppri.firstname, fppri.regdate, tblbangsal.nmbangsal, tblkelas.nmkelas, fppri.nokamar, fppri.nottidur, tblcarabayar.nmcbayar, fppri.kdicd, fppri.diagnosa, tblperusahaan.nmperusahaan,tbljaminan.nmjaminan, fppri.validuser"))
    	->leftJoin("register", "fppri.regno", "=", "register.regno")
    	->leftJoin("tblbangsal", "fppri.kdbangsal", "=", "tblbangsal.kdbangsal")
    	->leftJoin("tblkelas", "fppri.kdkelas", "=", "tblkelas.kdkelas")
    	->leftJoin("tblcarabayar", "register.kdcbayar", "=", "tblcarabayar.kdcbayar")
    	->leftJoin("tblperusahaan", "register.kdperusahaan", "=", "tblperusahaan.kdperusahaan")
        ->leftJoin("tbljaminan", "register.kdjaminan", "=", "tbljaminan.kdjaminan")
        ->where("fppri.kdcbayar", "!=", "02")
        ->where("fppri.kdcbayar", "!=", "03");
        if($regno != ''){ $data->where("fppri.regno", "like", "%".$regno."%"); }

        if($medrec != ''){ $data->where("fppri.medrec", "like", "%".$medrec."%"); }
        if($nama != ''){ $data->where("fppri.firstname", "like", "%".$nama."%"); }
        if($date1 != ''){ $data->where("fppri.regdate", ">=" ,$date1); }
        if($date2 != ''){ $data->where("fppri.regdate", "<=" ,$date2); }
        $data = $data->orderBy("fppri.regdate","desc")->paginate(15);
        return $data;
    }

    public function get_one($regno)
    {
        $data = $this->select(DB::connection('main')->raw("fppri.regno, fppri.medrec, fppri.firstname, fppri.regdate, tblbangsal.nmbangsal, tblkelas.nmkelas, fppri.nokamar, fppri.nottidur, tblcarabayar.nmcbayar, fppri.kdicd, fppri.diagnosa, tblperusahaan.nmperusahaan,tbljaminan.nmjaminan, fppri.validuser, fppri.nopeserta, fppri.tglrujuk, fppri.nmdocrs, fppri.kddocrs, fppri.norujuk, fppri.jtkdkelas, fppri.kdpoli, fppri.kdbangsal, fppri.kdkelas, fppri.kddocrawat, ftdokter.nmdoc, fppri.kdsex, politpp.nmpoli, fppri.kategori, fppri.nosep, tblkategoripsn.nmkategori, fkeyakinan.phcek, fkeyakinan.phnote, fkeyakinan.ptcek, fkeyakinan.ptnote, fkeyakinan.pmcek, fkeyakinan.pmnote, fkeyakinan.ppcek, fkeyakinan.ppnote, fkeyakinan.lain"))
        ->leftJoin("register", "fppri.regno", "=", "register.regno")
        ->leftJoin("fkeyakinan", "fppri.medrec", "=", "fkeyakinan.medrec")
        ->leftJoin("ftdokter", "fppri.kddocrawat", "=", "ftdokter.kddoc")
        ->join("tblkategoripsn", "register.kategori", "=", "tblkategoripsn.kdkategori")
        ->leftJoin("politpp", "fppri.kdpoli", "=", "politpp.kdpoli")
        ->leftJoin("tblbangsal", "fppri.kdbangsal", "=", "tblbangsal.kdbangsal")
        ->leftJoin("tblkelas", "fppri.kdkelas", "=", "tblkelas.kdkelas")
        ->leftJoin("tblcarabayar", "register.kdcbayar", "=", "tblcarabayar.kdcbayar")
        ->leftJoin("tblperusahaan", "register.kdperusahaan", "=", "tblperusahaan.kdperusahaan")
        ->leftJoin("tbljaminan", "register.kdjaminan", "=", "tbljaminan.kdjaminan")
        ->whereNull("register.deleted")
        ->where("fppri.regno", $regno)->orderBy("fppri.regdate","desc")->first();
        return $data;
    }

    public function print_sep_rawat_inap($regno)
    {
        $data = $this->select(DB::connection('main')->raw("fppri.regno, fppri.medrec, fppri.firstname, fppri.regdate, tblbangsal.nmbangsal, tblkelas.nmkelas, fppri.nokamar, fppri.nottidur, tblcarabayar.nmcbayar, fppri.kdicd, fppri.diagnosa, tblperusahaan.nmperusahaan,tbljaminan.nmjaminan, fppri.validuser, fppri.nopeserta, fppri.tglrujuk, fppri.nmdocrs, fppri.kddocrs, fppri.norujuk, fppri.jtkdkelas, fppri.kdpoli, fppri.kdbangsal, fppri.kdkelas, fppri.kddocrawat, ftdokter.nmdoc, fppri.kdsex, politpp.nmpoli, fppri.kategori, fppri.nosep, tblkategoripsn.nmkategori, fkeyakinan.phcek, fkeyakinan.phnote, fkeyakinan.ptcek, fkeyakinan.ptnote, fkeyakinan.pmcek, fkeyakinan.pmnote, fkeyakinan.ppcek, fkeyakinan.ppnote, fkeyakinan.lain, fppri.nmrujukan, fppri.kdrujukan, fppri.phone, fppri.sex, fppri.nmrefpeserta, fppri.kdcob, fppri.jtkdkelas, masterps.bod, fcetaksep.nomor"))
        ->leftJoin("masterps", "fppri.medrec", "=", "masterps.medrec")
        ->leftJoin("register", "fppri.regno", "=", "register.regno")
        ->leftJoin("fkeyakinan", "fppri.medrec", "=", "fkeyakinan.medrec")
        ->leftJoin("ftdokter", "fppri.kddocrawat", "=", "ftdokter.kddoc")
        ->join("tblkategoripsn", "register.kategori", "=", "tblkategoripsn.kdkategori")
        ->leftJoin("politpp", "fppri.kdpoli", "=", "politpp.kdpoli")
        ->leftJoin("tblbangsal", "fppri.kdbangsal", "=", "tblbangsal.kdbangsal")
        ->leftJoin("tblkelas", "fppri.kdkelas", "=", "tblkelas.kdkelas")
        ->leftJoin("tblcarabayar", "register.kdcbayar", "=", "tblcarabayar.kdcbayar")
        ->leftJoin("tblperusahaan", "register.kdperusahaan", "=", "tblperusahaan.kdperusahaan")
        ->leftJoin("tbljaminan", "register.kdjaminan", "=", "tbljaminan.kdjaminan")
        ->leftJoin("fcetaksep", "fppri.regno", "=", "fcetaksep.regno")
        ->whereNull("register.deleted")
        ->where("fppri.regno", $regno)->orderBy("fppri.regdate","desc")->first();
        return $data;
    }

    public function get_one_fppri($regno)
    {
        $data = $this->select(DB::connection('main')->raw("FPPRI.Regno, FPPRI.Medrec, FPPRI.Firstname, Register.Sex, Register.KdSex, Register.AsalRujuk,
                                       TBLcarabayar.NMCbayar, Register.KdTuju, TBLTpengobatan.NMTuju, FPPRI.Regtime, Register.UmurThn,
                                       Register.UmurBln, Register.UmurHari, TBLPerusahaan.NMPerusahaan, Register.KdRujuk, Register.KdKasus,
                                       TBLAsalpasien.NMApasien, Register.GroupUnit, Register.NmUnit, Register.Pisat, Register.nikktp,
                                       Register.NoRujuk, Register.NoKontrol, MasterPS.Phone, TBLICD10.DIAGNOSA, Register.PoliEksekutif, 
                                       Register.Katarak, Register.TglKejadian, Register.Suplesi, Register.NoSuplesi, Register.Bod, 
                                       Register.NmKelas, Register.KdRujukan, Register.NmRujukan, Register.KdPoli, TBLBangsal.NmBangsal,
                                       POLItpp.NMPoli,Register.NomorUrut, Register.KdICD, Register.KdJaminan, MasterPS.Perkawinan,
                                       MasterPS.Agama, MasterPS.Keyakinan, MasterPS.Pendidikan, MasterPS.Pekerjaan, MasterPS.WargaNegara,
                                       MasterPS.NamaAyah, MasterPS.NamaIbu, MasterPS.PekerjaanPJ, MasterPS.PhonePJ, MasterPS.AlamatPJ,
                                       Register.KdCbayar, TBLJaminan.NMJaminan, Register.AtasNama, MasterPS.Address, FPPRI.KdBangsal,
                                       Register.KdPerusahaan, Register.NoPeserta, FPPRI.Regdate, Register.KdDoc, Register.Keterangan,
                                       Register.StatPeserta, Register.NmRefPeserta, Register.KdRefPeserta, Register.NoSep, Register.NotifSEP,
                                       FtDokter.NmDoc, Register.Kategori, TblKategoriPsn.NmKategori, Register.TglRujuk, Register.ValidUser,
                                       TBLKelas.NMKelas, FPPRI.KdKelas, MasterPS.Pod, MasterPS.NamaPJ, MasterPS.HubunganPJ"))
                    ->join("Register", "Fppri.Regno", "=", "Register.Regno")
                    ->join("TblKategoriPsn", "Register.Kategori", "=", "TblKategoriPsn.KdKategori")
                    ->leftJoin("TBLICD10", "Register.KdICD", "=", "TBLICD10.KDICD")
                    ->leftJoin("TBLBangsal", "FPPRI.KdBangsal", "=", "TBLBangsal.KdBangsal")
                    ->leftJoin("TBLKelas", "FPPRI.KdKelas", "=", "TBLKelas.KdKelas")
                    ->leftJoin("TBLJaminan", "Register.KdJaminan", "=", "TBLJaminan.KDJaminan")
                    ->leftJoin("TBLAsalpasien", "Register.KdRujuk", "=", "TBLAsalpasien.KDApasien")
                    ->leftJoin("TBLPerusahaan", "Register.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
                    ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
                    ->leftJoin("TBLTpengobatan", "Register.KdTuju", "=", "TBLTpengobatan.KDTuju")
                    ->leftJoin("MasterPS", "FPPRI.Medrec", "=", "MasterPS.Medrec")
                    ->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli")
                    ->leftJoin("FtDokter", "Register.KdDoc", "=", "FtDokter.KdDoc")
                    ->where("FPPRI.Regno",$regno)
                    ->orderBy("Register.Regdate", "DESC")->first();
        return $data;
    }

    public function get_one_bpjs($regno)
    {
        $data = $this->select(DB::connection('main')->raw("Fppri.Regno, Fppri.Medrec, Fppri.Firstname, Fppri.Sex, Register.KdSex, Fppri.AsalRujuk, fppri.jtkdkelas,
                                       TBLcarabayar.NMCbayar, Register.KdTuju, TBLTpengobatan.NMTuju, Fppri.Regtime, Register.UmurThn,
                                       Register.UmurBln, Register.UmurHari, TBLPerusahaan.NMPerusahaan, Fppri.KdRujuk, Register.KdKasus,
                                       TBLAsalpasien.NMApasien, Register.GroupUnit, Register.NmUnit, Register.Pisat, Register.nikktp,
                                       Fppri.NoRujuk, Register.NoKontrol, MasterPS.Phone, TBLICD10.DIAGNOSA, Register.PoliEksekutif, 
                                       Register.Katarak, Register.TglKejadian, Register.Suplesi, Register.NoSuplesi, Register.Bod, 
                                       Fppri.kdrujukan, Fppri.nmrujukan, Register.KdPoli, Fppri.nokamar, Fppri.NoTTidur,
                                       POLItpp.NMPoli,Register.NomorUrut, Fppri.KdIcd, Register.KdJaminan, Fppri.KdKelas, TBLKelas.NMKelas,
                                       Fppri.KdCbayar, TBLJaminan.NMJaminan, Register.AtasNama, Fppri.KdBangsal, TBLBangsal.NmBangsal,
                                       Register.KdPerusahaan, Fppri.NoPeserta, Fppri.Regdate, Fppri.KdDocRs, Fppri.Keterangan, Fppri.KdDocRS,
                                       Fppri.StatPeserta, Fppri.NmRefPeserta, Fppri.KdRefPeserta, Fppri.nosep, Fppri.notifsep,
                                       FtDokter.NmDoc, Fppri.Kategori, TblKategoriPsn.NmKategori, Fppri.TglRujuk, Register.ValidUser,
                                       Fppri.KdDocRawat, Fppri.NmDocRS, Fppri.jtnmkelas, Fppri.catatan"))
                    ->join("TblKategoriPsn", "Fppri.Kategori", "=", "TblKategoriPsn.KdKategori")
                    ->join("Register", "Fppri.Regno", "=", "Register.Regno")
                    ->leftJoin("TBLICD10", "Fppri.KdICD", "=", "TBLICD10.KDICD")
                    ->leftJoin("TBLBangsal", "Fppri.KdBangsal", "=", "TBLBangsal.KdBangsal")
                    ->leftJoin("TBLKelas", "Fppri.KdKelas", "=", "TBLKelas.KdKelas")
                    ->leftJoin("TBLJaminan", "Fppri.KdJaminan", "=", "TBLJaminan.KDJaminan")
                    ->leftJoin("TBLAsalpasien", "Register.KdRujuk", "=", "TBLAsalpasien.KDApasien")
                    ->leftJoin("TBLPerusahaan", "Fppri.KdPerusahaan", "=", "TBLPerusahaan.KDPerusahaan")
                    ->leftJoin("TBLcarabayar", "Register.KdCbayar", "=" , "TBLcarabayar.KDCbayar")
                    ->leftJoin("TBLTpengobatan", "Fppri.KdTuju", "=", "TBLTpengobatan.KDTuju")
                    ->leftJoin("MasterPS", "Fppri.Medrec", "=", "MasterPS.Medrec")
                    ->leftJoin("POLItpp", "Fppri.KdPoli", "=", "POLItpp.KDPoli")
                    ->leftJoin("FtDokter", "Fppri.KdDocRawat", "=", "FtDokter.KdDoc")
                    ->where("Fppri.Regno",$regno)->first();
        return $data;
    }


    public function mutasi_bpjs($regno = '', $medrec = '', $nama = '', $date1 = '', $date2 = '')
    {
        $data = $this->select(DB::connection('main')->raw("fppri.regno, fppri.medrec, fppri.firstname, fppri.regdate, fppri.nosep, fppri.kdicd, fppri.sex, tblcarabayar.nmcbayar, ftdokter.nmdoc, tblbangsal.nmbangsal, tblkelas.nmkelas, fppri.kategori, fppri.validuser"))
        ->leftJoin("register", "fppri.regno", "=", "register.regno")
        ->leftJoin("tblbangsal", "fppri.kdbangsal", "=", "tblbangsal.kdbangsal")
        ->leftJoin("tblkelas", "fppri.kdkelas", "=", "tblkelas.kdkelas")
        ->leftJoin("tblcarabayar", "fppri.kdcbayar", "=", "tblcarabayar.kdcbayar")
        ->leftJoin("ftdokter", "fppri.kddocrawat", "=", "ftdokter.kddoc")
        ->whereNull("fppri.deleted")
        ->where("fppri.kategori", ">=" ,"2")
        // ->where("fppri.kdcbayar", "!=", "01")
        // ->where("fppri.kategori", "!=" ,"3")
        ->where("fppri.regdate", '<=', date('Y-m-d H:i:s'));
        if($regno != ''){ $data->where("fppri.regno", "like", "%".$regno."%"); }
        if($medrec != ''){ $data->where("fppri.medrec", "like", "%".$medrec."%"); }
        if($nama != ''){ $data->where("fppri.firstname", "like", "%".$nama."%"); }
        if($date1 != ''){ $data->where("fppri.regdate", ">=" ,$date1); }
        if($date2 != ''){ $data->where("fppri.regdate", "<=" ,$date2); }
        $data = $data->orderBy("fppri.regdate","desc")->paginate(15);
        return $data;
    }

    public function cek_mutasi_pasien($regno)
    {
        $data = $this->selectRaw("Fppri.Regno, Fppri.Medrec, Fppri.Firstname, Fppri.Sex, Fppri.KdSex, Fppri.KdTuju, 
                        Fppri.KdPoli, POLItpp.NMPoli, Fppri.Regdate, Fppri.KdDocRS, FtDokter.NmDoc, Fppri.Kategori, TblKategoriPsn.NmKategori, Fppri.ValidUser")
                ->join("TblKategoriPsn", "Fppri.Kategori", "=", "TblKategoriPsn.KdKategori")
                ->leftJoin("POLItpp", "Fppri.KdPoli", "=", "POLItpp.KDPoli")
                ->leftJoin("FtDokter", "Fppri.KdDocRS", "=", "FtDokter.KdDoc")
                ->whereNull('Fppri.Deleted')
                ->where("Fppri.Regno",$regno)
                ->first();
        return $data;
    }
}
