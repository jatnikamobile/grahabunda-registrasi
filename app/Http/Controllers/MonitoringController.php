<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Procedure;
use App\Models\FTracer;
use Illuminate\Pagination\LengthAwarePaginator;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:dbpass');
    }

    // File Status Keluar
    public function file_status_keluar(Request $request)
    {
    	if ($request->input('Poli') > 0) {
    		$sdata = 1;
    	}elseif ($request->input('Regno') > 0 || $request->input('Medrec') > 0 || $request->input('Firstname') > 0) {
    		$sdata = 2;
    	}else{
    		$sdata = 1;
    	}

    	$data = [
	    	'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
	    	'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
	        'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
	        'poli' => $request->input('Poli') !== null ? $request->input('Poli') : '',
	        'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
	        'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
	        'sdata' => $sdata
		];

		$jos = $data;
		
        $list = Procedure::stpnet_ViewFileStKeluar_REGxhos($data);
        // dd($list);
        $page = request('page', 1);
    	$pageSize = 15;
    	$offset = ($page * $pageSize) - $pageSize;
	    $data = array_slice($list, $offset, $pageSize, true);
	    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($data, count($list), $pageSize, $page);
		$paginator->setPath(route('file-status-keluar'));

        $regis = new Register();
        $req = "00902164";
        $tesregis = $regis->get_info_status_keluar($req);
        // dd($tesregis);
        $parse = [
            'list' => $paginator,
            'data' => $jos
        ];

        return view('monitoring-status.file_status_keluar',$parse);
    }

    public function print_file_status_keluar(Request $request)
    {
        if ($request->input('Poli') > 0) {
            $sdata = 1;
        }elseif ($request->input('Regno') > 0 || $request->input('Medrec') > 0 || $request->input('Firstname') > 0) {
            $sdata = 2;
        }else{
            $sdata = 1;
        }

        $data = [
            'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
            'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
            'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
            'poli' => $request->input('Poli') !== null ? $request->input('Poli') : '',
            'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
            'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
            'sdata' => $sdata
        ];

        $date1 = date('d-m-Y',strtotime($data['date1']));
        $date2 = date('d-m-Y',strtotime($data['date2']));
        $data['set_awal'] = $date1;
        $data['set_akhir'] = $date2;
        
        $list = Procedure::stpnet_ViewFileStKeluar_REGxhos($data);

        $parse = [
            'list' => $list,
            'data' => $data
        ];
        // dd($parse);

        return view('monitoring-status.pdf.pdf_file_status_keluar',$parse);
    }

    public function file_status_keluar_post(Request $request)
    {
        $up = Procedure::stpnet_AddStatusKeluar_REGxhos($request->all());
        if($up)
        {
            $request->session()->flash('status', 'Data Berhasil Disimpan!');
            return redirect()->route('file-status-keluar');
        }else{
            return redirect()->back()->withInput($request->all());
        }
    }

    // File Status Masuk
    public function file_status_masuk(Request $request)
    {
    	if ($request->input('Regno') == '' && $request->input('Medrec') == '' && $request->input('Firstname') == '') {
    		$sdata = 1;
    	}elseif ($request->input('Regno') > 0 || $request->input('Medrec') > 0 || $request->input('Firstname') > 0) {
    		$sdata = 2;
    	}else{
    		$sdata = 2;
    	}
    	$data = [
	    	'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
	    	'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
	        'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
	        'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
	        'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
	        'sdata' => $sdata
		];

		$jos = $data;
		
        $list = Procedure::stpnet_ViewFileStatusMasuk_REGxhos($data);
        $page = request('page', 1);
    	$pageSize = 15;
    	$offset = ($page * $pageSize) - $pageSize;
	    $data = array_slice($list, $offset, $pageSize, true);
	    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($data, count($list), $pageSize, $page);
		$paginator->setPath(route('file-status-masuk'));

        $parse = [
            'list' => $paginator,
            'data' => $jos
        ];

        // dd($parse);
        return view('monitoring-status.file_status_masuk',$parse);
    }

    public function print_file_status_masuk(Request $request)
    {
        if ($request->input('Regno') == '' && $request->input('Medrec') == '' && $request->input('Firstname') == '') {
            $sdata = 1;
        }elseif ($request->input('Regno') > 0 || $request->input('Medrec') > 0 || $request->input('Firstname') > 0) {
            $sdata = 2;
        }else{
            $sdata = 2;
        }
        $data = [
            'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
            'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
            'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
            'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
            'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
            'sdata' => $sdata
        ];

        $date1 = date('d-m-Y',strtotime($data['date1']));
        $date2 = date('d-m-Y',strtotime($data['date2']));
        $data['set_awal'] = $date1;
        $data['set_akhir'] = $date2;

        $list = Procedure::stpnet_ViewFileStatusMasuk_REGxhos($data);

        $parse = [
            'list' => $list,
            'data' => $data
        ];
        // dd($parse);

        return view('monitoring-status.pdf.pdf_file_status_masuk',$parse);
    }

    public function file_status_masuk_post(Request $request)
    {
        // dd($request->all());
        $up = Procedure::stpnet_AddStatusMasuk_REGxhos($request->all());
        if($up)
        {
            $request->session()->flash('status', 'Data Berhasil Disimpan!');
            return redirect()->route('file-status-masuk');
        }else{
            return redirect()->back()->withInput($request->all());
        }
    }

    // File Status Belum Kembali
    public function file_status_belum_kembali(Request $request)
    {
    	if ($request->input('Poli') != '') {
    		$sdata = 1;
    	}elseif ($request->input('Regno') != '' || $request->input('Medrec') != '' || $request->input('Firstname') != '') {
    		$sdata = 2;
    	}else{
    		$sdata = 1;
    	}

    	$data = [
	    	'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
	    	'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
	        'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
	        'poli' => $request->input('Poli') !== null ? $request->input('Poli') : '',
	        'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
	        'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
	        'sdata' => $sdata
		];
		
        $list = Procedure::stpnet_ViewFileBlmKembali_REGxhos($data);
        $page = request('page', 1);
    	$pageSize = 15;
    	$offset = ($page * $pageSize) - $pageSize;
	    $data = array_slice($list, $offset, $pageSize, true);
	    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($data, count($list), $pageSize, $page);
		$paginator->setPath(route('file-status-belum-kembali'));

        $parse = [
            'list' => $paginator,
            'data' => $data
        ];

        // dd($parse);
        return view('monitoring-status.file_status_belum_kembali',$parse);
    }

    public function print_file_status_belum_kembali(Request $request)
    {
        if ($request->input('Poli') != '') {
            $sdata = 1;
        }elseif ($request->input('Regno') != '' || $request->input('Medrec') != '' || $request->input('Firstname') != '') {
            $sdata = 2;
        }else{
            $sdata = 1;
        }

        $data = [
            'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
            'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
            'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
            'poli' => $request->input('Poli') !== null ? $request->input('Poli') : '',
            'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
            'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
            'sdata' => $sdata
        ];

        $date1 = date('d-m-Y',strtotime($data['date1']));
        $date2 = date('d-m-Y',strtotime($data['date2']));
        $data['set_awal'] = $date1;
        $data['set_akhir'] = $date2;
        
        $list = Procedure::stpnet_ViewFileBlmKembali_REGxhos($data);

        $parse = [
            'list' => $list,
            'data' => $data
        ];
        // dd($parse);

        return view('monitoring-status.pdf.pdf_file_status_belum_kembali',$parse);
    }


    // Monitoring Status
    public function monitoring_file_status(Request $request)
    {
    	if ($request->input('Regno') != '' || $request->input('Medrec') != '' || $request->input('Firstname') != '') {
    		$sdata = 2;
    	}else {
    		$sdata = 1;
    	}

    	$data = [
	    	'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
	    	'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
	        'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
	        'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
	        'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
	        'sdata' => $sdata
		];
		
        $list = Procedure::stpnet_ViewMonitoring_REGxhos($data);
        $page = request('page', 1);
    	$pageSize = 15;
    	$offset = ($page * $pageSize) - $pageSize;
	    $data = array_slice($list, $offset, $pageSize, true);
	    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($data, count($list), $pageSize, $page);
		$paginator->setPath(route('monitoring-status'));

        $parse = [
            'list' => $paginator,
            'data' => $data
        ];

        // dd($parse);
        return view('monitoring-status.monitoring_file_status',$parse);
    }

    public function print_monitoring_status(Request $request)
    {
        if ($request->input('Regno') != '' || $request->input('Medrec') != '' || $request->input('Firstname') != '') {
            $sdata = 2;
        }else {
            $sdata = 1;
        }

        $data = [
            'regno' => $request->input('Regno') !== null ? $request->input('Regno') : '',
            'medrec' => $request->input('Medrec') !== null ? $request->input('Medrec') : '',
            'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
            'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
            'date2' => $request->input('date2') !== null ? $request->input('date2') : date('Y-m-d'),
            'sdata' => $sdata
        ];

        $date1 = date('d-m-Y',strtotime($data['date1']));
        $date2 = date('d-m-Y',strtotime($data['date2']));
        $data['set_awal'] = $date1;
        $data['set_akhir'] = $date2;
        
        $list = Procedure::stpnet_ViewMonitoring_REGxhos($data);

        $parse = [
            'list' => $list,
            'data' => $data
        ];
        // dd($parse);

        return view('monitoring-status.pdf.pdf_monitoring_status',$parse);
    }

    // Informasit Pasien Rawat Inap
    public function informasi_pasien_rawat_inap(Request $request)
    {
    	$validuser = Auth::user()->NamaUser;
    	$data = [
	        'date1' => $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d'),
	    	'bangsal' => $request->input('Bangsal') !== null ? $request->input('Bangsal') : '',
	    	'alamat' => $request->input('Alamat') !== null ? $request->input('Alamat') : '',
	        'nama' => $request->input('Firstname') !== null ? $request->input('Firstname') : '',
	        'user' => $validuser
		];
		// dd($data);
		
        $list = Procedure::stpnet_InformasiPasienRI_REGxhos($data);
        $page = request('page', 1);
    	$pageSize = 15;
    	$offset = ($page * $pageSize) - $pageSize;
	    $data = array_slice($list, $offset, $pageSize, true);
	    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($data, count($list), $pageSize, $page);
		$paginator->setPath(route('informasi-pasien-dirawat'));
        $parse = [
            'list' => $paginator,
            'data' => $data
        ];

        // dd($paginator->currentPage());
        return view('monitoring-status.informasi_pasien_rawat_inap',$parse);
    }

    // Print-prinnan
    public function print_label(Request $request)
    {
        $regno = $request->input('RegnoStatus');
        $jumlahprint = $request->input('Label');

        $register = new Register();
        $list = $register->print_label($regno);
        $parse = [
            'list' => $list,
            'width' => 205 * 2.834645669,
            'height' => 177 * 2.834645669,
            'jumlah' => $jumlahprint
        ];

        // dd($parse);
        // $pdf = PDF::loadView('monitoring-status.pdf.label',$parse);
        // $pdf->setPaper(array(0, 0, $parse['width'], $parse['height']));
        // return $pdf->stream($regno.date('d-m-Y').'.pdf');
        return view('monitoring-status.pdf.label',$parse);
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
        return base64_encode($pdf->stream($regno.date('dmYHs').'.pdf'));
        // return view('monitoring-status.pdf.slip', $parse);
    }

    public function print_slip_monitoring(Request $request)
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

    public function tracer(Request $request)
    {
        $parse = [
        ];
        return view('monitoring-status.tracer',$parse);
    }

    public function tracer_perjanjian(Request $request)
    {
        $parse = [
        ];
        return view('monitoring-status.tracer_perjanjian',$parse);
    }

    public function tracer_list(Request $request)
    {
        $tujuan = $request->input('tujuan') !== null ? $request->input('tujuan') : '';
        $poli = $request->input('poli') !== null ? $request->input('poli') : '';
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        $last_reg = $request->input('last_reg') !== null ? $request->input('last_reg') : '';
        $perjanjian = $request->input('perjanjian') ?? false;
        $debug = $request->input('debug') ?? false;
        $way = $request->input('way') ?? '';
        $set = 0;
        if(!$perjanjian){
            if($way == 'data'){
                $set = 2;
            }else{
                $set = 1;
            }
        }
        $register = new Register();
        $list = $register->tracer($tujuan, $poli, $date1, '', $set, $perjanjian, true);
        $parse = [
            'tujuan'    => $tujuan,
            'poli'      => $poli,
            'date1'     => $date1,
            'list'      => $list,
            'perjanjian'=> $perjanjian,
            'debug'     => $debug,
        ];
        // dd($parse);
        if($perjanjian){
            return view('monitoring-status.tracer-list-perjanjian',$parse);
        }else{
            if($way != 'data'){
                return view('monitoring-status.tracer-list',$parse);
            }else{
                $parse['stat'] = false;
                if(!$list->isEmpty()){
                    $parse['stat'] = true; 
                }
                return response()->json($parse);
            }
        }
    }

    public function print_tracer_one(Request $request)
    {
        $regno = $request->input('Regno');
        $way = $request->input('way') ?? '';

        $register = new Register();
        $tracer = new FTracer();
        $data = $register->print_tracer_one($regno,$way);
        $parse = [
            'data' => $data,
            'looping' => 1,
            'width' => 75 * 2.834645669,
            'height' => 60 * 2.834645669
        ];
        if($way == 'data'){
            $resp['stat'] = false;
            $resp['data'] = $data;
            if($data !== null){
                $resp['stat'] = true;
            }
            return response()->json($resp);
        }
        // else {
        //     if($data !== null){
        //         $tracer->save_to_tbl_tracer($regno);   
        //     }
        // }
        return view('monitoring-status.pdf.pdf_tracer',$parse);
        // $pdf = PDF::loadView('monitoring-status.pdf.pdf_tracer',$parse);
        // $pdf->setPaper(array(0, 0, $parse['width'], $parse['height']));
        // return $pdf->stream($regno.date('dmYHs').'.pdf');
    }

    public function set_print_status(Request $request)
    {
        $tracer = new FTracer();
        $regno = $request->input('regno');
        $tracer->save_to_tbl_tracer($regno);
    }

    public function print_tracer(Request $request)
    {
        $tujuan = $request->input('Tujuan') ?? '';
        $date1 = $request->input('date1') ?? date('Y-m-d');
        $date2 = $request->input('date2') ?? date('Y-m-d');
        $perjanjian = $request->input('perjanjian') ?? false;
        $register = new Register();
        
        $data = $register->tracer($tujuan, '', $date1, $date2, 0, $perjanjian, true);
        // dd($data);
        $parse = [
            'data' => $data,
            'looping' => count($data),
            'width' => 75 * 2.834645669,
            'height' => 60 * 2.834645669
        ];

        $tracer = new FTracer();
        foreach ($parse['data'] as $key => $value) {
            // echo $value->Regno.' ';
            $tracer->save_to_tbl_tracer($value->Regno);
        }
        // return view('monitoring-status.pdf.pdf_tracer_all',$parse);
        $pdf = PDF::loadView('monitoring-status.pdf.pdf_tracer_all',$parse);
        $pdf->setPaper(array(0, 0, $parse['width'], $parse['height']));
        return $pdf->stream($parse['looping'].date('dmYHs').'.pdf');
    }

    public function status_tracer(Request $request)
    {
        
        // dd($parse);
        return view('monitoring-status.status-tracer');
    }

    public function find_status(Request $request)
    {
        $date1 = $request->input('date1') !== null ? $request->input('date1') : date('Y-m-d');
        // dd($date1);
        $tracer = new FTracer();
        $data = $tracer->get_data_tracer($date1);

        $parse = [
            'list' => $data
        ];

        return view('monitoring-status.table-status-tracer', $parse);
    }

    public function update_siap(Request $request)
    {
        $siap = $request->input('siap');

        $tracer = new FTracer();
        $data = $tracer->update_siap($siap);

        return $data;
    }

    public function update_keluar(Request $request)
    {
        $keluar = $request->input('keluar');

        $tracer = new FTracer();
        $data = $tracer->update_keluar($keluar);

        return $data;
    }

    public function update_terima(Request $request)
    {
        $terima = $request->input('terima');

        $tracer = new FTracer();
        $data = $tracer->update_terima($terima);

        return $data;
    }
}
