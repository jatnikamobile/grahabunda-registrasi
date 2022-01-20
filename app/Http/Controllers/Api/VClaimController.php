<?php

namespace App\Http\Controllers\Api;

use App\Bridging\VClaim;
use App\Http\Controllers\Bridging\NewVClaimController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VClaimController extends Controller
{
	public function cari_peserta_by_bpjs(Request $request)
	{
		$no_kartu = $request->no_kartu;
		$tanggal_sep = $request->tanggal_sep ?: date('Y-m-d');
		return response()->json(VClaim::get_peserta_bpjs($no_kartu, $tanggal_sep));
	}

	public function diagnosa(Request $request)
	{
		$term = $request->term;
		$vclaim = new NewVClaimController();
		$diagnosa =$vclaim->referensiDiagnosa($term);
		return response()->json($diagnosa);
	}

	public function poli(Request $request)
	{
		$term = $request->term;
		$vclaim = new NewVClaimController();
		$poli =$vclaim->referensiPoli($term);
		return response()->json($poli);
	}

	public function faskes(Request $request)
	{
		$term = $request->term;
		$faskes = $request->faskes;
		$vclaim = new NewVClaimController();
		$faskes =$vclaim->referensiFasilitasKesehatan($term, $faskes);
		return response()->json($faskes);
	}

	public function dokter_dpjp(Request $request)
	{
		$pelayanan = $request->pelayanan;
		$tanggal = $request->tanggal ?: date('Y-m-d');
		$spesialis = $request->spesialis;
		$vclaim = new NewVClaimController();
		$dokter = $vclaim->referensiDokterDPJP($pelayanan, $tanggal, $spesialis);
		return response()->json($dokter);
	}

	public function propinsi(Request $request)
	{
		$vclaim = new NewVClaimController();
		$propinsi = $vclaim->referensiPropinsi();
		return response()->json($propinsi);
	}

	public function kabupaten(Request $request)
	{
		$propinsi = $request->propinsi;
		$vclaim = new NewVClaimController();
		$kabupaten = $vclaim->referensiKabupaten($propinsi);
		return response()->json($kabupaten);
	}

	public function kecamatan(Request $request)
	{
		$kabupaten = $request->kabupaten;
		$vclaim = new NewVClaimController();
		$kecamatan = $vclaim->referensiKecamatan($kabupaten);
		return response()->json($kecamatan);
	}

	public function tindakan(Request $request)
	{
		$term = $request->term;
		$vclaim = new NewVClaimController();
		$tindakan = $vclaim->referensiProcedureTindakan($term);
		return response()->json($tindakan);
	}

	public function kelas_rawat(Request $request)
	{
		$vclaim = new NewVClaimController();
		$kelas_rawat = $vclaim->referensiKelasRawat();
		return response()->json($kelas_rawat);
	}

	public function dokter(Request $request)
	{
		$term = $request->term;
		$vclaim = new NewVClaimController();
		$dokter = $vclaim->referensiDokter($term);
		return response()->json($dokter);
	}

	public function spesialistik(Request $request)
	{
		$vclaim = new NewVClaimController();
		$spesialistik = $vclaim->referensiSpesialistik();
		return response()->json($spesialistik);
	}

	public function ruang_rawat(Request $request)
	{
		$vclaim = new NewVClaimController();
		$ruang_rawat = $vclaim->referensiRuangRawat();
		return response()->json($ruang_rawat);
	}

	public function cara_keluar(Request $request)
	{
		$vclaim = new NewVClaimController();
		$cara_keluar = $vclaim->referensiCaraKeluar();
		return response()->json($cara_keluar);
	}

	public function pasca_pulang(Request $request)
	{
		$vclaim = new NewVClaimController();
		$pasca_pulang = $vclaim->referensiPascaPulang();
		return response()->json($pasca_pulang);
	}

	public function rujukan(Request $request)
	{
		return response()->json(VClaim::get_rujukan_by_nomor_rujukan($request->noRujukan, !$request->pcare));
	}

	public function sep(Request $request)
	{
		$no_sep = $request->no_sep;
		return response()->json(VClaim::get_sep($no_sep));
	}

	public function lembar_pk(Request $request)
	{
		$tanggal = $request->tanggal;
		$pelayanan = $request->pelayanan;

		return response()->json(VClaim::get_lpk($tanggal, $pelayanan));
	}

	public function potensi_suplesi(Request $request)
	{
		$tanggal = $request->tanggal;
		$no_kartu = $request->no_kartu;

		return response()->json(VClaim::get_suplesi_jasa_raharja($no_kartu, $tanggal));
	}

	public function histori_peserta(Request $request)
	{
		$no_kartu = $request->no_kartu;
		$tanggal_mulai = $request->tanggal_mulai;
		$tanggal_akhir = $request->tanggal_akhir;

		$vklaim_controller = new NewVClaimController();
		$response = $vklaim_controller->dataHistoriPelayananPeserta($no_kartu, $tanggal_mulai, $tanggal_akhir);

		Log::info('BPJS History Pelayanan Peserta API Response:');
		Log::info(json_encode($response));

		if (isset($response['histori'])) {
			$response['metaData'] = [
				'code' => 200,
				'message' => 'success'
			];
			$response['response'] = $response;
		}

		return response()->json($response);
	}

	public function klaim_jasa_raharja(Request $request)
	{
		$tanggal_mulai = $request->tanggal_mulai;
		$tanggal_akhir = $request->tanggal_akhir;

		return response()->json(VClaim::data_klaim_jasa_raharja($tanggal_mulai, $tanggal_akhir));
	}

	public function create_pengajuan_sep(Request $request)
	{
        $data = [
            "request" => [
                "t_sep" => [
                    "noKartu" => $request->no_peserta,
                    "tglSep" => $request->tanggal_sep,
                    "jnsPelayanan" => $request->pelayanan,
                    "keterangan" => ''.$request->keterangan,
                    "user" => "Coba Ws",
                ]
            ]
        ];

        return response()->json(VClaim::pengajuan_sep($data));
	}

	public function create_approval_sep(Request $request)
	{
        $data = [
            "request" => [
                "t_sep" => [
                    "noKartu" => $request->no_peserta,
                    "tglSep" => $request->tanggal_sep,
                    "jnsPelayanan" => $request->pelayanan,
                    "keterangan" => $request->keterangan,
                    "user" => "Coba Ws",
                ]
            ]
        ];
        // dd($data);

        return response()->json(VClaim::approval_sep($data));
	}

	public function create_rujukan(Request $request)
	{
		$data = [
			'request' => [
				't_rujukan' => [
					'noSep' => $request->NoSep,
					'tglRujukan' => $request->TglRujukan,
					'ppkDirujuk' => $request->Ppk,
					'jnsPelayanan' => $request->JenisPelayanan,
					'catatan' => $request->Catatan,
					'diagRujukan' => $request->DiagRujuk,
					'tipeRujukan' => $request->TipeRujukan,
					'poliRujukan' => $request->KdPoli,
					'user' => 'SIMRS',
				]
			]
		];

		return response()->json(VClaim::insert_rujukan($data));
	}

	public function monitoring_kunjungan(Request $request)
	{
		$tanggal_sep = $request->tanggal_sep;
		$pelayanan = $request->pelayanan;

		return response()->json(VClaim::monitoring_kunjungan($tanggal_sep, $pelayanan));
	}

	public function monitoring_klaim(Request $request)
	{
		$tanggal_sep = $request->tanggal_sep;
		$pelayanan = $request->pelayanan;
		$status = $request->status;

		return response()->json(VClaim::monitoring_klaim($tanggal_sep, $pelayanan, $status));
	}

	public function rujukan_list(Request $request)
	{
		$no_kartu = $request->no_kartu;
		if ($request->status_rujuk == '1') {
			return response()->json(VClaim::get_rujukan_by_nomor_kartu_list($no_kartu));
		}
		return response()->json(VClaim::get_rujukan_by_nomor_kartu_list($no_kartu, true));
	}
}