<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Illuminate\Http\Request;

use App\Models\MasterPS;
use App\Models\Procedure;
use App\Models\StoredProcedures;
use App\Models\FKeyakinan;
use App\Models\TBLAgama;
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
        $url = config('app.api_db_url') . "/api/master/pasien";
        $agama = TBLAgama::where('NmAgama', $request->Agama)->first();
        $pendi = TBLPendidikan::where('NmDidik', $request->Pendidikan)->first();
        $kerja = TBLPekerjaan::where('NmKerja', $request->Pekerjaan)->first();

        $pasien = MasterPS::where('Medrec', $request->Medrec)->first();
        if (!$pasien) {
            $up = StoredProcedures::stpnet_AddMasterPasien_REGxhos($request->all());
        } else {
            $pasien->Medrec = $request->Medrec ?: $pasien->Medrec;
            $pasien->Firstname = $request->Firstname ?: $pasien->Firstname;
            $pasien->Pod = $request->Pod ?: $pasien->Pod;
            $pasien->Bod = $request->Bod ?: $pasien->Bod;
            $pasien->UmurThn = $request->UmurThn ?: $pasien->UmurThn;
            $pasien->UmurBln = $request->UmurBln ?: $pasien->UmurBln;
            $pasien->UmurHr = $request->UmurHari ?: $pasien->UmurHr;
            $pasien->GolDarah = $request->GolDarah ?: $pasien->GolDarah;
            $pasien->RHDarah = $request->RHDarah ?: $pasien->RHDarah;
            $pasien->WargaNegara = $request->WargaNegara ?: $pasien->WargaNegara;
            $pasien->NoIden = $request->NoIden ?: $pasien->NoIden;
            $pasien->Perkawinan = $request->Perkawinan ?: $pasien->Perkawinan;
            $pasien->Agama = $request->Agama ?: $pasien->Agama;
            $pasien->Pendidikan = $request->Pendidikan ?: $pasien->Pendidikan;
            $pasien->NamaAyah = $request->WargaNegara ?: $pasien->NamaAyah;
            $pasien->NamaIbu = $request->NoIden ?: $pasien->NamaIbu;
            $pasien->AskesNo = $request->NoPeserta ?: $pasien->AskesNo;
            $pasien->Address = $request->Agama ?: $pasien->Address;
            $pasien->City = $request->Pendidikan ?: $pasien->City;
            $pasien->Propinsi = $request->NmProvinsi ?: $pasien->Propinsi;
            $pasien->Kecamatan = $request->NmKecamatan ?: $pasien->Kecamatan;
            $pasien->Kelurahan = $request->NmKelurahan ?: $pasien->Kelurahan;
            $pasien->KdPos = $request->KdPos ?: $pasien->KdPos;
            $pasien->Phone = $request->Phone ?: $pasien->Phone;
            $pasien->Kategori = $request->Kategori ?: $pasien->Kategori;
            $pasien->NmUnit = $request->Unit ?: $pasien->NmUnit;
            $pasien->NrpNip = $request->Nrp ?: $pasien->NrpNip;
            $pasien->NmKesatuan = $request->NmKesatuan ?: $pasien->NmKesatuan;
            $pasien->NmGol = $request->NmGol ?: $pasien->NmGol;
            $pasien->NmPangkat = $request->NmPangkat ?: $pasien->NmPangkat;
            $pasien->Pekerjaan = $request->Pekerjaan ?: $pasien->Pekerjaan;
            $pasien->NmKorp = $request->NmKorp ?: $pasien->NmKorp;
            $pasien->NamaPJ = $request->NamaPJ ?: $pasien->NamaPJ;
            $pasien->HubunganPJ = $request->HungunganPJ ?: $pasien->HubunganPJ;
            $pasien->PekerjaanPJ = $request->PekerjaanPJ ?: $pasien->PekerjaanPJ;
            $pasien->PhonePJ = $request->PhonePJ ?: $pasien->PhonePJ;
            $pasien->AlamatPJ = $request->AlamatPJ ?: $pasien->AlamatPJ;
            $pasien->KdKelurahan = $request->Kelurahan ?: $pasien->KdKelurahan;
            $pasien->NmSuku = $request->Suku ?: $pasien->NmSuku;
            $pasien->KdSex = $request->KdSex ?: $pasien->KdSex;
            $pasien->Keyakinan = $request->KdNilai ?: $pasien->Keyakinan;
            $pasien->save();

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

            $data = [
                'I_RekamMedis' => $parse['data']->Medrec,
                'N_Pasien' => $request->Firstname,
                'N_Keluarga' => $request->NamaAyah,
                'D_Lahir' => $request->Bod,
                'A_Lahir' => $request->Pod,
                'A_Rumah' => $request->Alamat,
                'I_Telepon' => $request->Phone,
                'I_Agama' => $request->KdAgama,
                'C_Sex' => $request->KdSex,
                'C_WargaNegara' => $request->WargaNegara,
                'C_StatusKawin' => $request->Perkawinan,
                'I_NoIdentitas' => $request->NoIden,
                'I_Entry' => 'system',
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

            $option = array(
                'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => "POST",
                'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($option);
            $result = file_get_contents($url, false, $context);
            $parse['result'] = $result;

            $pasien = MasterPS::where('Medrec', $parse['data']->Medrec)->first();
            if ($pasien) {
                $data_pasien = json_decode($result, true);
                $pasien->Medrec = $data_pasien['pasien']['I_RekamMedis'];
                $pasien->save();
            }

            return response()->json($parse);
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
