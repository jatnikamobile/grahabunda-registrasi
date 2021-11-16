<?php

namespace App\Http\Controllers;

use Auth;
// use PDF;
use Illuminate\Http\Request;
use App\Models\Register;
// use App\Models\Procedure;
use App\Models\POLItpp;
// use App\Models\FTracer;
// use Illuminate\Pagination\LengthAwarePaginator;

class TracerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:dbpass');
    }

    public function tracerHarian(Request $request)
    {
        $tanggal = $request->input('tanggal') ?: date('Y-m-d');
        $poli = $request->input('poli');

        $list_tracer = Register::listTracerHarian($tanggal, $poli);
        $list_poli = POLItpp::get();

        return view('tracer/harian')->with(compact('tanggal', 'poli', 'list_tracer', 'list_poli'));
    }

    public function tracerPerjanjian(Request $request)
    {
        $tanggal = $request->input('tanggal') ?: date('Y-m-d');
        $poli = $request->input('poli');

        $list_tracer = Register::listTracerPerjanjian($tanggal, $poli);
        $list_poli = POLItpp::get();

        return view('tracer/perjanjian')->with(compact('tanggal', 'poli', 'list_tracer', 'list_poli'));
    }

    public function tableRows(Request $request)
    {
        $tanggal = $request->input('tanggal') ?: date('Y-m-d');
        $poli = $request->input('poli');
        $last_regno = $request->input('last_regno');
        $last_time = $request->input('last_time');
        $last_number = $request->input('last_number') ?? 0;

        $list_tracer = Register::listTracerHarian($tanggal, $poli, $last_regno, $last_time);

        return empty($list_tracer) ? '' : view('tracer/harian--table-rows')->with(compact('list_tracer', 'last_number'));
    }

    public function printOne(Request $request)
    {
        $regno = $request->input('regno');
        $force_print = $request->input('force_print');

        $register = new Register();

        $tracer = $register->print_tracer_one($regno);

        $data = [
            'data' => $tracer,
            'looping' => 1,
            'width' => 75 * 2.834645669,
            'height' => 60 * 2.834645669
        ];

        // dd($data);

        return response()->json([
            'shouldPrint' => $force_print || empty($tracer->DiPrint),
            'markup' => view('monitoring-status.pdf.pdf_tracer')->with($data)->render()
        ]);
    }
}
