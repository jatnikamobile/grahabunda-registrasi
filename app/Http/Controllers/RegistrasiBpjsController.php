<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use App\Bridging\VClaim;
use App\Http\Controllers\Bridging\NewVClaimController;
use App\Http\Controllers\RsNet\RsNetBridgingController;
use App\Http\Controllers\RsNet\RsNetKunjunganController;
use App\Http\Controllers\RsNet\RsNetPasienController;
use App\Http\Controllers\RsNet\RsNetRujukanController;
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
use App\Models\DeleteSepLog;
use App\Models\Kepri\Master\TmKelompokRujukan;
use App\Models\SuratKonsul;
use App\Models\Radiologi;
use App\Models\Laboratorium;
use App\Models\PengajuanSPRI;
use App\Models\TblKategoriPsn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $parse['kelompok_rujukan'] = TmKelompokRujukan::orderBy('I_KelompokRujukan')->get();
        // $regno = $request->input("Regno");
        if ($regno !== null){
            $register = new Register();
            $data = $register->get_one($regno);
            $parse['edit'] = $data;
            // dd($data);
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
        $nosurat = strtoupper($request->nosurat);
        $surat = new SuratControl();
        $data = $surat->find_nosurat($nosurat);
        
        // $bpjs_data = VClaim::get_rencana_control($nosurat);
        $vclaim_controller = new NewVClaimController();
        $bpjs_data = $vclaim_controller->cariNomorSuratKontrol($nosurat);

        Log::info("data BPJS Surat Kontrol: " . $bpjs_data);

        $no_peserta = isset($bpjs_data['sep']['peserta']['noKartu']) ? $bpjs_data['sep']['peserta']['noKartu'] : null;
        $peserta_bpjs = $bpjs_data ? $vclaim_controller->pesertaKartu($no_peserta, date('Y-m-d')) : null;
        $medrec = $peserta_bpjs ? $peserta_bpjs['peserta']['mr']['noMR'] : null;

        $diagnosa = isset($bpjs_data['sep']['diagnosa']) ? $bpjs_data['sep']['diagnosa'] : null;
        $arr_diags = $diagnosa ? explode('-', $diagnosa) : [];
        $arr_diags = count($arr_diags) > 0 ? [
            'code' => trim($arr_diags[0]),
            'diagnosa' => trim($arr_diags[1]),
        ] : [];

        if (isset($bpjs_data['noSuratKontrol'])) {
            $jenis_pelayanan = $bpjs_data['sep']['jnsPelayanan'];
            if ($jenis_pelayanan == 'Rawat Inap') {
                $register = Fppri::where('nosep', $bpjs_data['sep']['noSep'])->first();
                $master_ps = $register ? MasterPS::where('Medrec', $register->Medrec)->first() : null;
                $kategori = TblKategoriPsn::where('KdKategori', 28)->first();
                $dokter = FtDokter::where('KdDPJP', $bpjs_data['kodeDokter'])->first();
                $poli = POLItpp::where('KdBPJS', $bpjs_data['poliTujuan'])->first();
            } else {
                $register = $no_peserta ? Register::where('NoSep', $bpjs_data['sep']['noSep'])->orderBy('Regno', 'desc')->first() : null;
                $medrec = $medrec ? $medrec : ($register ? $register->Medrec : null);
                $master_ps = $register ? MasterPS::where('Medrec', $medrec)->first() : null;
                $kategori = $master_ps ? TblKategoriPsn::where('KdKategori', $master_ps->Kategori)->first() : null;
                $dokter = $register ? FtDokter::where('KdDoc', $register->KdDoc)->first() : FtDokter::where('KdDPJP', $bpjs_data['kodeDokter'])->first();
                $poli = $register ? POLItpp::where('KDPoli', $register->KdPoli)->first() : POLItpp::where('KdBPJS', $bpjs_data['poliTujuan'])->first();
            }

            $response_data['metaData'] = ['code' => 200];
            $response_data['response'] = $bpjs_data;
            
			$registers = $medrec ? Register::where('Medrec', $medrec->Medrec)->get() : [];

            $data = [
                'data' => $data,
                'bpjs_data' => $response_data,
                'register' => $register,
                'master_ps' => $master_ps,
                'kategori' => $kategori,
                'dokter' => $dokter,
                'poli' => $poli,
                'diag' => $jenis_pelayanan == 'Rawat Inap' ? $register->KdIcd : $register->KdICDBPJS,
                'arr_diags' => $arr_diags,
                'peserta_bpjs' => $peserta_bpjs,
                'kunjungan' => count($registers) > 0 ? 'Lama' : 'Baru',
            ];

            Log::info("data BPJS Surat Kontrol: " . json_encode($data));
    
            return response()->json(['status' => 'success', 'data' => $data]);
        } else {
            return response()->json(['status' => 'failed', 'message' => $bpjs_data['metaData']['message']]);
        }
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
        $message = '';
        $register = new Register();
        $request->request->add(['id_old' => '']);

        if ($request->form_type == 'update') {
            $rs_net_kunjungan_controller = new RsNetKunjunganController();
            $D_Masuk = $request->Regdate . ' ' . $request->Regtime;
            $I_RekamMedis = $request->Medrec;
            $cek_kunjungan = $rs_net_kunjungan_controller->cehKunjunganAktif($D_Masuk, $I_RekamMedis);

            if (!$cek_kunjungan) {
                $parse = array(
                    'status' => false,
                    'message' => 'Kunjungan di aplikasi lama sudah tidak aktif, mungkin sudah cancel atau closed. Update tidak bisa dilanjutkan!',
                    'result' => ''
                );
                return response()->json($parse);
            }
        }
        
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

                try {
                    $data_rujukan = [
                        'I_KelRujukan' => 1,
                        'N_Rujukan' => $request->noPpk,
                        'C_PPKRujukan' => $request->kodeoPpk,
                    ];

                    $rs_net_rujukan_controller = new RsNetRujukanController();
                    $create_rujukan = $rs_net_rujukan_controller->store($data_rujukan);
    
                    $data_kunjungan = [
                        'form_type' => $request->form_type,
                        'rujukan_dari' => $request->rujukan_dari,
                        'poli' => $request->KdPoli,
                        'I_RekamMedis' => $request->Medrec,
                        'I_Unit' => $request->KdPoli,
                        'I_UrutMasuk' => $data->NomorUrut,
                        'D_Masuk' => $request->Regdate . ' ' . $request->Regtime,
                        'C_Pegawai' => $request->DocRS,
                        'I_Penerimaan' => 0,
                        'I_Rujukan' => $create_rujukan ? $create_rujukan->I_Rujukan : null,
                        'N_DokterPengirim' => $request->KdDPJP,
                        'N_Diagnosa' => $request->DiagAw,
                        'I_Kontraktor' => $request->KategoriPasien,
                        'I_StatusBaru' => $request->Kunjungan == 'Baru' ? 1 : 0,
                        'I_StatusKunjungan' => 1,
                        'C_Shift' => 1,
                        'I_Entry' => Auth::user() ? Auth::user()->NamaUser : 'system',
                        'D_Entry' => $request->Regdate,
                        'N_PasienLuar' => $request->Firstname,
                        'Umur_tahun' => $request->UmurThn,
                        'Umur_bulan' => $request->UmurBln,
                        'Umur_hari' => $request->UmurHari,
                        'I_SKP' => $request->NoSep,
                        'i_kunjungan' => isset($data->I_Kunjungan) ? $data->I_Kunjungan : null,
                    ];

                    Log::info('Inset/Update Kunjungan Log');
                    Log::info('Data Kunjungan:');
                    Log::info($data_kunjungan);

                    $rs_net_kunjungan_controller = new RsNetKunjunganController();
                    $create_kunjungan = $rs_net_kunjungan_controller->store($data_kunjungan);
                    Log::info('Response Kunjungan:');
                    Log::info($create_kunjungan);
                    Log::info('End Inset/Update Kunjungan Log');

                    if ($data) {
                        $register = Register::where('Regno', $data->Regno)->first();
                        if ($register) {
                            $register->rujukan_dari = $request->rujukan_dari;
                            $register->I_Kunjungan = $create_kunjungan->I_Kunjungan;
                            $register->save();
                        }
                    }
                } catch (\Throwable $th) {
                    $message = $th->getMessage();
                }

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
                    $rs_net_kunjungan_controller = new RsNetKunjunganController();
                    $delete_kunjungan = $rs_net_kunjungan_controller->destroy($get_delete);
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

        $data_pasien = [
            'I_RekamMedis' => $request->Medrec,
            'NoPeserta' => $request->askesno,
            'kategori' => $request->Kategori,
            'I_NoIdentitas' => $request->NoIden
        ];

        $rs_net_pasien_controller = new RsNetPasienController();
        $update_pasien = $rs_net_pasien_controller->store($data_pasien);

        $pasien = MasterPS::where('Medrec', $request->Medrec)->first();
        if ($pasien) {
            $pasien->Medrec = $update_pasien->I_RekamMedis;
            $pasien->save();
        }
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
        $parse['kelompok_rujukan'] = TmKelompokRujukan::orderBy('I_KelompokRujukan')->get();
        return view('registrasi-bpjs.mutasi-pasien.form',$parse);
    }

    public function mutasi_post(Request $request)
    {
        // return response()->json($request->all());
        $up = StoredProcedures::stpnet_AddMutasiPasienBPJS_REGxhos($request->all());
        if ($up) {
            $fppri = Fppri::where('nosep', $request->NoSep)->first();
            if ($fppri) {
                $fppri->Kategori = '28';
                $fppri->no_spri = $request->noSurat;
                $fppri->save();
            }
            $cetakan = Procedure::stpnet_NomCetakSEP_REGxhos($request->Regno);

            $KdTuju = Register::where('Regno',$request->Regno)->update(['KdTuju'=>'RI']);

            $rs_net_bridging = new RsNetBridgingController();
            $rs_net_ranap = $rs_net_bridging->addDataRanap($request, $fppri);

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
		$no_sep = $request->NoSep;
		$vclaim = new NewVClaimController();
		$peserta = $vclaim->cariSEP($no_sep);

        $icd = TBLICD10::where('KDICD', $request->DiagRujuk)->first();
        $ppk = Refppk::where('kdppk', $request->Ppk)->first();
        $poli = POLItpp::where('KdBPJS', $request->KdPoli)->first();

        $data_rujukan = [
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
            'nopeserta' => $peserta['peserta']['noKartu'],
            'medrec' => $peserta['peserta']['noMr'],
            'firstname' => $request->Firstname,
            'sex' => $request->Sex,
            'bod' => $request->TglLahir,
            'jenispeserta' => $request->JenisPeserta,
            'kelas' => $request->HakKelas,
            'kdasalrujukan' => VClaim::$ppkPelayanan,
            'nmasalrujukan' => VClaim::$namaPpkPelayanan,
            'catatan' => $request->Catatan,
            'validuser' => $request->user()->NamaUser.' '.date('Y-m-d H:i:s'),
        ];

        StoredProcedures::stpnet_AddNewRujukanBPJS_REGxhos($data_rujukan);

        $rujukan = RujukanBPJS::where('NoSep', $request->NoSep)->where('NoRujukan', $request->NoRujukan)->first();
        if ($rujukan) {
            $rujukan->tglRencanaKunjungan = $request->tglRencanaKunjungan;
            $rujukan->save();
        }

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
        $list_deleted = DeleteSepLog::orderBy('deleted_date', 'desc')->get();
        $parse = [
            'list' => $list,
            'list_deleted' => $list_deleted
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
            'data' => $data,
            'reff' => 'list'
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

    public function pengajuanSPRIIndex(Request $request)
    {
        $pengajuan_spri = PengajuanSPRI::orderBy('id', 'desc')->paginate(10);

        return view('registrasi-bpjs.pengajuan-spri.index', compact('pengajuan_spri'));
    }

    public function pengajuanSPRIForm(Request $request)
    {
        $regno = $request->Regno;
        $register = $regno ? Register::where('Regno', $regno)->first() : null;
        $poli = POLItpp::orderBy('KDPoli')->get();
        $dokter = $register ? FtDokter::where('KdPoli', $register->KdPoli)->get() : null;

        return view('registrasi-bpjs.pengajuan-spri.form', compact('register', 'poli', 'dokter'));
    }

    public function pengajuanSPRISave(Request $request)
    {
        $no_kartu = $request->no_kartu;
        $poli = $request->poli;
        $dokter = $request->dokter;
        $tanggal = $request->tanggal;

        $data_req = [
            'noKartu' => $no_kartu,
            'kodeDokter' => $dokter,
            'poliKontrol' => $poli,
            'tglRencanaKontrol' => $tanggal,
            'user' => Auth::user()['NamaUser']
        ];
        $vclaim = new NewVClaimController();
        $insert_spri = $vclaim->insertSPRI($data_req);
        $status = isset($insert_spri['metaData']['code']) ? $insert_spri['metaData']['code'] : ($insert_spri == false ? 201 : 200);

		Log::info('BPJS Insert SPRI API Response:');
		Log::info($insert_spri);

        if ($status == 200) {
            $pengajuan_spri = new PengajuanSPRI();
            $pengajuan_spri->no_kartu = $no_kartu;
            $pengajuan_spri->nama = $insert_spri['nama'];
            $pengajuan_spri->kelamin = $insert_spri['kelamin'];
            $pengajuan_spri->tanggal_lahir = $insert_spri['tglLahir'];
            $pengajuan_spri->kode_dokter = $dokter;
            $pengajuan_spri->nama_dokter = $insert_spri['namaDokter'];
            $pengajuan_spri->poli_kontrol = $poli;
            $pengajuan_spri->tanggal_rencana_kontrol = $tanggal;
            $pengajuan_spri->no_spri = $insert_spri['noSPRI'];
            $pengajuan_spri->nama_diagnosa = $insert_spri['namaDiagnosa'];
            $pengajuan_spri->user = Auth::user()['NamaUser'];
            $pengajuan_spri->save();
        }

        return redirect(route('reg-bpjs-pengajuan-spri'));
    }

    public function pengajuanSPRIView(Request $request)
    {
        return view('registrasi-bpjs.pengajuan-spri.detail');
    }

    public function pengajuanSPRIAjax(Request $request)
    {
        $action = $request->action;

        switch ($action) {
            case 'get-dokter':
                $poli_bpjs = $request->poli;

                $poli = POLItpp::where('KdBPJS', $poli_bpjs)->first();
                $kd_poli = $poli ? $poli->KDPoli : null;

                $dokter = FtDokter::where('KdPoli', $kd_poli)->get();

                $data_dokter = '<option value="0">--- Pilih Dokter ---</option>';
                if (count($dokter) > 0) {
                    foreach ($dokter as $dr) {
                        $data_dokter .= '<option value="' . $dr->KdDPJP . '">' . $dr->NmDoc . ' - ' . $dr->KdDPJP . '</option>';
                    }
                }

                return response()->json(['status' => 'success', 'data_dokter' => $data_dokter]);
                break;

            case 'get-register':
                $regno = $request->Regno;

                $register = $regno ? Register::where('Regno', $regno)->first() : null;
                $poli = POLItpp::orderBy('KDPoli')->get();
                $dokter = $register ? FtDokter::where('KdPoli', $register->KdPoli)->get() : [];
                $data_dokter = $register ? FtDokter::where('KdDoc', $register->KdDoc)->first() : null;
                $data_poli = $register ? POLItpp::where('KDPoli', $register->KdPoli)->first() : null;

                return response()->json(['status' => 'success', 'register' => $register, 'poli' => $poli, 'dokter' => $dokter, 'data_dokter' => $data_dokter, 'data_poli' => $data_poli]);
                break;
            
            default:
                # code...
                break;
        }
    }
}
