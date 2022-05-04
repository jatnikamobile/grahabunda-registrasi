<?php

namespace App\Http\Controllers\RsNet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RsNet\TmRujukan;

class RsNetRujukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function store($data_rujukan)
    {
        $I_KelRujukan = isset($data_rujukan['I_KelRujukan']) ? $data_rujukan['I_KelRujukan'] : null;
        $N_Rujukan = isset($data_rujukan['N_Rujukan']) ? $data_rujukan['N_Rujukan'] : null;
        $A_Rujukan = isset($data_rujukan['A_Rujukan']) ? $data_rujukan['A_Rujukan'] : null;
        $Kota_Rujukan = isset($data_rujukan['Kota_Rujukan']) ? $data_rujukan['Kota_Rujukan'] : null;
        $I_Entry = isset($data_rujukan['I_Entry']) ? $data_rujukan['I_Entry'] : null;
        $D_Entry = isset($data_rujukan['D_Entry']) ? $data_rujukan['D_Entry'] : null;
        $C_PPKRujukan = isset($data_rujukan['C_PPKRujukan']) ? $data_rujukan['C_PPKRujukan'] : null;

        $last_rujukan = TmRujukan::orderBy('I_Rujukan', 'desc')->limit(1)->first();
        $next = $last_rujukan ? $last_rujukan->I_Rujukan + 1 : 1;

        try {
            $rujukan = new TmRujukan();
            $rujukan->I_Rujukan = $next;
            $rujukan->I_KelRujukan = $I_KelRujukan;
            $rujukan->N_Rujukan = $N_Rujukan;
            $rujukan->A_Rujukan = $A_Rujukan;
            $rujukan->Kota_Rujukan = $Kota_Rujukan;
            $rujukan->I_Entry = $I_Entry;
            $rujukan->D_Entry = $D_Entry;
            $rujukan->C_PPKRujukan = $C_PPKRujukan;
            $rujukan->save();

            return $rujukan;
        } catch (\Throwable $th) {
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
