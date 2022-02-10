<?php

namespace App\Http\Controllers;

use App\Models\Kepri\Master\TmKelompokRujukan;
use PDF;
use Auth;
use Illuminate\Http\Request;

use App\Models\SuratControl;
use App\Models\SuratKontrolInap;
use App\Models\Radiologi;
use App\Models\Laboratorium;
use App\Models\SuratKonsul;
use App\Models\Procedure;

class SuratKontrolController extends Controller
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
        $nama = $request->input('Firstname') !== null ? $request->input('Firstname') : '';
        $medrec = $request->input('Medrec') !== null ? $request->input('Medrec') : '';
        $inst = $request->input('instalasi') !== null ? $request->input('instalasi') : 1;

        if ($inst == 2) {
            $surat = new SuratKontrolInap();
            $list = $surat->get_list($medrec,$nama);                        
        }elseif($inst == 3){
            $surat = new SuratKonsul();
            $list = $surat->get_list($medrec,$nama);                        
        }elseif($inst == 4){
            $surat = new Radiologi();
            $list = $surat->get_list($medrec,$nama);                        
        }elseif($inst == 5){
            $surat = new Laboratorium();
            $list = $surat->get_list($medrec,$nama);                        
        }else{
            $surat = new SuratControl();
            $list = $surat->get_list($medrec,$nama);                        
        }

        $parse = [
            'list' => $list,
            'inst' => $inst,
        ];
        // dd($parse);
        return view('surat-kontrol.index',$parse);
    }

    public function form_reg_bpjs($nosurat  = null)
    {
        $parse['group_unit'] = [];
        $parse['unit'] = [];
        $parse['kategori_psn'] = [];
        $parse['cara_bayar'] = [];
        $parse['poli'] = [];
        $parse['kelas'] = [];
        $parse['diagnosa'] = [];
        $parse['prov'] = [];
        $parse['dokter'] = [];
        $parse['nosurat'] = $nosurat;
        $parse['kelompok_rujukan'] = TmKelompokRujukan::orderBy('I_KelompokRujukan')->get();
        return view('surat-kontrol.daftar-pasien.form',$parse);
    }

    public function form_reg_bpjs_konsul($nosurat  = null)
    {
        $parse['group_unit'] = [];
        $parse['unit'] = [];
        $parse['kategori_psn'] = [];
        $parse['cara_bayar'] = [];
        $parse['poli'] = [];
        $parse['kelas'] = [];
        $parse['diagnosa'] = [];
        $parse['prov'] = [];
        $parse['dokter'] = [];
        $parse['nosurat'] = $nosurat;
        return view('surat-kontrol.daftar-pasien.form_konsul',$parse);
    }

    public function form_rad($nosurat  = null, $medrec= null)
    {
        $parse['group_unit'] = [];
        $parse['unit'] = [];
        $parse['kategori_psn'] = [];
        $parse['cara_bayar'] = [];
        $parse['poli'] = [];
        $parse['kelas'] = [];
        $parse['diagnosa'] = [];
        $parse['prov'] = [];
        $parse['dokter'] = [];
        $parse['medrec'] = $medrec;
        $parse['nosurat'] = $nosurat;
        return view('surat-kontrol.daftar-pasien.form_rad',$parse);
    }

    public function form_lab($nosurat  = null, $medrec= null)
    {
        $parse['group_unit'] = [];
        $parse['unit'] = [];
        $parse['kategori_psn'] = [];
        $parse['cara_bayar'] = [];
        $parse['poli'] = [];
        $parse['kelas'] = [];
        $parse['diagnosa'] = [];
        $parse['prov'] = [];
        $parse['dokter'] = [];
        $parse['medrec'] = $medrec;
        $parse['nosurat'] = $nosurat;
        return view('surat-kontrol.daftar-pasien.form_lab',$parse);
    }

}
