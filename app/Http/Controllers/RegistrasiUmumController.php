<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use PDF;

use App\Models\MasterPS;
use App\Models\Procedure;
use App\Models\Register;
use App\Models\Fppri;
use App\Models\TempatTidur;
use App\Models\FtDokter;
use App\Models\POLItpp;
use App\Models\StoredProcedures;

class RegistrasiUmumController extends Controller
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

    // PENDAFTARAN PASIEN UMUM
    public function daftar_index(Request $request)
    {
        $regno = $request->input('Regno') !== null ? $request->input('Regno') : '';
        $nama = $request->input('Firstname') !== null ? $request->input('Firstname') : '';
        $medrec = $request->input('Medrec') !== null ? $request->input('Medrec') : '';
        $poli = $request->input('Poli') !== null ? $request->input('Poli') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');
        $register = new Register();
        $list = $register->get_all($regno, $medrec, $nama,$poli, $date1, $date2);
        $parse = [
            'list' => $list,
            'total' => count($list)
        ];
        return view('registrasi-umum.daftar-pasien.index',$parse);
    }

    public function daftar_form($Regno = null)
    {
        $parse['jaminan'] = [];
        $parse['perusahaan'] = [];
        $parse['cara_bayar'] = [];
        $parse['kategori_psn'] = [];
        $parse['group_unit'] = [];
        $parse['unit'] = [];
        $parse['rujukan'] = [];
        $parse['pengobatan'] = [];
        $parse['poli'] = [];
        $parse['dokter'] = [];
        $parse['asal_pasien'] = [];
        // $regno = $request->input('Regno');
        if ($Regno !== null){
            $pasien = new Register();
            $edit = $pasien->get_one($Regno);
            $parse['edit'] = $edit;
        }
        // dd($parse);
        return view('registrasi-umum.daftar-pasien.form',$parse);   
    }

    public function find_pasien(Request $request)
	{
		$medrec = $request->input("medrec");
		$notelp = $request->input("notelp");
		$nama = $request->input("nama");
		$alamat = $request->input("alamat");
		$nopeserta = $request->input("nopeserta");
		$tgl_lahir = $request->input("tgl_lahir");
		$date1 = $request->input("date1");
		$date2 = $request->input("date2");
		// dd($request->all());
		$pasien = new MasterPS();
        $data = $pasien->get_list($medrec, $notelp, $nama, $alamat, $nopeserta, $tgl_lahir, $date1, $date2);
        $parse = array(
            'list'=> $data,
        );
        return view('registrasi-umum.daftar-pasien.form-cari-pasien',$parse);
    }
    
    // public function test_tedi(){
    //     $push = (new Procedure)->push_konsul($poli='19', $regno='00910909');
    // }

    public function post(Request $request)
    {
        // $database2 = $this->post_to_mysql($request);
        // $database2 = json_decode($database2);
        // $idregis = $request->input('id_old', $database2->id_register);
        $request->request->add(['id_old' => '']);
        
        $input = StoredProcedures::stpnet_AddNewRegistrasiUmum_REGxhos($request->all());
        if($input)
        {
            $master = new MasterPS();
            $update = $master->update_umum($request->all());
            if ($update) {
                $medrec = $request->input('Medrec');
                $regdate = $request->input('Regdate');
                $kdpoli = $request->input('KdPoli');
                $register = new Register();
                $data = $register->get_register($medrec,$regdate,$kdpoli);
                if($request->input("Regno") == ''){
                    $push = (new Procedure)->push_konsul($data->KdPoli, $data->Regno);
                }

                $parse = array(
                    'status' => true,
                    'data' => $data,
                    'message' => 'Berhasil!',
                    'result' => ''
                );
                return response()->json($parse);
            }
        }else{
            $url = "http://localhost:81/rsau-esnawan/central-api.php";
            $data = array('_id_reg' => $idregis, '_key' => 'teujadi');
            $option = array(
                'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => "POST",
                'content' => http_build_query($data)
                )
            );

            $context = stream_context_create($option);
            $result = file_get_contents($url, false, $context);
            $parse = array(
                'status' => true,
                'data' => $data,
                'message' => 'Gagal!',
                'result' => '-'
            );
            return response()->json($parse);
            // return redirect()->back()->withInput($request->all());
        }
    }

    public function post_to_mysql(Request $request)
    {
        // dd($request->all());
        $url = "http://localhost:81/rsau-esnawan/central-api.php";
        $pasien = MasterPS::where('Medrec', $request->Medrec)->orderBy("TglDaftar","DESC")->first();
        $dokter = FtDokter::where('KdDoc', $request->kdDoc)->first();
        $poli = POLItpp::where('KDPoli', $request->KdPoli)->first();

        $data = array(
            '_key' => 'ngeusiKaUMUM',
            '_regdate' =>$request->Regdate.' '.date('H:i:s'),
            '_medrec' => $request->Medrec,
            '_firstname' => $request->Firstname,
            '_noiden' => $pasien->NoIden ?? '',
            '_kategori' => $request->Kategori,
            '_kode_doc' => $dokter->KdMapping,
            '_kode_poli' => $poli->KdMapping,
            '_no_anggota_reg' => $request->NoPeserta ?? '',
            '_alamat' => $pasien->Address ?? '',
            '_notelp' => $pasien->Phone ?? '',
            '_almtpenanggungjwb' => $pasien->AlamatPJ ?? '',
            '_keluargadkt' => $pasien->NamaAyah ?? '',
            '_pekerjaan' => $pasien->Pekerjaan ?? '',
            '_kunjungan' => $request->Kunjungan == 'Lama' ? 'Y' : 'T',
            '_nrp' => $pasien->NrpNip ?? '',
            '_nm_kategori' => $request->Kategori == '2' ? 'BPJS'.' '.$request->GroupUnit.' '.$request->Unit : 'Swasta',
            '_nm_unit' => $request->GroupUnit.' '.$request->Unit,
            '_regtime' => $request->Regtime,
            '_nm_dok' => $dokter->NmDoc,
            '_nm_poli' => $poli->NMPoli,
            '_pek_pas_pnj' => '',
            '_institusi_pas_pnj' => $pasien->NmKesatuan ?? '',
            '_pangkat_pnj' => $pasien->NmPangkat ?? '',
            '_status_reg' => $request->Perjanjian != 'true' ? 'Check-in' : 'waiting',
            '_perjanjian' => $request->Perjanjian == 'true' ? 'Y' : '',
            '_regold' => $request->regold ?? '',
            '_tanggaldaftar' => $request->Regdate
        );

        $option = array(
            'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => "POST",
            'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($option);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public function delete(Request $request)
    {       
        $Regno = $request->Regno;
        $User = Auth::user()->NamaUser; 
        $Time = date('Y/m/d H:i:s');
        $Deleted = $User.'-'.$Time;
        $get_delete = Register::where('Regno', $Regno)->first();

        $delete =   Register::where('Regno',$Regno)->update(['Deleted'=>$Deleted]);
        if($delete){
            {
                if ($get_delete->IdRegOld!= '') {
                    $url = "http://localhost:81/rsau-esnawan/central-api.php";
                    $data = array('_id_reg' => $get_delete->IdRegOld, '_key' => 'teujadi');
                    $option = array(
                        'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => "POST",
                        'content' => http_build_query($data)
                        )
                    );

                    $context = stream_context_create($option);
                    $result = file_get_contents($url, false, $context);
                }
                
                $request->session()->flash('status', 'Data Berhasil Dihapus!');
                return redirect()->route('reg-umum-daftar');
            }
        }else{
            return redirect()->back();
        }
    }

    // MUTASI PASIEN UMUM
    public function mutasi_index(Request $request)
    {
        $regno = $request->input('Regno');
        // dd($regno);
        $nama = $request->input('Firstname');
        $medrec = $request->input('Medrec');
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');
        $fppri = new Fppri();
        $data = $fppri->get_list($regno, $medrec, $nama, $date1, $date2);

        $parse = [
            'list' => $data,
        ];
        return view('registrasi-umum.mutasi-pasien.index',$parse);
    }
    
    public function mutasi_form($regno = null)
    {
        // dd($request->all());
        $kelas = Procedure::stpn_ViewKelas_INAxhos();
        // $regno = $request->input('Regno');
        if ($regno !== null){
            $pasien = new Fppri();
            $edit = $pasien->get_one($regno);
            $parse['edit'] = $edit;
        }
        
        $parse['ruang'] = $kelas;
        // dd($parse);
        return view('registrasi-umum.mutasi-pasien.form',$parse);
    }

    public function find_registrasi(Request $request)
	{
		$medrec = $request->input("medrec");
		$notelp = $request->input("notelp");
		$nama = $request->input("nama");
		$alamat = $request->input("alamat");
		$nopeserta = $request->input("nopeserta");
		$tgl_lahir = $request->input("tgl_lahir");
		$date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');
		// dd($request->all());
		$pasien = new Register();
        $data = $pasien->get_all($regno = '', $medrec, $nama, $date1, $date2,  $notelp, $alamat, $nopeserta, $tgl_lahir);
        $parse = array(
            'list'=> $data,
        );
        return view('registrasi-umum.mutasi-pasien.find-register',$parse);
    }

    public function print_ringkasan_pasien_masuk(Request $request) 
    {
        $pasien = new Fppri();
        $Regno = $request->input('noRegno');

        $data = $pasien->get_one_fppri($Regno);
        $parse = [
            'pasien' => $data,
            'width' => 205 * 2.834645669,
            'height' => 177 * 2.834645669,
        ];
        $pdf = PDF::loadView('monitoring-status.pdf.ringkasan_pasien_masuk',$parse);
        return $pdf->stream($Regno.date('d-m-Y').'.pdf');
    }
    
    public function post_mutasi(Request $request)
    {
        // return response()->json($request->all());
        $up = StoredProcedures::stpnet_AddMutasiPasienUmum_REGxhos($request->all());
        if ($up) {
            $master = new MasterPS();
            $update = $master->update_umum_mutasi($request->all());
            if ($update) {
                $register = new Register();
                $changeClassAndDoc = $register->update_umum($request->all());
                $parse = array(
                    'status' => true,
                    'message' => 'Berhasil disimpan'
                );
                return response()->json($parse);
            } else{
                $parse = array(
                    'status' => true,
                    'message' => 'Berhasil disimpan'
                );
                return response()->json($parse);
            }
        }else{
            $parse = array(
                'status' => true,
                'message' => 'Berhasil disimpan'
            );
            return response()->json($parse);
        }
    }

    public function post_to_mysql_mutasi(Request $request)
    {
        $url = "http://localhost:81/rsau-esnawan/central-api.php";
        $pasien = MasterPS::where('Medrec', $request->Medrec)->orderBy("TglDaftar","DESC")->first();
        $dokter = FtDokter::where('KdDoc', $request->kdDoc)->first();
        $poli = POLItpp::where('KDPoli', $request->KdPoli)->first();

        $data = array(
            '_key' => 'ngeusiKaUMUM',
            '_regdate' => $request->Regdate,
            '_medrec' => $request->Medrec,
            '_firstname' => $request->Firstname,
            '_noiden' => $pasien->NoIden,
            '_kategori' => $request->Kategori,
            '_kode_doc' => $dokter->KdMapping,
            '_kode_poli' => $poli->KdMapping,
            '_no_anggota_reg' => $request->NoPeserta ?? '',
            '_alamat' => $pasien->Address,
            '_notelp' => $pasien->Phone,
            '_almtpenanggungjwb' => $pasien->AlamatPJ,
            '_keluargadkt' => $pasien->NamaAyah,
            '_pekerjaan' => $pasien->Pekerjaan,
            '_kunjungan' => $request->Kunjungan == 'Lama' ? 'Y' : 'T',
            '_nrp' => $pasien->NrpNip,
            '_nm_kategori' => $request->Kategori == '2' ? 'BPJS'.' '.$request->GroupUnit.' '.$request->Unit : 'Swasta',
            '_nm_unit' => $request->GroupUnit.' '.$request->Unit,
            '_regtime' => $request->Regtime,
            '_nm_dok' => $dokter->NmDoc,
            '_nm_poli' => $poli->NMPoli,
            '_pek_pas_pnj' => '',
            '_institusi_pas_pnj' => $pasien->NmKesatuan,
            '_pangkat_pnj' => $pasien->NmPangkat,
            '_status_reg' => $request->Perjanjian == '' ? 'Check-in' : 'waiting'
        );

        $option = array(
            'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => "POST",
            'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($option);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public function delete_mutasi(Request $request)
    {
        // dd($request->Regno);
        $up = Procedure::stpnet_DeleteMutasiPasien_REGxhos($request->all());
        if ($up) {
            $request->session()->flash('status', 'Data dihapus!');
            return redirect()->route('reg-umum-mutasi');
        } else {
            return redirect()->back()->withInput($request->all());
        }
    }

    public function print_slip(Request $request)
    {
        $validuser = Auth::user()->NamaUser;
        $regno = $request->input('noRegno');

        $register = new Register();
        $list = $register->print_slip($regno);
        $parse = [
            'list' => $list,
            'width' => 75 * 2.834645669,
            'user' => $validuser
        ];
        $pdf = PDF::loadView('monitoring-status.pdf.slip',$parse);
        $pdf->setPaper(array(0, 0, $parse['width'], 250));
        return $pdf->stream($regno.date('dmYHs').'.pdf');
        // return view('monitoring-status.pdf.slip', $parse);
    }

    public function search_bed(Request $request)
    {
        $kode = $request->kode;
        $tempattidur = new TempatTidur();
        $search = $tempattidur->search_ttidur($kode);
        // dd($search);
        return $search;
    }   

}
