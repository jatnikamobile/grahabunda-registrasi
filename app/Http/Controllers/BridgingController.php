<?php

namespace App\Http\Controllers;

use App\Bridging\VClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BridgingController extends Controller
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

    public function referensi(Request $request)
    {
        return view('bridging.referensi');
    }

    public function kunjungan(Request $request)
    {
        return view('bridging.monitoring_kunjungan');
    }

    public function klaim(Request $request)
    {
        return view('bridging.monitoring_klaim');
    }

    public function suplesi(Request $request)
    {
        return view('bridging.suplesi');
    }

    public function histori_peserta(Request $request)
    {
        return view('bridging.histori_peserta');
    }

    public function klaim_jasa_raharja(Request $request)
    {
        return view('bridging.klaim_jasa_raharja');
    }

    public function lpk(Request $request)
    {
        return view('bridging.lembar_pk');
    }

    public function lpk_create(Request $request)
    {
        return view('bridging.lpk.form');
    }

    public function lpk_list(Request $request)
    {
        $no_rm = $request->no_rm;
        $nama_pasien = $request->nama_pasien;
        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_akhir = $request->tanggal_akhir;

        $query = DB::connection('main')->table('flpk')
            ->select(
                ['nosep', 'nopeserta', 'medrec', 'firstname', 'tglmasuk', 'tglkeluar', 'validuser']
            );

        if(!empty($no_rm))
        {
            $query->where('medrec', $no_rm);
        }

        if(!empty($nama_pasien))
        {
            $query->where('firstname', $nama_pasien);
        }

        if(!empty($tanggal_mulai) && !empty($tanggal_akhir))
        {
            $query->where('tglmasuk', '>=', $tanggal_mulai);
            $query->where('tglmasuk', '<=', $tanggal_akhir);
        }

        return $query->get()->all();
    }

    public function lpk_store(Request $request)
    {
        $data = [
            'request' => [
                't_lpk' => [
                    'noSep' => $request->no_sep ?? '',
                    'tglMasuk' => $request->tanggal_masuk ?? '',
                    'tglKeluar' => $request->tanggal_keluar ?? '',
                    'jaminan' => $request->jaminan ?? '',
                    'poli' => [
                        'poli' => $request->poli ?? ''
                    ],
                    'perawatan' => [
                        'ruangRawat' => $request->ruang_rawat ?? '',
                        'kelasRawat' => $request->kelas ?? '',
                        'spesialistik' => $request->spesialistik ?? '',
                        'caraKeluar' => $request->cara_keluar ?? '',
                        'kondisiPulang' => $request->kondisi_pulang ?? '',
                    ],
                    'rencanaTL' => [
                        'tindakLanjut' => $request->tindak_lanjut ?? '',
                        'dirujukKe' => [
                            'kodePPK' => $request->ppk_rujukan ?? '',
                        ],
                        'kontrolKembali' => [
                            'tglKontrol' => $request->tanggal_kontrol ?? '',
                            'poli' => $request->tindak_lanjut_poli ?? '',
                        ]
                    ],
                    'DPJP' => $request->dpjp ?? '',
                    'user' => 'Coba Ws',
                ]
            ]
        ];

        $data['request']['t_lpk']['diagnosa'] = $request->diagnosa ? array_map(function($i, $j) {
                        return ['kode' => $i, 'level' => $j ?? 2];
                    }, $request->diagnosa , [1]) : [];

        $data['request']['t_lpk']['procedure'] = $request->procedure ? array_map(function($i) {
                        return ['kode' => $i];
                    }, $request->procedure) : [];

        $response = VClaim::insert_lpk($data);

        return response()->json($response);
    }
}
