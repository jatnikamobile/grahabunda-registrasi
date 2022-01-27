<?php

namespace App\Http\Controllers\RsNet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RsNet\AdmKunjungan;

class RsNetBridgingController extends Controller
{
    public function addDataRanap(Request $request)
    {
        $adm_kunjungan = new AdmKunjungan();
    }
}
