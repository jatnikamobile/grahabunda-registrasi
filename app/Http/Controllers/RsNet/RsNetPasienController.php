<?php

namespace App\Http\Controllers\RsNet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RsNet\TmPasien;
use App\Models\RsNet\TmPasienHubKeluarga;
use App\Models\RsNet\TmPasienKontraktor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RsNetPasienController extends Controller
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
    public function store($data_pasien)
    {
        try {
            DB::beginTransaction();
            DB::connection('sqlsrv_kepri')->beginTransaction();

            $master_pasien = new TmPasien();
            $new_medrec = $master_pasien->generateCode();
            while (TmPasien::where('I_RekamMedis', $new_medrec)->first()) {
                $new_medrec = $master_pasien->generateCode(true);
            }

            $form_type = isset($data_pasien['form_type']) ? $data_pasien['form_type'] : null;
            $I_RekamMedis = isset($data_pasien['I_RekamMedis']) ? $data_pasien['I_RekamMedis'] : null;
            $N_Pasien = isset($data_pasien['N_Pasien']) ? $data_pasien['N_Pasien'] : null;
            $N_Keluarga = isset($data_pasien['N_Keluarga']) ? $data_pasien['N_Keluarga'] : null;
            $D_Lahir = isset($data_pasien['D_Lahir']) ? $data_pasien['D_Lahir'] : null;
            $A_Lahir = isset($data_pasien['A_Lahir']) ? $data_pasien['A_Lahir'] : null;
            $A_Rumah = isset($data_pasien['A_Rumah']) ? $data_pasien['A_Rumah'] : null;
            $I_Telepon = isset($data_pasien['I_Telepon']) ? $data_pasien['I_Telepon'] : null;
            $I_Kelurahan = isset($data_pasien['I_Kelurahan']) ? $data_pasien['I_Kelurahan'] : null;
            $Kota = isset($data_pasien['Kota']) ? $data_pasien['Kota'] : null;
            $I_Agama = $data_pasien['I_Agama'];
            $C_Sex = isset($data_pasien['C_Sex']) && $data_pasien['C_Sex'] == 'L' ? 1 : 0;
            $C_WargaNegara = isset($data_pasien['C_WargaNegara']) == 'WNI' ? 0 : 1;
            $I_Pendidikan = isset($data_pasien['I_Pendidikan']) ? $data_pasien['I_Pendidikan'] : null;
            $I_Pekerjaan = isset($data_pasien['I_Pekerjaan']) ? $data_pasien['I_Pekerjaan'] : null;
            $C_StatusKawin = isset($data_pasien['C_StatusKawin']) && $data_pasien['C_StatusKawin'] == 'NIKAH' ? 1 : 0;
            $I_GolDarah = isset($data_pasien['I_GolDarah']) ? $data_pasien['I_GolDarah'] : null;
            $I_JenisIdentitas = isset($data_pasien['I_JenisIdentitas']) ? $data_pasien['I_JenisIdentitas'] : null;
            $I_NoIdentitas = isset($data_pasien['I_NoIdentitas']) ? $data_pasien['I_NoIdentitas'] : null;
            $Kd_Asuransi = isset($data_pasien['Kd_Asuransi']) ? $data_pasien['Kd_Asuransi'] : null;
            $C_Asuransi = isset($data_pasien['C_Asuransi']) ? $data_pasien['C_Asuransi'] : null;
            $C_KodePos = isset($data_pasien['C_KodePos']) ? $data_pasien['C_KodePos'] : null;
            $I_SukuBangsa = isset($data_pasien['I_SukuBangsa']) ? $data_pasien['I_SukuBangsa'] : null;
            $I_Jabatan = isset($data_pasien['I_Jabatan']) ? $data_pasien['I_Jabatan'] : null;
            $Pemegang_Asuransi = isset($data_pasien['Pemegang_Asuransi']) ? $data_pasien['Pemegang_Asuransi'] : null;
            $I_Entry = isset($data_pasien['I_Entry']) ? $data_pasien['I_Entry'] : null;
            $D_Entry = isset($data_pasien['D_Entry']) ? $data_pasien['D_Entry'] : null;
            $IsCetak = isset($data_pasien['IsCetak']) ? $data_pasien['IsCetak'] : null;
            $Foto = isset($data_pasien['Foto']) ? $data_pasien['Foto'] : null;
            $N_Foto = isset($data_pasien['N_Foto']) ? $data_pasien['N_Foto'] : null;
            $E_Foto = isset($data_pasien['E_Foto']) ? $data_pasien['E_Foto'] : null;
            $NoPeserta = isset($data_pasien['NoPeserta']) ? $data_pasien['NoPeserta'] : null;
            $kelas_bpjs = isset($data_pasien['kelas_bpjs']) ? $data_pasien['kelas_bpjs'] : null;
            $jenis_peserta = isset($data_pasien['jenis_peserta']) ? $data_pasien['jenis_peserta'] : null;
            $kategori = isset($data_pasien['kategori']) ? $data_pasien['kategori'] : null;

            $exists = true;
            if ($form_type == 'insert') {
                $exists = false;
                $pasien = new TmPasien();
                $pasien->I_RekamMedis = $new_medrec;
                $pasien->N_Pasien = $N_Pasien;
                $pasien->N_Keluarga = $N_Keluarga;
                $pasien->D_Lahir = $D_Lahir;
                $pasien->A_Lahir = $A_Lahir;
                $pasien->A_Rumah = $A_Rumah;
                $pasien->I_Telepon = $I_Telepon;
                $pasien->I_Kelurahan = $I_Kelurahan;
                $pasien->Kota = $Kota;
                $pasien->I_Agama = $I_Agama;
                $pasien->C_Sex = $C_Sex;
                $pasien->C_WargaNegara = $C_WargaNegara;
                $pasien->I_Pendidikan = $I_Pendidikan;
                $pasien->I_Pekerjaan = $I_Pekerjaan;
                $pasien->C_StatusKawin = $C_StatusKawin;
                $pasien->I_GolDarah = $I_GolDarah;
                $pasien->I_JenisIdentitas = $I_JenisIdentitas;
                $pasien->I_NoIdentitas = $I_NoIdentitas;
                $pasien->Kd_Asuransi = $Kd_Asuransi;
                $pasien->C_Asuransi = $C_Asuransi;
                $pasien->C_KodePos = $C_KodePos;
                $pasien->I_SukuBangsa = $I_SukuBangsa;
                $pasien->I_Jabatan = $I_Jabatan;
                $pasien->Pemegang_Asuransi = $Pemegang_Asuransi;
                $pasien->I_Entry = $I_Entry;
                $pasien->D_Entry = $D_Entry;
                $pasien->IsCetak = $IsCetak;
            } else {
                $pasien = TmPasien::where('I_RekamMedis', $I_RekamMedis)->first();
                $pasien->N_Pasien = $N_Pasien ?: $pasien->N_Pasien;
                $pasien->N_Keluarga = $N_Keluarga ?: $pasien->N_Keluarga;
                $pasien->D_Lahir = $D_Lahir ?: $pasien->D_Lahir;
                $pasien->A_Lahir = $A_Lahir ?: $pasien->A_Lahir;
                $pasien->A_Rumah = $A_Rumah ?: $pasien->A_Rumah;
                $pasien->I_Telepon = $I_Telepon ?: $pasien->I_Telepon;
                $pasien->I_Kelurahan = $I_Kelurahan ?: $pasien->I_Kelurahan;
                $pasien->Kota = $Kota ?: $pasien->Kota;
                $pasien->I_Agama = $I_Agama ?: $pasien->I_Agama;
                $pasien->C_Sex = $C_Sex ?: $pasien->C_Sex;
                $pasien->C_WargaNegara = $C_WargaNegara ?: $pasien->C_WargaNegara;
                $pasien->I_Pendidikan = $I_Pendidikan ?: $pasien->I_Pendidikan;
                $pasien->I_Pekerjaan = $I_Pekerjaan ?: $pasien->I_Pekerjaan;
                $pasien->C_StatusKawin = $C_StatusKawin ?: $pasien->C_StatusKawin;
                $pasien->I_GolDarah = $I_GolDarah ?: $pasien->I_GolDarah;
                $pasien->I_JenisIdentitas = $I_JenisIdentitas ?: $pasien->I_JenisIdentitas;
                $pasien->I_NoIdentitas = $I_NoIdentitas ?: $pasien->I_NoIdentitas;
                $pasien->Kd_Asuransi = $Kd_Asuransi ?: $pasien->Kd_Asuransi;
                $pasien->C_Asuransi = $C_Asuransi ?: $pasien->C_Asuransi;
                $pasien->C_KodePos = $C_KodePos ?: $pasien->C_KodePos;
                $pasien->I_SukuBangsa = $I_SukuBangsa ?: $pasien->I_SukuBangsa;
                $pasien->I_Jabatan = $I_Jabatan ?: $pasien->I_Jabatan;
                $pasien->Pemegang_Asuransi = $Pemegang_Asuransi ?: $pasien->Pemegang_Asuransi;
                $pasien->I_Entry = $I_Entry ?: $pasien->I_Entry;
                $pasien->D_Entry = $D_Entry ?: $pasien->D_Entry;
                $pasien->IsCetak = $IsCetak ?: $pasien->IsCetak;
            }
            $pasien->save();

            if (!$exists) {
                $NamaPJ = isset($data_pasien['NamaPJ']) ? $data_pasien['NamaPJ'] : null;
                $PekerjaanPJ = isset($data_pasien['PekerjaanPJ']) ? $data_pasien['PekerjaanPJ'] : null;
                $PhonePJ = isset($data_pasien['PhonePJ']) ? $data_pasien['PhonePJ'] : null;
                $HungunganPJ = isset($data_pasien['HungunganPJ']) ? $data_pasien['HungunganPJ'] : null;
                $AlamatPJ = isset($data_pasien['AlamatPJ']) ? $data_pasien['AlamatPJ'] : null;

                if ($NamaPJ) {
                    $hub_klg = new TmPasienHubKeluarga();
                    $hub_klg->I_RekamMedis = $pasien->I_RekamMedis;
                    $hub_klg->I_HubKel = $HungunganPJ;
                    $hub_klg->N_HubKel = $NamaPJ;
                    $hub_klg->A_HubKel = $AlamatPJ;
                    $hub_klg->I_Pekerjaan_HubKel = $PekerjaanPJ;
                    $hub_klg->Telp_HubKel = $PhonePJ;
                    $hub_klg->save();
                }
            }

            switch ($kelas_bpjs) {
                case '1':
                    $kelas = 'I';
                    break;
                case '2':
                    $kelas = 'II';
                    break;
                case '3':
                    $kelas = 'III';
                    break;

                default:
                    $kelas = null;
                    break;
            }
            $pasien_kontraktor = TmPasienKontraktor::where('I_RekamMedis', $pasien->I_RekamMedis)->first();
            if (!$pasien_kontraktor) {
                $pasien_kontraktor = new TmPasienKontraktor();
                $pasien_kontraktor->I_RekamMedis = $pasien->I_RekamMedis;
                $pasien_kontraktor->I_Kontraktor = $kategori;
                $pasien_kontraktor->I_Golongan = $kelas;
                $pasien_kontraktor->C_Asuransi = $NoPeserta;
                $pasien_kontraktor->I_Entry = 'system';
                $pasien_kontraktor->D_Entry = $D_Entry;
                $pasien_kontraktor->C_Aktif = 1;
                $pasien_kontraktor->N_Peserta = $jenis_peserta;
            } else {
                $pasien_kontraktor->I_Kontraktor = $kategori ?: $pasien_kontraktor->I_Kontraktor;
                $pasien_kontraktor->I_Golongan = $kelas;
                $pasien_kontraktor->C_Asuransi = $NoPeserta;
                $pasien_kontraktor->D_Entry = $D_Entry ?: $pasien_kontraktor->D_Entry;
                $pasien_kontraktor->N_Peserta = $jenis_peserta ?: $pasien_kontraktor->N_Peserta;
            }
            $pasien_kontraktor->save();

            DB::commit();
            DB::connection('sqlsrv_kepri')->commit();

            return $pasien;

        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            DB::rollBack();
            DB::connection('sqlsrv_kepri')->rollBack();
            return null;
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
        $pasien = TmPasien::find($id);

        return $pasien;
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
    public function destroy($id, $user = null)
    {
        DB::beginTransaction();
        DB::connection('sqlsrv_kepri')->beginTransaction();

        try {
            $pasien = TmPasien::where('I_RekamMedis', $id)->first();
    
            if ($pasien) {
                Log::info('Pasien delete:');
                Log::info($pasien);
                $hub_klg = TmPasienHubKeluarga::where('I_RekamMedis', $id)->first();
                if ($hub_klg) {
                    $hub_klg->delete();
                }
    
                $pasien_kontraktor = TmPasienKontraktor::where('I_RekamMedis', $id)->first();
                if ($pasien_kontraktor) {
                    $pasien_kontraktor->delete();
                }
    
                $pasien->delete();
    
                DB::commit();
                DB::connection('sqlsrv_kepri')->commit();

                Log::info('Pasien with I_RekamMedis '. $id .' deleted by user ' . $user);
                return true;
            } else {
                Log::info('Pasien with I_RekamMedis '. $id .' not found');
                DB::rollBack();
                DB::connection('sqlsrv_kepri')->rollBack();
                return false;
            }
        } catch (\Throwable $th) {
            Log::info('Delete Pasien with I_RekamMedis '. $id .' failed');
            Log::info($th->getMessage());
            DB::rollBack();
            DB::connection('sqlsrv_kepri')->rollBack();
        }
    }
}
