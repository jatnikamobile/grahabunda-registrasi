<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Register;
use App\Models\POLItpp;
use App\Models\StoredProcedures;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:dbpass');
    }

    public function antrian_lama(Request $request)
    {
         // dd($request->all());
        $url = "http://localhost:81/rsau-esnawan/central-api.php";
        $tanggal = $request->input('Tanggal') !== null ? $request->input('Tanggal') : date('Y-m-d');
        $poli = $request->input('poli') !== null ? $request->input('poli') : '';
        $medrec = $request->input('medrec');
        $searchPoli = POLItpp::where('KDPoli', $poli)->first();
        // dd($poli);
        $data = array(
            '_key' => 'ngantri',
            '_poli' => $poli == '' ? '1000' : $searchPoli->KdMapping,
            '_tanggal' => $tanggal,
            '_medrec' => $medrec,
        );
        // dd($data);

        $option = array(
            'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => "POST",
            'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($option);
        $result = file_get_contents($url, false, $context);
        $json = json_decode($result);
        $parse = [
            'list' => $json ?? [],
            'total' => $json ? count($json) : '0'
        ];
        // dd($parse);

        return view('registrasi.antrian-lama', $parse);
    }

    public function pembatalan_pasien(Request $request)
    {
        $User = Auth::user()->NamaUser; 
        $Time = date('Y/m/d H:i:s');
        $Deleted = $User.'-'.$Time;
        $get_delete = Register::where('IdRegOld', $request->id_reg)->first();
        if (empty($get_delete)) {
            $get_delete = '';
        }
        else {
            $get_delete = $get_delete->Regno;   
        }
        if($get_delete){
            $delete = Register::where('Regno',$get_delete)->update(['Deleted'=>$Deleted]);
        }

        $url = "http://localhost:81/rsau-esnawan/central-api.php";
        $data = array('_id_reg' => $request->id_reg, '_key' => 'teujadi');
        $option = array(
            'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => "POST",
            'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($option);
        $result = file_get_contents($url, false, $context);

        return redirect()->route('antrian-lama');
    }

    public function index(Request $request)
    {
        $medrec = $request->input('Medrec') !== null ? $request->input('Medrec') : '';
        $kategori = $request->input('Kategori') !== null ? $request->input('Kategori') : '';
        $groupunit = $request->input('GroupUnit') !== null ? $request->input('GroupUnit') : '';
        $unit = $request->input('Unit') !== null ? $request->input('Unit') : '';
        $korpunit = $request->input('korpUnit') !== null ? $request->input('korpUnit') : '';
        $poli = $request->input('Poli') !== null ? $request->input('Poli') : '';
        $dokter = $request->input('Dokter') !== null ? $request->input('Dokter') : '';
        $tujuan = $request->input('Tujuan') !== null ? $request->input('Tujuan') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $register = new Register();
        
        $list = $register->register($medrec, $kategori, $groupunit, $unit, $korpunit, $poli, $dokter, $tujuan, $date1, $date2);
        $dataCount = $register->register($medrec, $kategori, $groupunit, $unit, $korpunit, $poli, $dokter, $tujuan, $date1, $date2, true);
        $parse = [
            'list' => $list,
            'total' => count($dataCount)
        ];
        // dd($parse);
        return view('registrasi.index',$parse);
    }

    public function print_register(Request $request)
    {
        $kategori = $request->input('Kategori') !== null ? $request->input('Kategori') : '';
        $groupunit = $request->input('GroupUnit') !== null ? $request->input('GroupUnit') : '';
        $unit = $request->input('Unit') !== null ? $request->input('Unit') : '';
        $korpunit = $request->input('korpUnit') !== null ? $request->input('korpUnit') : '';
        $poli = $request->input('Poli') !== null ? $request->input('Poli') : '';
        $dokter = $request->input('Dokter') !== null ? $request->input('Dokter') : '';
        $tujuan = $request->input('Tujuan') !== null ? $request->input('Tujuan') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $register = new Register();
        
        $list = $register->register('', $kategori, $groupunit, $unit, $korpunit, $poli, $dokter, $tujuan, $date1, $date2, true);

        $date1 = date('d-m-Y',strtotime($date1));
        $date2 = date('d-m-Y',strtotime($date2));
        $data['set_awal'] = $date1;
        $data['set_akhir'] = $date2;

        $parse = [
            'list' => $list,
            'total' => count($list),
            'data' => $data
        ];

        return view('registrasi.print-register', $parse);
    }

    public function register_perjanjian(Request $request)
    {
        $medrec = $request->input('medrec') !== null ? $request->input('medrec') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');

        $register = new Register();
        $list = $register->get_perjanjian($medrec, $date1, $date2);
        $totalpasien = $register->get_perjanjian($medrec, $date1, $date2, true);
        $parse = [
            'list' => $list,
            'total' => count($totalpasien)
        ];
        return view('registrasi.pasien-perjanjian', $parse);
    }

    public function register_mcu(Request $request)
    {
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');
        $register = new Register();
        $list = $register->get_mcu_pasien($date1, $date2);
        $totalpasien = $register->get_mcu_pasien($date1, $date2, true);
        $parse = [
            'list' => $list,
            'total' => count($totalpasien)
        ];
        return view('registrasi.pasien-mcu', $parse);
    }

    public function print_mcu(Request $request)
    {
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $date2 = $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d');
        $register = new Register();
        $totalpasien = $register->get_mcu_pasien($date1, $date2, true);
        $date1 = date('d-m-Y',strtotime($date1));
        $date2 = date('d-m-Y',strtotime($date2));
        $data['set_awal'] = $date1;
        $data['set_akhir'] = $date2;

        $parse = [
            'list' => $totalpasien,
            'total' => count($totalpasien),
            'data' => $data
        ];
        return view('registrasi.print-mcu', $parse);
    }

    public function ubah_carabayar(Request $request)
    {
        $data['regno'] = $request->input('regno');
        $data['kategori'] = $request->input('KategoriPasien') ;
        $data['carabayar'] = $request->input('KdCbayar');

        if ($data['regno'] != '' || $data['kategori'] != '' || $data['carabayar'] != '') {
            $up = StoredProcedures::stpnet_UpdateCaraBayar_REGxhos($data);
            $request->session()->flash('status', 'Data Berhasil Diubah!');            
        }
        
        return view('registrasi.ubah-carabayar.form');
    }
    
    public function ubah_dokter(Request $request)
    {
        if (!empty($request)) {
            $data['regno'] = $request->input('regno');
            $data['poli'] = $request->input('poli') ;
            $data['dokter_pil'] = $request->input('dokter_pil');
            $data['register'] = Register::where('Regno', $data['regno'])->first();

            // print_r($data['register']); die();
            if (!empty($data['register'])) {
                if ($data['register']->KdPoli == $data['poli']) {
                    if ($data['regno'] != '' || $data['poli'] != '' || $data['dokter_pil'] != '') {
                        $StoredProcedures = new StoredProcedures();
                        $up = $StoredProcedures->stpnet_UpdateDokterPasien_REGxhos($data);
                        $request->session()->flash('status', 'Data Berhasil Diubah!');            
                    }
                }else{
                    $request->session()->flash('status', 'Poli Tidak Cocok dengan Registrasi');
                }
            }
        }
        
        return view('registrasi.ubahdokter-form');
    }
}
