<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use App\Bridging\VClaim;

use App\Models\TBLICD10;
use App\Models\Refppk;
use App\Models\POLItpp;
use App\Models\FtDokter;
use App\Models\RujukanBPJS;
use App\Models\Fppri;
use App\Models\MasterPS;
use App\Models\Procedure;
use App\Models\Register;
use App\Models\fPSEP01;
use App\Models\SuratControl;
use App\Models\StoredProcedures;
use App\Models\Bridging_bpjs;
use App\Models\SuratKonsul;
use App\Models\Radiologi;
use App\Models\Laboratorium;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrasiBpjsController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:dbpass');
    }

    // PENDAFTARAN PASIEN BPJS
    public function daftar_index(Request $request)
    {
        $regno = $request->input('Regno') !== null ? $request->input('Regno') : '';
        $medrec = $request->input('Medrec') !== null ? $request->input('Medrec') : '';
        $nama = $request->input('Firstname') !== null ? $request->input('Firstname') : '';
        $poli = $request->input('Poli') !== null ? $request->input('Poli') : '';
        $dokter = $request->input('Dokter') !== null ? $request->input('Dokter') : '';
        $tujuan = $request->input('Tujuan') !== null ? $request->input('Tujuan') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $register = new Register();
        
        $list = $register->get_all_bpjs($regno, $medrec, $nama, $poli, $dokter, $tujuan, $date1, $date2);

        $parse = [
            'list' => $list,
            'total' => count($list)
        ];
        return view('registrasi-bpjs.daftar-pasien.index',$parse);
    }

    public function daftar_form($regno = null)
    {
        $parse['group_unit'] = [];
        $parse['unit'] = [];
        $parse['kategori_psn'] = [];
        $parse['cara_bayar'] = [];
        $parse['poli'] = [];
        $parse['kelas'] = [];
        $parse['diagnosa'] = [];
        $parse['prov'] = [];
        $parse['dokter'] = [];
        // $regno = $request->input("Regno");
        if ($regno !== null){
            $register = new Register();
            $data = $register->get_one($regno);
            $parse['edit'] = $data;
        }
        // dd($parse);
        return view('registrasi-bpjs.daftar-pasien.form',$parse);
    }

    public function find_pasien(Request $request)
	{
		$medrec = $request->input("medrec");
		$notelp = $request->input("notelp");
		$nama = $request->input("nama");
		$alamat = $request->input("alamat");
		$nopeserta = $request->input("nopeserta");
		$tgl_lahir = $request->input("tgl_lahir");
		$date1 = $request->input("date1");
		$date2 = $request->input("date2");
		$pasien = new MasterPS();
        $data = $pasien->get_list($medrec, $notelp, $nama, $alamat, $nopeserta, $tgl_lahir, $date1, $date2);
        $parse = array(
            'list'=> $data,
        );
        return view('registrasi-bpjs.daftar-pasien.form-cari-pasien',$parse);
    }

    public function find_nosurat(Request $request)
    {
        $nosurat = $request->nosurat;
        $surat = new SuratControl();
        $data = $surat->find_nosurat($nosurat);
        return $data;
    }

    public function find_konsul(Request $request)
    {
        $nosurat = $request->nosurat;
        $surat = new SuratKonsul();
        $data = $surat->find_konsul($nosurat);
        return $data;
    }

    public function find_rujukrad(Request $request)
    {
        $nosurat = $request->nosurat;
        $surat = new Radiologi();
        $data = $surat->find_rujukan($nosurat);
        return $data;
    }

    public function find_rujuklab(Request $request)
    {
        $nosurat = $request->nosurat;
        $surat = new Laboratorium();
        $data = $surat->find_rujukan($nosurat);
        return $data;
    }

    public function up_radiologi(Request $request)
    {
        $surat = new Radiologi();
        $param = array(
                'notrans'=>$request->notrans, 'regno'=>$request->regno,
                'rad'=>$surat->find_rujukan($request->notrans)
                );
        $data = StoredProcedures::stp_UpdateRadiologiAcc_REGxhos($param);
        $rad = $surat->UpdateAcc($request->notrans);
        return response()->json($data); 
    }

    public function up_laboratorium(Request $request)
    {
        $surat = new Laboratorium();
        // $push = file_get_contents("http://localhost:8080/lab_umum/Registrasi/updatelab/$request->notrans/$request->regno");
        $push = file_get_contents("http://192.168.136.252:81/rsau-lab/Registrasi/updatelab/$request->notrans/$request->regno");
        $push= json_decode($push, true);
         if ($push['NoTran'] != '') {
            $lab = $surat->UpdateAcc($request->notrans);
        }
        return response()->json($push); 
    }

    public function post(Request $request) 
    {
        // $datamysql = $this->post_to_mysql($request);
        // $datamysql = json_decode($datamysql);
        // $idregis = $request->input('id_old', $datamysql->id_register);
        // $request->request->add(['id_old' => $idregis]);
        $register = new Register();
        $request->request->add(['id_old' => '']);

        
        $up = StoredProcedures::stpnet_AddNewRegistrasiBPJS_REGxhos($request->all());

        if($up)
        {
            $master = new MasterPS();
            $update = $master->update_bpjs_reg($request->all());
            $register->updateSepOnly($request->all());
            if ($update) {
                $medrec = $request->input('Medrec');
                $regdate = $request->input('Regdate');
                $kdpoli = $request->input('KdPoli');
                
                $data = $register->get_register($medrec,$regdate,$kdpoli);
                // echo"<pre>"; print_r($data); die();
                if (empty($data)) {
                    $up = $register->backup_registrasi_pasien($request);
                    $data = $register->get_register($medrec,$regdate,$kdpoli);
                }

                if($request->input("Regno") == ''){
                    // $push = (new Procedure)->push_konsul($kdpoli, $data->Regno);
                }

                if (!empty($data->NoSep)) {
                    $cetakan = Procedure::stpnet_NomCetakSEP_REGxhos($data->Regno);
                }

                // $data = [
                //     'N_Pasien' => $request->Firstname,
                //     // 'N_Keluarga' => $request->NamaAyah,
                //     'D_Lahir' => $request->Bod,
                //     // 'A_Lahir' => $request->Pod,
                //     // 'A_Rumah' => $request->Alamat,
                //     // 'I_Telepon' => $request->Phone,
                //     // 'I_Kelurahan' => $request->I_Kelurahan,
                //     // 'Kota' => $request->Kota,
                //     // 'I_Agama' => $request->KdAgama,
                //     'C_Sex' => $request->KdSex,
                //     // 'C_WargaNegara' => $request->WargaNegara,
                //     // 'I_Pendidikan' => $request->KdDidik,
                //     // 'I_Pekerjaan' => $request->KdMapping,
                //     // 'C_StatusKawin' => $request->Perkawinan,
                //     // 'I_GolDarah' => $request->I_GolDarah,
                //     // 'I_JenisIdentitas' => $request->I_JenisIdentitas,
                //     // 'I_NoIdentitas' => $request->NoIden,
                //     // 'Kd_Asuransi' => $request->Kd_Asuransi,
                //     // 'C_Asuransi' => $request->NoPeserta,
                //     // 'C_KodePos' => $request->C_KodePos,
                //     // 'I_SukuBangsa' => $request->Suku,
                //     // 'I_Jabatan' => $request->I_Jabatan,
                //     // 'Pemegang_Asuransi' => $request->Pemegang_Asuransi,
                //     'I_Entry' => 'system',
                //     'D_Entry' => date('Y-m-d'),
                //     // 'IsCetak' => $request->IsCetak,
                //     // 'Foto' => $request->Foto,
                //     // 'N_Foto' => $request->N_Foto,
                //     // 'E_Foto' => $request->E_Foto,
    
                //     // 'NamaPJ' => $request->NamaPJ,
                //     // 'PekerjaanPJ' => 0,
                //     // 'PhonePJ' => $request->PhonePJ,
                //     // 'HungunganPJ' => 0,
                //     // 'AlamatPJ' => $request->AlamatPJ,
                //     'NoPeserta' => $request->NoPeserta,
                //     'kelas_bpjs' => $request->kelas_bpjs,
                //     'jenis_peserta' => $request->jenis_peserta,
                //     'kategori' => $request->Kategori,
                // ];
    
                // $option = array(
                //     'http' => array(
                //     'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                //     'method' => "POST",
                //     'content' => http_build_query($data)
                //     )
                // );
                // $url = config('app.api_db_url') . "/api/master/pasien";
                // $context = stream_context_create($option);
                // $result = file_get_contents($url, false, $context);
                // $parse['result'] = $result;
    
                // $pasien = MasterPS::where('Medrec', $request->Medrec)->first();
                // if ($pasien) {
                //     $data_pasien = json_decode($result, true);
                //     $pasien->Medrec = $data_pasien['pasien']['I_RekamMedis'];
                //     $pasien->save();
                // }

                $parse = array(
                    'status' => true,
                    'data' => $data,
                    'message' => 'Data berhasil disimpans!',
                    'result' => ''
                );
                return response()->json($parse);
            }
        }else{
            $parse = array(
                'status' => true,
                'message' => 'Gagal!',
                'result' => '-'
            );
            return response()->json($parse);
        }
    }

    public function post_to_mysql(Request $request)
    {
        $poli = POLItpp::where('KDPoli', $request->KdPoli)->first();
        // dd($request->Perjanjian);
        $url = "http://localhost:81/rsau-esnawan/central-api.php";
        $pasien = MasterPS::where('Medrec', $request->Medrec)->orderBy("TglDaftar","DESC")->first();
        $dokter = FtDokter::where('KdDoc', $request->DocRS)->first();
        $data = array(
            '_key' => 'ngeusiKaBPJS',
            '_medrec' => $request->Medrec,
            '_firstname' => $request->Firstname,
            '_regdate' => $request->Regdate.' '.date('H:i:s'),
            '_noiden' => $pasien->NoIden ?? '',
            '_kategori' => $request->KategoriPasien,
            '_kode_doc' => $dokter->KdMapping,
            '_kode_poli' => $poli->KdMapping,
            '_no_anggota_reg' => $request->noKartu ?? '',
            '_alamat' => $pasien->Address ?? '',
            '_notelp' => $pasien->Phone ?? '',
            '_almtpenanggungjwb' => $pasien->AlamatPJ ?? '',
            '_keluargadkt' => $pasien->NamaAyah ?? '',
            '_pekerjaan' => $pasien->Pekerjaan ?? '5',
            '_kunjungan' => $request->Kunjungan == 'Lama' ? 'Y' : 'T',
            '_kdicd' => $request->DiagAw ?? '',
            '_nrp' => $pasien->NrpNip ?? '',
            '_catatan_rujuk' => '',
            '_nm_kategori' => $request->KategoriPasien == '2' ? 'BPJS'.' '.$request->GroupUnit.' '.$request->Unit : 'UMUM',
            '_nm_unit' => $request->GroupUnit.' '.$request->Unit,
            '_regtime' => date('Y-m-d').' '.$request->Regtime,
            '_norujukan' => $request->NoRujuk ?? '-',
            '_tglrujukan' => $request->RegRujuk,
            '_nm_dok' => $dokter->NmDoc ?? '',
            '_nm_poli' => $poli->NMPoli ?? '',
            '_pek_pas_pnj' => '',
            '_institusi_pas_pnj' => $pasien->NmKesatuan ?? '',
            '_pangkat_pnj' => $pasien->NmPangkat ?? '',
            '_pas_kecelakaan_ya' => $request->KasKe ?? '',
            '_status_reg' => $request->Perjanjian != 'true' ? 'Check-in' : 'waiting',
            '_perjanjian' => $request->Perjanjian == 'true' ? 'Y' : '',
            '_regold' => $request->idregold ?? '',
            '_tanggaldaftar' => $request->Regdate
        );

        $option = array(
            'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => "POST",
            'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($option);
        $result = file_get_contents($url, false, $context);
        // dd($result);
        return $result;
    }

    public function delete(Request $request)
    {
        $Regno = $request->Regno;
        $User = Auth::user()->NamaUser; 
        $Time = date('Y/m/d H:i:s');
        $Deleted = $User.'-'.$Time;
        $get_delete = Register::where('Regno', $Regno)->first();
        $delete = Register::where('Regno',$Regno)->update(['Deleted'=>$Deleted]);
        if($delete){
            {
                if ($get_delete->IdRegOld!= '') {
                    $url = "http://localhost:81/rsau-esnawan/central-api.php";
                    $data = array('_id_reg' => $get_delete->IdRegOld, '_key' => 'teujadi');
                    $option = array(
                        'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => "POST",
                        'content' => http_build_query($data)
                        )
                    );

                    $context = stream_context_create($option);
                    $result = file_get_contents($url, false, $context);
                }
                
                $request->session()->flash('status', 'Data Berhasil Dihapus!');
                return redirect()->route('reg-bpjs-daftar');
            }
        }else{
            return redirect()->back();
        }
    }

    public function update_kategori(Request $request)
    {
        $up = Procedure::stpnet_UpdateKategori_REGxhos($request->all());
    }

    // MUTASI PASIEN BPJS
    public function mutasi_index(Request $request)
    {
        $regno = $request->input('Regno');
        $nama = $request->input('Firstname');
        $medrec = $request->input('Medrec');
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');
        $fppri = new Fppri();
        $data = $fppri->mutasi_bpjs($regno, $medrec, $nama, $date1, $date2);
        // dd($data);
        $parse = [
            'list' => $data,
        ];
        return view('registrasi-bpjs.mutasi-pasien.index',$parse);
    }

    public function mutasi_form($regno = null)
    {
        $kelas = Procedure::stpn_ViewKelas_INAxhos();

        $parse = [
            'ruang' => $kelas
        ];
        if ($regno !== null){
            $register = new Fppri();
            $data = $register->get_one_bpjs($regno);
            $parse = [
                'ruang' => $kelas,
                'edit' => $data
            ];
        }
        // dd($parse);
        return view('registrasi-bpjs.mutasi-pasien.form',$parse);
    }

    public function mutasi_post(Request $request)
    {
        // return response()->json($request->all());
        $up = StoredProcedures::stpnet_AddMutasiPasienBPJS_REGxhos($request->all());
        if ($up) {
            $cetakan = Procedure::stpnet_NomCetakSEP_REGxhos($request->Regno);

            $KdTuju = Register::where('Regno',$request->Regno)->update(['KdTuju'=>'RI']);


            $parse = array(
                'status' => true,
                'message' => 'Data berhasil disimpan!'
            );

            return response()->json($parse);
        }else{
            return redirect()->back()->withInput($request->all());
        }
    }

    public function delete_mutasi(Request $request)
    {
        $Regno = $request->Regno;
        $nosep = Fppri::where('Regno', $request->Regno)->first();
        $bpjs = new Bridging_bpjs();
        if (!empty($nosep->NoSep)) {
            $data = $bpjs->get_sep($nosep->NoSep);
            if (!empty($data->noSep)) {
                $validuser = 'SIMRS';

                $data = array(
                    'request' => [
                        't_sep' => [
                            'noSep' => $data->noSep,
                            'user' => $validuser
                        ]
                    ]
                );
                $response = $bpjs->delete_sep($data);

                $delete = Procedure::stpnet_DeleteMutasiPasien_REGxhos($request->all());
                if($delete){
                   $KdTuju = Register::where('Regno',$request->Regno)->update(['KdTuju'=>'RJ']);

                    {
                        $request->session()->flash('status', 'Data Berhasil Dihapus!');
                        return redirect()->route('reg-bpjs-mutasi');
                    }
                }else{
                    return redirect()->back();
                }
            } else {
                $delete = Procedure::stpnet_DeleteMutasiPasien_REGxhos($request->all());
                if($delete){
                    $KdTuju = Register::where('Regno',$request->Regno)->update(['KdTuju'=>'RJ']);

                    {
                        $request->session()->flash('status', 'Data Berhasil Dihapus!');
                        return redirect()->route('reg-bpjs-mutasi');
                    }
                }else{
                    return redirect()->back();
                }
            }
        }
        else {
            $delete = Procedure::stpnet_DeleteMutasiPasien_REGxhos($request->all());
            if($delete){
                $KdTuju = Register::where('Regno',$request->Regno)->update(['KdTuju'=>'RJ']);
                
                {
                    $request->session()->flash('status', 'Data Berhasil Dihapus!');
                    return redirect()->route('reg-bpjs-mutasi');
                }
            }else{
                return redirect()->back();
            }
        }
    }

    public function find_registrasi(Request $request)
	{
		$notelp = $request->input("notelp");
		$medrec = $request->input("medrec");
		$nama = $request->input("nama");
		$alamat = $request->input("alamat");
		$nopeserta = $request->input("nopeserta");
		$tgl_lahir = $request->input("tgl_lahir");
		$date1 = $request->input("date1");
		$date2 = $request->input("date2");
		// dd($request->all());
		$pasien = new Register();
        $data = $pasien->find_register_bpjs($medrec, $notelp, $nama, $alamat, $tgl_lahir, $date1, $date2);
        $parse = array(
            'list'=> $data,
        );
        return view('registrasi-bpjs.mutasi-pasien.find-register',$parse);
    }
    // RUJUKAN PASIEN BPJS
    public function rujukan_index(Request $request)
    {
        $medrec = $request->input("medrec");
        $nama = $request->input("nama");
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $rujukanbpjs = new RujukanBPJS();
        $data = $rujukanbpjs->get_list($medrec, $nama, $date1, $date2);
        $parse = [
            'list' => $data,
        ];
        return view('registrasi-bpjs.rujukan-pasien.index',$parse);
    }

    public function rujukan_form($no_rujukan = null)
    {
        $data = [
            'is_edit' => !is_null($no_rujukan),
            'rujukan' => is_null($no_rujukan) ? new RujukanBPJS() : RujukanBPJS::where('NoRujukan', $no_rujukan)->firstOrFail()
        ];

        return view('registrasi-bpjs.rujukan-pasien.form', $data);
    }

    public function rujukan_delete($no_rujukan)
    {
        $rujukan = RujukanBPJS::where('NoSep', $no_rujukan)->firstOrFail();

        $data = [
            'request' => [
                't_rujukan' => [
                    'noRujukan' => $rujukan->NoRujukan,
                    'user' => 'SIMRS',
                ]
            ]
        ];

        VClaim::delete_rujukan($data);

        $rujukan->delete();

        return redirect()->route('reg-bpjs-rujukan');
    }

    public function rujukan_create(Request $request)
    {
        $data = [
            'request' => [
                't_rujukan' => [
                    'noRujukan' => $request->NoRujukan,
                    'ppkDirujuk' => $request->Ppk,
                    'tipe' => $request->TipeRujukan,
                    'jnsPelayanan' => $request->JenisPelayanan,
                    'catatan' => $request->Catatan,
                    'diagRujukan' => $request->DiagRujuk,
                    'tipeRujukan' => $request->TipeRujukan,
                    'poliRujukan' => $request->KdPoli,
                    'user' => 'SIMRS',
                ]
            ]
        ];

        $icd = TBLICD10::where('KDICD', $request->DiagRujuk)->first();
        $ppk = Refppk::where('kdppk', $request->Ppk)->first();
        $poli = POLItpp::where('KdBPJS', $request->KdPoli)->first();
        $peserta = VClaim::get_sep($request->NoSep);
        // dd($peserta->response->peserta->noMr);

        VClaim::update_rujukan($data);
        StoredProcedures::stpnet_AddNewRujukanBPJS_REGxhos([
            'nosep' => $request->NoSep,
            'tglrujukan' => $request->TglRujukan,
            'kdrujukan' => $request->Ppk,
            'nmrujukan' => $request->NmPpk ?? $ppk->NMPPK.' - '.$ppk->NMDATI2PPK,
            'kdicd' => $request->DiagRujuk,
            'diagnosa' => $icd->KDICD.' - '.$icd->DIAGNOSA ?? $request->DiagRujuk,
            'kdpoli' => $request->KdPoli,
            'nmpoli' => $poli->NMPoli ?? $request->NmPoli,
            'jnspelayanan' => $request->JenisPelayanan,
            'tiperujukan' => $request->TipeRujukan,
            'norujukan' => $request->NoRujukan,
            'nopeserta' => $peserta->response->peserta->noKartu,
            'medrec' => $peserta->response->peserta->noMr,
            'firstname' => $request->Firstname,
            'sex' => $request->Sex,
            'bod' => $request->TglLahir,
            'jenispeserta' => $request->JenisPeserta,
            'kelas' => $request->HakKelas,
            'kdasalrujukan' => VClaim::$ppkPelayanan,
            'nmasalrujukan' => VClaim::$namaPpkPelayanan,
            'catatan' => $request->Catatan,
            'validuser' => $request->user()->NamaUser.' '.date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('reg-bpjs-rujukan');
    }

    public function print_rujukan(Request $request)
    {
        $norujuk = $request->norujukan;
        $rujuk = RujukanBPJS::where('NoRujukan', $norujuk)->firstOrFail();
        $parse = array(
            'data' => $rujuk
        );

        return view('registrasi-bpjs.rujukan-pasien.print_rujukan', $parse);
    }

    // PENGAJUAN SEP PASIEN
    public function pengajuan_index()
    {
        $psep = new fPSEP01();
        $data = $psep->get_data();
        $parse = [
            'list' => $data,
        ];
        return view('registrasi-bpjs.pengajuan-sep.index',$parse);
    }

    public function pengajuan_form(Request $request)
    {
        $nopeserta = $request->input("NoPeserta");
        $parse[] = [];
        if ($nopeserta !== null){
            $psep = new fPSEP01();
            $data = $psep->get_one($nopeserta);
            $parse = [
                'edit' => $data
            ];
        }
        // dd($parse);
        return view('registrasi-bpjs.pengajuan-sep.form',$parse);
    }

    public function save_sep(Request $request)
    {
        $psep = new fPSEP01();
        $save = $psep->save_to_fpsep($request->no_peserta, $request->tanggal_sep, $request->pelayanan, $request->keterangan);

        return $save;
    }

    // DETAIL SEP PASIEN
    public function detail_sep()
    {
        $list = [];
        $parse = [
            'list' => $list,
        ];
        return view('registrasi-bpjs.detail-sep.detail-sep', $parse);
    }

    public function get_sep(Request $request)
    {
        $medrec = $request->input("medrec");
        $nama = $request->input("nama");
        $date1 = $request->input("date1");
        $date2 = $request->input("date2");

        $register = new Register();
        $data = $register->get_sep($medrec, $nama, $date1, $date2);
        // dd($data);
        $parse = array(
            'list' => $data
        );

        return view('registrasi-bpjs.detail-sep.form-cari-sep', $parse);
    }

    public function print_sep(Request $request)
    {
        $regno = $request->input("Regno");
        // dd($nosep);
        $register = new Register();
        $data = $register->print_sep($regno);
        $parse = array(
            'data' => $data
        );
        // dd($parse);
        return view('registrasi-bpjs.pengajuan-sep.lembar-sep', $parse);
    }

    public function print_sep_register(Request $request)
    {
        
        $regno = $request->input("Regno");
        // dd($nosep);
        $register = new Register();
        $data = $register->print_sep($regno);
        $parse = array(
            'data' => $data
        );
        
        return view('registrasi-bpjs.pengajuan-sep.lembar-sep', $parse);
        // $pdf = PDF::loadView('registrasi-bpjs.daftar-pasien.print-sep',$parse);
        // $pdf->setPaper(array(0, 0, $parse['width'], $parse['height']));
        // return base64_encode($pdf->stream($regno.date('dmYHs').'.pdf'));
    }

    
    public function print_sep_rawat_inap(Request $request)
    {
        $regno = $request->input("Regno");
        // dd($nosep);
        $fppri = new Fppri();
        $data = $fppri->print_sep_rawat_inap($regno);
        $parse = array(
            'data' => $data
        );
        return view('registrasi-bpjs.pengajuan-sep.lembar-sep-rawat-inap', $parse);
    }

    public function print_registrasi(Request $request)
    {
        // dd($request->all());
        $data = [];
        $poli = $request->input('Poli') !== null ? $request->input('Poli') : '';
        $dokter = $request->input('Dokter') !== null ? $request->input('Dokter') : '';
        $tujuan = $request->input('Tujuan') !== null ? $request->input('Tujuan') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $data['set_awal'] = date('d-m-Y',strtotime($date1));
        $data['set_akhir'] = date('d-m-Y',strtotime($date2));

        $register = new Register();
        
        $list = $register->printPeserta($poli, $dokter, $tujuan, $date1, $date2);

        $parse = [
            'list' => $list,
            'data' => $data
        ];

        return view('registrasi-bpjs.daftar-pasien.registrasi', $parse);
    }

    public function print_registrasi_baru(Request $request)
    {
        // dd($request->all());
        $data = [];
        $poli = $request->input('Poli') !== null ? $request->input('Poli') : '';
        $dokter = $request->input('Dokter') !== null ? $request->input('Dokter') : '';
        $tujuan = $request->input('Tujuan') !== null ? $request->input('Tujuan') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $data['set_awal'] = date('d-m-Y',strtotime($date1));
        $data['set_akhir'] = date('d-m-Y',strtotime($date2));

        $register = new Register();
        
        $list = $register->printPeserta_baru($poli, $dokter, $tujuan, $date1, $date2);

        $parse = [
            'list' => $list,
            'data' => $data
        ];

        return view('registrasi-bpjs.daftar-pasien.registrasi', $parse);
    }

    public function print_registrasi_lama(Request $request)
    {
        // dd($request->all());
        $data = [];
        $poli = $request->input('Poli') !== null ? $request->input('Poli') : '';
        $dokter = $request->input('Dokter') !== null ? $request->input('Dokter') : '';
        $tujuan = $request->input('Tujuan') !== null ? $request->input('Tujuan') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $data['set_awal'] = date('d-m-Y',strtotime($date1));
        $data['set_akhir'] = date('d-m-Y',strtotime($date2));

        $register = new Register();
        
        $list = $register->printPeserta_lama($poli, $dokter, $tujuan, $date1, $date2);

        $parse = [
            'list' => $list,
            'data' => $data
        ];

        return view('registrasi-bpjs.daftar-pasien.registrasi', $parse);
    }
}
