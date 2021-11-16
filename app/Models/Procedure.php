<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Procedure extends DBpass
{
    // Master Pasien
    public static function stpnet_AddMasterPasien_REGxhos(array $data)
    {   
        $data = (object) $data;
        $tanggaldaftar = date('Y-m-d H:m:s');
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $qString = "EXEC stpnet_AddMasterPasien_REGxhos
                                    @medrec = '$data->Medrec',
                                    @firstname = '$data->Firstname',
                                    @pod = '$data->Pod',
                                    @bod = '$data->Bod',
                                    @umurthn = '$data->UmurThn',
                                    @umurbln = '$data->UmurBln',
                                    @sex = '$sex',
                                    @goldarah = '$data->GolDarah',
                                    @rhdarah = '$data->RHDarah',
                                    @warganegara = '$data->WargaNegara',
                                    @noiden = '$data->NoIden',
                                    @perkawinan = '$data->Perkawinan',
                                    @agama = '$data->Agama',
                                    @pendidikan = '$data->Pendidikan',
                                    @namaayah = '$data->NamaAyah',
                                    @namaibu = '$data->NamaIbu',
                                    @askesno = '$data->NoPeserta',
                                    @tgldaftar = '$tanggaldaftar',
                                    @address = '$data->Alamat',
                                    @city = '$data->NmKabupaten',
                                    @propinsi = '$data->NmProvinsi',
                                    @kecamatan = '$data->NmKecamatan',
                                    @kelurahan = '$data->NmKelurahan',
                                    @kdpos = '$data->KdPos',
                                    @phone = '$data->Phone',
                                    @kategori = '$data->Kategori',
                                    @nmunit = '$data->Unit',
                                    @nrpnip = '$data->Nrp',
                                    @nmkesatuan = '$data->NmKesatuan',
                                    @nmgol = '$data->NmGol',
                                    @nmpangkat = '$data->NmPangkat',
                                    @pekerjaan = '$data->Pekerjaan',
                                    @nmkorp = '$data->NmKorp',
                                    @namapj = '$data->NamaPJ',
                                    @hubunganpj = '$data->HungunganPJ',
                                    @pekerjaanpj = '$data->PekerjaanPJ',
                                    @phonepj = '$data->PhonePJ',
                                    @alamatpj = '$data->AlamatPJ',
                                    @validuser = '$validuser',
                                    @GroupUnit = '$data->GroupUnit',
                                    @GroupPangkat = '$data->GroupPangkat',
                                    @StatusKelDinas = '',
                                    @NamaKelDinas = '$data->NamaKelDinas',
                                    @kdkelurahan = '$data->Kelurahan',
                                    @nmsuku = '$data->Suku',
                                    @kdsex = '$data->KdSex',
                                    @umurhr = '$data->UmurHari',
                                    @keyakinan = '$data->KdNilai',
                                    @subunit = '$data->korpUnit',
                                    @cotomatis = '',
                                    @regnumber = ''";
        $up = DB::connection('main')->statement($qString);
        return $up;
    }

    public static function stpnet_DeletePasien_REGxhos($medrec)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $qString = "EXEC stpnet_DeletePasien_REGxhos
                            @cmedrec = '$medrec',
                            @cvaliduser = '$validuser'";
        $up = DB::connection('main')->statement($qString);
        return $up;
    }

    public static function stpnet_UpdateKategori_REGxhos(array $data)
    {
        $data = (object) $data;
        $query = "EXEC stpnet_UpdateKategori_REGxhos
            @medrec = '$data->Medrec', 
            @kategori = '$data->Kategori', 
            @nmunit = '$data->nmunit',
            @groupunit = '$data->groupunit', 
            @askesno = '$data->askesno'";
        $query = DB::connection('main')->statement($query);
        return $query;
    }

    // Pasien BPJS
    public static function stpnet_ViewRegistrasi_REGxhos(array $data)
    {
        $data = (object) $data;
        $query = "EXEC stpnet_ViewRegistrasi_REGxhos 
            @cbegindate = '$data->date1',
            @cenddate   = '$data->date2',
            @cregno     = '$data->regno',
            @cmedrec    = '$data->medrec',
            @cfirstname = '$data->nama',
            @kddoc      = '$data->dokter',
            @kdpoli     = '$data->poli',
            @kdtuju     = '$data->tujuan',
            @sdata      = '$data->sdata'";
        $up = DB::connection('main')->select($query);
        return $up;
    }

    public static function stpn_ViewKelas_INAxhos($kdKelas = '', $nmkelas = '', $sdata = '')
    {
        $qString = "EXEC stpn_ViewKelas_INAxhos
                        @kdkelas = '$kdKelas',
                        @nmkelas = '$nmkelas',
                        @sdata = '$sdata'";
        $up = DB::connection('main')->select($qString);
        return $up;
    }

    public static function stpnet_ViewBedKosong_INAxhos($data)
    {
        $data = (object) $data;
        $sp = "EXEC stpnet_ViewBedKosong_INAxhos
                @cbegindate = '',
                @cenddate = '',
                @ckdbangsal = '199'";
        $up = DB::connection('main')->statement($sp);
        return $up;
    }

    public static function stpnet_ViewNoBedBPJS_REGxhos($data)
    {
        $date = date('Y-m-d');
        $data = (object) $data;
        $sp = "EXEC stpnet_ViewNoBedBPJS_REGxhos
                @cbegindate = '$date',
                @kdkelas = '$data->kelas'";
        $up = DB::connection('main')->select($sp);
        return $up;
    }

    public function spwe_AddKeyakinanxhos(array $data)
    {
        $data = (object) $data;
        $date = date('Y-m-d H:m:s');
        $validuser = Auth::user()['NamaUser'];
        $sp = "EXEC spwe_AddKeyakinanxhos 
            @medrec = '$data->medrec',
            @phcek = '$data->phcek',
            @phnote = '$data->phnote',
            @ptcek = '$data->ptcek',
            @ptnote = '$data->ptnote',
            @pmcek = '$data->pmcek',
            @pmnote = '$data->pmnote',
            @ppcek = '$data->ppcek',
            @ppnote = '$data->ppnote',
            @lain = '$data->lain',
            @validuser = '$validuser',
            @tanggal = '$date'";
        $up = DB::connection('main')->statement($sp);
        return $up;
    }

    // Registrasi Umum
    public static function stpnet_AddNewRegistrasiUmum_REGxhos(array $data)
    {
        $data = (object) $data;
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser;
        $date = $data->Regdate.' '.date('H:i:s');
        $query = "EXEC stpnet_AddNewRegistrasiUmum_REGxhos
            @regno = '$data->Regno',
            @medrec = '$data->Medrec',
            @firstname = '$data->Firstname',
            @regdate = '$data->Regdate',
            @regtime = '$date',
            @kunjungan = '$data->Kunjungan',
            @nomorurut = '$data->NoUrut',
            @kdsex = '$data->KdSex',
            @sex = '$sex',
            @bod = '$data->Bod',
            @umurthn = '$data->UmurThn',
            @umurbln = '$data->UmurBln',
            @umurhari = '$data->UmurHari',
            @kdtuju = '$data->KdTuju',
            @kdpoli = '$data->KdPoli',
            @kddoc = '$data->kdDoc',
            @kdapasien = '$data->kdRujuk',
            @kddocrujuk = '$data->KdDocRujuk',
            @kdcbayar = '$data->KdCbayar',
            @kdjaminan = '$data->NMPenjamin',
            @kdperusahaan = '$data->NMPerusahaan',
            @nopeserta = '$data->NoPeserta',
            @atasnama = '$data->AtasNama',
            @kategori = '$data->Kategori',
            @groupunit = '$data->GroupUnit',
            @nmunit = '$data->NamaUnit',
            @statusreg = '2',
            @validuser = '$validuser',
            @perjanjian = '$data->Perjanjian',
            @idregold = '$data->id_old',
            @regnumber = 0,
            @sequalNum = 0";
        $up = DB::connection('main')->statement($query);
        return $up;
    }

    public static function stpnet_AddNewRegistrasiBPJS_REGxhos($data)
    {
        // $data = (object) $data;
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        if ($data->KdTuju == '1') {
            $data->KdTuju = 'RI';
        }
        if ($data->KdTuju == '2') {
            $data->KdTuju = 'RJ';
        }
        if ($data->KdTuju == '3') {
            $data->KdTuju = 'RM';
        }
        $validuser = Auth::user()['DisplayName'] == '' ? Auth::user()['NamaUser'] : Auth::user()['DisplayName'];
        $date = $data->Regdate.' '.$data->Regtime;
        $query = "EXEC spwe_AddNewRegistrasiBPJS_REGxhos
            @regno          = '$data->Regno',
            @medrec         = '$data->Medrec',
            @firstname      = '$data->Firstname',
            @regdate        = '$data->Regdate',
            @regtime        = '$date',
            @kdcbayar       = '$data->KdCbayar',
            @kdjaminan      = '$data->Penjamin',
            @kdperusahaan   = '',
            @nopeserta      = '$data->noKartu',
            @kdtuju         = '$data->KdTuju',
            @kdpoli         = '$data->KdPoli',
            @kdbangsal      = '',
            @kdkelas        = '',
            @nottidur       = '',
            @kddoc          = '$data->DocRS',
            @kunjungan      = '$data->Kunjungan',
            @validuser      = '$validuser',
            @sex            = '$sex',
            @umurthn        = '$data->UmurThn',
            @umurbln        = '$data->UmurBln',
            @umurhari       = '$data->UmurHari',
            @bod            = '$data->Bod',
            @nomorurut      = '$data->NomorUrut',
            @statusreg      = '1',
            @kategori       = '$data->KategoriPasien',
            @nosep          = '$data->NoSep', 
            @kdicd          = '$data->DiagAw',
            @kdsex          = '$data->KdSex',
            @groupunit      = '$data->GroupUnit',
            @kdicdbpjs      = '$data->DiagAw',
            @bodbpjs        = '$data->Bod',
            @pisat          = '$data->pisat',
            @keterangan     = '$data->Keterangan',
            @catatan        = '$data->catatan',
            @tglrujuk       = '$data->RegRujuk',
            @nokontrol      = '$data->nokontrol',
            @norujuk        = '$data->NoRujuk',
            @kdrujukan      = '$data->Ppk',
            @nmrujukan      = '$data->noPpk',
            @kdrefpeserta   = '$data->kodePeserta',
            @nmrefpeserta   = '$data->Peserta',
            @nmkelas        = '$data->JatKelas',
            @notifsep       = '$data->NotifSep',
            @kdkasus        = '$data->KasKe',
            @lokasikasus    = '',
            @nikktp         = '$data->NoIden',
            @statpeserta    = '$data->statusPeserta',
            @kdstatpeserta  = '$data->Faskes',
            @asalrujuk      = '$data->asalRujukan',
            @phone          = '$data->Notelp',
            @kdcob          = '$data->Cob',
            @nmcob          = '',
            @kdjaminanbpjs  = '$data->KategoriPasien',
            @prolanis       = '$data->Prolanis',
            @idregold       = '$data->id_old',
            @perjanjian     = '$data->Perjanjian',
            @kddpjp         = '$data->KdDPJP',
            @regnumber      = 0,
            @sequalNum      = 0";
        // dd($query);
        $up = DB::connection('main')->statement($query);
        // dd($up);
        return $up;
    }

    public static function stpnet_AddMutasiPasienBPJS_REGxhos(array $data)
    {
        $data = (object) $data;
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $query = "EXEC stpnet_AddMutasiPasienBPJS_REGxhos 
            @regno = '$data->Regno',
            @medrec = '$data->Medrec',
            @firstname = '$data->Firstname',
            @regdate = '$data->Regdate',
            @regtime = '$data->Regtime',
            @kdcbayar = '$data->KdCbayar',
            @kdjaminan = '$data->Penjamin',
            @kdperusahaan = '',
            @nopeserta = '$data->noKartu',
            @kdtuju = '$data->KdTuju',
            @kdpoli = '$data->KdPoli',
            @kdbangsal = '$data->kelas',
            @kdkelas = '$data->bangsal',
            @nokamar = '$data->Bed',
            @nottidur = '$data->TempatTidur',
            @kddocrawat = '$data->DocRawat',
            @kddocrs = '$data->DocRS',
            @nmdocrs = '$data->NmDoc',
            @jtkdkelas = '$data->JatKelas',
            @jtnmkelas = '$data->nmJatahKelas',
            @validuser = '$validuser',
            @kdsex = '$data->KdSex',
            @sex = '$sex',
            @umurthn = '$data->UmurThn',
            @umurbln = '$data->UmurBln',
            @umurhari = '$data->UmurHari',
            @bod = '$data->Bod',
            @kategori = '$data->KategoriPasien',
            @nosep = '$data->NoSep',
            @kdicd = '$data->DiagAw',
            @diagnosa = '$data->NmDiagnosa',
            @pisat = '$data->pisat',
            @keterangan = '$data->catatan',
            @tglrujuk = '$data->RegRujuk',
            @norujuk = '$data->NoRujuk',
            @kdrujukan = '$data->Ppk',
            @nmrujukan = '$data->noPpk',
            @kdrefpeserta = '$data->kodePeserta',
            @nmrefpeserta = '$data->Peserta',
            @notifsep = '$data->NotifSep',
            @kdkasus = '$data->KasKe',
            @lokasikasus = '',
            @nikktp = '$data->NoIden',
            @statpeserta = '$data->statusPeserta',
            @kdstatpeserta = '',
            @asalrujuk = '$data->asalRujukan',
            @phone = '$data->Notelp',
            @kdcob = '$data->Cob',
            @nmcob = '',
            @kdjaminanbpjs = ''";
        $up = DB::statement($query);
        return $up;
    }

    // Mutasi Registrasi Umum
    public static function stpnet_AddMutasiPasienUmum_REGxhos(array $data)
    {
        $data = (object) $data;
        $sex = $data->KdSex == 'L' ? 'Laki-laki' : 'Perempuan';
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $query = "EXEC stpnet_AddMutasiPasienUmum_REGxhos
        @regno      = '$data->Regno',
        @regdate    = '$data->Regdate',
        @regtime    = '$data->Regtime',
        @medrec     = '$data->Medrec',
        @firstname  = '$data->Firstname',
        @kategori   = '$data->Kategori',
        @kdsex      = '$data->KdSex',
        @sex        = '$sex',
        @kdcbayar   = '$data->KdCbayar',
        @kdperusahaan = '$data->NMPerusahaan',
        @kdjaminan  = '$data->NMPenjamin',
        @nopeserta  = '$data->NoPeserta',
        @tglrujuk   = '$data->TglRujuk',
        @norujuk    = '$data->NoRujuk',
        @kddocrujuk = '',
        @kddocrs    = '$data->DocRS',
        @nmdocrs    = '$data->nmDocRs',
        @kdpoli     = '$data->KdPoli',
        @kdapasien  = '',
        @kdbangsal  = '$data->Kelas',
        @kdkelas    = '$data->Bangsal',
        @nokamar    = '$data->Bed',
        @nottidur   = '$data->TempatTidur',
        @kddocrawat = '$data->Docmerawat',
        @kdicd      = '$data->Diagnosa',
        @diagnosa   = '$data->NmDiagnosa',
        @validuser  = '$validuser'";
        $up = DB::connection('main')->statement($query);
        return $up;
    }

    public static function stpnet_DeleteMutasiPasien_REGxhos(array $data)
    {
        $data = (object) $data;
        $validuser = Auth::user()->NamaUser;
        $query = "EXEC stpnet_DeleteMutasiPasien_REGxhos 
            @regno = '$data->Regno',
            @cvaliduser = '$validuser'";

        $up = DB::connection('main')->statement($query);
        return $up;
    }

    // File Status
    public static function stpnet_ViewFileStKeluar_REGxhos(array $data)
    {
        $data = (object) $data;
        $query = "EXEC stpnet_ViewFileStKeluar_REGxhos 
            @cbegindate  = '$data->date1',
            @cenddate = '$data->date2',
            @cregno = '$data->regno',
            @cmedrec = '$data->medrec',
            @cfirstname = '$data->nama',
            @ckdpoli = '$data->poli',
            @sdata = '$data->sdata'";
        $up = DB::connection('main')->select($query);
        return $up;
    }

    public static function stpnet_AddStatusKeluar_REGxhos(array $data)
    {
        $data = (object) $data;
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $query = "EXEC stpnet_AddStatusKeluar_REGxhos 
        @regno = '$data->noRegno',
        @nstatus = '$data->Status',
        @namapeminjam = '$data->NmPenjamin',
        @bagian = '$data->noBagian',
        @keterangan = '$data->keterangan',
        @validuser = '$validuser'";
        $up = DB::connection('main')->statement($query);
        return $up;
    }

    public static function stpnet_ViewFileStatusMasuk_REGxhos(array $data)
    {
        $data = (object) $data;
        $query = "EXEC stpnet_ViewFileStatusMasuk_REGxhos 
            @cbegindate = '$data->date1',
            @cenddate   = '$data->date2',
            @cregno     = '$data->regno',
            @cmedrec    = '$data->medrec',
            @cfirstname = '$data->nama',
            @sdata      = '$data->sdata'";
        $up = DB::connection('main')->select($query);
        return $up;
    }

    public static function stpnet_AddStatusMasuk_REGxhos(array $data)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $data = (object) $data;
        $query = "EXEC stpnet_AddStatusMasuk_REGxhos
        @regno          = '$data->noRegno',
        @nstatus        = '$data->Status',
        @namapeminjam   = '$data->NmPenjamin',
        @bagian         = '$data->noBagian',
        @keterangan     = '$data->keterangan',
        @validuser      = '$validuser'";
        $up = DB::connection('main')->statement($query);
        return $up;
    }

    public static function stpnet_ViewFileBlmKembali_REGxhos(array $data)
    {
        $data = (object) $data;
        $query = "EXEC stpnet_ViewFileBlmKembali_REGxhos
            @cbegindate = '$data->date1',
            @cenddate   = '$data->date2',
            @cregno     = '$data->regno',
            @cmedrec    = '$data->medrec',
            @cfirstname = '$data->nama',
            @ckdpoli    = '$data->poli',
            @sdata      = '$data->sdata'";
        $up = DB::connection('main')->select($query);
        return $up;
    }

    public static function stpnet_ViewMonitoring_REGxhos(array $data)
    {
        $data = (object) $data;
        $query = "EXEC stpnet_ViewMonitoring_REGxhos 
            @cbegindate = '$data->date1',
            @cenddate   = '$data->date2',
            @cregno     = '$data->regno',
            @cmedrec    = '$data->medrec',
            @cfirstname = '$data->nama',
            @sdata      = '$data->sdata'";
        $up = DB::connection('main')->select($query);
        return $up;
    }

    public static function stpnet_InformasiPasienRI_REGxhos(array $data)
    {
        $data = (object) $data;
        $query = "EXEC stpnet_InformasiPasienRI_REGxhos 
            @cbegindate  = '$data->date1',
            @cfirstname  = '$data->nama',
            @ckdbangsal  = '$data->bangsal',
            @calamat     = '$data->alamat',
            @cvaliduser  = '$data->user'";
        $up = DB::connection('main')->select($query);
        return $up;
    }

    public static function stpnet_NomCetakSEP_REGxhos($regno)
    {
        $query = "EXEC stpnet_NomCetakSEP_REGxhos @regno = '$regno'";
        $up = DB::connection('main')->select($query);
        return $up;
    }

    public function push_konsul($kdpoli,$regno)
    {
        $push = file_get_contents("http://192.168.136.252:81/modul_rj/api/RawatJalan/PushKonsul/$kdpoli/$regno");
        return $push;
    }

    public function push_mutasi($data)
    {
        $url = 'http://192.168.136.252:81/modul_rawat_inap/api/push_mutasi';
        $data = json_encode($data);
        $headers = [
            'Content-Type: Application/x-www-form-urlencoded'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
