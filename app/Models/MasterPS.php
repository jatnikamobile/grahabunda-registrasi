<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class MasterPS extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'MasterPS';
        // Table Primary Key
        $this->primaryKey = 'Medrec';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        // $this->fillable = ['Medrec'];
        // 
        // $this->hidden = [];
    }

    public function generateMedrec()
    {
        $last_data = $this->where('Medrec', 'like', 'P%')->orderBy('Medrec', 'desc')->first();

        $last_medrec = $last_data ? $last_data->Medrec : null;
        $last_medrec_length = $last_medrec ? strlen($last_medrec) : 0;

        if (!$last_data || $last_medrec_length < 9) {
            $last_data = $this->where('Medrec', 'P10000001')->first();

            if ($last_data) {
                $medrec = str_replace('P', '', $last_data->Medrec);
                $next_regno = $medrec + 1;
                while ($this->where('Medrec', 'P' . str_pad($next_regno, 8, '0', STR_PAD_LEFT))->first()) {
                    $next_regno = $next_regno + 1;
                }
    
                return 'P' . str_pad($next_regno, 8, '0', STR_PAD_LEFT);
            }
            return 'P10000001';
        } else {
            $medrec = str_replace('P', '', $last_data->Medrec);
            $next_regno = $medrec + 1;
            while ($this->where('Medrec', 'P' . str_pad($next_regno, 8, '0', STR_PAD_LEFT))->first()) {
                $next_regno = $next_regno + 1;
            }

            return 'P' . str_pad($next_regno, 8, '0', STR_PAD_LEFT);
        }
    }

    public function get_list($medrec = '', $notelp = '', $nama = '', $alamat = '', $nopeserta = '' ,$tgl_lahir = '', $date1 = '', $date2 = '')
    {
        $data = $this->select(DB::connection('main')->raw("MasterPS.Medrec, MasterPS.Firstname, MasterPS.TglDaftar, MasterPS.Address,
                                        MasterPS.Pod, MasterPS.Bod, MasterPS.Sex, MasterPS.KdPos, MasterPS.KdSex,
                                        MasterPS.Kategori, MasterPS.Phone, MasterPS.ValidUser, TblKategoriPsn.NmKategori"))
                     ->leftJoin("TblKategoriPsn", "MasterPS.Kategori", "=", "TblKategoriPsn.KdKategori")
                     ->whereNull("McuInstansi")
                     ->whereNull("Deleted");
        if($medrec != ''){ $data->where("MasterPS.Medrec", "like", "%".$medrec."%"); }
        if($notelp != ''){ $data->where("MasterPS.Phone", "like", "%".$notelp."%"); }
        if($nama != ''){ $data->where("MasterPS.Firstname", "like", "%".$nama."%"); }
        if($alamat != ''){ $data->where("MasterPS.Address", "like", "%".$alamat."%"); }
        if($nopeserta != ''){ $data->where("MasterPS.AskesNo", "like", "%".$nopeserta."%"); }
        if($tgl_lahir != ''){ $data->where("MasterPS.Bod", $tgl_lahir); }
        if($date1 != ''){ $data->where("MasterPS.TglDaftar", ">=" ,$date1); }
        if($date2 != ''){ $data->where("MasterPS.TglDaftar", "<=" ,date("Y-m-d", strtotime("+1 day", strtotime($date2)))); }
        $data = $data->orderBy("Medrec","DESC")->orderBy("TglDaftar","DESC")->paginate(15);
        // dd($data);
        return $data;
    }

    public function get_list_bpjs($medrec = '', $notelp = '', $nama = '', $alamat = '', $nopeserta = '',$tgl_lahir = '', $date1 = '', $date2 = '')
    {        
        $data = $this->select(DB::connection('main')->raw("MasterPS.Medrec, MasterPS.Firstname, MasterPS.Address, MasterPS.Pod, MasterPS.Bod,
                                        MasterPS.Sex, MasterPS.KdSex, MasterPS.GolDarah, MasterPS.RHDarah, MasterPS.WargaNegara,
                                        MasterPS.NoIden, MasterPS.Perkawinan, MasterPS.Agama, MasterPS.Pendidikan, MasterPS.NamaAyah,
                                        MasterPS.NamaIbu, MasterPS.AskesNo, MasterPS.NmUnit, MasterPS.TglDaftar, MasterPS.City,
                                        MasterPS.Propinsi, MasterPS.Kecamatan, MasterPS.Kelurahan, MasterPS.KdPos, MasterPS.NrpNip,
                                        MasterPS.NmKesatuan, MasterPS.NmGol, MasterPS.NmPangkat, MasterPS.Pekerjaan, MasterPS.NmKorp,
                                        MasterPS.NamaPJ, MasterPS.HubunganPJ, MasterPS.PekerjaanPJ, MasterPS.AlamatPJ,
                                        MasterPS.PhonePJ,MasterPS.GroupPangkat, MasterPS.StatusKelDinas, MasterPS.NamaKelDinas,
                                        MasterPS.ValidUser, MasterPS.KdKelurahan, MasterPS.NmSuku, MasterPS.UmurThn, MasterPS.UmurBln, 
                                        MasterPS.UmurHr,MasterPS.Keyakinan, MasterPS.GroupUnit, MasterPS.Kategori, 
                                        MasterPS.Phone, TblKategoriPsn.NmKategori"))
                     ->leftJoin("TblKategoriPsn", "MasterPS.Kategori", "=", "TblKategoriPsn.KdKategori")
                     ->whereNull("Deleted");
        if($medrec != ''){ $data->where("MasterPS.Medrec", "like", "%".$medrec."%"); }
        if($notelp != ''){ $data->where("MasterPS.Phone", "like", "%".$notelp."%"); }
        if($nama != ''){ $data->where("MasterPS.Firstname", "like", "%".$nama."%"); }
        if($nopeserta != ''){ $data->where("MasterPS.AskesNo", "like", "%".$nopeserta."%"); }
        if($alamat != ''){ $data->where("MasterPS.Address", "like", "%".$alamat."%"); }
        if($tgl_lahir != ''){ $data->where("MasterPS.Bod", $tgl_lahir); }
        if($date1 != ''){ $data->where("MasterPS.TglDaftar", ">=" ,$date1); }
        if($date2 != ''){ $data->where("MasterPS.TglDaftar", "<=" ,$date2); }
        $data = $data->orderBy("TglDaftar","DESC")->paginate(10);

        return $data;
    }

    public function get_one($medrec)
    {
        $data = $this->select(DB::connection('main')->raw("MasterPS.Medrec, MasterPS.Firstname, MasterPS.Address, MasterPS.Pod, MasterPS.Bod,
                                        MasterPS.Sex, MasterPS.KdSex, MasterPS.GolDarah, MasterPS.RHDarah, MasterPS.WargaNegara,
                                        MasterPS.NoIden, MasterPS.Perkawinan, MasterPS.Agama, MasterPS.Pendidikan, MasterPS.NamaAyah,
                                        MasterPS.NamaIbu, MasterPS.AskesNo, MasterPS.NmUnit, MasterPS.TglDaftar, MasterPS.City,
                                        MasterPS.Propinsi, MasterPS.Kecamatan, MasterPS.Kelurahan, MasterPS.KdPos, MasterPS.NrpNip,
                                        MasterPS.NmKesatuan, MasterPS.NmGol, MasterPS.NmPangkat, MasterPS.Pekerjaan, MasterPS.NmKorp,
                                        MasterPS.NamaPJ, MasterPS.HubunganPJ, MasterPS.PekerjaanPJ, MasterPS.AlamatPJ,
                                        MasterPS.PhonePJ,MasterPS.GroupPangkat, MasterPS.StatusKelDinas, MasterPS.NamaKelDinas,
                                        MasterPS.ValidUser, MasterPS.KdKelurahan, MasterPS.NmSuku, MasterPS.UmurThn, MasterPS.UmurBln, 
                                        MasterPS.UmurHr,MasterPS.Keyakinan, MasterPS.GroupUnit, MasterPS.Kategori, 
                                        MasterPS.Phone, TblKategoriPsn.NmKategori, MasterPS.SubUnit, fKeyakinan.phcek, fKeyakinan.phnote, fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, fKeyakinan.pmnote, fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain"))
                        ->leftJoin("TblKategoriPsn", "MasterPS.Kategori", "=", "TblKategoriPsn.KdKategori")
                        ->leftJoin("fKeyakinan", "MasterPS.Medrec", "=", "fKeyakinan.medrec")
                        ->leftJoin("TBLSuku", "MasterPS.NmSuku", "=", "TBLSuku.NmSuku")
                        ->leftJoin("TBLAgama", "MasterPS.Agama", "=", "TBLAgama.NmAgama")
                        ->leftJoin("TBLPendidikan", "MasterPS.Pendidikan", "=", "TBLPendidikan.NmDidik")
                        ->leftJoin("TBLGroupUnit", "MasterPS.GroupUnit", "=", "TBLGroupUnit.GroupUnit")
                        ->leftJoin("TBLUnitKategori", "MasterPS.NmUnit", "=", "TBLUnitKategori.NmUnit")
                        ->leftJoin("TBLKesatuan", "MasterPS.NmKesatuan", "=", "TBLKesatuan.NmKeSatuan")
                        ->leftJoin("TBLPangkat", "MasterPS.NmPangkat", "=", "TBLPangkat.NmPangkat")
                        ->leftJoin("TBLGolongan", "MasterPS.NmGol", "=", "TBLGolongan.NAMAGOL")
                        ->leftJoin("TBLPekerjaan", "MasterPS.Pekerjaan", "=", "TBLPekerjaan.NmKerja")
                        ->leftJoin("TBLKorp", "MasterPS.NmKorp", "=", "TBLKorp.NmKorp")
                        ->leftJoin("TBLPropinsi", "MasterPS.Propinsi", "=", "TBLPropinsi.NmPropinsi")
                        ->leftJoin("TBLKabupaten", "MasterPS.City", "=", "TBLKabupaten.NmKabupaten")
                        ->leftJoin("TBLKecamatan", "MasterPS.Kecamatan", "=", "TBLKecamatan.NmKecamatan")
                        ->leftJoin("TBLKelurahan", "MasterPS.Kelurahan", "=", "TBLKelurahan.NmKelurahan")
                        ->whereNull("Deleted")
                        ->where("MasterPS.Medrec",$medrec)->first();
        return $data;
    }

    public function get_kategori_pasien($medrec)
    {
        $data = $this->select(DB::connection('main')->raw("MasterPS.Medrec, MasterPS.Firstname, MasterPS.NmUnit, MasterPS.GroupUnit, MasterPS.Kategori, TblKategoriPsn.NmKategori, MasterPS.SubUnit"))
                        ->leftJoin("TblKategoriPsn", "MasterPS.Kategori", "=", "TblKategoriPsn.KdKategori")
                        ->whereNull("Deleted")
                        ->where("MasterPS.Medrec", $medrec)->first();
        return $data;
    }

    public function update_umum(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'Bod' => $data->Bod,
                'UmurThn' => $data->UmurThn,
                'UmurBln' => $data->UmurBln,
                'UmurHr' => $data->UmurHari,
                'AskesNo' => $data->NoPeserta,
                'Kategori' => $data->Kategori,
                'NmUnit' => $data->NamaUnit,
                'GroupUnit' => $data->GroupUnit
            ]);
        return $data;
    }

    public function update_umum_mutasi(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'AskesNo' => $data->NoPeserta,
                'Kategori' => $data->Kategori
            ]);
        return $data;
    }

    public function update_bpjs(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'Bod' => $data->Bod,
                'AskesNo' => $data->noKartu,
                'NoIden' => $data->NoIden,
                'UmurThn' => $data->UmurThn,
                'UmurBln' => $data->UmurBln,
                'UmurHr' => $data->UmurHari,
                'Kategori' => $data->KategoriPasien,
                'Phone' => $data->Notelp,
                'Keyakinan' => $data->Keyakinan
            ]);
        return $data;
    }
	
	public function update_bpjs_reg(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'Bod' => $data->Bod,
                'AskesNo' => $data->noKartu,
                'NoIden' => $data->NoIden,
                'UmurThn' => $data->UmurThn,
                'UmurBln' => $data->UmurBln,
                'UmurHr' => $data->UmurHari,
                'Phone' => $data->Notelp,
                'Keyakinan' => $data->Keyakinan,
                'Kategori' => $data->KategoriPasien
            ]);
        return $data;
    }

    public function khusus_validuser($nama)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $data = DB::connection('main')->table('MasterPS')->where('Firstname', 'like', '%'.$nama.'%')->orderBy('TglDaftar', 'desc')->first();
        $val = $data->Medrec;
        $update = DB::connection('main')->table('MasterPS')->where('Medrec', $val)->update(['ValidUser' => $validuser]);
        return $data;
    }
}
