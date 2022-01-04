<?php

namespace App\Http\Controllers;

use App\Http\Controllers\RsNet\RsNetPasienController;
use PDF;
use Auth;
use Illuminate\Http\Request;

use App\Models\MasterPS;
use App\Models\Procedure;
use App\Models\StoredProcedures;
use App\Models\FKeyakinan;
use App\Models\RsNet\TmGolonganDarah;
use App\Models\TBLAgama;
use App\Models\TBLKabupaten;
use App\Models\TBLKelurahan;
use App\Models\TBLPendidikan;
use App\Models\TBLPekerjaan;

class MasterPasienController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:dbpass');
        // $this->middleware('logs.dbpass');
    }

    public function index(Request $request)
    {
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');
        $nama = $request->input('Firstname') !== null ? $request->input('Firstname') : '';
        $medrec = $request->input('Medrec') !== null ? $request->input('Medrec') : '';
        $notelp = $request->input('Phone') !== null ? $request->input('Phone') : '';
        $alamat = $request->input('Address') !== null ? $request->input('Address') : '';
        $tgl_lahir = $request->input('Tgl_lahir') !== null ? $request->input('Tgl_lahir') : '';

        if ($nama != '' || $medrec != '' || $notelp != '' || $alamat != '' || $tgl_lahir != '') {
            $date1 = '';
            $date2 = '';
        }

        $pasien = new MasterPS();
        $list = $pasien->get_list($medrec, $notelp, $nama, $alamat, '',$tgl_lahir, $date1, $date2);
        $parse = [
            'list' => $list,
        ];
        // dd($parse);
        return view('master-pasien.index',$parse);
    }

    public function form($medrec = null)
    {
        $parse[] = '';
        if ($medrec !== null){
            $pasien = new MasterPS();
            $edit = $pasien->get_one($medrec);
            $parse['edit'] = $edit;
            // dd($edit);
        }
        // dd($medrec);
        return view('master-pasien.form',$parse);
    }

    public function post(Request $request)
    {
        // Input to mysql simrsau
        $bayi = $request->UmurThn;
        $agama = TBLAgama::where('NmAgama', $request->Agama)->first();
        $pendi = TBLPendidikan::where('NmDidik', $request->Pendidikan)->first();
        $kerja = TBLPekerjaan::where('NmKerja', $request->Pekerjaan)->first();
        $kota = TBLKabupaten::where('NmKabupaten', $request->NmKabupaten)->first();
        $pekerjaan = TBLPekerjaan::where('NmKerja', $request->Pekerjaan)->first();
        $GolDarah = $request->GolDarah;
        $RHDarah = $request->RHDarah;
        $golongan_darah = $GolDarah . $RHDarah;
        $dt_gol_darah = TmGolonganDarah::where('N_GolonganDarah', $golongan_darah)->first();

        $pendidikan = $request->Pendidikan;

        switch ($pendidikan) {
            case 'SD':
                $kode_pendidikan = 2;
                break;
            case 'SLTP':
                $kode_pendidikan = 3;
                break;
            case 'SLTA':
                $kode_pendidikan = 4;
                break;
            case 'BELUM SEKOLAH':
                $kode_pendidikan = 1;
                break;
            case 'DIPLOMA 3':
                $kode_pendidikan = 5;
                break;
            case 'S1':
                $kode_pendidikan = 6;
                break;
            case 'S2':
                $kode_pendidikan = 7;
                break;
            case 'S3':
                $kode_pendidikan = 8;
                break;
            case 'TIDAK SEKOLAH':
                $kode_pendidikan = 1;
                break;
            
            default:
                $kode_pendidikan = null;
                break;
        }

        $data_pasien = [
            'I_RekamMedis' => $request->Medrec,
            'N_Pasien' => $request->Firstname,
            'N_Keluarga' => $request->NamaAyah,
            'D_Lahir' => $request->Bod,
            'A_Lahir' => $request->Pod,
            'A_Rumah' => $request->Alamat,
            'I_Kelurahan' => $request->Kelurahan,
            'Kota' => $kota ? $kota->KdKabupaten : null,
            'I_Telepon' => $request->Phone,
            'I_Agama' => $agama ? $agama->KdAgama : null,
            'C_Sex' => $request->KdSex == 'L' ? 1 : 0,
            // 'C_WargaNegara' => $request->WargaNegara,
            // 'C_StatusKawin' => $request->Perkawinan,
            'I_Pendidikan' => $kode_pendidikan,
            'I_Pekerjaan' => $pekerjaan ? $pekerjaan->KdKerja : null,
            'I_GolDarah' => $dt_gol_darah ? $dt_gol_darah->I_GolonganDarah : null,
            'I_JenisIdentitas' => $request->JenisIdentitas,
            'I_NoIdentitas' => $request->NoIden,
            'I_Entry' => Auth::user() ? Auth::user()->NamaUser : 'system',
            'D_Entry' => date('Y-m-d'),

            'NamaPJ' => $request->NamaPJ,
            'PekerjaanPJ' => 0,
            'PhonePJ' => $request->PhonePJ,
            'HungunganPJ' => 0,
            'AlamatPJ' => $request->AlamatPJ,
            'NoPeserta' => $request->NoPeserta,
            'kelas_bpjs' => $request->kelas_bpjs,
            'jenis_peserta' => $request->jenis_peserta,
            'kategori' => $request->Kategori,
        ];
        
        $rs_net_pasien_controller = new RsNetPasienController();
        $create_pasien = $rs_net_pasien_controller->store($data_pasien);

        if ($create_pasien) {
            $new_pasien = MasterPS::where('Medrec', $request->Medrec)->first();
            if (!$new_pasien) {
                // $up = StoredProcedures::stpnet_AddMasterPasien_REGxhos($request->all());
                $new_pasien = new MasterPS();
                $new_pasien->Medrec = $create_pasien->I_RekamMedis;
                $new_pasien->Firstname = $request->Firstname;
                $new_pasien->Pod = $request->Pod;
                $new_pasien->Bod = $request->Bod;
                $new_pasien->UmurThn = $request->UmurThn;
                $new_pasien->UmurBln = $request->UmurBln;
                $new_pasien->UmurHr = $request->UmurHari;
                $new_pasien->GolDarah = $request->GolDarah;
                $new_pasien->RHDarah = $request->RHDarah;
                $new_pasien->WargaNegara = $request->WargaNegara;
                $new_pasien->NoIden = $request->NoIden;
                $new_pasien->Perkawinan = $request->Perkawinan;
                $new_pasien->Agama = $request->Agama;
                $new_pasien->Pendidikan = $request->Pendidikan;
                $new_pasien->NamaAyah = $request->NamaAyah;
                $new_pasien->NamaIbu = $request->NamaIbu;
                $new_pasien->AskesNo = $request->NoPeserta;
                $new_pasien->TglDaftar = date('Y-m-d H:i:s');
                $new_pasien->Address = $request->Alamat;
                $new_pasien->City = $request->NmKabupaten;
                $new_pasien->Propinsi = $request->NmProvinsi;
                $new_pasien->Kecamatan = $request->NmKecamatan;
                $new_pasien->Kelurahan = $request->NmKelurahan;
                $new_pasien->KdPos = $request->KdPos;
                $new_pasien->Phone = $request->Phone;
                $new_pasien->Kategori = $request->Kategori;
                $new_pasien->NmUnit = $request->Unit;
                $new_pasien->NrpNip = $request->Nrp;
                $new_pasien->NmKesatuan = $request->NmKesatuan;
                $new_pasien->NmGol = $request->NmGol;
                $new_pasien->NmPangkat = $request->NmPangkat;
                $new_pasien->Pekerjaan = $request->Pekerjaan;
                $new_pasien->NmKorp = $request->NmKorp;
                $new_pasien->NamaPJ = $request->NamaPJ;
                $new_pasien->HubunganPJ = $request->HungunganPJ;
                $new_pasien->PekerjaanPJ = $request->PekerjaanPJ;
                $new_pasien->PhonePJ = $request->PhonePJ;
                $new_pasien->AlamatPJ = $request->AlamatPJ;
                $new_pasien->KdKelurahan = $request->Kelurahan;
                $new_pasien->NmSuku = $request->Suku;
                $new_pasien->KdSex = $request->KdSex;
                $new_pasien->Keyakinan = $request->KdNilai;
                $new_pasien->ValidUser = Auth::user() ? Auth::user()->NamaUser : 'system';
                $new_pasien->save();
    
                $up = true;
            } else {
                $new_pasien->Medrec = $request->Medrec ?: $new_pasien->Medrec;
                $new_pasien->Firstname = $request->Firstname ?: $new_pasien->Firstname;
                $new_pasien->Pod = $request->Pod ?: $new_pasien->Pod;
                $new_pasien->Bod = $request->Bod ?: $new_pasien->Bod;
                $new_pasien->UmurThn = $request->UmurThn ?: $new_pasien->UmurThn;
                $new_pasien->UmurBln = $request->UmurBln ?: $new_pasien->UmurBln;
                $new_pasien->UmurHr = $request->UmurHari ?: $new_pasien->UmurHr;
                $new_pasien->GolDarah = $request->GolDarah ?: $new_pasien->GolDarah;
                $new_pasien->RHDarah = $request->RHDarah ?: $new_pasien->RHDarah;
                $new_pasien->WargaNegara = $request->WargaNegara ?: $new_pasien->WargaNegara;
                $new_pasien->NoIden = $request->NoIden ?: $new_pasien->NoIden;
                $new_pasien->Perkawinan = $request->Perkawinan ?: $new_pasien->Perkawinan;
                $new_pasien->Agama = $request->Agama ?: $new_pasien->Agama;
                $new_pasien->Pendidikan = $request->Pendidikan ?: $new_pasien->Pendidikan;
                $new_pasien->NamaAyah = $request->NamaAyah ?: $new_pasien->NamaAyah;
                $new_pasien->NamaIbu = $request->NamaIbu ?: $new_pasien->NamaIbu;
                $new_pasien->AskesNo = $request->NoPeserta ?: $new_pasien->AskesNo;
                $new_pasien->Address = $request->Alamat ?: $new_pasien->Address;
                $new_pasien->City = $request->NmKabupaten ?: $new_pasien->City;
                $new_pasien->Propinsi = $request->NmProvinsi ?: $new_pasien->Propinsi;
                $new_pasien->Kecamatan = $request->NmKecamatan ?: $new_pasien->Kecamatan;
                $new_pasien->Kelurahan = $request->NmKelurahan ?: $new_pasien->Kelurahan;
                $new_pasien->KdPos = $request->KdPos ?: $new_pasien->KdPos;
                $new_pasien->Phone = $request->Phone ?: $new_pasien->Phone;
                $new_pasien->Kategori = $request->Kategori ?: $new_pasien->Kategori;
                $new_pasien->NmUnit = $request->Unit ?: $new_pasien->NmUnit;
                $new_pasien->NrpNip = $request->Nrp ?: $new_pasien->NrpNip;
                $new_pasien->NmKesatuan = $request->NmKesatuan ?: $new_pasien->NmKesatuan;
                $new_pasien->NmGol = $request->NmGol ?: $new_pasien->NmGol;
                $new_pasien->NmPangkat = $request->NmPangkat ?: $new_pasien->NmPangkat;
                $new_pasien->Pekerjaan = $request->Pekerjaan ?: $new_pasien->Pekerjaan;
                $new_pasien->NmKorp = $request->NmKorp ?: $new_pasien->NmKorp;
                $new_pasien->NamaPJ = $request->NamaPJ ?: $new_pasien->NamaPJ;
                $new_pasien->HubunganPJ = $request->HungunganPJ ?: $new_pasien->HubunganPJ;
                $new_pasien->PekerjaanPJ = $request->PekerjaanPJ ?: $new_pasien->PekerjaanPJ;
                $new_pasien->PhonePJ = $request->PhonePJ ?: $new_pasien->PhonePJ;
                $new_pasien->AlamatPJ = $request->AlamatPJ ?: $new_pasien->AlamatPJ;
                $new_pasien->KdKelurahan = $request->Kelurahan ?: $new_pasien->KdKelurahan;
                $new_pasien->NmSuku = $request->Suku ?: $new_pasien->NmSuku;
                $new_pasien->KdSex = $request->KdSex ?: $new_pasien->KdSex;
                $new_pasien->Keyakinan = $request->KdNilai ?: $new_pasien->Keyakinan;
                $new_pasien->ValidUser = Auth::user() ? Auth::user()->NamaUser : 'system';
                $new_pasien->save();
    
                $up = true;
            }
            if($up)
            {
                $pasien = new MasterPS();
                $handleServer = $pasien->khusus_validuser($request->Firstname);
    
                $parse = array(
                    'status' => true,
                    'data' => $handleServer,
                    'message' => 'Data berhasil disimpan!'
                );
    
                return response()->json($parse);
            }else{
                return redirect()->back()->withInput($request->all());
            }
        }else{
            return redirect()->back()->withInput($request->all());
        }
    }

    public function delete(Request $request)
    {       
        $medrec = $request->medrec;
        $User = Auth::user()->NamaUser;
        $Time = date('Y/m/d H:i:s');
        $Deleted = $User.'-'.$Time;

        $delete =   MasterPS::where('Medrec',$medrec)->update(['Deleted'=>$Deleted]);

        // $del = Procedure::stpnet_DeletePasien_REGxhos($medrec);
        if($delete){
            {
                $request->session()->flash('status', 'Data Berhasil Dihapus!');
                return redirect()->route('mst-psn');
            }
        }else{
            return redirect()->back();
        }
    }

    public function print_pasien(Request $request)
    {
        $medrec = $request->input('Medrec');
        $master = new MasterPS();
        $data = $master->get_one($medrec);
        $parse = [
            'data' => $data
        ];
        return view('master-pasien.pdf-pasien', $parse);
    }

    public function print_pemeriksaan(Request $request)
    {
        $medrec = $request->input('Medrec');
        $master = new MasterPS();
        $data = $master->get_one($medrec);
        $parse = [
            'data' => $data
        ];
        return view('master-pasien.pemeriksaDepan', $parse);
    }

    public function print_pemeriksaan_belakang(Request $request)
    {
        return view('master-pasien.pemeriksaBelakang');
    }

    public function print_keyakinan(Request $request)
    {
        $user = Auth::user()->NamaUser;
        $medrec = $request->input('medrec');
        $keyakinan = new FKeyakinan();
        $data = $keyakinan->get_keyakinan($medrec);
        $parse = [
            'data' => $data,
            'user' => $user
        ];
        // dd($parse);
        $pdf = PDF::loadView('monitoring-status.pdf.keyakinan',$parse);
        return base64_encode($pdf->stream($medrec.date('d-m-Y').'.pdf'));
        // return view('monitoring-status.pdf.keyakinan', $parse);
    }

    public function print_kartu_pasien(Request $request)
    {
        $medrec = $request->input('Medrec');
        $master = new MasterPS();
        $data = $master->get_one($medrec);
        $parse = [
            'list' => $data,
            'width' => 80.4 * 2.834645669,
            'height' => 50.3 * 2.834645669,
        ];
        $pdf = PDF::loadView('master-pasien.print-kartu-pasien',$parse);
        $pdf->setPaper(array(0, 0, $parse['width'], $parse['height']));
        return $pdf->stream($medrec.date('d-m-Y').'.pdf');
        // return view('master-pasien.print-kartu-pasien', $parse);
    }

    public function print_kartu_pasien2(Request $request)
    {
        $medrec = $request->input('Medrec');
        $master = new MasterPS();
        $data = $master->get_one($medrec);
        $parse = [
            'list' => $data,
            'width' => 80.4 * 2.834645669,
            'height' => 50.3 * 2.834645669,
        ];
        $pdf = PDF::loadView('master-pasien.print-kartu-pasien',$parse);
        $pdf->setPaper(array(0, 0, $parse['width'], $parse['height']));
        return base64_encode($pdf->stream($medrec.date('d-m-Y').'.pdf'));
    }
}
