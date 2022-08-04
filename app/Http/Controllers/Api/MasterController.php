<?php

namespace App\Http\Controllers\Api;

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
use App\Models\DeleteSepLog;
use App\Models\Fppri;
use App\Models\SuratKontrolInap;
use App\RegisterTaskData;
use DateTime;
use DateTimeZone;
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
		$kunjungan = Register::where('Medrec', $medrec)->first();

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
		// if ($sep == '') {
			$resp['stat'] = true;
			$resp['data'] = array();
		// }else{
		// 	$cek = (new Register)->cek_sep_pasien($sep);
		// 	if (empty($cek)) {
		// 		$resp['stat'] = true;
		// 		$resp['data'] = array();
		// 	}else {
		// 		$resp['stat'] = false;
		// 		$resp['data'] = $cek;
				
		// 		if($cek->Regno == $regno){
		// 			$resp['stat'] = true;
		// 		}
		// 		elseif(
		// 			$cek->Medrec == $medrec &&
		// 			date('Y-m-d', strtotime($cek->Regdate)) == date('Y-m-d', strtotime($regdate)) &&
		// 			$cek->Kategori == $kategori && 
		// 			$cek->KdCbayar == $cbayar &&
		// 			$cek->KdPoli == $poli
		// 		){
		// 			$resp['stat'] = true;
		// 		}
		// 	}
		// }
			
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
		Log::info($request);
		$peserta = $request['peserta'];
		$pasien = $peserta ? MasterPS::where('NoIden', $peserta['nik'])->first() : null;
		$registers = Register::where('NoPeserta', $nopeserta)->get();

		return response()->json([
			'status' => true,
			'data' => $request,
			'pasien' => $pasien,
			'kunjungan' => count($registers) > 0 ? 'Lama' : 'Baru'
		]);
	}

	public function get_peserta_nik(Request $request)
	{
		$reg_type = $request->reg_type;

		if ($reg_type == 'umum') {
			$nik = $request->nik;
			$data = true;
			$pasien = MasterPS::where('NoIden', $nik)->orderBy('TglDaftar', 'desc')->first();
			$no_peserta = $pasien ? $pasien->AskesNo : null;
			$registers = $pasien ? Register::where('Medrec', $pasien->Medrec)->get() : [];
		} else {
			$vclaim_controller = new NewVClaimController();
			$nik = $request->nik;
			$tanggal = date('Y-m-d');
			$data = $vclaim_controller->pesertaNIK($nik, $tanggal);
			Log::info($data);
			$peserta = $data['peserta'];
			$pasien = $peserta ? MasterPS::where('NoIden', $peserta['nik'])->orderBy('TglDaftar', 'desc')->first() : null;
			$no_peserta = $peserta ? $peserta['noKartu'] : null;
			$registers = $no_peserta ? Register::where('NoPeserta', $no_peserta)->get() : [];
		}
		$bod = $pasien ? date('Y-m-d', strtotime($pasien->Bod)) : null;

		return response()->json([
			'status' => true,
			'data' => $data,
			'pasien' => $pasien,
			'kunjungan' => count($registers) > 0 ? 'Lama' : 'Baru',
			'bod' => $bod
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
		$noRujukan = strtoupper($request->noRujukan);
		$request = $vclaim_controller->getRujukanByNomor($noRujukan, 1);

		Log::info('BPJS Get Rujukan API Response:');
		Log::info($request);

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
		$no_peserta = isset($request['rujukan']['peserta']['noKartu']) ? $request['rujukan']['peserta']['noKartu'] : null;
		$registers = $no_peserta ? Register::where('NoPeserta', $no_peserta)->get() : [];

		return response()->json([
			'code' => isset($request['metaData']['code']) ? $request['metaData']['code'] : 200,
			'message' => isset($request['metaData']['message']) ? $request['metaData']['message'] : null,
			'status' => true,
			'data' => $data,
			'pasien' => $pasien,
			'kunjungan' => count($registers) > 0 ? 'Lama' : 'Baru'
		]);
	}

	public function get_peserta_rujukan_rs(Request $request)
	{
		$vclaim_controller = new NewVClaimController();
		$noRujukan = strtoupper($request->noRujukan);
		$request = $vclaim_controller->getRujukanByNomor($noRujukan, 2);

		Log::info('BPJS Get Rujukan API Response:');
		Log::info($request);

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
		$no_peserta = isset($request['rujukan']['peserta']['noKartu']) ? $request['rujukan']['peserta']['noKartu'] : null;
		$registers = $no_peserta ? Register::where('NoPeserta', $no_peserta)->get() : [];

		return response()->json([
			'code' => isset($request['metaData']['code']) ? $request['metaData']['code'] : 200,
			'message' => isset($request['metaData']['message']) ? $request['metaData']['message'] : null,
			'status' => true,
			'data' => $data,
			'pasien' => $pasien,
			'kunjungan' => count($registers) > 0 ? 'Lama' : 'Baru'
		]);
	}

	public function get_peserta_rujukan_no_kartu_pcare(Request $request)
	{
		$vclaim_controller = new NewVClaimController();
		$nopeserta = $request->nopeserta;
		$request = $vclaim_controller->getOneRujukanByNoKartu($nopeserta, 1);

		Log::info('BPJS Get Rujukan API Response:');
		Log::info($request);

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
		$no_peserta = isset($request['rujukan']['peserta']['noKartu']) ? $request['rujukan']['peserta']['noKartu'] : null;
		$registers = $no_peserta ? Register::where('NoPeserta', $no_peserta)->get() : [];

		return response()->json([
			'asalFaskes' => isset($request['asalFaskes']) ? $request['asalFaskes'] : null,
			'code' => isset($request['metaData']['code']) ? $request['metaData']['code'] : 200,
			'message' => isset($request['metaData']['message']) ? $request['metaData']['message'] : null,
			'status' => true,
			'data' => $data,
			'pasien' => $pasien,
			'kunjungan' => count($registers) > 0 ? 'Lama' : 'Baru'
		]);
	}

	public function get_peserta_rujukan_no_kartu_rs(Request $request)
	{
		$vclaim_controller = new NewVClaimController();
		$nopeserta = $request->nopeserta;
		$request = $vclaim_controller->getOneRujukanByNoKartu($nopeserta, 2);

		Log::info('BPJS Get Rujukan API Response:');
		Log::info($request);

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
		$no_peserta = isset($request['rujukan']['peserta']['noKartu']) ? $request['rujukan']['peserta']['noKartu'] : null;
		$registers = $no_peserta ? Register::where('NoPeserta', $no_peserta)->get() : [];

		return response()->json([
			'asalFaskes' => isset($request['asalFaskes']) ? $request['asalFaskes'] : null,
			'code' => isset($request['metaData']['code']) ? $request['metaData']['code'] : 200,
			'message' => isset($request['metaData']['message']) ? $request['metaData']['message'] : null,
			'status' => true,
			'data' => $data,
			'pasien' => $pasien,
			'kunjungan' => count($registers) > 0 ? 'Lama' : 'Baru'
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

		$StatusRujuk = $request->input('StatusRujuk');
		$type = $request->input("type");
		$Regno = $request->input("Regno");
		$noKartu = $request->input("noKartu");
		$tglSep = $request->input("tglSep");
		$ppkPelayanan = $request->input("ppkPelayanan");
		$jnsPelayanan = $request->input("jnsPelayanan");
		$klsRawat = $request->input("klsRawat");
		$noMR = $request->input("noMR");
		$asalRujukan = $request->input("asalRujukan");
		$tglRujukan = $request->input("tglRujukan");
		$noRujukan = strtoupper($request->input("noRujukan"));
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
		$noSurat = strtoupper($request->input("noSurat"));

		$tujuan_kunjungan = $request->input('tujuan_kunjungan');
		$flag_procedure = $request->input('flag_procedure');
		$kode_penunjang = $request->input('kode_penunjang');
		$assesment = $request->input('assesment');
		$DocYgMerawat = $request->input('DocYgMerawat');

		if ($type == 'spri') {
			$register = Register::where('Regno', $Regno)->first();
	
			$vclaim_controller = new NewVClaimController();
			$rencana_kontrol = $noSurat ? $vclaim_controller->cariNomorSuratKontrol($noSurat) : [];
		
			Log::info('BPJS Surat Kontrol API Response:');
			Log::info($rencana_kontrol);
	
			$dokter = $request->input("dokter");
			$dokter = FtDokter::where('KdDoc', $DocYgMerawat)->first();
	
			$poli = POLItpp::where('KDPoli', $tujuan)->first();
	
			$noTelp = $request->input("noTelp");
			$user = $validuser;

			$code = isset($rencana_kontrol['metaData']['code']) ? $rencana_kontrol['metaData']['code'] : 201;
	
			if ($code == 200) {
				$data_sep = [
					'noKartu' => $noKartu,
					'tglSep' => $rencana_kontrol['tglRencanaKontrol'],
					'ppkPelayanan' => $ppkPelayanan,
					'jnsPelayanan' => $jnsPelayanan,
					'klsRawatHak' => $klsRawat,
					// 'klsRawatNaik' => $klsRawat,
					// 'pembiayaan' => $klsRawat,
					// 'penanggungJawab' => $klsRawat,
					'noMR' => $noMR,
					'asalRujukan' => $StatusRujuk == 2 ? 1 : 2,
					'tglRujukan' => date('Y-m-d', strtotime($register->Regdate)),
					'noRujukan' => $register ? $register->NoSep : '',
					'ppkRujukan' => config('vclaim.kode_ppk'),
					'catatan' => $catatan,
					'diagAwal' => $register ? $register->KdICD : '',
					'poli_tujuan' => '',
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
					'tujuanKunj' => 0,
					'flagProcedure' => '',
					'kdPenunjang' => '',
					'assesmentPel' => '',
					'noSurat' => $noSurat,
					'kodeDPJP' => $dokter ? $dokter->KdDPJP : '',
					'dpjpLayan' => '',
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
					'asalRujukan' => $StatusRujuk == 2 ? 1 : 2,
					'tglRujukan' => date('Y-m-d', strtotime($register->Regdate)),
					'noRujukan' => $register ? $register->NoSep : '',
					'ppkRujukan' => config('vclaim.kode_ppk'),
					'catatan' => $catatan,
					'diagAwal' => $register ? $register->KdICD : '',
					'poli_tujuan' => '',
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
					'tujuanKunj' => 0,
					'flagProcedure' => '',
					'kdPenunjang' => '',
					'assesmentPel' => '',
					'noSurat' => $noSurat,
					'kodeDPJP' => $dokter ? $dokter->KdDPJP : '',
					'dpjpLayan' => '',
					'noTelp' => $noTelp,
					'user' => $user,
				];
			}
		} else {
			$register = Register::where('NoRujuk', $noRujukan)->whereNotNull('NoSep')->first();
			$surat_kontrol = $register ? AwSuratKontrolHead::where('Regno', $register->Regno)->where('no_surat_kontrol_bpjs', $noSurat)->first() : null;
			$no_surat_kontrol = $surat_kontrol ? $surat_kontrol->no_surat_kontrol_bpjs : $noSurat;
	
			$vclaim_controller = new NewVClaimController();
			$rencana_kontrol = $vclaim_controller->cariNomorSuratKontrol($no_surat_kontrol);
		
			Log::info('BPJS Surat Kontrol API Response:');
			Log::info($rencana_kontrol);
	
			$dokter = $request->input("dokter");
			$dokter = FtDokter::where('KdDoc', $dokter)->first();
	
			$poli = POLItpp::where('KDPoli', $tujuan)->first();
	
			$noTelp = $request->input("noTelp");
			$user = $validuser;

			$code = isset($rencana_kontrol['metaData']['code']) ? $rencana_kontrol['metaData']['code'] : 201;
	
			if ($code == 200) {
				$register = $register ?: Fppri::where('nosep', $rencana_kontrol['sep']['noSep'])->first();
				$data_sep = [
					'noKartu' => $rencana_kontrol['sep']['peserta']['noKartu'],
					'tglSep' => $rencana_kontrol['tglRencanaKontrol'],
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
					'ppkRujukan' => $rencana_kontrol['provPerujuk']['kdProviderPerujuk'],
					'catatan' => $catatan,
					// 'diagAwal' => $rencana_kontrol['sep']['diagnosa'],
					'diagAwal' => $diagAwal ?: ($register ? $register->KdIcd : null),
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

			$kode_booking = $register->Regno;
			$register_task_data = RegisterTaskData::where('registrasi_id', $Regno)->where('task_id', 3)->where('tanggal', date('Y-m-d'))->first();
			if ($kode_booking && !$register_task_data) {
				$int_time = strtotime(date('Y-m-d H:i:s') . ' Asia/Jakarta') * 1000;
				$data_update_waktu_antrean = [
					"kodebooking" => $kode_booking,
					"taskid" => 3,
					"waktu" => $int_time
				];
	
				$vclaim_controller = new NewVClaimController();
				$update_waktu_antrean = $vclaim_controller->wsBpjsUpdateWaktuAntrean($data_update_waktu_antrean);

                $tz = 'Asia/Jakarta';
                $timestamp = time();
                $dt = new DateTime('now', new DateTimeZone($tz));
                $dt->setTimestamp($timestamp);
                $tm_tz = $dt->format('Y-m-d H:i:s');

                $register_task_data = new RegisterTaskData();
                $register_task_data->registrasi_id = $kode_booking;
                $register_task_data->tanggal = date('Y-m-d');
                $register_task_data->waktu = $tm_tz;
                $register_task_data->task_id = 3;
                $register_task_data->save();
			}
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
		$no_sep = $request->noSep;
		$vclaim_controller = new NewVClaimController();
		$data_sep = $vclaim_controller->cariSEP($no_sep);

		return response()->json([
			'status' => true,
			'data' => $data_sep
		]);
	}

	public function delete_sep(Request $request)
	{
		$noSep = $request->noSep;
		$vclaim_controller = new NewVClaimController();
		$validuser = $request->user;

		if (!$validuser) {
			return response()->json(['data' => false, 'message' => 'User tidak ditemukan. Silahkan login ulang!']);
		}

		try {
			$delete_sep_log = new DeleteSepLog();
			$delete_sep_log->no_sep = $noSep;
			$delete_sep_log->deleted_date = date('Y-m-d H:i:s');
			$delete_sep_log->user = $validuser;
			$delete_sep_log->save();

			$data = array(
				'noSep' => $noSep,
				'user' => $validuser
			);

			$response = $vclaim_controller->hapusSEP($data);
			if ($response == $noSep) {
				return response()->json([
					'data' => $response
				]);
			} else {
				$delete_sep_log->delete();
				$message = isset($response['metaData']['message']) ? $response['metaData']['message'] : 'Hapus SEP Gagal!';
				return response()->json([
					'message' => $message,
					'data' => false
				]);
			}
		} catch (\Throwable $th) {
			$message = $th->getMessage();
			return response()->json([
				'message' => $message,
				'data' => false
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