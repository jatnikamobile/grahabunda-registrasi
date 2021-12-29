<?php

namespace App\Http\Controllers\Api;

use App\Bridging\VClaim;
use App\Http\Controllers\Bridging\NewVClaimController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
		return response()->json(VClaim::get_diagnosa($term));
	}

	public function poli(Request $request)
	{
		$term = $request->term;
		return response()->json(VClaim::get_poli($term));
	}

	public function faskes(Request $request)
	{
		$term = $request->term;
		$faskes = $request->faskes;
		return response()->json(VClaim::get_faskes($faskes, $term));
	}

	public function dokter_dpjp(Request $request)
	{
		$pelayanan = $request->pelayanan;
		$tanggal = $request->tanggal ?: date('Y-m-d');
		$spesialis = $request->spesialis;
		return response()->json(VClaim::get_dokter_dpjp($pelayanan, $tanggal, $spesialis));
	}

	public function propinsi(Request $request)
	{
		return response()->json(VClaim::get_propinsi());
	}

	public function kabupaten(Request $request)
	{
		$propinsi = $request->propinsi;
		return response()->json(VClaim::get_kabupaten($propinsi));
	}

	public function kecamatan(Request $request)
	{
		$kabupaten = $request->kabupaten;
		return response()->json(VClaim::get_kecamatan($kabupaten));
	}

	public function tindakan(Request $request)
	{
		$term = $request->term;
		return response()->json(VClaim::get_tindakan($term));
	}

	public function kelas_rawat(Request $request)
	{
		return response()->json(VClaim::get_kelas_rawat());
	}

	public function dokter(Request $request)
	{
		$term = $request->term;
		return response()->json(VClaim::get_dokter($term));
	}

	public function spesialistik(Request $request)
	{
		return response()->json(VClaim::get_spesialistik());
	}

	public function ruang_rawat(Request $request)
	{
		return response()->json(VClaim::get_ruang_rawat());
	}

	public function cara_keluar(Request $request)
	{
		return response()->json(VClaim::get_cara_keluar());
	}

	public function pasca_pulang(Request $request)
	{
		return response()->json(VClaim::get_pasca_pulang());
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