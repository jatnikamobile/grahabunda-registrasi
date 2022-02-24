<?php

namespace App\Http\Controllers\Bridging;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use LZCompressor\LZString;

class NewVClaimController extends Controller
{
    private $url;
    private $antrean_url;
    private $cons_id;
    private $secret_key;
    private $user_key;
    private $kode_ppk;
    private $nama_ppk;

    public function __construct()
    {
        $this->url = config('vclaim.url');
        $this->antrean_url = config('vclaim.antrean_url');
        $this->cons_id = config('vclaim.cons_id');
        $this->secret_key = config('vclaim.secret_key');
        $this->user_key = config('vclaim.user_key');
        $this->kode_ppk = config('vclaim.kode_ppk');
        $this->nama_ppk = config('vclaim.nama_ppk');
    }

    private function createSignature()
    {
        date_default_timezone_set('UTC');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        return [
            'timestamp' => $timestamp,
            'signature' => base64_encode(hash_hmac('sha256', $this->cons_id . '&' . $timestamp, $this->secret_key, true))
        ];
    }

    private function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
    
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
    
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
    
        return $output;
    }

    private function decompress($string)
    {
        return LZString::decompressFromEncodedURIComponent($string);
    }

    private function getResult($string, $timestamp)
    {
        $key = $this->cons_id . $this->secret_key . $timestamp;

        $decrypt = $this->stringDecrypt($key, $string);
        $result = $this->decompress($decrypt);

        return json_decode($result, true);
    }
    
    private function sendRequest($method, $data, $url, $headers)
    {
        $curl = curl_init();
        $json_data = is_array($data) ? json_encode($data) : $data;

        switch ($method){
            case "POST":
            case "post":
                $headers[] = 'Content-Type: Application/x-www-form-urlencoded';
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($json_data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
                break;
            case "PUT":
            case "put":
                $headers[] = 'Content-Type: Application/x-www-form-urlencoded';
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($json_data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
                break;
            case "GET":
            case "get":
                $headers[] = 'Content-Type: application/json; charset=UTF-8';
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                if ($json_data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
                break;
            case "DELETE":
            case "delete":
                $headers[] = 'Content-Type: Application/x-www-form-urlencoded';
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($json_data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
                break;
            default:
                $headers[] = 'Content-Type: application/json; charset=UTF-8';
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                break;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($curl);

        return $result;
    }

    private function setHeaders()
    {
        $signature = $this->createSignature();
        
        return [
            'headers' => [
                'Accept: application/json',
                'X-cons-id: ' . $this->cons_id,
                'X-timestamp: ' . $signature['timestamp'],
                'X-signature: ' . $signature['signature'],
                'user_key: ' . $this->user_key,
            ],
            'timestamp' => $signature['timestamp']
        ];
    }

    private function setAntreanHeaders()
    {
        $signature = $this->createSignature();

        return [
            'headers' => [
                'Accept: application/json',
                'X-cons-id: ' . $this->cons_id,
                'X-timestamp: ' . $signature['timestamp'],
                'X-signature: ' . $signature['signature'],
                'user_key: ' . $this->user_key_antrean,
            ],
            'timestamp' => $signature['timestamp']
        ];
    }

    public function insertLPK($data_lpk = [])
    {
        if (count($data_lpk) > 0) {
            $url = $this->url . 'LPK/insert';
            $noSep = isset($data_lpk['noSep']) ? $data_lpk['noSep'] : '';
            $tglMasuk = isset($data_lpk['tglMasuk']) ? $data_lpk['tglMasuk'] : '';
            $tglKeluar = isset($data_lpk['tglKeluar']) ? $data_lpk['tglKeluar'] : '';
            $jaminan = isset($data_lpk['jaminan']) ? $data_lpk['jaminan'] : '';
            $poli = isset($data_lpk['poli']) ? $data_lpk['poli'] : '';
            $ruangRawat = isset($data_lpk['ruangRawat']) ? $data_lpk['ruangRawat'] : '';
            $kelasRawat = isset($data_lpk['kelasRawat']) ? $data_lpk['kelasRawat'] : '';
            $spesialistik = isset($data_lpk['spesialistik']) ? $data_lpk['spesialistik'] : '';
            $caraKeluar = isset($data_lpk['caraKeluar']) ? $data_lpk['caraKeluar'] : '';
            $kondisiPulang = isset($data_lpk['kondisiPulang']) ? $data_lpk['kondisiPulang'] : '';
            $diagnosa = isset($data_lpk['diagnosa']) ? $data_lpk['diagnosa'] : '';
            $procedure = isset($data_lpk['procedure']) ? $data_lpk['procedure'] : '';
            $tindakLanjut = isset($data_lpk['tindakLanjut']) ? $data_lpk['tindakLanjut'] : '';
            $dirujuk_ke_kodePPK = isset($data_lpk['dirujuk_ke_kodePPK']) ? $data_lpk['dirujuk_ke_kodePPK'] : '';
            $kontrol_kembali_tgl = isset($data_lpk['kontrol_kembali_tgl']) ? $data_lpk['kontrol_kembali_tgl'] : '';
            $kontrol_kembali_poli = isset($data_lpk['kontrol_kembali_poli']) ? $data_lpk['kontrol_kembali_poli'] : '';
            $DPJP = isset($data_lpk['DPJP']) ? $data_lpk['DPJP'] : '';
            $user = isset($data_lpk['user']) ? $data_lpk['user'] : '';

            $data_request_lpk = [
                'request' => [
                    't_lpk' => [
                        'noSep' => $noSep,
                        'tglMasuk' => $tglMasuk,
                        'tglKeluar' => $tglKeluar,
                        'jaminan' => $jaminan,
                        'poli' => [
                            'poli' => $poli
                        ],
                        'perawatan' => [
                            'ruangRawat' => $ruangRawat,
                            'kelasRawat' => $kelasRawat,
                            'spesialistik' => $spesialistik,
                            'caraKeluar' => $caraKeluar,
                            'kondisiPulang' => $kondisiPulang,
                        ],
                        'diagnosa' => $diagnosa,
                        'procedure' => $procedure,
                        'rencanaTL' => [
                            'tindakLanjut' => $tindakLanjut,
                            'dirujukKe' => [
                                'kodePPK' => $dirujuk_ke_kodePPK
                            ],
                            'kontrolKembali' => [
                                'tglKontrol' => $kontrol_kembali_tgl,
                                'poli' => $kontrol_kembali_poli
                            ]
                        ],
                        'DPJP' => $DPJP,
                        'user' => $user
                    ]
                ]
            ];

            $headers = $this->setHeaders();
            $timestamp = $headers['timestamp'];

            Log::info('BPJS Insert LPK API Request:');
            Log::info($data_request_lpk);

            $send_request = $this->sendRequest('POST', json_encode($data_request_lpk), $url, $headers['headers']);
            $result = json_decode($send_request, true);

            $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
            if ($result_code == 200) {
                $response = isset($result['response']) ? $result['response'] : null;

                if ($response) {
                    $arr_response = $this->getResult($response, $timestamp);

                    return $arr_response;
                } else {
                    return $result;
                }
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    public function updatetLPK($data_lpk = [])
    {
        if (count($data_lpk) > 0) {
            $url = $this->url . 'LPK/update';
            $noSep = isset($data_lpk['noSep']) ? $data_lpk['noSep'] : '';
            $tglMasuk = isset($data_lpk['tglMasuk']) ? $data_lpk['tglMasuk'] : '';
            $tglKeluar = isset($data_lpk['tglKeluar']) ? $data_lpk['tglKeluar'] : '';
            $jaminan = isset($data_lpk['jaminan']) ? $data_lpk['jaminan'] : '';
            $poli = isset($data_lpk['poli']) ? $data_lpk['poli'] : '';
            $ruangRawat = isset($data_lpk['ruangRawat']) ? $data_lpk['ruangRawat'] : '';
            $kelasRawat = isset($data_lpk['kelasRawat']) ? $data_lpk['kelasRawat'] : '';
            $spesialistik = isset($data_lpk['spesialistik']) ? $data_lpk['spesialistik'] : '';
            $caraKeluar = isset($data_lpk['caraKeluar']) ? $data_lpk['caraKeluar'] : '';
            $kondisiPulang = isset($data_lpk['kondisiPulang']) ? $data_lpk['kondisiPulang'] : '';
            $diagnosa = isset($data_lpk['diagnosa']) ? $data_lpk['diagnosa'] : '';
            $procedure = isset($data_lpk['procedure']) ? $data_lpk['procedure'] : '';
            $tindakLanjut = isset($data_lpk['tindakLanjut']) ? $data_lpk['tindakLanjut'] : '';
            $dirujuk_ke_kodePPK = isset($data_lpk['dirujuk_ke_kodePPK']) ? $data_lpk['dirujuk_ke_kodePPK'] : '';
            $kontrol_kembali_tgl = isset($data_lpk['kontrol_kembali_tgl']) ? $data_lpk['kontrol_kembali_tgl'] : '';
            $kontrol_kembali_poli = isset($data_lpk['kontrol_kembali_poli']) ? $data_lpk['kontrol_kembali_poli'] : '';
            $DPJP = isset($data_lpk['DPJP']) ? $data_lpk['DPJP'] : '';
            $user = isset($data_lpk['user']) ? $data_lpk['user'] : '';

            $data_request_lpk = [
                'request' => [
                    't_lpk' => [
                        'noSep' => $noSep,
                        'tglMasuk' => $tglMasuk,
                        'tglKeluar' => $tglKeluar,
                        'jaminan' => $jaminan,
                        'poli' => [
                            'poli' => $poli
                        ],
                        'perawatan' => [
                            'ruangRawat' => $ruangRawat,
                            'kelasRawat' => $kelasRawat,
                            'spesialistik' => $spesialistik,
                            'caraKeluar' => $caraKeluar,
                            'kondisiPulang' => $kondisiPulang,
                        ],
                        'diagnosa' => $diagnosa,
                        'procedure' => $procedure,
                        'rencanaTL' => [
                            'tindakLanjut' => $tindakLanjut,
                            'dirujukKe' => [
                                'kodePPK' => $dirujuk_ke_kodePPK
                            ],
                            'kontrolKembali' => [
                                'tglKontrol' => $kontrol_kembali_tgl,
                                'poli' => $kontrol_kembali_poli
                            ]
                        ],
                        'DPJP' => $DPJP,
                        'user' => $user
                    ]
                ]
            ];

            $headers = $this->setHeaders();
            $timestamp = $headers['timestamp'];

            $send_request = $this->sendRequest('PUT', json_encode($data_request_lpk), $url, $headers['headers']);
            $result = json_decode($send_request, true);

            $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
            if ($result_code == 200) {
                $response = isset($result['response']) ? $result['response'] : null;

                if ($response) {
                    $arr_response = $this->getResult($response, $timestamp);

                    return $arr_response;
                } else {
                    return $result;
                }
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    public function deleteLPK($data_lpk = [])
    {
        if (count($data_lpk) > 0) {
            $url = $this->url . 'LPK/delete';
            $noSep = isset($data_lpk['noSep']) ? $data_lpk['noSep'] : '';

            $data_request_lpk = [
                'request' => [
                    't_lpk' => [
                        'noSep' => $noSep
                    ]
                ]
            ];

            $headers = $this->setHeaders();
            $timestamp = $headers['timestamp'];

            $send_request = $this->sendRequest('DELETE', json_encode($data_request_lpk), $url, $headers['headers']);
            $result = json_decode($send_request, true);

            $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
            if ($result_code == 200) {
                $response = isset($result['response']) ? $result['response'] : null;

                if ($response) {
                    $arr_response = $this->getResult($response, $timestamp);

                    return $arr_response;
                } else {
                    return $result;
                }
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

    public function dataLembarPengajuanKlaim($tanggal_masuk, $jenis_pelayanan)
    {
        $url = $this->url . 'LPK/TglMasuk/' . $tanggal_masuk . '/JnsPelayanan/' . $jenis_pelayanan;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataKunjungan($tanggal_sep, $jenis_pelayanan)
    {
        $url = $this->url . 'Monitoring/Kunjungan/Tanggal/' . $tanggal_sep . '/JnsPelayanan/' . $jenis_pelayanan;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataKlaim($tanggal_pulang, $jenis_pelayanan, $status_klaim)
    {
        $url = $this->url . 'Monitoring/Klaim/Tanggal/' . $tanggal_pulang . '/JnsPelayanan/' . $jenis_pelayanan . '/Status/' . $status_klaim;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataHistoriPelayananPeserta($no_kartu, $tanggal_mulai, $tanggal_akhir)
    {
        $url = $this->url . 'monitoring/HistoriPelayanan/NoKartu/' . $no_kartu . '/tglMulai/' . $tanggal_mulai . '/tglAkhir/' . $tanggal_akhir;

		Log::info('BPJS History Pelayanan Peserta API Request:');
		Log::info($url);

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataKlaimJaminanJasaRaharja($jenis_pelayanan, $tanggal_mulai, $tanggal_akhir)
    {
        $url = $this->url . 'monitoring/JasaRaharja/JnsPelayanan/' . $jenis_pelayanan . '/tglMulai/' . $tanggal_mulai . '/tglAkhir/' . $tanggal_akhir;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function pesertaKartu($no_kartu, $tanggal_pelayanan_sep)
    {
        $url = $this->url . 'Peserta/nokartu/' . $no_kartu . '/tglSEP/' . $tanggal_pelayanan_sep;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function pesertaNIK($nik_ktp, $tanggal_pelayanan_sep)
    {
        $url = $this->url . 'Peserta/nik/' . $nik_ktp . '/tglSEP/' . $tanggal_pelayanan_sep;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertPRB($data_prb)
    {
        $url = $this->url . 'PRB/insert';
        $noSep = isset($data_prb['noSep']) ? $data_prb['noSep'] : '';
        $noKartu = isset($data_prb['noKartu']) ? $data_prb['noKartu'] : '';
        $alamat = isset($data_prb['alamat']) ? $data_prb['alamat'] : '';
        $email = isset($data_prb['email']) ? $data_prb['email'] : '';
        $programPRB = isset($data_prb['programPRB']) ? $data_prb['programPRB'] : '';
        $kodeDPJP = isset($data_prb['kodeDPJP']) ? $data_prb['kodeDPJP'] : '';
        $keterangan = isset($data_prb['keterangan']) ? $data_prb['keterangan'] : '';
        $saran = isset($data_prb['saran']) ? $data_prb['saran'] : '';
        $user = isset($data_prb['user']) ? $data_prb['user'] : '';
        $obat = isset($data_prb['obat']) ? $data_prb['obat'] : '';

        $data_request_prb = [
            'request' => [
                't_prb' => [
                    'noSep' => $noSep,
                    'noKartu' => $noKartu,
                    'alamat' => $alamat,
                    'email' => $email,
                    'programPRB' => $programPRB,
                    'kodeDPJP' => $kodeDPJP,
                    'keterangan' => $keterangan,
                    'saran' => $saran,
                    'user' => $user,
                    'obat' => $obat
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_prb, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updatePRB($data_prb)
    {
        $url = $this->url . 'PRB/Update';
        $noSrb = isset($data_prb['noSrb']) ? $data_prb['noSrb'] : '';
        $noSep = isset($data_prb['noSep']) ? $data_prb['noSep'] : '';
        $alamat = isset($data_prb['alamat']) ? $data_prb['alamat'] : '';
        $email = isset($data_prb['email']) ? $data_prb['email'] : '';
        $kodeDPJP = isset($data_prb['kodeDPJP']) ? $data_prb['kodeDPJP'] : '';
        $keterangan = isset($data_prb['keterangan']) ? $data_prb['keterangan'] : '';
        $saran = isset($data_prb['saran']) ? $data_prb['saran'] : '';
        $user = isset($data_prb['user']) ? $data_prb['user'] : '';
        $obat = isset($data_prb['obat']) ? $data_prb['obat'] : '';

        $data_request_prb = [
            'request' => [
                't_prb' => [
                    'noSrb' => $noSrb,
                    'noSep' => $noSep,
                    'alamat' => $alamat,
                    'email' => $email,
                    'kodeDPJP' => $kodeDPJP,
                    'keterangan' => $keterangan,
                    'saran' => $saran,
                    'user' => $user,
                    'obat' => $obat
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_prb, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function deletePRB($data_prb)
    {
        $url = $this->url . 'PRB/Delete';
        $noSrb = isset($data_prb['noSrb']) ? $data_prb['noSrb'] : '';
        $noSep = isset($data_prb['noSep']) ? $data_prb['noSep'] : '';
        $user = isset($data_prb['user']) ? $data_prb['user'] : '';

        $data_request_prb = [
            'request' => [
                't_prb' => [
                    'noSrb' => $noSrb,
                    'noSep' => $noSep,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_prb, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function nomorSRB($no_srb, $no_sep)
    {
        $url = $this->url . 'prb/' . $no_srb . '/nosep/' . $no_sep;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function tanggalSRB($tanggal_mulai, $tanggal_selesai)
    {
        $url = $this->url . 'prb/tglMulai/' . $tanggal_mulai . '/tglAkhir/' . $tanggal_selesai;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiDiagnosa($kode)
    {
        $url = $this->url . 'referensi/diagnosa/' . $kode;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiPoli($kode)
    {
        $url = $this->url . 'referensi/poli/' . $kode;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiFasilitasKesehatan($kode, $jenis_faskes)
    {
        $url = $this->url . 'referensi/faskes/' . $kode . '/' . $jenis_faskes;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiDokterDPJP($jenis_pelayanan, $tanggal_pelayanan, $kode_spesialis)
    {
        $url = $this->url . 'referensi/dokter/pelayanan/' . $jenis_pelayanan . '/tglPelayanan/' . $tanggal_pelayanan . '/Spesialis/' . $kode_spesialis;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiPropinsi()
    {
        $url = $this->url . 'referensi/propinsi';

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiKabupaten($kode_propinsi)
    {
        $url = $this->url . 'referensi/kabupaten/propinsi/' . $kode_propinsi;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiKecamatan($kode_kabupaten)
    {
        $url = $this->url . 'referensi/kecamatan/kabupaten/' . $kode_kabupaten;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiDiagnosaProgramPRB()
    {
        $url = $this->url . 'referensi/diagnosaprb';

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiObatGenerikProgramPRB($nama_obat_generik)
    {
        $url = $this->url . 'referensi/obatprb/' . $nama_obat_generik;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiProcedureTindakan($kode)
    {
        $url = $this->url . 'referensi/procedure/' . $kode;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiKelasRawat()
    {
        $url = $this->url . 'referensi/kelasrawat';

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiDokter($nama)
    {
        $url = $this->url . 'referensi/dokter/' . $nama;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiSpesialistik()
    {
        $url = $this->url . 'referensi/spesialistik';

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiRuangRawat()
    {
        $url = $this->url . 'referensi/ruangrawat';

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiCaraKeluar()
    {
        $url = $this->url . 'referensi/carakeluar';

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function referensiPascaPulang()
    {
        $url = $this->url . 'referensi/pascapulang';

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertRencanaKontrol($data_rk)
    {
        $url = $this->url . 'RencanaKontrol/insert';

        $noSEP = isset($data_rk['noSEP']) ? $data_rk['noSEP'] : '';
        $kodeDokter = isset($data_rk['kodeDokter']) ? $data_rk['kodeDokter'] : '';
        $poliKontrol = isset($data_rk['poliKontrol']) ? $data_rk['poliKontrol'] : '';
        $tglRencanaKontrol = isset($data_rk['tglRencanaKontrol']) ? $data_rk['tglRencanaKontrol'] : '';
        $user = isset($data_rk['user']) ? $data_rk['user'] : '';

        $data_request_rk = [
            'request' => [
                'noSEP' => $noSEP,
                'kodeDokter' => $kodeDokter,
                'poliKontrol' => $poliKontrol,
                'tglRencanaKontrol' => $tglRencanaKontrol,
                'user' => $user,
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_rk, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateRencanaKontrol($data_rk)
    {
        $url = $this->url . 'RencanaKontrol/Update';

        $noSuratKontrol = isset($data_rk['noSuratKontrol']) ? $data_rk['noSuratKontrol'] : '';
        $noSEP = isset($data_rk['noSEP']) ? $data_rk['noSEP'] : '';
        $kodeDokter = isset($data_rk['kodeDokter']) ? $data_rk['kodeDokter'] : '';
        $poliKontrol = isset($data_rk['poliKontrol']) ? $data_rk['poliKontrol'] : '';
        $tglRencanaKontrol = isset($data_rk['tglRencanaKontrol']) ? $data_rk['tglRencanaKontrol'] : '';
        $user = isset($data_rk['user']) ? $data_rk['user'] : '';

        $data_request_rk = [
            'request' => [
                'noSuratKontrol' => $noSuratKontrol,
                'noSEP' => $noSEP,
                'kodeDokter' => $kodeDokter,
                'poliKontrol' => $poliKontrol,
                'tglRencanaKontrol' => $tglRencanaKontrol,
                'user' => $user,
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_rk, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function deleteRencanaKontrol($data_rk)
    {
        $url = $this->url . 'RencanaKontrol/Delete';

        $noSuratKontrol = isset($data_rk['noSuratKontrol']) ? $data_rk['noSuratKontrol'] : null;
        $user = isset($data_rk['user']) ? $data_rk['user'] : null;

        $data_request_rk = [
            'request' => [
                't_suratkontrol' => [
                    'noSuratKontrol' => $noSuratKontrol,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('DELETE', $data_request_rk, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertSPRI($data_spri)
    {
        $url = $this->url . 'RencanaKontrol/InsertSPRI';

        $noKartu = isset($data_spri['noKartu']) ? $data_spri['noKartu'] : '';
        $kodeDokter = isset($data_spri['kodeDokter']) ? $data_spri['kodeDokter'] : '';
        $poliKontrol = isset($data_spri['poliKontrol']) ? $data_spri['poliKontrol'] : '';
        $tglRencanaKontrol = isset($data_spri['tglRencanaKontrol']) ? $data_spri['tglRencanaKontrol'] : '';
        $user = isset($data_spri['user']) ? $data_spri['user'] : '';

        $data_request_rk = [
            'request' => [
                'noKartu' => $noKartu,
                'kodeDokter' => $kodeDokter,
                'poliKontrol' => $poliKontrol,
                'tglRencanaKontrol' => $tglRencanaKontrol,
                'user' => $user,
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

		Log::info('BPJS Insert SPRI API Request:');
		Log::info($data_request_rk);

        $send_request = $this->sendRequest('POST', $data_request_rk, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateSPRI($data_spri)
    {
        $url = $this->url . 'RencanaKontrol/UpdateSPRI';

        $noSPRI = isset($data_spri['noSPRI']) ? $data_spri['noSPRI'] : '';
        $kodeDokter = isset($data_spri['kodeDokter']) ? $data_spri['kodeDokter'] : '';
        $poliKontrol = isset($data_spri['poliKontrol']) ? $data_spri['poliKontrol'] : '';
        $tglRencanaKontrol = isset($data_spri['tglRencanaKontrol']) ? $data_spri['tglRencanaKontrol'] : '';
        $user = isset($data_spri['user']) ? $data_spri['user'] : '';

        $data_request_rk = [
            'request' => [
                'noSPRI' => $noSPRI,
                'kodeDokter' => $kodeDokter,
                'poliKontrol' => $poliKontrol,
                'tglRencanaKontrol' => $tglRencanaKontrol,
                'user' => $user,
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_rk, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function rencanaKontrolCariSEP($nomor_sep)
    {
        $url = $this->url . 'RencanaKontrol/nosep/' . $nomor_sep;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function cariNomorSuratKontrol($nomor_surat_kontrol)
    {
        $url = $this->url . 'RencanaKontrol/noSuratKontrol/' . $nomor_surat_kontrol;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return [
                    'metaData' => [
                        'code' => 201,
                        'message' => 'Decrypt failed'
                    ]
                ];
            }
        } else {
            return $result;
        }
    }

    public function dataNomorSuratKontrol($tanggal_awal, $tanggal_akhir, $format_filter)
    {
        $url = $this->url . 'RencanaKontrol/ListRencanaKontrol/tglAwal/' . $tanggal_awal . '/tglAkhir/' . $tanggal_akhir . '/filter/' . $format_filter;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataPoliSpesialistik($jenis_kontrol, $nomor, $tanggal_rencana_kontrol)
    {
        $url = $this->url . 'RencanaKontrol/ListSpesialistik/JnsKontrol/' . $jenis_kontrol . '/nomor/' . $nomor . '/TglRencanaKontrol/' . $tanggal_rencana_kontrol;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataDokter($jenis_kontrol, $kode_poli, $tanggal_rencana_kontrol)
    {
        $url = $this->url . 'RencanaKontrol/JadwalPraktekDokter/JnsKontrol/' . $jenis_kontrol . '/KdPoli/' . $kode_poli . '/TglRencanaKontrol/' . $tanggal_rencana_kontrol;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function getRujukanByNomor($nomor_rujukan, $faskes)
    {
        if ($faskes == 1) {
            $url = $this->url . 'Rujukan/' . $nomor_rujukan;
        } else {
            $url = $this->url . 'Rujukan/RS/' . $nomor_rujukan;
        }

		Log::info('BPJS Get Rujukan API Request:');
		Log::info($url);

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function getOneRujukanByNoKartu($nomor_kartu, $faskes)
    {
        if ($faskes == 1) {
            $url = $this->url . 'Rujukan/Peserta/' . $nomor_kartu;
        } else {
            $url = $this->url . 'Rujukan/RS/Peserta/' . $nomor_kartu;
        }

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function getAllRujukanByNoKartu($nomor_kartu)
    {
        $url = $this->url . 'Rujukan/List/Peserta/' . $nomor_kartu;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertRujukan($data_rujukan)
    {
        $url = $this->url . 'Rujukan/insert';

        $noSep = isset($data_rujukan['noSep']) ? $data_rujukan['noSep'] : '';
        $tglRujukan = isset($data_rujukan['tglRujukan']) ? $data_rujukan['tglRujukan'] : '';
        $ppkDirujuk = isset($data_rujukan['ppkDirujuk']) ? $data_rujukan['ppkDirujuk'] : '';
        $jnsPelayanan = isset($data_rujukan['jnsPelayanan']) ? $data_rujukan['jnsPelayanan'] : '';
        $catatan = isset($data_rujukan['catatan']) ? $data_rujukan['catatan'] : '';
        $diagRujukan = isset($data_rujukan['diagRujukan']) ? $data_rujukan['diagRujukan'] : '';
        $tipeRujukan = isset($data_rujukan['tipeRujukan']) ? $data_rujukan['tipeRujukan'] : '';
        $poliRujukan = isset($data_rujukan['poliRujukan']) ? $data_rujukan['poliRujukan'] : '';
        $user = isset($data_rujukan['user']) ? $data_rujukan['user'] : '';

        $data_request_rujukan = [
            'request' => [
                't_rujukan' => [
                    'noSep' => $noSep,
                    'tglRujukan' => $tglRujukan,
                    'ppkDirujuk' => $ppkDirujuk,
                    'jnsPelayanan' => $jnsPelayanan,
                    'catatan' => $catatan,
                    'diagRujukan' => $diagRujukan,
                    'tipeRujukan' => $tipeRujukan,
                    'poliRujukan' => $poliRujukan,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_rujukan, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateRujukan($data_rujukan)
    {
        $url = $this->url . 'Rujukan/update';

        $noRujukan = isset($data_rujukan['noRujukan']) ? $data_rujukan['noRujukan'] : '';
        $ppkDirujuk = isset($data_rujukan['ppkDirujuk']) ? $data_rujukan['ppkDirujuk'] : '';
        $tipe = isset($data_rujukan['tipe']) ? $data_rujukan['tipe'] : '';
        $jnsPelayanan = isset($data_rujukan['jnsPelayanan']) ? $data_rujukan['jnsPelayanan'] : '';
        $catatan = isset($data_rujukan['catatan']) ? $data_rujukan['catatan'] : '';
        $diagRujukan = isset($data_rujukan['diagRujukan']) ? $data_rujukan['diagRujukan'] : '';
        $tipeRujukan = isset($data_rujukan['tipeRujukan']) ? $data_rujukan['tipeRujukan'] : '';
        $poliRujukan = isset($data_rujukan['poliRujukan']) ? $data_rujukan['poliRujukan'] : '';
        $user = isset($data_rujukan['user']) ? $data_rujukan['user'] : '';

        $data_request_rujukan = [
            'request' => [
                't_rujukan' => [
                    'noRujukan' => $noRujukan,
                    'ppkDirujuk' => $ppkDirujuk,
                    'tipe' => $tipe,
                    'jnsPelayanan' => $jnsPelayanan,
                    'catatan' => $catatan,
                    'diagRujukan' => $diagRujukan,
                    'tipeRujukan' => $tipeRujukan,
                    'poliRujukan' => $poliRujukan,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_rujukan, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function deleteRujukan($data_rujukan)
    {
        $url = $this->url . 'Rujukan/delete';

        $noRujukan = isset($data_rujukan['noRujukan']) ? $data_rujukan['noRujukan'] : '';
        $user = isset($data_rujukan['user']) ? $data_rujukan['user'] : '';

        $data_request_rujukan = [
            'request' => [
                't_rujukan' => [
                    'noRujukan' => $noRujukan,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('DELETE', $data_request_rujukan, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertRujukanKhusus($data_rujukan)
    {
        $url = $this->url . 'Rujukan/Khusus/insert';

        $noRujukan = isset($data_rujukan['noRujukan']) ? $data_rujukan['noRujukan'] : '';
        $diagnosa = isset($data_rujukan['diagnosa']) ? $data_rujukan['diagnosa'] : '';
        $procedure = isset($data_rujukan['procedure']) ? $data_rujukan['procedure'] : '';
        $user = isset($data_rujukan['user']) ? $data_rujukan['user'] : '';

        $data_request_rujukan = [
            'request' => [
                'noRujukan' => $noRujukan,
                'diagnosa' => $diagnosa,
                'procedure' => $procedure,
                'user' => $user,
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_rujukan, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function deleteRujukanKhusus($data_rujukan)
    {
        $url = $this->url . 'Rujukan/Khusus/delete';

        $idRujukan = isset($data_rujukan['idRujukan']) ? $data_rujukan['idRujukan'] : '';
        $noRujukan = isset($data_rujukan['noRujukan']) ? $data_rujukan['noRujukan'] : '';
        $user = isset($data_rujukan['user']) ? $data_rujukan['user'] : null;

        $data_request_rujukan = [
            'request' => [
                't_rujukan' => [
                    'idRujukan' => $idRujukan,
                    'noRujukan' => $noRujukan,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('DELETE', $data_request_rujukan, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function listRujukanKhusus($bulan, $tahun)
    {
        $url = $this->url . 'Rujukan/Khusus/List/Bulan/' . $bulan . '/Tahun/' . $tahun;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertRujukanV2($data_rujukan)
    {
        $url = $this->url . 'Rujukan/2.0/insert';

        $noSep = isset($data_rujukan['noSep']) ? $data_rujukan['noSep'] : '';
        $tglRujukan = isset($data_rujukan['tglRujukan']) ? $data_rujukan['tglRujukan'] : '';
        $tglRencanaKunjungan = isset($data_rujukan['tglRencanaKunjungan']) ? $data_rujukan['tglRencanaKunjungan'] : '';
        $ppkDirujuk = isset($data_rujukan['ppkDirujuk']) ? $data_rujukan['ppkDirujuk'] : '';
        $jnsPelayanan = isset($data_rujukan['jnsPelayanan']) ? $data_rujukan['jnsPelayanan'] : '';
        $catatan = isset($data_rujukan['catatan']) ? $data_rujukan['catatan'] : '';
        $diagRujukan = isset($data_rujukan['diagRujukan']) ? $data_rujukan['diagRujukan'] : '';
        $tipeRujukan = isset($data_rujukan['tipeRujukan']) ? $data_rujukan['tipeRujukan'] : '';
        $poliRujukan = isset($data_rujukan['poliRujukan']) ? $data_rujukan['poliRujukan'] : '';
        $user = isset($data_rujukan['user']) ? $data_rujukan['user'] : '';

        $data_request_rujukan = [
            'request' => [
                't_rujukan' => [
                    'noSep' => $noSep,
                    'tglRujukan' => $tglRujukan,
                    'tglRencanaKunjungan' => $tglRencanaKunjungan,
                    'ppkDirujuk' => $ppkDirujuk,
                    'jnsPelayanan' => $jnsPelayanan,
                    'catatan' => $catatan,
                    'diagRujukan' => $diagRujukan,
                    'tipeRujukan' => $tipeRujukan,
                    'poliRujukan' => $poliRujukan,
                    'user' => $user,
                ]
            ]
        ];

		Log::info('BPJS Create Rujukan API Request:');
		Log::info($data_request_rujukan);

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_rujukan, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateRujukanV2($data_rujukan)
    {
        $url = $this->url . 'Rujukan/2.0/Update';

        $noRujukan = isset($data_rujukan['noRujukan']) ? $data_rujukan['noRujukan'] : '';
        $tglRujukan = isset($data_rujukan['tglRujukan']) ? $data_rujukan['tglRujukan'] : '';
        $tglRencanaKunjungan = isset($data_rujukan['tglRencanaKunjungan']) ? $data_rujukan['tglRencanaKunjungan'] : '';
        $ppkDirujuk = isset($data_rujukan['ppkDirujuk']) ? $data_rujukan['ppkDirujuk'] : '';
        $jnsPelayanan = isset($data_rujukan['jnsPelayanan']) ? $data_rujukan['jnsPelayanan'] : '';
        $catatan = isset($data_rujukan['catatan']) ? $data_rujukan['catatan'] : '';
        $diagRujukan = isset($data_rujukan['diagRujukan']) ? $data_rujukan['diagRujukan'] : '';
        $tipeRujukan = isset($data_rujukan['tipeRujukan']) ? $data_rujukan['tipeRujukan'] : '';
        $poliRujukan = isset($data_rujukan['poliRujukan']) ? $data_rujukan['poliRujukan'] : '';
        $user = isset($data_rujukan['user']) ? $data_rujukan['user'] : '';

        $data_request_rujukan = [
            'request' => [
                't_rujukan' => [
                    'noRujukan' => $noRujukan,
                    'tglRujukan' => $tglRujukan,
                    'tglRencanaKunjungan' => $tglRencanaKunjungan,
                    'ppkDirujuk' => $ppkDirujuk,
                    'jnsPelayanan' => $jnsPelayanan,
                    'catatan' => $catatan,
                    'diagRujukan' => $diagRujukan,
                    'tipeRujukan' => $tipeRujukan,
                    'poliRujukan' => $poliRujukan,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_rujukan, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function listSpesialistikRujukan($kode_ppk_rujukan, $tanggal_rujukan)
    {
        $url = $this->url . 'Rujukan/ListSpesialistik/PPKRujukan/' . $kode_ppk_rujukan . '/TglRujukan/' . $tanggal_rujukan;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function listSarana($kode_ppk_rujukan)
    {
        $url = $this->url . 'Rujukan/ListSarana/PPKRujukan/' . $kode_ppk_rujukan;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertSEP($data_sep)
    {
        $url = $this->url . 'SEP/1.1/insert';

        $noKartu = isset($data_sep['noKartu']) ? $data_sep['noKartu'] : '';
        $tglSep = isset($data_sep['tglSep']) ? $data_sep['tglSep'] : '';
        $ppkPelayanan = isset($data_sep['ppkPelayanan']) ? $data_sep['ppkPelayanan'] : '';
        $jnsPelayanan = isset($data_sep['jnsPelayanan']) ? $data_sep['jnsPelayanan'] : '';
        $klsRawat = isset($data_sep['klsRawat']) ? $data_sep['klsRawat'] : '';
        $noMR = isset($data_sep['noMR']) ? $data_sep['noMR'] : '';
        $asalRujukan = isset($data_sep['asalRujukan']) ? $data_sep['asalRujukan'] : '';
        $tglRujukan = isset($data_sep['tglRujukan']) ? $data_sep['tglRujukan'] : '';
        $noRujukan = isset($data_sep['noRujukan']) ? $data_sep['noRujukan'] : '';
        $ppkRujukan = isset($data_sep['ppkRujukan']) ? $data_sep['ppkRujukan'] : '';
        $catatan = isset($data_sep['catatan']) ? $data_sep['catatan'] : '';
        $diagAwal = isset($data_sep['diagAwal']) ? $data_sep['diagAwal'] : '';
        $poli_tujuan = isset($data_sep['poli_tujuan']) ? $data_sep['poli_tujuan'] : '';
        $poli_eksekutif = isset($data_sep['poli_eksekutif']) ? $data_sep['poli_eksekutif'] : '';
        $cob = isset($data_sep['cob']) ? $data_sep['cob'] : '';
        $katarak = isset($data_sep['katarak']) ? $data_sep['katarak'] : '';
        $lakaLantas = isset($data_sep['lakaLantas']) ? $data_sep['lakaLantas'] : '';
        $penjamin = isset($data_sep['penjamin']) ? $data_sep['penjamin'] : '';
        $tglKejadian = isset($data_sep['tglKejadian']) ? $data_sep['tglKejadian'] : '';
        $keterangan = isset($data_sep['keterangan']) ? $data_sep['keterangan'] : '';
        $suplesi = isset($data_sep['suplesi']) ? $data_sep['suplesi'] : '';
        $noSepSuplesi = isset($data_sep['noSepSuplesi']) ? $data_sep['noSepSuplesi'] : '';
        $kdPropinsi = isset($data_sep['kdPropinsi']) ? $data_sep['kdPropinsi'] : '';
        $kdKabupaten = isset($data_sep['kdKabupaten']) ? $data_sep['kdKabupaten'] : '';
        $kdKecamatan = isset($data_sep['kdKecamatan']) ? $data_sep['kdKecamatan'] : '';
        $noSurat = isset($data_sep['noSurat']) ? $data_sep['noSurat'] : '';
        $kodeDPJP = isset($data_sep['kodeDPJP']) ? $data_sep['kodeDPJP'] : '';
        $noTelp = isset($data_sep['noTelp']) ? $data_sep['noTelp'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';

        $data_request_sep = [
            'request' => [
                't_sep' => [
                    'noKartu' => $noKartu,
                    'tglSep' => $tglSep,
                    'ppkPelayanan' => $ppkPelayanan,
                    'jnsPelayanan' => $jnsPelayanan,
                    'klsRawat' => $klsRawat,
                    'noMR' => $noMR,
                    'rujukan' => [
                        'asalRujukan' => $asalRujukan,
                        'tglRujukan' => $tglRujukan,
                        'noRujukan' => $noRujukan,
                        'ppkRujukan' => $ppkRujukan,
                    ],
                    'catatan' => $catatan,
                    'diagAwal' => $diagAwal,
                    'poli' => [
                        'tujuan' => $poli_tujuan,
                        'eksekutif' => $poli_eksekutif,
                    ],
                    'cob' => [
                        'cob' => $cob,
                    ],
                    'katarak' => [
                        'katarak' => $katarak,
                    ],
                    'jaminan' => [
                        'lakaLantas' => $lakaLantas,
                        'penjamin' => [
                            'penjamin' => $penjamin,
                            'tglKejadian' => $tglKejadian,
                            'keterangan' => $keterangan,
                            'suplesi' => [
                                'suplesi' => $suplesi,
                                'noSepSuplesi' => $noSepSuplesi,
                                'lokasiLaka' => [
                                    'kdPropinsi' => $kdPropinsi,
                                    'kdKabupaten' => $kdKabupaten,
                                    'kdKecamatan' => $kdKecamatan,
                                ]
                            ]
                        ]
                    ],
                    'skdp' => [
                        'noSurat' => $noSurat,
                        'kodeDPJP' => $kodeDPJP,
                    ],
                    'noTelp' => $noTelp,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateSEP($data_sep)
    {
        $url = $this->url . 'SEP/1.1/Update';

        $tglSep = isset($data_sep['tglSep']) ? $data_sep['tglSep'] : '';
        $klsRawat = isset($data_sep['klsRawat']) ? $data_sep['klsRawat'] : '';
        $noMR = isset($data_sep['noMR']) ? $data_sep['noMR'] : '';
        $asalRujukan = isset($data_sep['asalRujukan']) ? $data_sep['asalRujukan'] : '';
        $tglRujukan = isset($data_sep['tglRujukan']) ? $data_sep['tglRujukan'] : '';
        $noRujukan = isset($data_sep['noRujukan']) ? $data_sep['noRujukan'] : '';
        $ppkRujukan = isset($data_sep['ppkRujukan']) ? $data_sep['ppkRujukan'] : '';
        $catatan = isset($data_sep['catatan']) ? $data_sep['catatan'] : '';
        $diagAwal = isset($data_sep['diagAwal']) ? $data_sep['diagAwal'] : '';
        $poli_eksekutif = isset($data_sep['poli_eksekutif']) ? $data_sep['poli_eksekutif'] : '';
        $cob = isset($data_sep['cob']) ? $data_sep['cob'] : '';
        $katarak = isset($data_sep['katarak']) ? $data_sep['katarak'] : '';
        $lakaLantas = isset($data_sep['lakaLantas']) ? $data_sep['lakaLantas'] : '';
        $penjamin = isset($data_sep['penjamin']) ? $data_sep['penjamin'] : '';
        $tglKejadian = isset($data_sep['tglKejadian']) ? $data_sep['tglKejadian'] : '';
        $keterangan = isset($data_sep['keterangan']) ? $data_sep['keterangan'] : '';
        $suplesi = isset($data_sep['suplesi']) ? $data_sep['suplesi'] : '';
        $noSepSuplesi = isset($data_sep['noSepSuplesi']) ? $data_sep['noSepSuplesi'] : '';
        $kdPropinsi = isset($data_sep['kdPropinsi']) ? $data_sep['kdPropinsi'] : '';
        $kdKabupaten = isset($data_sep['kdKabupaten']) ? $data_sep['kdKabupaten'] : '';
        $kdKecamatan = isset($data_sep['kdKecamatan']) ? $data_sep['kdKecamatan'] : '';
        $noSurat = isset($data_sep['noSurat']) ? $data_sep['noSurat'] : '';
        $kodeDPJP = isset($data_sep['kodeDPJP']) ? $data_sep['kodeDPJP'] : '';
        $noTelp = isset($data_sep['noTelp']) ? $data_sep['noTelp'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';

        $data_request_sep = [
            'request' => [
                't_sep' => [
                    'tglSep' => $tglSep,
                    'klsRawat' => $klsRawat,
                    'noMR' => $noMR,
                    'rujukan' => [
                        'asalRujukan' => $asalRujukan,
                        'tglRujukan' => $tglRujukan,
                        'noRujukan' => $noRujukan,
                        'ppkRujukan' => $ppkRujukan,
                    ],
                    'catatan' => $catatan,
                    'diagAwal' => $diagAwal,
                    'poli' => [
                        'eksekutif' => $poli_eksekutif,
                    ],
                    'cob' => [
                        'cob' => $cob,
                    ],
                    'katarak' => [
                        'katarak' => $katarak,
                    ],
                    'skdp' => [
                        'noSurat' => $noSurat,
                        'kodeDPJP' => $kodeDPJP,
                    ],
                    'jaminan' => [
                        'lakaLantas' => $lakaLantas,
                        'penjamin' => [
                            'penjamin' => $penjamin,
                            'tglKejadian' => $tglKejadian,
                            'keterangan' => $keterangan,
                            'suplesi' => [
                                'suplesi' => $suplesi,
                                'noSepSuplesi' => $noSepSuplesi,
                                'lokasiLaka' => [
                                    'kdPropinsi' => $kdPropinsi,
                                    'kdKabupaten' => $kdKabupaten,
                                    'kdKecamatan' => $kdKecamatan,
                                ]
                            ]
                        ]
                    ],
                    'noTelp' => $noTelp,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function hapusSEP($data_sep)
    {
        $url = $this->url . 'SEP/2.0/delete';

        $noSep = isset($data_sep['noSep']) ? $data_sep['noSep'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';

        $data_request_sep = [
            'request' => [
                't_sep' => [
                    'noSep' => $noSep,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

		Log::info('BPJS Delete SEP API Request:');
		Log::info($data_request_sep);

        $send_request = $this->sendRequest('DELETE', $data_request_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

		Log::info('BPJS Delete SEP API Response:');
		Log::info($result);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                return $response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function cariSEP($nomor_sep)
    {
        $url = $this->url . 'SEP/' . $nomor_sep;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function insertSEPV2($data_sep)
    {
        $url = $this->url . 'SEP/2.0/insert';

        $noKartu = isset($data_sep['noKartu']) ? $data_sep['noKartu'] : '';
        $tglSep = isset($data_sep['tglSep']) ? $data_sep['tglSep'] : '';
        $ppkPelayanan = isset($data_sep['ppkPelayanan']) ? $data_sep['ppkPelayanan'] : '';
        $jnsPelayanan = isset($data_sep['jnsPelayanan']) ? $data_sep['jnsPelayanan'] : '';
        $klsRawatHak = isset($data_sep['klsRawatHak']) ? $data_sep['klsRawatHak'] : '';
        $klsRawatNaik = isset($data_sep['klsRawatNaik']) ? $data_sep['klsRawatNaik'] : '';
        $pembiayaan = isset($data_sep['pembiayaan']) ? $data_sep['pembiayaan'] : '';
        $penanggungJawab = isset($data_sep['penanggungJawab']) ? $data_sep['penanggungJawab'] : '';
        $noMR = isset($data_sep['noMR']) ? $data_sep['noMR'] : '';
        $asalRujukan = isset($data_sep['asalRujukan']) ? $data_sep['asalRujukan'] : '';
        $tglRujukan = isset($data_sep['tglRujukan']) ? $data_sep['tglRujukan'] : '';
        $noRujukan = isset($data_sep['noRujukan']) ? $data_sep['noRujukan'] : '';
        $ppkRujukan = isset($data_sep['ppkRujukan']) ? $data_sep['ppkRujukan'] : '';
        $catatan = isset($data_sep['catatan']) ? $data_sep['catatan'] : '';
        $diagAwal = isset($data_sep['diagAwal']) ? $data_sep['diagAwal'] : '';
        $poli_tujuan = isset($data_sep['poli_tujuan']) ? $data_sep['poli_tujuan'] : '';
        $poli_eksekutif = isset($data_sep['poli_eksekutif']) ? $data_sep['poli_eksekutif'] : 0;
        $cob = isset($data_sep['cob']) ? $data_sep['cob'] : '';
        $katarak = isset($data_sep['katarak']) ? $data_sep['katarak'] : '';
        $lakaLantas = isset($data_sep['lakaLantas']) ? $data_sep['lakaLantas'] : '';
        $tglKejadian = isset($data_sep['tglKejadian']) ? $data_sep['tglKejadian'] : '';
        $keterangan = isset($data_sep['keterangan']) ? $data_sep['keterangan'] : '';
        $suplesi = isset($data_sep['suplesi']) ? $data_sep['suplesi'] : '';
        $noSepSuplesi = isset($data_sep['noSepSuplesi']) ? $data_sep['noSepSuplesi'] : '';
        $kdPropinsi = isset($data_sep['kdPropinsi']) ? $data_sep['kdPropinsi'] : '';
        $kdKabupaten = isset($data_sep['kdKabupaten']) ? $data_sep['kdKabupaten'] : '';
        $kdKecamatan = isset($data_sep['kdKecamatan']) ? $data_sep['kdKecamatan'] : '';
        $tujuanKunj = isset($data_sep['tujuanKunj']) ? $data_sep['tujuanKunj'] : '';
        $flagProcedure = isset($data_sep['flagProcedure']) ? $data_sep['flagProcedure'] : '';
        $kdPenunjang = isset($data_sep['kdPenunjang']) ? $data_sep['kdPenunjang'] : '';
        $assesmentPel = isset($data_sep['assesmentPel']) ? $data_sep['assesmentPel'] : '';
        $noSurat = isset($data_sep['noSurat']) ? $data_sep['noSurat'] : '';
        $kodeDPJP = isset($data_sep['kodeDPJP']) ? $data_sep['kodeDPJP'] : '';
        $dpjpLayan = isset($data_sep['dpjpLayan']) ? $data_sep['dpjpLayan'] : '';
        $noTelp = isset($data_sep['noTelp']) ? $data_sep['noTelp'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';

        $data_request_sep = [
            'request' => [
                't_sep' => [
                    'noKartu' => $noKartu,
                    'tglSep' => $tglSep,
                    'ppkPelayanan' => $this->kode_ppk,
                    'jnsPelayanan' => $jnsPelayanan,
                    'klsRawat' => [
                        'klsRawatHak' => $klsRawatHak,
                        'klsRawatNaik' => $klsRawatNaik,
                        'pembiayaan' => $pembiayaan,
                        'penanggungJawab' => $penanggungJawab,
                    ],
                    'noMR' => $noMR,
                    'rujukan' => [
                        'asalRujukan' => $asalRujukan,
                        'tglRujukan' => $tglRujukan,
                        'noRujukan' => $noRujukan,
                        'ppkRujukan' => $ppkRujukan,
                    ],
                    'catatan' => $catatan,
                    'diagAwal' => $diagAwal,
                    'poli' => [
                        'tujuan' => $poli_tujuan,
                        'eksekutif' => $poli_eksekutif,
                    ],
                    'cob' => [
                        'cob' => $cob,
                    ],
                    'katarak' => [
                        'katarak' => $katarak,
                    ],
                    'jaminan' => [
                        'lakaLantas' => $lakaLantas,
                        'penjamin' => [
                            'tglKejadian' => $lakaLantas != 0 ? $tglKejadian : '',
                            'keterangan' => $keterangan,
                            'suplesi' => [
                                'suplesi' => $suplesi,
                                'noSepSuplesi' => $noSepSuplesi,
                                'lokasiLaka' => [
                                    'kdPropinsi' => $kdPropinsi,
                                    'kdKabupaten' => $kdKabupaten,
                                    'kdKecamatan' => $kdKecamatan,
                                ]
                            ]
                        ]
                    ],
                    'tujuanKunj' => $tujuanKunj,
                    'flagProcedure' => $flagProcedure,
                    'kdPenunjang' => $kdPenunjang,
                    'assesmentPel' => $assesmentPel,
                    'skdp' => [
                        'noSurat' => $noSurat,
                        'kodeDPJP' => $kodeDPJP,
                    ],
                    'dpjpLayan' => $dpjpLayan,
                    'noTelp' => $noTelp,
                    'user' => $user,
                ]
            ]
        ];

		Log::info('BPJS Create SEP API Request:');
		Log::info($data_request_sep);

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateSEPV2($data_sep)
    {
        $url = $this->url . 'SEP/2.0/update';

        $noSep = isset($data_sep['noSep']) ? $data_sep['noSep'] : '';
        $klsRawatHak = isset($data_sep['klsRawatHak']) ? $data_sep['klsRawatHak'] : '';
        $klsRawatNaik = isset($data_sep['klsRawatNaik']) ? $data_sep['klsRawatNaik'] : '';
        $pembiayaan = isset($data_sep['pembiayaan']) ? $data_sep['pembiayaan'] : '';
        $penanggungJawab = isset($data_sep['penanggungJawab']) ? $data_sep['penanggungJawab'] : '';
        $noMR = isset($data_sep['noMR']) ? $data_sep['noMR'] : '';
        $catatan = isset($data_sep['catatan']) ? $data_sep['catatan'] : '';
        $diagAwal = isset($data_sep['diagAwal']) ? $data_sep['diagAwal'] : '';
        $poli_tujuan = isset($data_sep['poli_tujuan']) ? $data_sep['poli_tujuan'] : '';
        $poli_eksekutif = isset($data_sep['poli_eksekutif']) ? $data_sep['poli_eksekutif'] : '';
        $cob = isset($data_sep['cob']) ? $data_sep['cob'] : '';
        $katarak = isset($data_sep['katarak']) ? $data_sep['katarak'] : '';
        $lakaLantas = isset($data_sep['lakaLantas']) ? $data_sep['lakaLantas'] : '';
        $tglKejadian = isset($data_sep['tglKejadian']) ? $data_sep['tglKejadian'] : '';
        $keterangan = isset($data_sep['keterangan']) ? $data_sep['keterangan'] : '';
        $suplesi = isset($data_sep['suplesi']) ? $data_sep['suplesi'] : '';
        $noSepSuplesi = isset($data_sep['noSepSuplesi']) ? $data_sep['noSepSuplesi'] : '';
        $kdPropinsi = isset($data_sep['kdPropinsi']) ? $data_sep['kdPropinsi'] : '';
        $kdKabupaten = isset($data_sep['kdKabupaten']) ? $data_sep['kdKabupaten'] : '';
        $kdKecamatan = isset($data_sep['kdKecamatan']) ? $data_sep['kdKecamatan'] : '';
        $dpjpLayan = isset($data_sep['dpjpLayan']) ? $data_sep['dpjpLayan'] : '';
        $noTelp = isset($data_sep['noTelp']) ? $data_sep['noTelp'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';

        $data_request_sep = [
            'request' => [
                't_sep' => [
                    'noSep' => $noSep,
                    'klsRawat' => [
                        'klsRawatHak' => $klsRawatHak,
                        'klsRawatNaik' => $klsRawatNaik,
                        'pembiayaan' => $pembiayaan,
                        'penanggungJawab' => $penanggungJawab,
                    ],
                    'noMR' => $noMR,
                    'catatan' => $catatan,
                    'diagAwal' => $diagAwal,
                    'poli' => [
                        'tujuan' => $poli_tujuan,
                        'eksekutif' => $poli_eksekutif,
                    ],
                    'cob' => [
                        'cob' => $cob,
                    ],
                    'katarak' => [
                        'katarak' => $katarak,
                    ],
                    'jaminan' => [
                        'lakaLantas' => $lakaLantas,
                        'penjamin' => [
                            'tglKejadian' => $tglKejadian,
                            'keterangan' => $keterangan,
                            'suplesi' => [
                                'suplesi' => $suplesi,
                                'noSepSuplesi' => $noSepSuplesi,
                                'lokasiLaka' => [
                                    'kdPropinsi' => $kdPropinsi,
                                    'kdKabupaten' => $kdKabupaten,
                                    'kdKecamatan' => $kdKecamatan,
                                ]
                            ]
                        ]
                    ],
                    'dpjpLayan' => $dpjpLayan,
                    'noTelp' => $noTelp,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function deleteSEPV2($data_sep)
    {
        $url = $this->url . 'SEP/2.0/delete';

        $noSep = isset($data_sep['noSep']) ? $data_sep['noSep'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';

        $data_request_sep = [
            'request' => [
                't_sep' => [
                    'noSep' => $noSep,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

		Log::info('BPJS Delete SEP API Request:');
		Log::info($data_request_sep);

        $send_request = $this->sendRequest('DELETE', $data_request_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

		Log::info('BPJS Delete SEP API Response:');
		Log::info($result);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function suplesiJasaRaharja($no_kartu_peserta, $tanggal_pelayanan)
    {
        $url = $this->url . 'sep/JasaRaharja/Suplesi/' . $no_kartu_peserta . '/tglPelayanan/' . $tanggal_pelayanan;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataIndukKecelakaan($no_kartu_peserta)
    {
        $url = $this->url . 'sep/KllInduk/List/' . $no_kartu_peserta;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function pengajuanSEP($data_sep)
    {
        $url = $this->url . 'Sep/pengajuanSEP';

        $noKartu = isset($data_sep['noKartu']) ? $data_sep['noKartu'] : '';
        $tglSep = isset($data_sep['tglSep']) ? $data_sep['tglSep'] : '';
        $jnsPelayanan = isset($data_sep['jnsPelayanan']) ? $data_sep['jnsPelayanan'] : '';
        $jnsPengajuan = isset($data_sep['jnsPengajuan']) ? $data_sep['jnsPengajuan'] : '';
        $keterangan = isset($data_sep['keterangan']) ? $data_sep['keterangan'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';
        
        $data_request_pengajuan_sep = [
            'request' => [
                't_sep' => [
                    'noKartu' => $noKartu,
                    'tglSep' => $tglSep,
                    'jnsPelayanan' => $jnsPelayanan,
                    'jnsPengajuan' => $jnsPengajuan,
                    'keterangan' => $keterangan,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_pengajuan_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function approvalPengajuanSEP($data_sep)
    {
        $url = $this->url . 'Sep/pengajuanSEP';

        $noKartu = isset($data_sep['noKartu']) ? $data_sep['noKartu'] : '';
        $tglSep = isset($data_sep['tglSep']) ? $data_sep['tglSep'] : '';
        $jnsPelayanan = isset($data_sep['jnsPelayanan']) ? $data_sep['jnsPelayanan'] : '';
        $jnsPengajuan = isset($data_sep['jnsPengajuan']) ? $data_sep['jnsPengajuan'] : '';
        $keterangan = isset($data_sep['keterangan']) ? $data_sep['keterangan'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';
        
        if ($jnsPengajuan) {
            $data_request_pengajuan_sep = [
                'request' => [
                    't_sep' => [
                        'noKartu' => $noKartu,
                        'tglSep' => $tglSep,
                        'jnsPelayanan' => $jnsPelayanan,
                        'keterangan' => $keterangan,
                        'user' => $user,
                    ]
                ]
            ];
        } else {
            $data_request_pengajuan_sep = [
                'request' => [
                    't_sep' => [
                        'noKartu' => $noKartu,
                        'tglSep' => $tglSep,
                        'jnsPelayanan' => $jnsPelayanan,
                        'jnsPengajuan' => $jnsPengajuan,
                        'keterangan' => $keterangan,
                        'user' => $user,
                    ]
                ]
            ];
        }

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_pengajuan_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateTanggalPulang($data_sep)
    {
        $url = $this->url . 'Sep/updtglplg';

        $noSep = isset($data_sep['noSep']) ? $data_sep['noSep'] : '';
        $tglPlg = isset($data_sep['tglPlg']) ? $data_sep['tglPlg'] : '';
        $ppkPelayanan = isset($data_sep['ppkPelayanan']) ? $data_sep['ppkPelayanan'] : '';
        
        $data_request_pengajuan_sep = [
            'request' => [
                't_sep' => [
                    'noSep' => $noSep,
                    'tglPlg' => $tglPlg,
                    'ppkPelayanan' => $ppkPelayanan,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_pengajuan_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function updateTanggalPulangV2($data_sep)
    {
        $url = $this->url . 'SEP/2.0/updtglplg';

        $noSep = isset($data_sep['noSep']) ? $data_sep['noSep'] : '';
        $statusPulang = isset($data_sep['statusPulang']) ? $data_sep['statusPulang'] : '';
        $noSuratMeninggal = isset($data_sep['noSuratMeninggal']) ? $data_sep['noSuratMeninggal'] : '';
        $tglMeninggal = isset($data_sep['tglMeninggal']) ? $data_sep['tglMeninggal'] : '';
        $tglPulang = isset($data_sep['tglPulang']) ? $data_sep['tglPulang'] : '';
        $noLPManual = isset($data_sep['noLPManual']) ? $data_sep['noLPManual'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';
        
        $data_request_update_tanggal_pulang = [
            'request' => [
                't_sep' => [
                    'noSep' => $noSep,
                    'statusPulang' => $statusPulang,
                    'noSuratMeninggal' => $noSuratMeninggal,
                    'tglMeninggal' => $tglMeninggal,
                    'tglPulang' => $tglPulang,
                    'noLPManual' => $noLPManual,
                    'user' => $user,
                ]
            ]
        ];

		Log::info('BPJS Update Tanggal Pulang API Request:');
		Log::info($data_request_update_tanggal_pulang);

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('PUT', $data_request_update_tanggal_pulang, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function integrasiSepDenganInacbg($nomor_sep)
    {
        $url = $this->url . 'sep/cbg/' . $nomor_sep;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function dataSepInternal($nomor_sep)
    {
        $url = $this->url . 'SEP/Internal/' . $nomor_sep;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function hapusSepInternal($data_sep)
    {
        $url = $this->url . 'SEP/Internal/delete';

        $noSep = isset($data_sep['noSep']) ? $data_sep['noSep'] : '';
        $noSurat = isset($data_sep['noSurat']) ? $data_sep['noSurat'] : '';
        $tglRujukanInternal = isset($data_sep['tglRujukanInternal']) ? $data_sep['tglRujukanInternal'] : '';
        $kdPoliTuj = isset($data_sep['kdPoliTuj']) ? $data_sep['kdPoliTuj'] : '';
        $user = isset($data_sep['user']) ? $data_sep['user'] : '';

        $data_request_sep = [
            'request' => [
                't_sep' => [
                    'noSep' => $noSep,
                    'noSurat' => $noSurat,
                    'tglRujukanInternal' => $tglRujukanInternal,
                    'kdPoliTuj' => $kdPoliTuj,
                    'user' => $user,
                ]
            ]
        ];

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('DELETE', $data_request_sep, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function getFingerPrint($no_kartu_peserta, $tanggal_pelayanan)
    {
        $url = $this->url . 'SEP/FingerPrint/Peserta/' . $no_kartu_peserta . '/TglPelayanan/' . $tanggal_pelayanan;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function getListFingerPrint($tanggal_pelayanan)
    {
        $url = $this->url . 'SEP/FingerPrint/List/Peserta/TglPelayanan/' . $tanggal_pelayanan;

        $headers = $this->setHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metaData']['code']) ? $result['metaData']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return $result;
        }
    }

    public function wsBpjsReferensiPoli()
    {
        $url = $this->antrean_url . 'ref/poli';

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 1) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsReferensiDokter()
    {
        $url = $this->antrean_url . 'ref/dokter';

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 1) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsReferensiJadwalDokter($kode_poli_bpjs, $tanggal)
    {
        $url = $this->antrean_url . 'jadwaldokter/kodepoli/' . $kode_poli_bpjs . '/tanggal/' . $tanggal;

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        Log::info('headers');
        Log::info($headers);

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsUpdateJadwalDokter($data_update)
    {
        $url = $this->antrean_url . 'jadwaldokter/updatejadwaldokter';

        $kodepoli = isset($data_update['kodepoli']) ? $data_update['kodepoli'] : '';
        $kodesubspesialis = isset($data_update['kodesubspesialis']) ? $data_update['kodesubspesialis'] : '';
        $kodedokter = isset($data_update['kodedokter']) ? $data_update['kodedokter'] : '';
        $jadwal = isset($data_update['jadwal']) ? $data_update['jadwal'] : '';

        $data_request_update = [
            'kodepoli' => $kodepoli,
            'kodesubspesialis' => $kodesubspesialis,
            'kodedokter' => $kodedokter,
            'jadwal' => $jadwal,
        ];

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_update, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsTambahAntrean($data_antrean)
    {
        $url = $this->antrean_url . 'antrean/add';

        $kodebooking = isset($data_antrean['kodebooking']) ? $data_antrean['kodebooking'] : '';
        $jenispasien = isset($data_antrean['jenispasien']) ? $data_antrean['jenispasien'] : '';
        $nomorkartu = isset($data_antrean['nomorkartu']) ? $data_antrean['nomorkartu'] : '';
        $nik = isset($data_antrean['nik']) ? $data_antrean['nik'] : '';
        $nohp = isset($data_antrean['nohp']) ? $data_antrean['nohp'] : '';
        $kodepoli = isset($data_antrean['kodepoli']) ? $data_antrean['kodepoli'] : '';
        $namapoli = isset($data_antrean['namapoli']) ? $data_antrean['namapoli'] : '';
        $pasienbaru = isset($data_antrean['pasienbaru']) ? $data_antrean['pasienbaru'] : '';
        $norm = isset($data_antrean['norm']) ? $data_antrean['norm'] : '';
        $tanggalperiksa = isset($data_antrean['tanggalperiksa']) ? $data_antrean['tanggalperiksa'] : '';
        $kodedokter = isset($data_antrean['kodedokter']) ? $data_antrean['kodedokter'] : '';
        $namadokter = isset($data_antrean['namadokter']) ? $data_antrean['namadokter'] : '';
        $jampraktek = isset($data_antrean['jampraktek']) ? $data_antrean['jampraktek'] : '';
        $jeniskunjungan = isset($data_antrean['jeniskunjungan']) ? $data_antrean['jeniskunjungan'] : '';
        $nomorreferensi = isset($data_antrean['nomorreferensi']) ? $data_antrean['nomorreferensi'] : '';
        $nomorantrean = isset($data_antrean['nomorantrean']) ? $data_antrean['nomorantrean'] : '';
        $angkaantrean = isset($data_antrean['angkaantrean']) ? $data_antrean['angkaantrean'] : '';
        $estimasidilayani = isset($data_antrean['estimasidilayani']) ? $data_antrean['estimasidilayani'] : '';
        $sisakuotajkn = isset($data_antrean['sisakuotajkn']) ? $data_antrean['sisakuotajkn'] : '';
        $kuotajkn = isset($data_antrean['kuotajkn']) ? $data_antrean['kuotajkn'] : '';
        $sisakuotanonjkn = isset($data_antrean['sisakuotanonjkn']) ? $data_antrean['sisakuotanonjkn'] : '';
        $kuotanonjkn = isset($data_antrean['kuotanonjkn']) ? $data_antrean['kuotanonjkn'] : '';
        $keterangan = isset($data_antrean['keterangan']) ? $data_antrean['keterangan'] : '';

        $data_request_antrean = [
            'kodebooking' => $kodebooking,
            'jenispasien' => $jenispasien,
            'nomorkartu' => $nomorkartu,
            'nik' => $nik,
            'nohp' => $nohp,
            'kodepoli' => $kodepoli,
            'namapoli' => $namapoli,
            'pasienbaru' => $pasienbaru,
            'norm' => $norm,
            'tanggalperiksa' => $tanggalperiksa,
            'kodedokter' => $kodedokter,
            'namadokter' => $namadokter,
            'jampraktek' => $jampraktek,
            'jeniskunjungan' => $jeniskunjungan,
            'nomorreferensi' => $nomorreferensi,
            'nomorantrean' => $nomorantrean,
            'angkaantrean' => $angkaantrean,
            'estimasidilayani' => $estimasidilayani,
            'sisakuotajkn' => $sisakuotajkn,
            'kuotajkn' => $kuotajkn,
            'sisakuotanonjkn' => $sisakuotanonjkn,
            'kuotanonjkn' => $kuotanonjkn,
            'keterangan' => $keterangan,
        ];

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_antrean, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsUpdateWaktuAntrean($data_antrean)
    {
        $url = $this->antrean_url . 'antrean/updatewaktu';

        $kodebooking = isset($data_antrean['kodebooking']) ? $data_antrean['kodebooking'] : '';
        $taskid = isset($data_antrean['taskid']) ? $data_antrean['taskid'] : '';
        $waktu = isset($data_antrean['waktu']) ? $data_antrean['waktu'] : '';

        $data_request_antrean = [
            'kodebooking' => $kodebooking,
            'taskid' => $taskid,
            'waktu' => $waktu,
        ];

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_antrean, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsBatalAntrean($kodebooking, $keterangan)
    {
        $url = $this->antrean_url . 'antrean/batal';

        $data_request_antrean = [
            'kodebooking' => $kodebooking,
            'keterangan' => $keterangan,
        ];

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_antrean, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsListWaktuTaskId($data_booking)
    {
        $url = $this->antrean_url . 'antrean/getlisttask';

        $kodebooking = isset($data_booking['kodebooking']) ? $data_booking['kodebooking'] : '';

        $data_request_booking = [
            'kodebooking' => $kodebooking,
        ];

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('POST', $data_request_booking, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsDashboardPerTanggal($tanggal, $waktu)
    {
        $url = $this->antrean_url . 'dashboard/waktutunggu/tanggal/' . $tanggal . '/waktu/' . $waktu;

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }

    public function wsBpjsDashboardPerBulan($bulan, $tahun, $waktu)
    {
        $url = $this->antrean_url . 'dashboard/waktutunggu/bulan/' . $bulan . '/tahun/' . $tahun . '/waktu/' . $waktu;

        $headers = $this->setAntreanHeaders();
        $timestamp = $headers['timestamp'];

        $send_request = $this->sendRequest('GET', null, $url, $headers['headers']);
        $result = json_decode($send_request, true);

        $result_code = isset($result['metadata']['code']) ? $result['metadata']['code'] : null;
        if ($result_code == 200) {
            $response = isset($result['response']) ? $result['response'] : null;

            if ($response) {
                $arr_response = $this->getResult($response, $timestamp);

                return $arr_response;
            } else {
                return $result;
            }
        } else {
            return [
                'metadata' => [
                    'message' => isset($result['metadata']['message']) ? $result['metadata']['message'] : 'API BPJS Request gagal',
                    'code' => 201
                ]
            ];
        }
    }
}
