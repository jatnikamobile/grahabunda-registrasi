<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RsNet\AdmKunjungan;
use App\Models\RsNet\TmPasien;
use App\Models\RsNet\TmPasienKontraktor;

class ApiController extends Controller
{
    public function storeRujukan(Request $request)
    {
        $data = [
            'I_KelRujukan' => $request->I_KelRujukan,
            'N_Rujukan' => $request->N_Rujukan,
            'A_Rujukan' => $request->A_Rujukan,
            'Kota_Rujukan' => $request->Kota_Rujukan,
            'I_Entry' => $request->I_Entry,
            'D_Entry' => $request->D_Entry,
            'C_PPKRujukan' => $request->C_PPKRujukan,
        ];

        $url = config('app.api_db_url') . '/api/master/rujukan';
        $response = $this->sendApiRequest($data, $url);

        return response()->json(['status' => 'success', 'response' => $response]);
    }

    public function storeKunjungan(Request $request)
    {
        $poli = $request->poli;
        $url_unit = config('app.api_db_url') . '/api/master/get-unit-by-id';
        $data_unit = [
            'i_unit' => $poli
        ];
        $unit = $this->sendApiRequest($data_unit, $url_unit);
        
        if ($unit['status'] == 'success') {
            $data_unit = $unit['unit'];
            $data = [
                'I_RekamMedis' => $request->I_RekamMedis,
                'I_Bagian' => $data_unit['I_Bagian'],
                'I_Unit' => $poli,
                'I_UrutMasuk' => $request->I_UrutMasuk,
                'D_Masuk' => $request->D_Masuk,
                'D_Keluar' => $request->D_Keluar,
                'C_Pegawai' => $request->C_Pegawai,
                'I_Penerimaan' => $request->I_Penerimaan,
                'I_Rujukan' => $request->I_Rujukan,
                'N_DokterPengirim' => $request->N_DokterPengirim,
                'N_Diagnosa' => $request->N_Diagnosa,
                'N_Tindakan' => $request->N_Tindakan,
                'N_Terapi' => $request->N_Terapi,
                'I_Kontraktor' => $request->I_Kontraktor,
                'N_PenanggungJwb' => $request->N_PenanggungJwb,
                'Telp_PenanggungJwb' => $request->Telp_PenanggungJwb,
                'A_PenanggungJwb' => $request->A_PenanggungJwb,
                'I_StatusBaru' => $request->I_StatusBaru,
                'I_Kontrol' => $request->I_Kontrol,
                'I_StatusKunjungan' => $request->I_StatusKunjungan,
                'C_Shift' => $request->C_Shift,
                'I_Entry' => $request->I_Entry,
                'D_Entry' => $request->D_Entry,
                'I_StatusPasien' => $request->I_StatusPasien,
                'N_PasienLuar' => $request->N_PasienLuar,
                'A_PasienLuar' => $request->A_PasienLuar,
                'JK_PasienLuar' => $request->JK_PasienLuar,
                'Umur_tahun' => $request->Umur_tahun,
                'Umur_bulan' => $request->Umur_bulan,
                'Umur_hari' => $request->Umur_hari,
                'I_KunjunganAsal' => $request->I_KunjunganAsal,
                'I_IjinPulang' => $request->I_IjinPulang,
                'IsBayi' => $request->IsBayi,
                'IsOpenMedrek' => $request->IsOpenMedrek,
                'I_StatusObservasi' => $request->I_StatusObservasi,
                'I_MasukUlang' => $request->I_MasukUlang,
                'D_Masuk2' => $request->D_Masuk2,
                'D_Keluar2' => $request->D_Keluar2,
                'I_Urut' => $request->I_Urut,
                'I_StatusPenanganan' => $request->I_StatusPenanganan,
                'I_SKP' => $request->I_SKP,
                'catatan' => $request->catatan,
                'KD_RujukanSEP' => $request->KD_RujukanSEP,
                'tgl_lahirPLuar' => $request->tgl_lahirPLuar,
                'tempatLahirPLuar' => $request->tempatLahirPLuar,
                'Pulang' => $request->Pulang,
                'I_EntryUpdate' => $request->I_EntryUpdate,
                'n_AsalRujukan' => $request->n_AsalRujukan,
            ];
    
            $url = config('app.api_db_url') . '/api/master/kunjungan';
            $response = $this->sendApiRequest($data, $url);
    
            return response()->json(['status' => 'success', 'response' => $response]);
        }
    }

