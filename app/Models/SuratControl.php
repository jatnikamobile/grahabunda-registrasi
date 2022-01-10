<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class SuratControl extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'AwSuratKontrolHead';
        // Table Primary Key
        $this->primaryKey = 'NoSurat';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function find_nosurat($noSurat)
    {
    	$data = $this->select(DB::connection('main')->raw("AwSuratKontrolHead.NoSurat, AwSuratKontrolHead.Medrec, AwSuratKontrolHead.Firstname, MasterPS.TglDaftar, MasterPS.Address, MasterPS.Pod, MasterPS.Bod, MasterPS.Sex, MasterPS.KdPos, MasterPS.KdSex, MasterPS.Kategori, MasterPS.Phone, MasterPS.ValidUser, TblKategoriPsn.NmKategori, MasterPS.AskesNo, AwSuratKontrolHead.NoRujukan, AwSuratKontrolHead.TanggalRujukan, AwSuratKontrolHead.TanggalSurat, AwSuratKontrolHead.KdPoli, POLItpp.NMPoli, AwSuratKontrolHead.KdDoc, FtDokter.NmDoc, AwSuratKontrolHead.Diagnosa, AwSuratKontrolHead.NoAntri, Register.KdICD, TBLICD10.DIAGNOSA, MasterPS.Address, MasterPS.Pod, MasterPS.Bod, MasterPS.Sex, MasterPS.KdSex, MasterPS.GolDarah, MasterPS.RHDarah, MasterPS.WargaNegara, MasterPS.NoIden, MasterPS.Perkawinan, MasterPS.Agama, MasterPS.Pendidikan, MasterPS.NamaAyah, MasterPS.NamaIbu, MasterPS.AskesNo, MasterPS.NmUnit, MasterPS.TglDaftar, MasterPS.City, MasterPS.Propinsi, MasterPS.Kecamatan, MasterPS.Kelurahan, MasterPS.KdPos, MasterPS.NrpNip, MasterPS.NmKesatuan, MasterPS.NmGol, MasterPS.NmPangkat, MasterPS.Pekerjaan, MasterPS.NmKorp, MasterPS.NamaPJ, MasterPS.HubunganPJ, MasterPS.PekerjaanPJ, MasterPS.AlamatPJ, MasterPS.PhonePJ,MasterPS.GroupPangkat, MasterPS.StatusKelDinas, MasterPS.NamaKelDinas, MasterPS.ValidUser, MasterPS.KdKelurahan, MasterPS.NmSuku, MasterPS.UmurThn, MasterPS.UmurBln, MasterPS.UmurHr,MasterPS.Keyakinan, MasterPS.GroupUnit, MasterPS.Kategori, MasterPS.Phone, TblKategoriPsn.NmKategori, MasterPS.SubUnit, fKeyakinan.phcek, fKeyakinan.phnote, fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, fKeyakinan.pmnote, fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain"))
                     ->join("MasterPS", "AwSuratKontrolHead.Medrec", "=", "MasterPS.Medrec")
                     ->join("Register", "AwSuratKontrolHead.Regno", "=", "Register.Regno")
                     ->leftJoin("fKeyakinan", "MasterPS.Medrec", "=", "fKeyakinan.medrec")
                     ->leftJoin("TblKategoriPsn", "MasterPS.Kategori", "=", "TblKategoriPsn.KdKategori")
                     ->leftJoin("POLItpp", "AwSuratKontrolHead.KdPoli", "=", "POLItpp.KDPoli")
                     ->leftJoin("FtDokter", "AwSuratKontrolHead.KdDoc", "=", "FtDokter.KdDoc")
                     ->leftJoin("TBLICD10", "Register.KdICD", "=", "TBLICD10.KDICD")
                     ->whereNull("MasterPS.McuInstansi")
                     ->whereNull("MasterPS.Deleted")->where("AwSuratKontrolHead.NoSurat", $noSurat)->first();
        return $data;
    }

    public function get_list($medrec = '',$nama = '')
    {
        $tgl=date('Y-m-d');
        $data = $this->select(DB::connection('main')->raw("POLItpp.NMPoli, AwSuratKontrolHead.NoSurat, AwSuratKontrolHead.Regno, AwSuratKontrolHead.Medrec, AwSuratKontrolHead.Firstname, AwSuratKontrolHead.Norujukan, AwSuratKontrolHead.TanggalRujukan, AwSuratKontrolHead.TanggalSurat, AwSuratKontrolHead.no_surat_kontrol_bpjs"))
                     ->leftJoin("POLItpp", "POLItpp.KDPoli", "=", "AwSuratKontrolHead.KdPoli");
        if($medrec != ''){ $data->where("AwSuratKontrolHead.Medrec", "like", "%".$medrec."%"); }
        if($nama != ''){ $data->where("AwSuratKontrolHead.Firstname", "like", "%".$nama."%"); }
        if ($medrec == '' && $nama == '') {
            $data->where("AwSuratKontrolHead.TanggalSurat",$tgl);
        }
        $data = $data->orderBy("NoSurat","DESC")->orderBy("CreateAt","DESC")->paginate(5);
        // dd($data);
        return $data;
    }
}
