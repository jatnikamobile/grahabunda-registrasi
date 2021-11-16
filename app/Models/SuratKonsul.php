<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class SuratKonsul  extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'AwSuratKonsul';
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

    public function get_list($medrec = '',$nama = '')
    {
        $tgl=date('Y-m-d');
        $data = $this->select(DB::connection('main')->raw("POLItpp.NMPoli, AwSuratKonsul.NoSuratKonsul as NoSurat, AwSuratKonsul.Regno, Register.Medrec, Register.Firstname, '-' as Norujukan, AwSuratKonsul.TanggalKonsul as TanggalSurat, AwSuratKonsul.TanggalSuratKonsul as TanggalRujukan "))
                     ->leftJoin("POLItpp", "POLItpp.KDPoli", "=", "AwSuratKonsul.KdPoliTuju")
                     ->leftJoin("Register", "Register.Regno", "=", "AwSuratKonsul.Regno");
        if($medrec != ''){ $data->where("Register.Medrec", "like", "%".$medrec."%"); }
        if($nama != ''){ $data->where("Register.Firstname", "like", "%".$nama."%"); }
        if ($medrec == '' && $nama == '') {
            $data->where("AwSuratKonsul.TanggalKonsul",$tgl);
        }
        $data = $data->orderBy("NoSuratKonsul","DESC")->orderBy("TanggalKonsul","DESC")->paginate(5);
        // dd($data);
        return $data;
    }

    public function find_konsul($noSurat)
    {
        $data = $this->select(DB::connection('main')->raw("AwSuratKonsul.NoSuratKonsul as NoSurat, Register.Medrec, Register.Firstname,Register.NoRujuk, MasterPS.TglDaftar, MasterPS.Address, MasterPS.Pod, MasterPS.Bod, MasterPS.Sex, MasterPS.KdPos, MasterPS.KdSex, MasterPS.Kategori, MasterPS.Phone, MasterPS.ValidUser, TblKategoriPsn.NmKategori, MasterPS.AskesNo, AwSuratKonsul.TanggalKonsul as TanggalRujukan, AwSuratKonsul.TanggalSuratKonsul as TanggalSurat, AwSuratKonsul.KdPoliTuju as KdPoli, POLItpp.NMPoli, AwSuratKonsul.KdDocTuju as KdDoc, FtDokter.NmDoc, AwSuratKonsul.KdICD as Diagnosa, ' - ' as NoAntri, Register.KdICD, TBLICD10.DIAGNOSA, MasterPS.Address, MasterPS.Pod, MasterPS.Bod, MasterPS.Sex, MasterPS.KdSex, MasterPS.GolDarah, MasterPS.RHDarah, MasterPS.WargaNegara, MasterPS.NoIden, MasterPS.Perkawinan, MasterPS.Agama, MasterPS.Pendidikan, MasterPS.NamaAyah, MasterPS.NamaIbu, MasterPS.AskesNo, MasterPS.NmUnit, MasterPS.TglDaftar, MasterPS.City, MasterPS.Propinsi, MasterPS.Kecamatan, MasterPS.Kelurahan, MasterPS.KdPos, MasterPS.NrpNip, MasterPS.NmKesatuan, MasterPS.NmGol, MasterPS.NmPangkat, MasterPS.Pekerjaan, MasterPS.NmKorp, MasterPS.NamaPJ, MasterPS.HubunganPJ, MasterPS.PekerjaanPJ, MasterPS.AlamatPJ, MasterPS.PhonePJ,MasterPS.GroupPangkat, MasterPS.StatusKelDinas, MasterPS.NamaKelDinas, MasterPS.ValidUser, MasterPS.KdKelurahan, MasterPS.NmSuku, MasterPS.UmurThn, MasterPS.UmurBln, MasterPS.UmurHr,MasterPS.Keyakinan, MasterPS.GroupUnit, MasterPS.Kategori, MasterPS.Phone, TblKategoriPsn.NmKategori, MasterPS.SubUnit, fKeyakinan.phcek, fKeyakinan.phnote, fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, fKeyakinan.pmnote, fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain"))
                     ->join("Register", "AwSuratKonsul.Regno", "=", "Register.Regno")
                     ->join("MasterPS", "Register.Medrec", "=", "MasterPS.Medrec")
                     ->leftJoin("fKeyakinan", "MasterPS.Medrec", "=", "fKeyakinan.medrec")
                     ->leftJoin("TblKategoriPsn", "MasterPS.Kategori", "=", "TblKategoriPsn.KdKategori")
                     ->leftJoin("POLItpp", "AwSuratKonsul.KdPoliTuju", "=", "POLItpp.KDPoli")
                     ->leftJoin("FtDokter", "AwSuratKonsul.KdDocTuju", "=", "FtDokter.KdDoc")
                     ->leftJoin("TBLICD10", "AwSuratKonsul.KdICD", "=", "TBLICD10.KDICD")
                     ->whereNull("MasterPS.McuInstansi")
                     ->whereNull("MasterPS.Deleted")
                     ->where("NoSuratKonsul","like", $noSurat."%")
                     ->orderBy('TanggalSuratKonsul', 'DESC')->first();
        return $data;
    }
}
