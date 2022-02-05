<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'Select2'],function(){
    Route::get('/Suku',['as'=>'api.select2.suku','uses'=>'Api\Select2Controller@suku']);
    Route::get('/Agama',['as'=>'api.select2.agama','uses'=>'Api\Select2Controller@agama']);
    Route::get('/Cara-bayar',['as'=>'api.select2.cara_bayar','uses'=>'Api\Select2Controller@cara_bayar']);
    Route::get('/Bangsal',['as'=>'api.select2.bangsal','uses'=>'Api\Select2Controller@bangsal']);
    Route::get('/Dokter',['as'=>'api.select2.dokter','uses'=>'Api\Select2Controller@dokter']);
    Route::get('/DokterRawat',['as'=>'api.select2.dokter-rawat','uses'=>'Api\Select2Controller@dokter_rawat']);
    Route::get('/Icd',['as'=>'api.select2.icd','uses'=>'Api\Select2Controller@ICD']);
    Route::get('/SearchIcd',['as'=>'api.select2.search-icd','uses'=>'Api\Select2Controller@search_icd']);
    Route::get('/Perkawinan',['as'=>'api.select2.perkawinan','uses'=>'Api\Select2Controller@perkawinan']);
    Route::get('/Pendidikan',['as'=>'api.select2.pendidikan','uses'=>'Api\Select2Controller@pendidikan']);
    Route::get('/KateogriPasien',['as'=>'api.select2.kategori-pasien','uses'=>'Api\Select2Controller@kategori_pasien']);
    Route::get('/GroupUnit',['as'=>'api.select2.group-unit','uses'=>'Api\Select2Controller@group_unit']);
    Route::get('/UnitKategori',['as'=>'api.select2.unit-kategori','uses'=>'Api\Select2Controller@unit_kategori']);
    Route::get('/GroupPangkat',['as'=>'api.select2.group-pangkat','uses'=>'Api\Select2Controller@group_pangkat']);
    Route::get('/Pangkat',['as'=>'api.select2.pangkat','uses'=>'Api\Select2Controller@pangkat']);
    Route::get('/Kesatuan',['as'=>'api.select2.kesatuan','uses'=>'Api\Select2Controller@kesatuan']);
    Route::get('/Golongan',['as'=>'api.select2.golongan','uses'=>'Api\Select2Controller@golongan']);
    Route::get('/Pekerjaan',['as'=>'api.select2.pekerjaan','uses'=>'Api\Select2Controller@pekerjaan']);
    Route::get('/Korp',['as'=>'api.select2.korp','uses'=>'Api\Select2Controller@korp']);
    Route::get('/Poli',['as'=>'api.select2.poli','uses'=>'Api\Select2Controller@poli']);
    Route::get('/AsalPasien',['as'=>'api.select2.asal-pasien','uses'=>'Api\Select2Controller@asal_pasien']);
    Route::get('/Provinsi',['as'=>'api.select2.provinsi','uses'=>'Api\Select2Controller@provinsi']);
    Route::get('/Kabupaten',['as'=>'api.select2.kabupaten','uses'=>'Api\Select2Controller@kabupaten']);
    Route::get('/Kecamatan',['as'=>'api.select2.kecamatan','uses'=>'Api\Select2Controller@kecamatan']);
    Route::get('/Kelurahan',['as'=>'api.select2.kelurahan','uses'=>'Api\Select2Controller@kelurahan']);
    Route::get('/Pengobatan',['as'=>'api.select2.pengobatan','uses'=>'Api\Select2Controller@pengobatan']);
    Route::get('/Penjamin',['as'=>'api.select2.penjamin','uses'=>'Api\Select2Controller@penjamin']);
    Route::get('/Perusahaan',['as'=>'api.select2.perusahaan','uses'=>'Api\Select2Controller@perusahaan']);
    Route::get('/Ppk',['as'=>'api.select2.ppk','uses'=>'Api\Select2Controller@ppk']);
    Route::get('/Spesialistik',['as'=>'api.select2.spesialistik','uses'=>'Api\MasterController@spesialistik']);
});
// Keyakinan
Route::post('/post-keyakinan', ['as' => 'keyakinan-post', 'uses' => 'Api\MasterController@post_keyakinan']);
// Detail pasien
Route::get('/detailpasien', ['as' => 'detail-pasien', 'uses' => 'Api\MasterController@detail_pasien']);
Route::get('/keyakinan-pasien', ['as' => 'keyakinan-pasien', 'uses' => 'Api\MasterController@cek_detail_pasien_keyakinan']);
// Detail Mutasi pasien Umum
Route::get('/mutasiumum', ['as' => 'mutasi-umum', 'uses' => 'Api\MasterController@detail_mutasi']);
Route::get('/mutasibpjs', ['as' => 'mutasi-bpjs', 'uses' => 'Api\MasterController@detail_mutasi_bpjs']);
Route::get('/cekbed', ['as' => 'mutasi-umum-bed', 'uses' => 'Api\MasterController@cek_tempat_tidur']);
Route::get('/ruangkelas', ['as' => 'ruangkelas', 'uses' => 'Api\MasterController@cek_bed']);
// Cek Pendaftaran Pasien
Route::get('/Cek/Registrasi', ['as' => 'api.cek-regis-pasien', 'uses' => 'Api\MasterController@cek_regis_pasien']);
Route::get('/Cek/NoSep', ['as' => 'api.cek-sep-pasien', 'uses' => 'Api\MasterController@cek_sep_pasien']);
Route::get('/Cek/Mutasi', ['as' => 'api.cek-mutasi-pasien', 'uses' => 'Api\MasterController@cek_mutasi_pasien']);
Route::get('/Cek/Kategori', ['as' => 'api.cek-kategori', 'uses' => 'Api\MasterController@cek_kategori_pasien']);
Route::get('/Cek/NomorUrut', ['as' => 'api.cek-nomor-urut', 'uses' => 'Api\MasterController@cek_nomor_urut']);

