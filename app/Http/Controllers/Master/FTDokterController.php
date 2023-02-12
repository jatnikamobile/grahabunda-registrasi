<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FtDokter;
use App\Models\POLItpp;
use App\Models\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FTDokterController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->flash();
        $kode_dokter = $request->kode_dokter;
        $nama_dokter = $request->nama_dokter;
        $kode_dpjp = $request->kode_dpjp;

        $ft_dokter = FtDokter::orderBy('KdDoc');
        
        if ($kode_dokter) {
            $ft_dokter->where('KdDoc', $kode_dokter);
        }

        if ($nama_dokter) {
            $ft_dokter->where('NmDoc', 'like', '%' . $nama_dokter . '%');
        }
        
        if ($kode_dpjp) {
            $ft_dokter->where('KdDPJP', $kode_dpjp);
        }


        $ft_dokter = $ft_dokter->get();

        return view('master-dokter.list', compact('ft_dokter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $poli = POLItpp::orderBy('NMPoli')->get();

        return view('master-dokter.create', compact('poli'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kode_dokter = $request->kode_dokter;
        $nama_dokter = $request->nama_dokter;
        $sip_dokter = $request->sip_dokter;
        $kategori = $request->kategori;
        $jenis_kelamin = $request->jenis_kelamin;
        $kode_dpjp = $request->kode_dpjp;
        $alamat = $request->alamat;
        $kota = $request->kota;
        $kode_pos = $request->kode_pos;
        $telepon = $request->telepon;
        $poli = $request->poli;

        switch ($kategori) {
            case '1':
                $cat = 'Specialis';
                break;
            case '2':
                $cat = 'Umum';
                break;
            case '3':
                $cat = 'Gigi';
                break;
            default:
                $cat = '';
                break;
        }

        switch ($jenis_kelamin) {
            case '1':
                $sex = 'Laki-laki';
                break;
            case '2':
                $sex = 'Perempuan';
                break;
            default:
                $sex = '';
                break;
        }

        $poli_data = POLItpp::where('KDPoli', $poli)->first();
        if (!$poli_data) {
            return response()->json(['status' => 'failed', 'message' => 'Poli tidak ditemukan!']);
        }

        try {
            $ft_dokter = new FtDokter();
            $ft_dokter->KdDoc = $kode_dokter;
            $ft_dokter->NmDoc = $nama_dokter;
            $ft_dokter->NoPraktek = $sip_dokter;
            $ft_dokter->Kategori = $cat;
            $ft_dokter->Sex = $sex;
            $ft_dokter->KdDPJP = $kode_dpjp;
            $ft_dokter->Address = $alamat;
            $ft_dokter->City = $kota;
            $ft_dokter->KdPos = $kode_pos;
            $ft_dokter->Phone = $telepon;
            $ft_dokter->KdPoli = $poli;
            $ft_dokter->NmPoli = $poli_data ? $poli_data->NMPoli : '';
            $ft_dokter->Validuser = Auth::user() ? Auth::user()->NamaUser : 'system';
            $ft_dokter->save();
    
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json(['status' => 'failed', 'message' => $th->getMessage()]);
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
        $ft_dokter = FtDokter::where('KdDoc', $id)->first();
        $poli = POLItpp::orderBy('NMPoli')->get();

        return view('master-dokter.edit', compact('ft_dokter', 'poli'));
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
        $kode_dokter = $request->kode_dokter;
        $nama_dokter = $request->nama_dokter;
        $sip_dokter = $request->sip_dokter;
        $kategori = $request->kategori;
        $jenis_kelamin = $request->jenis_kelamin;
        $kode_dpjp = $request->kode_dpjp;
        $alamat = $request->alamat;
        $kota = $request->kota;
        $kode_pos = $request->kode_pos;
        $telepon = $request->telepon;
        $poli = $request->poli;

        switch ($kategori) {
            case '1':
                $cat = 'Specialis';
                break;
            case '2':
                $cat = 'Umum';
                break;
            case '3':
                $cat = 'Gigi';
                break;
            default:
                $cat = '';
                break;
        }

        switch ($jenis_kelamin) {
            case '1':
                $sex = 'Laki-laki';
                break;
            case '2':
                $sex = 'Perempuan';
                break;
            default:
                $sex = '';
                break;
        }

        $poli_data = POLItpp::where('KDPoli', $poli)->first();
        if (!$poli_data) {
            return response()->json(['status' => 'failed', 'message' => 'Poli tidak ditemukan!']);
        }

        try {
            $ft_dokter = FtDokter::where('KdDoc', $id)->first();
            if ($ft_dokter) {
                $ft_dokter->KdDoc = $kode_dokter;
                $ft_dokter->NmDoc = $nama_dokter;
                $ft_dokter->NoPraktek = $sip_dokter;
                $ft_dokter->Kategori = $cat;
                $ft_dokter->Sex = $sex;
                $ft_dokter->KdDPJP = $kode_dpjp;
                $ft_dokter->Address = $alamat;
                $ft_dokter->City = $kota;
                $ft_dokter->KdPos = $kode_pos;
                $ft_dokter->Phone = $telepon;
                $ft_dokter->KdPoli = $poli;
                $ft_dokter->NmPoli = $poli_data ? $poli_data->NMPoli : '';
                $ft_dokter->Validuser = Auth::user() ? Auth::user()->NamaUser : 'system';
                $ft_dokter->save();
        
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Dokter tidak ditemukan!']);
            }
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json(['status' => 'failed', 'message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ft_dokter = FtDokter::where('KdDoc', $id)->first();

        if ($ft_dokter) {
            $register = Register::where('KdDoc', $id)->first();

            if (!$register) {
                $ft_dokter->delete();
    
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Dokter memiliki transaksi!']);
            }
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Dokter tidak ditemukan!']);
        }
    }
}