    public function storePasien(Request $request)
    {
        $url = config('app.api_db_url') . '/api/master/pasien';
        $pasien = $this->sendApiRequest(['I_RekamMedis' => $request->I_RekamMedis], $url, 'GET');

        $data = [
            'I_RekamMedis' => $request->I_RekamMedis,
            'N_Pasien' => $request->N_Pasien,
            'N_Keluarga' => $request->N_Keluarga,
            'D_Lahir' => $request->D_Lahir,
            'A_Lahir' => $request->A_Lahir,
            'A_Rumah' => $request->A_Rumah,
            'I_Telepon' => $request->I_Telepon,
            'I_Kelurahan' => $request->I_Kelurahan,
            'Kota' => $request->Kota,
            'I_Agama' => $request->I_Agama,
            'C_Sex' => $request->C_Sex,
            'C_WargaNegara' => $request->C_WargaNegara,
            'I_Pendidikan' => $request->I_Pendidikan,
            'I_Pekerjaan' => $request->I_Pekerjaan,
            'C_StatusKawin' => $request->C_StatusKawin,
            'I_GolDarah' => $request->I_GolDarah,
            'I_JenisIdentitas' => $request->I_JenisIdentitas,
            'I_NoIdentitas' => $request->I_NoIdentitas,
            'Kd_Asuransi' => $request->Kd_Asuransi,
            'C_Asuransi' => $request->C_Asuransi,
            'C_KodePos' => $request->C_KodePos,
            'I_SukuBangsa' => $request->I_SukuBangsa,
            'I_Jabatan' => $request->I_Jabatan,
            'Pemegang_Asuransi' => $request->Pemegang_Asuransi,
            'I_Entry' => $request->I_Entry,
            'D_Entry' => $request->D_Entry,
            'IsCetak' => $request->IsCetak,
            'Foto' => $request->Foto,
            'N_Foto' => $request->N_Foto,
            'E_Foto' => $request->E_Foto,
        ];

        if ($pasien['status'] == 'success') {
            $response = $this->sendApiRequest($data, $url, 'PUT');
        } else {
            $response = $this->sendApiRequest($data, $url);
        }

        return response()->json(['status' => 'success', 'response' => $response]);
    }

    public function sendApiRequest($data, $url, $method = 'POST')
    {
        $option = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => $method,
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($option);
        $result = file_get_contents($url, false, $context);
        $parse['result'] = $result;

        return $parse;
    }

    public function checkStatusPasien(Request $request)
    {
        $medrec = $request->medrec;
        $no_kartu = $request->no_kartu;
        $nik = $request->nik;

        $closed = 'yes';
        if ($medrec && $closed == 'yes') {
            $history_kunjungan = AdmKunjungan::where('I_RekamMedis', $medrec)->whereIn('I_StatusKunjungan', [0, 1])->first();

            $closed = $history_kunjungan ? 'no' : 'yes';
        }

        if ($no_kartu && $closed == 'yes') {
            $tm_ps_kontraktor = TmPasienKontraktor::where('C_Asuransi', $no_kartu)->first();
            $history_kunjungan = $tm_ps_kontraktor ? AdmKunjungan::where('I_RekamMedis', $tm_ps_kontraktor->I_RekamMedis)->whereIn('I_StatusKunjungan', [0, 1])->first() : null;

            $closed = $history_kunjungan ? 'no' : 'yes';
        }

        if ($nik && $closed == 'yes') {
            $pasien = TmPasien::where('I_NoIdentitas', $nik)->first();
            $history_kunjungan = $pasien ? AdmKunjungan::where('I_RekamMedis', $pasien->I_RekamMedis)->whereIn('I_StatusKunjungan', [0, 1])->first() : null;

            $closed = $history_kunjungan ? 'no' : 'yes';
        }

        return response()->json(['status' => 'success', 'closed' => $closed, 'history_kunjungan' => $history_kunjungan]);
    }
}
