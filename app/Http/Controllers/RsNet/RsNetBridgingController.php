<?php

namespace App\Http\Controllers\RsNet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RsNet\AdmKunjungan;

class RsNetBridgingController extends Controller
{
    public function addDataRanap(Request $request, $fppri)
    {
        $data_kunjungan = [
            'I_RekamMedis' => $fppri->Medrec,
            'I_Bagian' => 1,
            'I_Unit' => $fppri->KdPoli,
            'I_UrutMasuk' => $request->I_UrutMasuk,
            'D_Masuk' => $fppri->Regdate,
            'C_Pegawai' => $fppri->KdDocRS,
            'I_Penerimaan' => $request->rujukan_dari,
            'I_Rujukan' => $request->I_Rujukan,
            'N_Diagnosa' => $fppri->Diagnosa,
            'I_Kontraktor' => $fppri->Kategori,
            'I_StatusBaru' => $request->I_StatusBaru,
            'I_StatusKunjungan' => 1,
            'Umur_tahun' => $fppri->umurthn,
            'Umur_bulan' => $fppri->umurbln,
            'Umur_hari' => $fppri->umurhari,
            'Umur_hari' => $fppri->umurhari,
            'I_Entry' => $fppri->ValidUser,
            'D_Entry' => $fppri->Regdate,
            'I_SKP' => $fppri->nosep,
        ];

        // $kunjungan_controller = new RsNetKunjunganController();
        // $save_kunjungan = $kunjungan_controller->store($data_kunjungan);

        // return $save_kunjungan;
    }
}
