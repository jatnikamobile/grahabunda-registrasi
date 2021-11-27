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

        $up = StoredProcedures::stpnet_AddMasterPasien_REGxhos($request->all());
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
                // 'I_Kelurahan' => $request->I_Kelurahan,
                // 'Kota' => $request->Kota,
                'I_Agama' => $request->KdAgama,
                'C_Sex' => $request->KdSex,
                'C_WargaNegara' => $request->WargaNegara,
                // 'I_Pendidikan' => $request->KdDidik,
                // 'I_Pekerjaan' => $request->KdMapping,
                'C_StatusKawin' => $request->Perkawinan,
                // 'I_GolDarah' => $request->I_GolDarah,
                // 'I_JenisIdentitas' => $request->I_JenisIdentitas,
                'I_NoIdentitas' => $request->NoIden,
                // 'Kd_Asuransi' => $request->Kd_Asuransi,
                // 'C_Asuransi' => $request->NoPeserta,
                // 'C_KodePos' => $request->C_KodePos,
                // 'I_SukuBangsa' => $request->Suku,
                // 'I_Jabatan' => $request->I_Jabatan,
                // 'Pemegang_Asuransi' => $request->Pemegang_Asuransi,
                'I_Entry' => 'system',
                'D_Entry' => date('Y-m-d'),
                // 'IsCetak' => $request->IsCetak,
                // 'Foto' => $request->Foto,
                // 'N_Foto' => $request->N_Foto,
                // 'E_Foto' => $request->E_Foto,

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
