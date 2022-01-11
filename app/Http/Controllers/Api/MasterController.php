<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bridging\VClaim;
use App\Http\Controllers\Bridging\NewVClaimController;
use App\Models\AwSuratKontrolHead;
use App\Models\Keyakinan;
use App\Models\POLItpp;
use App\Models\FtDokter;
use App\Models\MasterPS;
use App\Models\Register;
use App\Models\Procedure;
use App\Models\Bridging_bpjs;
use App\Models\Fppri;
use App\Models\RsNet\AdmKunjungan;
use Illuminate\Support\Facades\Log;

class MasterController extends Controller{

	public function spesialistik()
	{
        return  (new Bridging_bpjs)->get_spesialistik();
	}

	public function detail_pasien(Request $request)
	{
		$medrec = $request->input("Medrec");
		$pasien = new MasterPS();
		$list = $pasien->get_one($medrec);
		if (empty($list)) {
		       return response()->json(['status' => false]);
		}

		$register = new Register();
		$check = $register->cek_pasien($medrec);
		$kunjungan = AdmKunjungan::where('I_RekamMedis', $medrec)->first();
		// dd($check);

		return response()->json([
			'status' => true,
			'data' => $list,
			'register' => $check,
			'kunjungan' => $kunjungan
			]);
	}

