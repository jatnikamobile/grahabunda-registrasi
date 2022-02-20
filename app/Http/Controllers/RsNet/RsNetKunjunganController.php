<?php

namespace App\Http\Controllers\RsNet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FtDokter;
use App\Models\RsNet\AdmKunjungan;
use App\Models\RsNet\BillTransaksi;
use App\Models\RsNet\BillTransaksiDetail;
use App\Models\RsNet\BillTransaksiDokter;
use App\Models\RsNet\PtProdukUnit;
use App\Models\RsNet\PtTarif;
use App\Models\RsNet\TmUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RsNetKunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data_kunjungan)
    {
        try {
            DB::beginTransaction();
            DB::connection('sqlsrv_kepri')->beginTransaction();

            $form_type = isset($data_kunjungan['form_type']) ? $data_kunjungan['form_type'] : null;
            $rujukan_dari = isset($data_kunjungan['rujukan_dari']) ? $data_kunjungan['rujukan_dari'] : null;
            $I_RekamMedis = isset($data_kunjungan['I_RekamMedis']) ? $data_kunjungan['I_RekamMedis'] : null;
            $I_Bagian = isset($data_kunjungan['I_Bagian']) ? $data_kunjungan['I_Bagian'] : null;
            $I_Unit = isset($data_kunjungan['I_Unit']) ? $data_kunjungan['I_Unit'] : null;
            $I_UrutMasuk = isset($data_kunjungan['I_UrutMasuk']) ? $data_kunjungan['I_UrutMasuk'] : null;
            $D_Masuk = isset($data_kunjungan['D_Masuk']) ? $data_kunjungan['D_Masuk'] : null;
            $D_Keluar = isset($data_kunjungan['D_Keluar']) ? $data_kunjungan['D_Keluar'] : null;
            $C_Pegawai = isset($data_kunjungan['C_Pegawai']) ? $data_kunjungan['C_Pegawai'] : null;
            $I_Penerimaan = isset($data_kunjungan['I_Penerimaan']) ? $data_kunjungan['I_Penerimaan'] : null;
            $I_Rujukan = isset($data_kunjungan['I_Rujukan']) ? $data_kunjungan['I_Rujukan'] : null;
            $N_DokterPengirim = isset($data_kunjungan['N_DokterPengirim']) ? $data_kunjungan['N_DokterPengirim'] : null;
            $N_Diagnosa = isset($data_kunjungan['N_Diagnosa']) ? $data_kunjungan['N_Diagnosa'] : null;
            $N_Tindakan = isset($data_kunjungan['N_Tindakan']) ? $data_kunjungan['N_Tindakan'] : null;
            $N_Terapi = isset($data_kunjungan['N_Terapi']) ? $data_kunjungan['N_Terapi'] : null;
            $I_Kontraktor = isset($data_kunjungan['I_Kontraktor']) ? $data_kunjungan['I_Kontraktor'] : null;
            $N_PenanggungJwb = isset($data_kunjungan['N_PenanggungJwb']) ? $data_kunjungan['N_PenanggungJwb'] : null;
            $Telp_PenanggungJwb = isset($data_kunjungan['Telp_PenanggungJwb']) ? $data_kunjungan['Telp_PenanggungJwb'] : null;
            $A_PenanggungJwb = isset($data_kunjungan['A_PenanggungJwb']) ? $data_kunjungan['A_PenanggungJwb'] : null;
            $I_StatusBaru = isset($data_kunjungan['I_StatusBaru']) ? $data_kunjungan['I_StatusBaru'] : null;
            $I_Kontrol = isset($data_kunjungan['I_Kontrol']) ? $data_kunjungan['I_Kontrol'] : null;
            $I_StatusKunjungan = isset($data_kunjungan['I_StatusKunjungan']) ? $data_kunjungan['I_StatusKunjungan'] : null;
            $C_Shift = isset($data_kunjungan['C_Shift']) ? $data_kunjungan['C_Shift'] : null;
            $I_Entry = isset($data_kunjungan['I_Entry']) ? $data_kunjungan['I_Entry'] : null;
            $D_Entry = isset($data_kunjungan['D_Entry']) ? $data_kunjungan['D_Entry'] : null;
            $I_StatusPasien = isset($data_kunjungan['I_StatusPasien']) ? $data_kunjungan['I_StatusPasien'] : null;
            $N_PasienLuar = isset($data_kunjungan['N_PasienLuar']) ? $data_kunjungan['N_PasienLuar'] : null;
            $A_PasienLuar = isset($data_kunjungan['A_PasienLuar']) ? $data_kunjungan['A_PasienLuar'] : null;
            $JK_PasienLuar = isset($data_kunjungan['JK_PasienLuar']) ? $data_kunjungan['JK_PasienLuar'] : null;
            $Umur_tahun = isset($data_kunjungan['Umur_tahun']) ? $data_kunjungan['Umur_tahun'] : null;
            $Umur_bulan = isset($data_kunjungan['Umur_bulan']) ? $data_kunjungan['Umur_bulan'] : null;
            $Umur_hari = isset($data_kunjungan['Umur_hari']) ? $data_kunjungan['Umur_hari'] : null;
            $I_KunjunganAsal = '';
            $I_IjinPulang = isset($data_kunjungan['I_IjinPulang']) ? $data_kunjungan['I_IjinPulang'] : null;
            $IsBayi = isset($data_kunjungan['IsBayi']) ? $data_kunjungan['IsBayi'] : null;
            $IsOpenMedrek = isset($data_kunjungan['IsOpenMedrek']) ? $data_kunjungan['IsOpenMedrek'] : null;
            $I_StatusObservasi = isset($data_kunjungan['I_StatusObservasi']) ? $data_kunjungan['I_StatusObservasi'] : null;
            $I_MasukUlang = isset($data_kunjungan['I_MasukUlang']) ? $data_kunjungan['I_MasukUlang'] : null;
            $D_Masuk2 = isset($data_kunjungan['D_Masuk2']) ? $data_kunjungan['D_Masuk2'] : null;
            $D_Keluar2 = isset($data_kunjungan['D_Keluar2']) ? $data_kunjungan['D_Keluar2'] : null;
            $I_Urut = isset($data_kunjungan['I_Urut']) ? $data_kunjungan['I_Urut'] : null;
            $I_StatusPenanganan = isset($data_kunjungan['I_StatusPenanganan']) ? $data_kunjungan['I_StatusPenanganan'] : null;
            $I_SKP = isset($data_kunjungan['I_SKP']) ? $data_kunjungan['I_SKP'] : null;
            $catatan = isset($data_kunjungan['catatan']) ? $data_kunjungan['catatan'] : null;
            $KD_RujukanSEP = isset($data_kunjungan['KD_RujukanSEP']) ? $data_kunjungan['KD_RujukanSEP'] : null;
            $tgl_lahirPLuar = isset($data_kunjungan['tgl_lahirPLuar']) ? $data_kunjungan['tgl_lahirPLuar'] : null;
            $tempatLahirPLuar = isset($data_kunjungan['tempatLahirPLuar']) ? $data_kunjungan['tempatLahirPLuar'] : null;
            $Pulang = isset($data_kunjungan['Pulang']) ? $data_kunjungan['Pulang'] : null;
            $I_EntryUpdate = isset($data_kunjungan['I_EntryUpdate']) ? $data_kunjungan['I_EntryUpdate'] : null;
            $n_AsalRujukan = isset($data_kunjungan['n_AsalRujukan']) ? $data_kunjungan['n_AsalRujukan'] : null;

            $action = isset($data_kunjungan['action']) ? $data_kunjungan['action'] : null;
            $medrec = isset($data_kunjungan['medrec']) ? $data_kunjungan['medrec'] : null;
            $date = isset($data_kunjungan['date']) ? $data_kunjungan['date'] : null;
            $kategori = isset($data_kunjungan['kategori']) ? $data_kunjungan['kategori'] : null;
            $poli = isset($data_kunjungan['poli']) ? $data_kunjungan['poli'] : null;
            $dokter_pil = isset($data_kunjungan['dokter_pil']) ? $data_kunjungan['dokter_pil'] : null;
            $i_kunjungan = isset($data_kunjungan['i_kunjungan']) ? $data_kunjungan['i_kunjungan'] : null;

            if ($action == 'update_kategori') {
                $kunjungan = $i_kunjungan ? AdmKunjungan::where('I_Kunjungan', $i_kunjungan)->first() : null;
                Log::info('I_Kunjungan:');
                Log::info($i_kunjungan);
                Log::info('Kunjungan by I_Kunjungan:');
                Log::info($kunjungan);
                if (!$kunjungan) {
                    $kunjungan = AdmKunjungan::where('I_Unit', $I_Unit)->where('I_Kunjungan', 'like', date('dmy', strtotime($date)) . '%')->where('I_RekamMedis', $medrec)->first();
                }
                if ($kunjungan) {
                    $kunjungan->I_Kontraktor = $kategori;
                    $kunjungan->save();
                }
            } elseif ($action == 'update_dokter') {
                $dokter_data = FtDokter::where('KdDoc', $dokter_pil)->first();
                $nip_dokter = $dokter_data ? $dokter_data->C_PEGAWAI : null;

                $tm_unit = TmUnit::where('I_Unit', $poli)->first();
                $bagian = $tm_unit ? $tm_unit->I_Bagian : 0;

                $kunjungan = $i_kunjungan ? AdmKunjungan::where('I_Kunjungan', $i_kunjungan)->first() : null;
                Log::info('I_Kunjungan:');
                Log::info($i_kunjungan);
                Log::info('Kunjungan by I_Kunjungan:');
                Log::info($kunjungan);
                if (!$kunjungan) {
                    $kunjungan = AdmKunjungan::where('I_Kunjungan', 'like', date('dmy', strtotime($date)) . '%')->where('I_RekamMedis', $medrec)->first();
                }
                if ($kunjungan) {
                    $kunjungan->C_Pegawai = $nip_dokter;
                    $kunjungan->save();
                }
            } else {
                $dokter_data = FtDokter::where('KdDoc', $C_Pegawai)->first();
                $nip_dokter = $dokter_data ? $dokter_data->C_PEGAWAI : null;

                $tm_unit = TmUnit::where('I_Unit', $I_Unit)->first();
                $bagian = $I_Bagian ? $I_Bagian : ($tm_unit ? $tm_unit->I_Bagian : 0);

                Log::info('form_type:');
                Log::info($form_type);
                if ($form_type == 'update') {
                    $kunjungan = $i_kunjungan ? AdmKunjungan::where('I_Kunjungan', $i_kunjungan)->first() : null;
                    Log::info('I_Kunjungan:');
                    Log::info($i_kunjungan);
                    Log::info('Kunjungan by I_Kunjungan:');
                    Log::info($kunjungan);
                    if (!$kunjungan) {
                        $kunjungan = AdmKunjungan::where('I_Kunjungan', 'like', date('dmy', strtotime($D_Masuk)) . '%')->where('I_RekamMedis', $I_RekamMedis)->where('I_StatusKunjungan', 1)->first();
                        Log::info('Kunjungan:');
                        Log::info($kunjungan);
                    }
                    if ($kunjungan) {
                        $kunjungan->I_RekamMedis = $I_RekamMedis;
                        $kunjungan->I_Bagian = $bagian ?: $kunjungan->I_Bagian;
                        $kunjungan->I_Unit = $I_Unit ?: $kunjungan->I_Unit;
                        $kunjungan->I_UrutMasuk = $I_UrutMasuk ?: $kunjungan->I_UrutMasuk;
                        $kunjungan->D_Masuk = $D_Masuk ?: $kunjungan->D_Masuk;
                        $kunjungan->D_Keluar = $D_Keluar ?: $kunjungan->D_Keluar;
                        $kunjungan->C_Pegawai = $nip_dokter ?: $kunjungan->C_Pegawai;
                        $kunjungan->I_Penerimaan = $rujukan_dari ?: $kunjungan->I_Penerimaan;
                        $kunjungan->I_Rujukan = $I_Rujukan ?: $kunjungan->I_Rujukan;
                        $kunjungan->N_DokterPengirim = $N_DokterPengirim ?: $kunjungan->N_DokterPengirim;
                        $kunjungan->N_Diagnosa = $N_Diagnosa ?: $kunjungan->N_Diagnosa;
                        $kunjungan->N_Tindakan = $N_Tindakan ?: $kunjungan->N_Tindakan;
                        $kunjungan->N_Terapi = $N_Terapi ?: $kunjungan->N_Terapi;
                        $kunjungan->I_Kontraktor = $I_Kontraktor ?: $kunjungan->I_Kontraktor;
                        $kunjungan->N_PenanggungJwb = $N_PenanggungJwb ?: $kunjungan->N_PenanggungJwb;
                        $kunjungan->Telp_PenanggungJwb = $Telp_PenanggungJwb ?: $kunjungan->Telp_PenanggungJwb;
                        $kunjungan->A_PenanggungJwb = $A_PenanggungJwb ?: $kunjungan->A_PenanggungJwb;
                        $kunjungan->I_StatusBaru = $I_StatusBaru ?: $kunjungan->I_StatusBaru;
                        $kunjungan->I_Kontrol = $I_Kontrol ?: $kunjungan->I_Kontrol;
                        $kunjungan->I_StatusKunjungan = $I_StatusKunjungan ?: $kunjungan->I_StatusKunjungan;
                        $kunjungan->C_Shift = $C_Shift ?: $kunjungan->C_Shift;
                        $kunjungan->I_Entry = $I_Entry ?: $kunjungan->I_Entry;
                        $kunjungan->D_Entry = $D_Entry ?: $kunjungan->D_Entry;
                        $kunjungan->I_StatusPasien = $I_StatusPasien ?: $kunjungan->I_StatusPasien;
                        $kunjungan->N_PasienLuar = $N_PasienLuar ?: $kunjungan->N_PasienLuar;
                        $kunjungan->A_PasienLuar = $A_PasienLuar ?: $kunjungan->A_PasienLuar;
                        $kunjungan->JK_PasienLuar = $JK_PasienLuar ?: $kunjungan->JK_PasienLuar;
                        $kunjungan->Umur_tahun = $Umur_tahun ?: $kunjungan->Umur_tahun;
                        $kunjungan->Umur_bulan = $Umur_bulan ?: $kunjungan->Umur_bulan;
                        $kunjungan->Umur_hari = $Umur_hari ?: $kunjungan->Umur_hari;
                        $kunjungan->I_KunjunganAsal = $I_KunjunganAsal ?: $kunjungan->I_KunjunganAsal;
                        $kunjungan->I_IjinPulang = $I_IjinPulang ?: $kunjungan->I_IjinPulang;
                        $kunjungan->IsBayi = $IsBayi ?: $kunjungan->IsBayi;
                        $kunjungan->IsOpenMedrek = $IsOpenMedrek ?: $kunjungan->IsOpenMedrek;
                        $kunjungan->I_StatusObservasi = $I_StatusObservasi ?: $kunjungan->I_StatusObservasi;
                        $kunjungan->I_MasukUlang = $I_MasukUlang ?: $kunjungan->I_MasukUlang;
                        $kunjungan->D_Masuk2 = $D_Masuk2 ?: $kunjungan->D_Masuk2;
                        $kunjungan->D_Keluar2 = $D_Keluar2 ?: $kunjungan->D_Keluar2;
                        $kunjungan->I_Urut = $I_Urut ?: $kunjungan->I_Urut;
                        $kunjungan->I_StatusPenanganan = $I_StatusPenanganan ?: $kunjungan->I_StatusPenanganan;
                        $kunjungan->I_SKP = $I_SKP ?: $kunjungan->I_SKP;
                        $kunjungan->catatan = $catatan ?: $kunjungan->catatan;
                        $kunjungan->KD_RujukanSEP = $KD_RujukanSEP ?: $kunjungan->KD_RujukanSEP;
                        $kunjungan->tgl_lahirPLuar = $tgl_lahirPLuar ?: $kunjungan->tgl_lahirPLuar;
                        $kunjungan->tempatLahirPLuar = $tempatLahirPLuar ?: $kunjungan->tempatLahirPLuar;
                        $kunjungan->Pulang = $Pulang ?: $kunjungan->Pulang;
                        $kunjungan->I_EntryUpdate = $I_EntryUpdate ?: $kunjungan->I_EntryUpdate;
                        $kunjungan->n_AsalRujukan = $n_AsalRujukan ?: $kunjungan->n_AsalRujukan;
                    } else {
                        return false;
                    }
                } else {
                    $kunjungan = new AdmKunjungan();
                    $kunjungan->I_Kunjungan = $kunjungan->generateCode($I_Unit, $D_Masuk);
                    $kunjungan->I_RekamMedis = $I_RekamMedis;
                    $kunjungan->I_Bagian = $bagian;
                    $kunjungan->I_Unit = $I_Unit;
                    $kunjungan->I_UrutMasuk = $I_UrutMasuk;
                    $kunjungan->D_Masuk = $D_Masuk;
                    $kunjungan->D_Keluar = $D_Keluar;
                    $kunjungan->C_Pegawai = $nip_dokter;
                    $kunjungan->I_Penerimaan = $rujukan_dari;
                    $kunjungan->I_Rujukan = $I_Rujukan;
                    $kunjungan->N_DokterPengirim = $N_DokterPengirim;
                    $kunjungan->N_Diagnosa = $N_Diagnosa;
                    $kunjungan->N_Tindakan = $N_Tindakan;
                    $kunjungan->N_Terapi = $N_Terapi;
                    $kunjungan->I_Kontraktor = $I_Kontraktor;
                    $kunjungan->N_PenanggungJwb = $N_PenanggungJwb;
                    $kunjungan->Telp_PenanggungJwb = $Telp_PenanggungJwb;
                    $kunjungan->A_PenanggungJwb = $A_PenanggungJwb;
                    $kunjungan->I_StatusBaru = $I_StatusBaru;
                    $kunjungan->I_Kontrol = $I_Kontrol;
                    $kunjungan->I_StatusKunjungan = $I_StatusKunjungan;
                    $kunjungan->C_Shift = $C_Shift;
                    $kunjungan->I_Entry = $I_Entry;
                    $kunjungan->D_Entry = $D_Entry;
                    $kunjungan->I_StatusPasien = $I_StatusPasien;
                    $kunjungan->N_PasienLuar = $N_PasienLuar;
                    $kunjungan->A_PasienLuar = $A_PasienLuar;
                    $kunjungan->JK_PasienLuar = $JK_PasienLuar;
                    $kunjungan->Umur_tahun = $Umur_tahun;
                    $kunjungan->Umur_bulan = $Umur_bulan;
                    $kunjungan->Umur_hari = $Umur_hari;
                    $kunjungan->I_KunjunganAsal = $I_KunjunganAsal;
                    $kunjungan->I_IjinPulang = $I_IjinPulang;
                    $kunjungan->IsBayi = $IsBayi;
                    $kunjungan->IsOpenMedrek = $IsOpenMedrek;
                    $kunjungan->I_StatusObservasi = $I_StatusObservasi;
                    $kunjungan->I_MasukUlang = $I_MasukUlang;
                    $kunjungan->D_Masuk2 = $D_Masuk2;
                    $kunjungan->D_Keluar2 = $D_Keluar2;
                    $kunjungan->I_Urut = $I_Urut;
                    $kunjungan->I_StatusPenanganan = $I_StatusPenanganan;
                    $kunjungan->I_SKP = $I_SKP;
                    $kunjungan->catatan = $catatan;
                    $kunjungan->KD_RujukanSEP = $KD_RujukanSEP;
                    $kunjungan->tgl_lahirPLuar = $tgl_lahirPLuar;
                    $kunjungan->tempatLahirPLuar = $tempatLahirPLuar;
                    $kunjungan->Pulang = $Pulang;
                    $kunjungan->I_EntryUpdate = $I_EntryUpdate;
                    $kunjungan->n_AsalRujukan = $n_AsalRujukan;
                }
                $kunjungan->save();

                $v_total_transaksi = 0 ;

                $bill_transaksi = BillTransaksi::where('I_Kunjungan', $kunjungan->I_Kunjungan)->first();
                Log::info('Bill Transaksi');
                Log::info($bill_transaksi);
                if (!$bill_transaksi) {
                    $last_rows_bt = BillTransaksi::orderBy('I_Transaksi', 'desc')->first();
                    $next_id_bt = $last_rows_bt ? $last_rows_bt->I_Transaksi + 1 : 1;
    
                    $bill_transaksi = new BillTransaksi();
                    $bill_transaksi->I_Transaksi = $next_id_bt;
                }
                $bill_transaksi->I_Kunjungan = $kunjungan->I_Kunjungan;
                $bill_transaksi->V_TotalTransaksi = $v_total_transaksi;
                $bill_transaksi->IsLunasPendaftaran = 0;
                $bill_transaksi->IsLunasLayanan = 0;
                $bill_transaksi->IsPulang = 0;
                $bill_transaksi->I_Entry = $I_Entry;
                $bill_transaksi->D_Entry = $D_Entry;
                $bill_transaksi->C_Shift = $C_Shift;
                $bill_transaksi->V_TotalDiskon = 0;
                $bill_transaksi->V_PersenSJP = 0;
                $bill_transaksi->V_NominalSJP = 0;
                $bill_transaksi->save();
            }

            DB::commit();
            DB::connection('sqlsrv_kepri')->commit();

            return $kunjungan;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            DB::rollBack();
            DB::connection('sqlsrv_kepri')->rollBack();
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kunjungan = AdmKunjungan::find($id);

        return $kunjungan;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($register)
    {
        $reg_date = $register->Regdate;
        $medrec = $register->Medrec;
        $kunjungan = AdmKunjungan::where('I_Kunjungan', 'like', date('dmy', strtotime($reg_date)) . '%')->where('I_RekamMedis', $medrec)->first();

        if ($kunjungan) {
            $kunjungan->I_StatusKunjungan = 0;
            $kunjungan->save();

            return $kunjungan;
        } else {
            return false;
        }
    }

    public function cehKunjunganAktif($D_Masuk, $I_RekamMedis)
    {
        $kunjungan = AdmKunjungan::where('I_Kunjungan', 'like', date('dmy', strtotime($D_Masuk)) . '%')->where('I_RekamMedis', $I_RekamMedis)->where('I_StatusKunjungan', 1)->first();

        return $kunjungan ? true : false;
    }
}
