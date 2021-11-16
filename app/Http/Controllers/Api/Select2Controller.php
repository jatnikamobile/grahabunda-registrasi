<?php

namespace App\Http\Controllers\Api;

use App\Bridging\VClaim;
use App\Http\Controllers\Controller;
use App\Models\FtDokter;
use App\Models\POLItpp;
use App\Models\Refppk;
use App\Models\TBLAgama;
use App\Models\TBLAsalpasien;
use App\Models\TBLBangsal;
use App\Models\TBLGolongan;
use App\Models\TBLGroupUnit;
use App\Models\TBLICD10;
use App\Models\TBLJaminan;
use App\Models\TBLKabupaten;
use App\Models\TBLKecamatan;
use App\Models\TBLKelurahan;
use App\Models\TBLKesatuan;
use App\Models\TBLKorp;
use App\Models\TBLPangkat;
use App\Models\TBLPekerjaan;
use App\Models\TBLPendidikan;
use App\Models\TBLPerkawinan;
use App\Models\TBLPerusahaan;
use App\Models\TBLPropinsi;
use App\Models\TBLSuku;
use App\Models\TBLTpengobatan;
use App\Models\TBLUnitKategori;
use App\Models\TBLcarabayar;
use App\Models\TblKategoriPsn;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    public function bangsal(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLBangsal::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function ICD(Request $request)
    {
        return TBLICD10::query()
            ->search($request->term)
            ->paginate();
    }

    public function search_icd(Request $request)
    {
        $kdicd = $request->input('kdicd');
        $icd = new TBLICD10();
        $data = $icd->search_icd($kdicd);
        // dd($data);
        return $data;
    }

    public function ppk(Request $request)
    {
        return response()->json(VClaim::get_faskes($request->faskes, $request->term));
    }

    public function dokter(Request $request)
    {
        $kdPoli = $request->kdPoli;
        $bpjs = null;
        if ($request->bpjs == 1 || $request->bpjs == 2 || $request->dpjpOnly == 1) {
            $bpjs = 1;
        }
        
        if($request->kdPoliBpjs)
        {
            $poli = POLItpp::where('KdBPJS', $request->kdPoliBpjs)->first();
            $bpjs = $poli ? $poli->KDPoli : '';
        }
        if($kdPoli==19){
            return FtDokter::query()
            ->search("D101")
            ->poli($kdPoli)
            // ->hasDpjp($request->dpjpOnly)
            ->paginate();
        }else{
            return FtDokter::query()
            ->search($request->term)
            ->poli($kdPoli)
            // ->hasDpjp($bpjs)
            ->paginate();
        }
    }

    public function dokter_rawat(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = FtDokter::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function suku(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLSuku::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function cara_bayar(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLcarabayar::select2($q,$limit,$offset);
        return response()->json($data);
    }
    
    public function agama(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLAgama::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function perkawinan(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLPerkawinan::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function pendidikan(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLPendidikan::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function kategori_pasien(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TblKategoriPsn::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function group_unit(Request $request)
    {
        $ktg = $request->input('ktg');
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLGroupUnit::select2($ktg, $q, $limit,$offset);
        return response()->json($data);
    }

    public function unit_kategori(Request $request)
    {
        $ktg = $request->input('ktg');
        $group = $request->input('group_ktg');
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLUnitKategori::select2($ktg, $group, $q, $limit,$offset);
        return response()->json($data);
    }

    public function korp(Request $request)
    {
        $angkatan = $request->input('angkatan') !== null ? explode(' ',trim($request->input('angkatan'))) : null;
        $angkatan = isset($angkatan[1]) ? $angkatan[1] : null;
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLKorp::select2($angkatan, $q, $limit,$offset);
        return response()->json($data);
    }

    public function asal_pasien(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLAsalpasien::select2($q,$limit,$offset);
        return response()->json($data);
    }
    
    public function kesatuan(Request $request)
    {
        $angkatan = $request->input('angkatan');
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLKesatuan::select2($angkatan, $q, $limit,$offset);
        return response()->json($data);
    }

    public function group_pangkat(Request $request)
    {
        $angkatan = $request->input('angkatan');
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLPangkat::select2group( $angkatan, $q, $limit,$offset);
        return response()->json($data);
    }

    public function pangkat(Request $request)
    {
        $angkatan = $request->input('angkatan');
        $group = $request->input('group');
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLPangkat::select2( $angkatan, $group, $q, $limit,$offset);
        return response()->json($data);
    }

    public function golongan(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLGolongan::select2($q, $limit,$offset);
        return response()->json($data);
    }

    public function penjamin(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLJaminan::select2($q, $limit,$offset);
        return response()->json($data);
    }

    public function perusahaan(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLPerusahaan::select2($q, $limit,$offset);
        return response()->json($data);
    }

    public function pekerjaan(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLPekerjaan::select2($q, $limit,$offset);
        return response()->json($data);
    }

    public function pengobatan(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = TBLTpengobatan::select2($q,$limit,$offset);
        return response()->json($data);
    }

    public function poli(Request $request)
    {
        $q = $request->input('q');
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $data = POLItpp::select2($q, $limit,$offset);
        return response()->json($data);
    }

    public function provinsi(Request $request)
    {
        $term = $request->input('term');
        $query = TBLPropinsi::search($term);

        return response()->json($query->paginate());
    }

    public function kabupaten(Request $request)
    {
        $term = $request->input('term');
        $query = TBLKabupaten::with('propinsi')->search($term);

        $parent = $request->input('provinsi');
        if(!empty($parent))
        {
            $query->where('KdPropinsi', $parent);
        }

        return response()->json($query->paginate());
    }

    public function kecamatan(Request $request)
    {
        $term = $request->input('term');
        $query = TBLKecamatan::with('kabupaten.propinsi')->search($term);

        $parent = $request->input('kabupaten');
        if(!empty($parent))
        {
            $query->where('KdKabupaten', $parent);
        }

        return response()->json($query->paginate());
    }

    public function kelurahan(Request $request)
    {
        $term = $request->input('term');
        $query = TBLKelurahan::with('kecamatan.kabupaten.propinsi')->search($term);

        $parent = $request->input('kecamatan');
        if(!empty($parent))
        {
            $query->where('KdKecamatan', $parent);
        }

        return response()->json($query->paginate());
    }
}
