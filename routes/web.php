<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dbpass.login');
});
Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'dbp'],function(){
    Route::get('/login', ['as' => 'dbpass.login', 'uses' => 'AuthDbpass\LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'dbpass.submit.login', 'uses' => 'AuthDbpass\LoginController@login']);
}); 
Route::get('/Beranda', 'WelcomeController@index')->name('beranda');
Route::post('/Beranda', 'WelcomeController@post_informasi')->name('post_infrmasi');
Route::get('/ChangePassword', 'WelcomeController@change_password')->name('change_password');
Route::post('/ChangePassword', 'WelcomeController@update_password')->name('update_password');
Route::get('/testing', 'RegistrasiBpjsController@testing')->name('testing');

// MASTER PASIEN
Route::group(['prefix'=>'MasterPasien'],function(){
    Route::get('/', ['as' => 'mst-psn', 'uses' => 'MasterPasienController@index']);
    Route::get('/Form', ['as' => 'mst-psn.form', 'uses' => 'MasterPasienController@form']);
    Route::get('/Edit/{medrec?}', ['as' => 'mst-psn.form-edit', 'uses' => 'MasterPasienController@form']);
    Route::post('/Post', ['as' => 'mst-psn.form-post', 'uses' => 'MasterPasienController@post']);
    Route::delete('/Delete', ['as' => 'mst-psn.form-delete', 'uses' => 'MasterPasienController@delete']);
    Route::get('/Print',['as' => 'mst-psn.print', 'uses' => 'MasterPasienController@print_pasien']);
    Route::get('/Print-Kartu',['as' => 'mst-psn.print-kartu', 'uses' => 'MasterPasienController@print_kartu_pasien']);
    Route::get('/Print-Kartu2',['as' => 'mst-psn.print-kartu2', 'uses' => 'MasterPasienController@print_kartu_pasien2']);
    Route::get('/PrintPemeriksaan',['as' => 'mst-psn.print-pemeriksaan', 'uses' => 'MasterPasienController@print_pemeriksaan']);
    Route::get('/PrintPemeriksaanBack',['as' => 'mst-psn.print-pemeriksaan-back', 'uses' => 'MasterPasienController@print_pemeriksaan_belakang']);
});

// SURAT KONTROL
Route::group(['prefix'=>'SuratKontrol'],function(){
    Route::get('/', ['as' => 'srt-kntrl', 'uses' => 'SuratKontrolController@index']);
    Route::get('/Form/{nosurat?}', ['as'=>'srt-kntrl.form', 'uses' => 'SuratKontrolController@form_reg_bpjs']);
    Route::get('/FormK/{nosurat?}', ['as'=>'srt-knsl.form', 'uses' => 'SuratKontrolController@form_reg_bpjs_konsul']);
    Route::get('/FormR/{nosurat?}/{medrec?}', ['as'=>'radiologi.form', 'uses' => 'SuratKontrolController@form_rad']);
    Route::get('/FormL/{nosurat?}/{medrec?}', ['as'=>'laboratorium.form', 'uses' => 'SuratKontrolController@form_lab']);
});

Route::group(['prefix'=>'Register'],function(){
    Route::get('/', ['as' => 'register', 'uses' => 'RegisterController@index']);
    Route::get('/antrian-apk-lama', ['as' => 'antrian-lama', 'uses' => 'RegisterController@antrian_lama']);
    Route::post('/pembatalan-pasien', ['as' => 'pembatalan.pasien', 'uses' => 'RegisterController@pembatalan_pasien']);
    Route::get('/Print', ['as' => 'register-print', 'uses' => 'RegisterController@print_register']);
    Route::get('/Pasien-perjanjian', ['as' => 'register-perjanjian', 'uses' => 'RegisterController@register_perjanjian']);
    Route::get('/Pasien-mcu', ['as' => 'register-mcu', 'uses' => 'RegisterController@register_mcu']);
    Route::get('/Pasien-mcu-print', ['as' => 'register-mcu-print', 'uses' => 'RegisterController@print_mcu']);
    Route::get('/Rubah-kategori', ['as' => 'rubah-kategori', 'uses' => 'RegisterController@ubah_carabayar']);
    Route::get('/Rubah-dokter', ['as' => 'rubah-dokter', 'uses' => 'RegisterController@ubah_dokter']);
});

// PASIEN UMUM
Route::group(['prefix'=>'RegistrasiUmum'],function(){
    // PENDAFTARAN
    Route::group(['prefix'=>'Pendaftaran'],function(){
        Route::get('/', ['as' => 'reg-umum-daftar', 'uses' => 'RegistrasiUmumController@daftar_index']);
        Route::get('/TesPush', ['as' => 'reg-umum-daftar-test', 'uses' => 'RegistrasiUmumController@push_test']);
        Route::get('/Edit/{Regno?}', ['as' => 'reg-umum-daftar.edit', 'uses' => 'RegistrasiUmumController@daftar_form']);
        Route::get('/Form', ['as' => 'reg-umum-daftar.form', 'uses' => 'RegistrasiUmumController@daftar_form']);
        Route::post('/Post', ['as' => 'reg-umum-daftar.form-post', 'uses' => 'RegistrasiUmumController@post']);
        Route::get('/PostTedi', ['as' => 'post-tedi', 'uses' => 'RegistrasiUmumController@test_tedi']);
        Route::delete('/Delete', ['as' => 'reg-umum-daftar-delete', 'uses' => 'RegistrasiUmumController@delete']);
        Route::put('/FindPasien', ['as' => 'reg-umum-daftar.find-pasien', 'uses' => 'RegistrasiUmumController@find_pasien']);
        Route::get('/PrintSlip', ['as' => 'reg-umum-daftar.print-slip', 'uses' => 'RegistrasiUmumController@print_slip']);
    });
    // MUTASI
    Route::group(['prefix'=>'Mutasi'],function(){
        Route::get('/', ['as' => 'reg-umum-mutasi', 'uses' => 'RegistrasiUmumController@mutasi_index']);
        Route::get('/Form', ['as' => 'reg-umum-mutasi.form', 'uses' => 'RegistrasiUmumController@mutasi_form']);
        Route::get('/Edit/{regno?}', ['as' => 'reg-umum-mutasi.edit', 'uses' => 'RegistrasiUmumController@mutasi_form']);
        Route::put('/Find/Register', ['as' => 'reg-umum-mutasi.find-register', 'uses' => 'RegistrasiUmumController@find_registrasi']);
        Route::post('/Post', ['as' => 'reg-umum-mutasi.form-post', 'uses' => 'RegistrasiUmumController@post_mutasi']);
        Route::post('/Delete', ['as' => 'reg-umum-mutasi.delete', 'uses' => 'RegistrasiUmumController@delete_mutasi']);
        Route::get('/Pdf', ['as' => 'ringkasan-pasien-masuk-print', 'uses' => 'RegistrasiUmumController@print_ringkasan_pasien_masuk']);
        Route::get('/get-bed', ['as' => 'get-bed', 'uses' => 'RegistrasiUmumController@search_bed']);
    });
});

// PASIEN BPJS
Route::group(['prefix'=>'ReigstrasiBPJS'], function(){
    // PENDAFTARAN
    Route::group(['prefix'=>'Pendaftaran'],function(){
        Route::get('/', ['as' => 'reg-bpjs-daftar', 'uses' => 'RegistrasiBpjsController@daftar_index']);
        Route::get('/Form', ['as' => 'reg-bpjs-daftar.form', 'uses' => 'RegistrasiBpjsController@daftar_form']);
        Route::get('/Edit/{regno?}', ['as' => 'reg-bpjs-daftar.form-edit', 'uses' => 'RegistrasiBpjsController@daftar_form']);
        Route::post('/Post', ['as' => 'reg-bpjs-daftar.form-post', 'uses' => 'RegistrasiBpjsController@post']);
        Route::post('/Delete', ['as' => 'reg-bpjs-daftar-delete', 'uses' => 'RegistrasiBpjsController@delete']);
        Route::put('/FindPasien', ['as' => 'reg-bpjs-daftar.find-pasien', 'uses' => 'RegistrasiBpjsController@find_pasien']);
        Route::get('/FindSurat', ['as' => 'reg-bpjs-daftar.find-surat', 'uses' => 'RegistrasiBpjsController@find_nosurat']);
        Route::get('/FindRujukRad', ['as' => 'reg-bpjs-daftar.find-rujukrad', 'uses' => 'RegistrasiBpjsController@find_rujukrad']);
        Route::get('/UpRujukRad', ['as' => 'reg-bpjs-daftar.up-radiologi', 'uses' => 'RegistrasiBpjsController@up_radiologi']);
        Route::get('/FindRujukLab', ['as' => 'reg-bpjs-daftar.find-rujuklab', 'uses' => 'RegistrasiBpjsController@find_rujuklab']);
        Route::get('/UpRujukLab', ['as' => 'reg-bpjs-daftar.up-laboratorium', 'uses' => 'RegistrasiBpjsController@up_laboratorium']);
        Route::get('/FindKonsul', ['as' => 'reg-bpjs-daftar.find-konsul', 'uses' => 'RegistrasiBpjsController@find_konsul']);
        Route::post('/UpdateKategori', ['as' => 'reg-bpjs-daftar.update-kategori', 'uses' => 'RegistrasiBpjsController@update_kategori'])
        ;
        Route::get('/PrintSEP', ['as' => 'reg-bpjs-daftar.print-sep', 'uses' => 'RegistrasiBpjsController@print_sep']);
        Route::get('/print-keyakinan', ['as' => 'keyakinan-print', 'uses' => 'MasterPasienController@print_keyakinan']);
        Route::get('/PrintSEPasien/', ['as' => 'reg-bpjs-daftar.print-sepasien', 'uses' => 'RegistrasiBpjsController@print_sep_register']);
        Route::get('/print-pasien', ['as' => 'reg-print', 'uses' => 'RegistrasiBpjsController@print_registrasi']);
        Route::get('/print-pasien-lama', ['as' => 'reg-print-lama', 'uses' => 'RegistrasiBpjsController@print_registrasi_lama']);
        Route::get('/print-pasien-baru', ['as' => 'reg-print-baru', 'uses' => 'RegistrasiBpjsController@print_registrasi_baru']);
    });
    // MUTASI
    Route::group(['prefix'=>'Mutasi'],function(){
        Route::get('/', ['as' => 'reg-bpjs-mutasi', 'uses' => 'RegistrasiBpjsController@mutasi_index']);
        Route::get('/Form', ['as' => 'reg-bpjs-mutasi.form', 'uses' => 'RegistrasiBpjsController@mutasi_form']);
        Route::post('/Post', ['as' => 'reg-bpjs-mutasi.post', 'uses' => 'RegistrasiBpjsController@mutasi_post']);
        Route::get('/Edit/{regno?}', ['as' => 'reg-bpjs-mutasi.form-edit', 'uses' => 'RegistrasiBpjsController@mutasi_form']);
        Route::post('/Delete', ['as' => 'reg-bpjs-mutasi.delete', 'uses' => 'RegistrasiBpjsController@delete_mutasi']);
        Route::put('/FindRegister', ['as' => 'reg-bpjs-daftar.find-register', 'uses' => 'RegistrasiBpjsController@find_registrasi']);
        Route::get('/PrintSEP-rawat-inap', ['as' => 'reg-bpjs-daftar.print-sep-rawat-inap', 'uses' => 'RegistrasiBpjsController@print_sep_rawat_inap']);
    });
    // RUJUKAN
    Route::group(['prefix'=>'Rujukan'],function(){
        Route::get('/', ['as' => 'reg-bpjs-rujukan', 'uses' => 'RegistrasiBpjsController@rujukan_index']);
        Route::get('/Form/{no_rujukan?}', ['as' => 'reg-bpjs-rujukan.form', 'uses' => 'RegistrasiBpjsController@rujukan_form']);
        Route::get('/Delete/{no_rujukan}', ['as' => 'reg-bpjs-rujukan.delete', 'uses' => 'RegistrasiBpjsController@rujukan_delete']);
        Route::post('/Form', ['as' => 'reg-bpjs-rujukan.create', 'uses' => 'RegistrasiBpjsController@rujukan_create']);
        Route::get('/Print', ['as' => 'reg-bpjs-rujukan.print', 'uses' => 'RegistrasiBpjsController@print_rujukan']);
    });
    // PENGAJUAN SEP
    Route::group(['prefix'=>'PengajuanSEP'],function(){
        Route::get('/', ['as' => 'reg-bpjs-pengajuan', 'uses' => 'RegistrasiBpjsController@pengajuan_index']);
        Route::get('/Form', ['as' => 'reg-bpjs-pengajuan.form', 'uses' => 'RegistrasiBpjsController@pengajuan_form']);
        Route::post('/Form', ['as' => 'reg-bpjs-pengajuan.create', 'uses' => 'RegistrasiBpjsController@save_sep']);
        Route::get('/View', ['as' => 'pengajuan-sep.cek', 'uses' => 'RegistrasiBpjsController@pengajuan_form']);
    });
    Route::group(['prefix'=>'DetailSEP'],function(){
        Route::get('/', ['as' => 'reg-bpjs-detailsep', 'uses' => 'RegistrasiBpjsController@detail_sep']);
        Route::put('/FindSEP', ['as' => 'reg-bpjs-findsep', 'uses' => 'RegistrasiBpjsController@get_sep']);
    });
});

// MONITORING STATUS
Route::group(['prefix'=>'Monitoring'], function(){
    // PRINT TRACER
    Route::group(['prefix'=>'Tracer'], function(){
        Route::get('/Harian', ['as' => 'tracer', 'uses' => 'TracerController@tracerHarian']);
        Route::get('/Perjanjian', ['as' => 'tracer-perjanjian', 'uses' => 'TracerController@tracerPerjanjian']);
        Route::get('/TableRows', ['as' => 'tracer-table-rows', 'uses' => 'TracerController@tableRows']);
        Route::get('/GetMarkup', ['as' => 'tracer-print-markup', 'uses' => 'TracerController@printOne']);
        // Route::get('/', ['as' => 'tracer', 'uses' => 'MonitoringController@tracer']);
        // Route::get('/Perjanjian', ['as' => 'tracer-perjanjian', 'uses' => 'MonitoringController@tracer_perjanjian']);
        Route::get('/list', ['as' => 'tracer-list', 'uses' => 'MonitoringController@tracer_list']);
        Route::get('/print-all', ['as' => 'tracer-print', 'uses' => 'MonitoringController@print_tracer']);
        Route::get('/print-one', ['as' => 'tracer-print-one', 'uses' => 'MonitoringController@print_tracer_one']);
        Route::post('/SetPrintStatus', ['as' => 'tracer-set-print-status', 'uses' => 'MonitoringController@set_print_status']);
    });

    // STATUS TRACER
    Route::group(['prefix'=>'StatusTracer'], function(){
        Route::get('/', ['as' => 'status-tracer', 'uses' => 'MonitoringController@status_tracer']);
        Route::put('/find-tracer', ['as' => 'status-tracer.find', 'uses' => 'MonitoringController@find_status']);
        Route::post('/post-siap', ['as' => 'status-tracer.siap', 'uses' => 'MonitoringController@update_siap']);
        Route::post('/post-keluar', ['as' => 'status-tracer.keluar', 'uses' => 'MonitoringController@update_keluar']);
        Route::post('/post-terima', ['as' => 'status-tracer.terima', 'uses' => 'MonitoringController@update_terima']);
    });

    Route::group(['prefix'=>'FileStatusKeluar'], function(){
        Route::get('/', ['as' => 'file-status-keluar', 'uses' => 'MonitoringController@file_status_keluar']);
        Route::post('/Post', ['as' => 'file-status-keluar-post', 'uses' => 'MonitoringController@file_status_keluar_post']);
        Route::get('/Pdf', ['as' => 'file-status-keluar-print', 'uses' => 'MonitoringController@print_file_status_keluar']);
        Route::get('/Lebel', ['as' => 'file-status-keluar-label', 'uses' => 'MonitoringController@print_label']);
        Route::get('/Monitoring', ['as' => 'file-status-keluar-slip-monitoring', 'uses' => 'MonitoringController@print_slip_monitoring']);
        Route::get('/Slip', ['as' => 'file-status-keluar-slip', 'uses' => 'MonitoringController@print_slip']);
    });
    Route::group(['prefix'=>'FileStatusMasuk'], function(){
        Route::get('/', ['as' => 'file-status-masuk', 'uses' => 'MonitoringController@file_status_masuk']);
        Route::post('/Post', ['as' => 'file-status-masuk-post', 'uses' => 'MonitoringController@file_status_masuk_post']);
        Route::get('/Pdf', ['as' => 'file-status-masuk-print', 'uses' => 'MonitoringController@print_file_status_masuk']);
    });
    Route::group(['prefix'=>'FileStatusBelumKembali'], function(){
        Route::get('/', ['as' => 'file-status-belum-kembali', 'uses' => 'MonitoringController@file_status_belum_kembali']);
        Route::get('/Pdf', ['as' => 'file-status-belum-kembali-print', 'uses' => 'MonitoringController@print_file_status_belum_kembali']);
    });
    Route::group(['prefix'=>'MonitoringStatus'], function(){
        Route::get('/', ['as' => 'monitoring-status', 'uses' => 'MonitoringController@monitoring_file_status']);
        Route::get('/Pdf', ['as' => 'monitoring-status-print', 'uses' => 'MonitoringController@print_monitoring_status']);
    });
    Route::group(['prefix'=>'InformasiPasienDirawat'], function(){
        Route::get('/', ['as' => 'informasi-pasien-dirawat', 'uses' => 'MonitoringController@informasi_pasien_rawat_inap']);
    });
});

Route::name('bridging')->prefix('bridging')->group(function() {

    Route::get('referensi', 'BridgingController@referensi')->name('.referensi');
    Route::get('kunjungan', 'BridgingController@kunjungan')->name('.kunjungan');
    Route::get('klaim', 'BridgingController@klaim')->name('.klaim');
    Route::get('suplesi', 'BridgingController@suplesi')->name('.suplesi');
    Route::get('histori_peserta', 'BridgingController@histori_peserta')->name('.histori_peserta');
    Route::get('klaim_jasa_raharja', 'BridgingController@klaim_jasa_raharja')->name('.klaim_jasa_raharja');
    Route::get('lpk', 'BridgingController@lpk')->name('.lpk');
    Route::get('lpk-list', 'BridgingController@lpk_list')->name('.lpk-list');
    Route::get('lpk-create', 'BridgingController@lpk_create')->name('.lpk-create');
    Route::post('lpk-store', 'BridgingController@lpk_store')->name('.lpk-store');
});

Route::group(['prefix'=>'test-ws'], function(){
    Route::get('/sender', ['as' => 'sender', 'uses' => 'WelcomeController@sender']);
    Route::get('/catcher', ['as' => 'catcher', 'uses' => 'WelcomeController@catcher']);
});