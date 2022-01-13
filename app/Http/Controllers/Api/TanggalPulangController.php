<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Bridging\NewVClaimController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TanggalPulangBPJS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TanggalPulangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tanggal_pulang = TanggalPulangBPJS::orderBy('id', 'desc')->paginate(10);

        return view('tanggal-pulang.index', compact('tanggal_pulang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tanggal-pulang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $no_sep = $request->no_sep;
        $status_pulang = $request->status_pulang;
        $no_surat_meninggal = $request->no_surat_meninggal;
        $tanggal_meninggal = $request->tanggal_meninggal;
        $tanggal_pulang = $request->tanggal_pulang;
        $no_lp_manual = $request->no_lp_manual;

        $data_sep = [
            'noSep' => $no_sep ?: '',
            'statusPulang' => $status_pulang ?: '',
            'noSuratMeninggal' => $no_surat_meninggal ?: '',
            'tglMeninggal' => $tanggal_meninggal ?: '',
            'tglPulang' => $tanggal_pulang ?: '',
            'noLPManual' => $no_lp_manual ?: '',
            'user' => 'system',
        ];

        $vclaim_controller = new NewVClaimController();
        $update_tanggal_pulang = $vclaim_controller->updateTanggalPulangV2($data_sep);
        $status = isset($update_tanggal_pulang['metaData']['code']) ? $update_tanggal_pulang['metaData']['code'] : 0;

        if ($status == 200) {
            $tanggal_pulang_bpjs = new TanggalPulangBPJS();
            $tanggal_pulang_bpjs->no_sep = $no_sep;
            $tanggal_pulang_bpjs->status_pulang = $status_pulang;
            $tanggal_pulang_bpjs->no_surat_meninggal = $no_surat_meninggal;
            $tanggal_pulang_bpjs->tanggal_meninggal = $tanggal_meninggal;
            $tanggal_pulang_bpjs->tanggal_pulang = $tanggal_pulang;
            $tanggal_pulang_bpjs->no_lp_manual = $no_lp_manual;
            $tanggal_pulang_bpjs->user = Auth::user() ? Auth::user()->NamaUser : 'system';
            $tanggal_pulang_bpjs->save();

            return redirect(route('update-tanggal-pulang-list'));
        } else {
            return redirect(route('update-tanggal-pulang-create'));
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
        //
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
    public function destroy($id)
    {
        //
    }
}