	public function cek_kategori_pasien(Request $request)
	{
		$medrec = $request->input("medrec");
		$pasien = new MasterPS();
		$data = $pasien->get_kategori_pasien($medrec);
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function cek_regis_pasien(Request $request)
	{

		$register = new Register();
		$medrec = $request->input("medrec");
		$kategori = $request->input("kategori");
		$cbayar = $request->input("cbayar");
		$poli = $request->input("poli");
		$regdate = $request->input("regdate");
		$cek_reg = $register->cek_regis_pasien($medrec, $regdate, $kategori, $cbayar, $poli);
		if($poli == '24'){
			return response()->json([
				'status' => true,
				'data' => [],
			]);
		} elseif($poli == '39'){
			return response()->json([
				'status' => true,
				'data' => [],
			]);
		} elseif($poli == '30'){
			return response()->json([
				'status' => true,
				'data' => [],
			]);
		} elseif(!empty($cek_reg)){
			return response()->json([
				'status' => false,
				'data' => $cek_reg,
			]);
		}else{
			return response()->json([
				'status' => true,
				'data' => [],
			]);
		}
	}
	public function cek_sep_pasien(Request $request)
	{
		$medrec = $request->input("medrec") ?? '';
		$kategori = $request->input("kategori") ?? '';
		$cbayar = $request->input("cbayar") ?? '';
		$poli = $request->input("poli") ?? '';
		$regdate = $request->input("regdate") ?? '';
		$regno = $request->input("regno") ?? '';
		$sep = $request->input("nosep") ?? '';
		if ($sep == '') {
			$resp['stat'] = true;
			$resp['data'] = array();
		}else{
			$cek = (new Register)->cek_sep_pasien($sep);
			if (empty($cek)) {
				$resp['stat'] = true;
				$resp['data'] = array();
			}else {
				$resp['stat'] = false;
				$resp['data'] = $cek;
				
				if($cek->Regno == $regno){
					$resp['stat'] = true;
				}
				elseif(
					$cek->Medrec == $medrec &&
					date('Y-m-d', strtotime($cek->Regdate)) == date('Y-m-d', strtotime($regdate)) &&
					$cek->Kategori == $kategori && 
					$cek->KdCbayar == $cbayar &&
					$cek->KdPoli == $poli
				){
					$resp['stat'] = true;
				}
			}
		}
			
		return response()->json($resp);
	}
	
	public function cek_sep_pasien2(Request $request)
	{
		$medrec = $request->input("medrec") ?? '';
		$kategori = $request->input("kategori") ?? '';
		$cbayar = $request->input("cbayar") ?? '';
		$poli = $request->input("poli") ?? '';
		$regdate = $request->input("regdate") ?? '';
		$regno = $request->input("regno") ?? '';
		$sep = $request->input("nosep") ?? '';
		
		$cek = (new Register)->cek_sep_pasien($sep);
		$resp['stat'] = false;
		$resp['data'] = $cek;
		
		if($cek->Regno == $regno){
			$resp['stat'] = true;
		}elseif(
			$cek->Medrec == $medrec &&
			date('Y-m-d', strtotime($cek->Regdate)) == date('Y-m-d', strtotime($regdate)) &&
			$cek->Kategori == $kategori && 
			$cek->KdCbayar == $cbayar &&
			$cek->KdPoli == $poli
		){
			$resp['stat'] = true;
		}
		return response()->json($resp);
	}

	public function cek_nomor_urut(Request $request)
    {
        $register = new Register();
        $regno = $request->input("regno");
        $kdpoli = $request->input("kdpoli");
        $regdate = $request->input("regdate");
        $cek = $register->get_one($regno);
        if ($kdpoli == $cek->KdPoli && $regdate.' 00:00:00.000' == $cek->Regdate) {
            return response()->json([
                'status' => true,
                'data' => $cek
            ]);
        } else {
            return response()->json([
                'status' => false,
                'data' => []
            ]);
        }
    }

	public function cek_mutasi_pasien(Request $request)
	{
		$fppri = new Fppri();
		$medrec = $request->input("medrec");
		$regno = $request->input("Regno");
		$kategori = $request->input("kategori");
		$poli = $request->input("poli");
		$regdate = $request->input("regdate");
		$cek_reg = $fppri->cek_mutasi_pasien($regno);
		if(!empty($cek_reg)){
			return response()->json([
				'status' => false,
				'data' => $cek_reg,
			]);
		}else{
			return response()->json([
				'status' => true,
				'data' => [],
			]);
		}
	}

	public function cek_detail_pasien_keyakinan(Request $request)
	{
		$medrec = $request->input("Medrec");
		$keyakinan = new Keyakinan();
		$data = $keyakinan->get_first_pasien($medrec);
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function detail_mutasi(Request $request)
	{
		$regno = $request->input("Regno");
		$pasien = new Register();
		$data = $pasien->get_mutasi($regno);
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function detail_mutasi_bpjs(Request $request)
	{
		$regno = $request->input("Regno");
		$pasien = new Register();
		$data = $pasien->get_mutasi_bpjs($regno);
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function cari_pasien_master(Request $request)
	{
		$medrec = $request->input("medrec");
		$notelp = $request->input("notelp");
		$nama = $request->input("nama");
		$alamat = $request->input("alamat");
		$nopeserta = $request->input("nopeserta");
		$tgl_lahir = $request->input("tgl_lahir");
		$date1 = $request->input("date1");
		$date2 = $request->input("date2");

		// dd($request->all());

		$pasien = new MasterPS();
		$data = $pasien->get_list_bpjs($medrec, $notelp, $nama, $alamat, $nopeserta, $tgl_lahir, $date1, $date2);
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function get_peserta_kartu_bpjs(Request $request)
	{
		$vclaim_controller = new NewVClaimController();
		$nopeserta = $request->nopeserta;
		$tanggal = date('Y-m-d');
		$request = $vclaim_controller->pesertaKartu($nopeserta, $tanggal);
		$peserta = $request['peserta'];
		$pasien = $peserta ? MasterPS::where('NoIden', $peserta['nik'])->first() : null;

		return response()->json([
			'status' => true,
			'data' => $request,
			'pasien' => $pasien
		]);
	}

	public function get_peserta_nik(Request $request)
	{
		$vclaim_controller = new NewVClaimController();
		$nik = $request->nik;
		$tanggal = date('Y-m-d');
		$request = $vclaim_controller->pesertaNIK($nik, $tanggal);
		$peserta = $request['peserta'];
		$pasien = $peserta ? MasterPS::where('NoIden', $peserta['nik'])->first() : null;

		return response()->json([
			'status' => true,
			'data' => $request,
			'pasien' => $pasien
		]);
	}

	public function get_peserta_rujukan(Request $request)
	{
		// $bpjs = new Bridging_bpjs();
		// $data = $bpjs->get_perserta_rujukan_Pcare($request->noRujukan);
		// // dd($data);
		// if($data)
		// $data->poli_local = @$data->rujukan->poliRujukan->kode
		// 	? POLItpp::where('KdBPJS', $data->rujukan->poliRujukan->kode)->first()->toArray()
		// 	: null;
		// return response()->json([
		// 	'status' => true,
		// 	'data' => $data
		// ]);
		
		$vclaim_controller = new NewVClaimController();
		$noRujukan = $request->noRujukan;
		$request = $vclaim_controller->getRujukanByNomor($noRujukan);

		Log::info('BPJS Get Rujukan API Response:');
		Log::info(json_encode($request));

		$nik = isset($request['rujukan']['peserta']['nik']) ? $request['rujukan']['peserta']['nik'] : null;
		$pasien = null;
		if ($nik) {
			$pasien = MasterPS::where('NoIden', $nik)->first();
		}

		$data = $request;
		$KdBPJS = isset($request['rujukan']['poliRujukan']['kode']) ? $request['rujukan']['poliRujukan']['kode'] : '';
		$poli = POLItpp::where('KdBPJS', $KdBPJS)->first();
		$data['poli_local']['KDPoli'] = $poli ? $poli->KDPoli : '';
		$data['poli_local']['NMPoli'] = $poli ? $poli->NMPoli : '';
		$data['poli_local']['KdBPJS'] = $KdBPJS;

		return response()->json([
			'status' => true,
			'data' => $data,
			'pasien' => $pasien
		]);
	}

	public function get_peserta_rujukan_rs(Request $request)
	{
		$bpjs = new Bridging_bpjs();
		$data = $bpjs->get_perserta_rujukan_RS($request->noRujukan);
		if($data)
		$data->poli_local = @$data->rujukan->poliRujukan->kode
			? POLItpp::where('KdBPJS', $data->rujukan->poliRujukan->kode)->first()->toArray()
			: null;

		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function get_peserta_rujukan_no_kartu_pcare(Request $request)
	{
		$bpjs = new Bridging_bpjs();
		$data = $bpjs->get_peserta_rujukan_noKartu_pCare($request->nopeserta);
		if($data)
		$data->poli_local = @$data->rujukan->poliRujukan->kode
			? POLItpp::where('KdBPJS', $data->rujukan->poliRujukan->kode)->first()->toArray()
			: null;
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function get_peserta_rujukan_no_kartu_rs(Request $request)
	{
		$bpjs = new Bridging_bpjs();
		$data = $bpjs->get_peserta_rujukan_noKartu_rs($request->nopeserta);
		if($data)
		$data->poli_local = @$data->rujukan->poliRujukan->kode
			? POLItpp::where('KdBPJS', $data->rujukan->poliRujukan->kode)->first()->toArray()
			: null;
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function detail_kelas()
	{
		$kelas = new Bridging_bpjs();
		$data = $kelas->get_kelas();
		return response()->json([
			'data' => $data->list
		]);
	}

	public function update_tanggal_pulang(Request $request)
	{
		$validuser = "SIMRS";
		$noSep = $request->input("noSep");
		$tglPulang = $request->input("tglPulang");
		$waktuPulang = $request->input("waktuPulang");

		$data = array(
			'request' => [
				't_sep' => [
					'noSep' => $noSep ?? '',
					'tglPulang' => "$tglPulang $waktuPulang" ?? date('Y-m-d H:i:s'),
					'user' => $validuser,
				]
			]
		);


		// $pulang = new Bridging_bpjs();
		$response = VClaim::update_tanggal_pulang($data);
		return response()->json($response);
	}

	public function create_sep(Request $request)
	{
		Log::info('===========================================================================');
		$validuser = 'SIMRS';

		$noKartu = $request->input("noKartu");
		$tglSep = $request->input("tglSep");
		$ppkPelayanan = $request->input("ppkPelayanan");
		$jnsPelayanan = $request->input("jnsPelayanan");
		$klsRawat = $request->input("klsRawat");
		$noMR = $request->input("noMR");
		$asalRujukan = $request->input("asalRujukan");
		$tglRujukan = $request->input("tglRujukan");
		$noRujukan = $request->input("noRujukan");
		$ppkRujukan = $request->input("ppkRujukan");
		$catatan = $request->input("catatan");
		$diagAwal = $request->input("diagAwal");

		$tujuan = $request->input("tujuan");
		$poli = POLItpp::where('KDPoli', $tujuan)->first();

		$eksekutif = $request->input("eksekutif");
		$cob = $request->input("cob");
		$katarak = $request->input("katarak");
		$lakaLantas = $request->input("lakaLantas");
		$penjamin = $request->input("penjamin");
		$tglKejadian = $request->input("tglKejadian");
		$keterangan = $request->input("keterangan");
		$suplesi = $request->input("suplesi");
		$noSepSuplesi = $request->input("noSepSuplesi");
		$kdPropinsi = $request->input("kdPropinsi");
		$kdKabupaten = $request->input("kdKabupaten");
		$kdKecamatan = $request->input("kdKecamatan");
		$noSurat = $request->input("noSurat");

		$tujuan_kunjungan = $request->input('tujuan_kunjungan');
		$flag_procedure = $request->input('flag_procedure');
		$kode_penunjang = $request->input('kode_penunjang');
		$assesment = $request->input('assesment');

		$register = Register::where('NoRujuk', $noRujukan)->whereNotNull('NoSep')->first();
		$surat_kontrol = $register ? AwSuratKontrolHead::where('Regno', $register->Regno)->first() : null;

		$vclaim_controller = new NewVClaimController();
		$rencana_kontrol = $surat_kontrol ? $vclaim_controller->cariNomorSuratKontrol($surat_kontrol->no_surat_kontrol_bpjs) : [];
	
		Log::info('BPJS Surat Kontrol API Response:');
		Log::info($rencana_kontrol);

		$dokter = $request->input("dokter");
		$dokter = FtDokter::where('KdDoc', $dokter)->first();

		$poli = POLItpp::where('KDPoli', $tujuan)->first();

		$noTelp = $request->input("noTelp");
		$user = $validuser;

		if (count($rencana_kontrol) > 0) {
			$data_sep = [
				'noKartu' => $rencana_kontrol['sep']['peserta']['noKartu'],
				'tglSep' => $tglSep,
				'ppkPelayanan' => $ppkPelayanan,
				'jnsPelayanan' => $jnsPelayanan,
				'klsRawatHak' => $klsRawat,
				// 'klsRawatNaik' => $klsRawat,
				// 'pembiayaan' => $klsRawat,
				// 'penanggungJawab' => $klsRawat,
				'noMR' => $noMR,
				'asalRujukan' => $rencana_kontrol['sep']['provPerujuk']['asalRujukan'],
				'tglRujukan' => $rencana_kontrol['sep']['provPerujuk']['tglRujukan'],
				'noRujukan' => $rencana_kontrol['sep']['provPerujuk']['noRujukan'],
				'ppkRujukan' => $rencana_kontrol['sep']['provPerujuk']['kdProviderPerujuk'],
				'catatan' => $catatan,
				// 'diagAwal' => $rencana_kontrol['sep']['diagnosa'],
				'diagAwal' => $diagAwal,
				// 'diagAwal' => '480.2',
				'poli_tujuan' => $poli->KdBPJS,
				'poli_eksekutif' => $eksekutif,
				'cob' => $cob,
				'katarak' => $katarak,
				'lakaLantas' => $lakaLantas,
				'tglKejadian' => $tglKejadian,
				'keterangan' => $keterangan,
				'suplesi' => $suplesi,
				'noSepSuplesi' => $noSepSuplesi,
				'kdPropinsi' => $kdPropinsi,
				'kdKabupaten' => $kdKabupaten,
				'kdKecamatan' => $kdKecamatan,
				'tujuanKunj' => $tujuan_kunjungan,
				'flagProcedure' => $flag_procedure,
				'kdPenunjang' => $kode_penunjang,
				'assesmentPel' => $assesment,
				'noSurat' => $rencana_kontrol['noSuratKontrol'],
				'kodeDPJP' => $rencana_kontrol['kodeDokter'],
				'dpjpLayan' => $rencana_kontrol['kodeDokter'],
				'noTelp' => $noTelp,
				'user' => $user,
			];
		} else {
			$data_sep = [
				'noKartu' => $noKartu,
				'tglSep' => $tglSep,
				'ppkPelayanan' => $ppkPelayanan,
				'jnsPelayanan' => $jnsPelayanan,
				'klsRawatHak' => $klsRawat,
				// 'klsRawatNaik' => $klsRawat,
				// 'pembiayaan' => $klsRawat,
				// 'penanggungJawab' => $klsRawat,
				'noMR' => $noMR,
				'asalRujukan' => $asalRujukan,
				'tglRujukan' => $tglRujukan,
				'noRujukan' => $noRujukan,
				'ppkRujukan' => $ppkRujukan,
				'catatan' => $catatan,
				'diagAwal' => $diagAwal,
				'poli_tujuan' => $poli ? $poli->KdBPJS : '',
				'poli_eksekutif' => $eksekutif,
				'cob' => $cob,
				'katarak' => $katarak,
				'lakaLantas' => $lakaLantas,
				'tglKejadian' => $tglKejadian,
				'keterangan' => $keterangan,
				'suplesi' => $suplesi,
				'noSepSuplesi' => $noSepSuplesi,
				'kdPropinsi' => $kdPropinsi,
				'kdKabupaten' => $kdKabupaten,
				'kdKecamatan' => $kdKecamatan,
				'tujuanKunj' => $tujuan_kunjungan,
				'flagProcedure' => $flag_procedure,
				'kdPenunjang' => $kode_penunjang,
				'assesmentPel' => $assesment,
				'noSurat' => $noSurat,
				'kodeDPJP' => $dokter ? $dokter->KdDPJP : '',
				'dpjpLayan' => $dokter ? $dokter->KdDPJP : '',
				'noTelp' => $noTelp,
				'user' => $user,
			];
		}
	
		$vclaim_controller = new NewVClaimController();
		$response = $vclaim_controller->insertSEPV2($data_sep);

		Log::info('BPJS Create SEP API Response:');
		Log::info($response);

		if (isset($response['sep'])) {
			$response['metaData'] = [
				'code' => 200,
				'message' => 'success'
			];
			$response['response'] = $response;
		}
		
		if (isset($response['metaData']['code']) && $response['metaData']['code'] == '201') {
			return response()->json([
				'metaData' => $response['metaData'],
				'data' => $response['response']
			]);
		} else {
			return response()->json([
				'metaData' => $response['metaData'],
				'data' => $response['response']
			]);
		}
	}

	public function update_sep(Request $request)
	{
		$noSep = $request->input('NoSep');
		$klsRawat = $request->input("klsRawat");
		$medrec = $request->input("noMR");
		$asalRujukan = $request->input('asalRujukan');
		$tglRujukan = $request->input("tglRujukan");
		$noRujukan = $request->input("noRujukan");
		$ppkRujukan = $request->input("ppkRujukan");
		$catatan = $request->input("catatan");
		$diagAwal = $request->input("diagAwal");
		$eksekutif = $request->input("eksekutif");
		$cob = $request->input("cob");
		$katarak = $request->input("katarak");
		$noSurat = $request->input('noSurat');
		$kodeDPJP = $request->input("kodeDPJP");
		$lakaLantas = $request->input("lakaLantas");
		$penjamin = $request->input("penjamin");
		$tglKejadian = $request->input("tglKejadian");
		$keterangan = $request->input("keterangan");
		$suplesi = $request->input("suplesi");
		$noSepSuplesi = $request->input("noSepSuplesi");
		$kdPropinsi = $request->input("kdPropinsi");
		$kdKabupaten = $request->input("kdKabupaten");
		$kdKecamatan = $request->input("kdKecamatan");
		$noTelp = $request->input("noTelp");

		$data = array(
			'request' => [
				't_sep' => [
					'noSep' => $noSep ?? '',
					'klsRawat' => $klsRawat ?? '3',
					'noMR' => $medrec ?? '',
					'rujukan' => [
						'asalRujukan' => $asalRujukan ?? '',
						'tglRujukan' => $tglRujukan ?? '',
						'noRujukan' => $noRujukan ?? '',
						'ppkRujukan' => $ppkRujukan ?? '',
					],
					'catatan' => $catatan ?? '',
					'diagAwal' => $diagAwal ?? '',
					'poli' => [
						'eksekutif' => $eksekutif ?? '0',
					],
					'cob' => [
						'cob' => $cob ?? '0',
					],
					'katarak' => [
						'katarak' => $katarak ?? '0',
					],
					'skdp' => [
						'noSurat' => $noSurat ?? '',
						'kodeDPJP' => $kodeDPJP ?? '',
					],
					'jaminan' => [
						'lakaLantas' => $lakaLantas ?? '0',
						'penjamin' => [
							'penjamin' => $penjamin ?? '0',
							'tglKejadian' => $tglKejadian ?? '',
							'keterangan' => $keterangan ?? '',
							'suplesi' => [
								'suplesi' => $suplesi ?? '0',
								'noSepSuplesi' => $noSepSuplesi ?? '',
								'lokasiLaka' => [
									'kdPropinsi' => $kdPropinsi ?? '',
									'kdKabupaten' => $kdKabupaten ?? '',
									'kdKecamatan' => $kdKecamatan ?? '',
								]
							]
						]
					],
					'noTelp' => $noTelp ?? '',
					'user' => "SIMRS",
				]
			]
		);

		// dd($data);

		// $sep = new Bridging_bpjs();
		$response = VClaim::update_sep($data);
		if ($response->metaData->code == '201') {
			return response()->json([
				'metaData' => $response->metaData,
				'data' => $response->response
			]);
		} else {
			return response()->json([
				'metaData' => $response->metaData,
				'data' => $response->response
			]);
		}
	}

	public function get_sep(Request $request)
	{
		$bpjs = new Bridging_bpjs();
		$data = $bpjs->get_sep($request->noSep);
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function delete_sep(Request $request)
	{
		$noSep = $request->input("noSep");
		$validuser = 'SIMRS';

		$data = array(
			'request' => [
				't_sep' => [
					'noSep' => $noSep,
					'user' => $validuser
				]
			]
		);

		$sep = new Bridging_bpjs();
		$response = $sep->delete_sep($data);
		if ($response->metaData->code == '201') {
			return response()->json([
				'metaData' => $response->metaData,
				'data' => $response->response
			]);
		} else {
			return response()->json([
				'metaData' => $response->metaData,
				'data' => $response->response
			]);
		}
	}

	public function cek_tempat_tidur(Request $request)
	{
		$data = [
			'kelas' => $request->input('kelas') !== null ? $request->input('kelas') : ''
		];
		
		$mutasi = new Procedure();
		$list = $mutasi->stpnet_ViewNoBedBPJS_REGxhos($data);
		// dd($list);
		return response()->json([
			'data' => $list
		]);
	}


    public function cek_bed(Request $request)
    {
        $kdBangsal = '02';
        $cekBed = Procedure::stpnet_ViewBedKosong_INAxhos($kdBangsal);
        dd($cekBed);
    }

	public function cek_bed1(Request $request)
	{
		$bangsal = $request->input("KdBangsal");
		$bed = new Procedure();
		$data = $bed->stpnet_ViewBedKosong_INAxhos($bangsal);
		dd($data);
		return response()->json([
			'data' => $data,
		]);
	}

	public function post_keyakinan(Request $request)
	{
		// dd($request->all());
		$data = [
			'medrec' => $request->input("medrec"),
			'phcek' => $request->input("phcek"),
			'phnote' => $request->input("phnote"),
			'ptcek' => $request->input("ptcek"),
			'ptnote' => $request->input("ptnote"),
			'pmcek' => $request->input("pmcek"),
			'pmnote' => $request->input("pmnote"),
			'ppcek' => $request->input("ppcek"),
			'ppnote' => $request->input("ppnote"),
			'lain' => $request->input("lain")
		];
		$procedure = new Procedure();
		$response = $procedure->spwe_AddKeyakinanxhos($data);
		return response()->json([
			'data' => $response
		]);
	}
}