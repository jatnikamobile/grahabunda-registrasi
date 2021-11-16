<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Register;
use App\Models\TBLInformasi;
use App\Models\DBpass;

class WelcomeController extends Controller
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


    public function index(Request $request)
    {
        $info = new TBLInformasi();
        $date = $request->input('tanggal') !== null ? $request->input('tanggal') : date('Y-m-d');
        $parse = array(
            'data' => $info->informasi_now($date),
            'date' => date('d-F-Y'),
            'dateSearch' => $date
        );
        return view('beranda', $parse);
    }

    public function sender()
    {
        // return view('test-ws.sender');
    }

    public function catcher()
    {
        $parse = [
            'list'      => (new Register)->tracer('', '', date('Y-m-d'), '', 1, false, true),
            'poli'      => '',
            'date1'     => '',
            'perjanjian'=> '',
        ];
        return view('test-ws.catcher',$parse);
    }

    public function change_password()
    {
        return view('authDbpass.changePassword');
    }

    public function update_password(Request $request)
    {
        // dd($request->input('oldpassword'));
        $dbpass = new DBpass();
        $cek = $dbpass->change_password($request->input('user'), $request->input('oldpassword'), $request->input('newPassword'), $request->input('displayName'));
        return response()->json($cek);
    }

    public function post_informasi(Request $request)
    {
        $info = new TBLInformasi();
        $post = $info->post_informasi($request->input('informasi'), $request->input('tanggal'));
        return route('beranda');
    }
}