// BPJS
Route::get('/cari-pasien-master', ['as' => 'cari-pasien-master', 'uses' => 'Api\MasterController@cari_pasien_master']);
// Bridging BPJS
Route::get('/get-peserta-kartu-bpjs', ['as' => 'peserta-kartu-bpjs', 'uses' => 'Api\MasterController@get_peserta_kartu_bpjs']);
Route::get('/get-peserta-nik-bpjs', ['as' => 'peserta-nik', 'uses' => 'Api\MasterController@get_peserta_nik']);

Route::get('/get-peserta-rujukan', ['as' => 'peserta-rujukan', 'uses' => 'Api\MasterController@get_peserta_rujukan']);
Route::get('/get-peserta-rujukan-rs', ['as' => 'peserta-rujukan-rs', 'uses' => 'Api\MasterController@get_peserta_rujukan_rs']);

Route::get('/get-peserta-rujukan-no-kartu-pcare', 
    ['as' => 'peserta-rujukan-no-kartu-pcare', 'uses' => 'Api\MasterController@get_peserta_rujukan_no_kartu_pcare']);

Route::get('/get-peserta-rujukan-no-kartu-rs', 
    ['as' => 'peserta-rujukan-no-kartu-rs', 'uses' => 'Api\MasterController@get_peserta_rujukan_no_kartu_rs']);

Route::get('/get-kelas-bpjs', ['as' => 'kelas-bpjs', 'uses' => 'Api\MasterController@detail_kelas']);
// SEP Peserta
Route::post('/post-sep', ['as' => 'api.sep_post', 'uses' => 'Api\MasterController@create_sep']);
Route::get('/get-sep', ['as' => 'api.get_sep', 'uses' => 'Api\MasterController@get_sep']);
Route::post('/delete-sep', ['as' => 'api.delete_sep', 'uses' => 'Api\MasterController@delete_sep']);
Route::put('/update-sep', ['as' => 'api.update_sep', 'uses' => 'Api\MasterController@update_sep']);
Route::put('/update-tanggal-pulang', ['as' => 'api.update.pulang', 'uses' => 'Api\MasterController@update_tanggal_pulang']);

Route::prefix('vclaim')->name('vclaim')->group(function() {

    Route::get('diagnosa', 'Api\VClaimController@diagnosa')->name('.diagnosa');
    Route::get('poli', 'Api\VClaimController@poli')->name('.poli');
    Route::get('faskes', 'Api\VClaimController@faskes')->name('.faskes');
    Route::get('dokter_dpjp', 'Api\VClaimController@dokter_dpjp')->name('.dokter_dpjp');
    Route::get('propinsi', 'Api\VClaimController@propinsi')->name('.propinsi');
    Route::get('kabupaten', 'Api\VClaimController@kabupaten')->name('.kabupaten');
    Route::get('kecamatan', 'Api\VClaimController@kecamatan')->name('.kecamatan');
    Route::get('tindakan', 'Api\VClaimController@tindakan')->name('.tindakan');
    Route::get('kelas_rawat', 'Api\VClaimController@kelas_rawat')->name('.kelas_rawat');
    Route::get('dokter', 'Api\VClaimController@dokter')->name('.dokter');
    Route::get('spesialistik', 'Api\VClaimController@spesialistik')->name('.spesialistik');
    Route::get('ruang_rawat', 'Api\VClaimController@ruang_rawat')->name('.ruang_rawat');
    Route::get('cara_keluar', 'Api\VClaimController@cara_keluar')->name('.cara_keluar');
    Route::get('pasca_pulang', 'Api\VClaimController@pasca_pulang')->name('.pasca_pulang');
    Route::get('sep', 'Api\VClaimController@sep')->name('.sep');
    Route::get('peserta_by_bpjs', 'Api\VClaimController@cari_peserta_by_bpjs')->name('.cari_peserta_by_bpjs');
    Route::get('monitoring_kunjungan', 'Api\VClaimController@monitoring_kunjungan')->name('.monitoring_kunjungan');
    Route::get('monitoring_klaim', 'Api\VClaimController@monitoring_klaim')->name('.monitoring_klaim');
    Route::get('potensi_suplesi', 'Api\VClaimController@potensi_suplesi')->name('.potensi_suplesi');
    Route::get('histori_peserta', 'Api\VClaimController@histori_peserta')->name('.histori_peserta');
    Route::get('klaim_jasa_raharja', 'Api\VClaimController@klaim_jasa_raharja')->name('.klaim_jasa_raharja');
    Route::get('rujukan', 'Api\VClaimController@rujukan')->name('.rujukan');
    Route::get('lembar_pk', 'Api\VClaimController@lembar_pk')->name('.lembar_pk');
    Route::get('rujukan_list', 'Api\VClaimController@rujukan_list')->name('.rujukan_list');
    Route::post('create-rujukan', 'Api\VClaimController@create_rujukan')->name('.create-rujukan');
    Route::post('pengajuan-sep', 'Api\VClaimController@create_pengajuan_sep')->name('.pengajuan-sep');
    Route::post('approval-sep', 'Api\VClaimController@create_approval_sep')->name('.approval-sep');

});

Route::group(['prefix' => 'api-db'], function () {
    Route::get('check-status-pasien', ['as' => 'api.api-db.check-status-pasien', 'uses' => 'Api\ApiController@checkStatusPasien']);
    Route::get('sync-pasien', ['as' => 'api.api-db.sync-pasien', 'uses' => 'Api\ApiController@syncPasien']);
});

