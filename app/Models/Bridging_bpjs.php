<?php

namespace App\Models;

class Bridging_bpjs
{
	public static function get_propinsi()
	{
		$url = config('vclaim.url').'referensi/propinsi';
		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function get_kabupaten($kode_propinsi)
	{
		$url = config('vclaim.url').'referensi/kabupaten/propinsi/'.$kode_propinsi;
		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function get_kecamatan($kode_kabupaten)
	{
		$url = config('vclaim.url').'referensi/kecamatan/kabupaten/'.$kode_kabupaten;
		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function get_ppk($faskes, $nama = '')
	{
		$url = config('vclaim.url').'referensi/faskes/'.urlencode($nama).'/'.urlencode($faskes);

		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function get_poli($term)
	{
		$url = config('vclaim.url').'referensi/poli/'.urlencode($term);
		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function get_diagnosa($term)
	{
		$url = config('vclaim.url').'referensi/diagnosa/'.urlencode($term);
		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function get_spesialistik()
	{
		$url = config('vclaim.url').'referensi/spesialistik';
		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function get_peserta_kartu_bpjs($nopeserta) {
		$date = date('Y-m-d');
		$url = config('vclaim.url').'Peserta/nokartu/'.$nopeserta.'/tglSEP/'.$date;
		
		$result = json_decode(self::send_curl($url));
		
		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function get_peserta_nik($nik) {
		$date = date('Y-m-d');
		$url = config('vclaim.url').'Peserta/nik/'.$nik.'/tglSEP/'.$date;
		
		$result = json_decode(self::send_curl($url));
		// echo "<pre>";print_r($result);die();
		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	// Rujukan Pasien by:
	public function get_perserta_rujukan_Pcare($noRujukan) {
		$url = config('vclaim.url').'Rujukan/'.$noRujukan;

		$result = json_decode(self::send_curl($url));
		

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function get_perserta_rujukan_RS($noRujukan) {
		$url = config('vclaim.url').'Rujukan/RS/'.$noRujukan;

		$result = json_decode(self::send_curl($url));
		
		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function get_peserta_rujukan_noKartu_pCare($noKartu) {

		$url = config('vclaim.url').'Rujukan/Peserta/'.$noKartu;

		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function get_peserta_rujukan_noKartu_rs($noKartu) {
		
		$url = config('vclaim.url').'Rujukan/RS/Peserta/'.$noKartu;

		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function update_tanggal_pulang($data)
	{
		$url = config('vclaim.url').'Sep/updtglplg';

		$data = json_encode($data);
		$result = json_decode(self::send_curl($url, TRUE, $data));

		return $result;

		// return ($metadata->code == 200) ? $response : FALSE;
	}

	public function get_kelas() {
		$url = config('vclaim.url').'referensi/kelasrawat';

		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function dokter($term)
	{
		$url = config('vclaim.url').'referensi/dokter/'.$term;

		$result = json_decode(self::send_curl($url));

		if(empty($result))
		{
			return FALSE;
		}

		$metadata = @$result->metaData;
		$response = @$result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public function dokter_dpjp($pelayanan, $spesialis, $tglPelayanan = null) {

		$tglPelayanan = $tglPelayanan ?: date('Y-m-d');
		$url = config('vclaim.url').'referensi/dokter/pelayanan/'.$pelayanan.'/tglPelayanan/'.$tglPelayanan.'/Spesialis/'.$spesialis;

		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function ppk($faskes, $nama = '') {
		$url = config('vclaim.url').'referensi/faskes/'.urlencode($nama).'/'.urlencode($faskes);

		$result = json_decode(self::send_curl($url));

		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	// SEP
	public static function post_sep($data) {

		$url = config('vclaim.url').'SEP/1.1/insert';

		$data = json_encode($data);
		$result = json_decode(self::send_curl($url, TRUE, $data));
		if ($result->response == null) {
			$response = $result->response;
			$metadata = $result->metaData;
			return $result;
		}else {
			$metadata = $result->metaData;
			$response = $result->response;
		}

		return $result;

		// return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function update_sep($data) {

		$url = config('vclaim.url').'SEP/1.1/Update';
		$data = json_encode($data);
		$result = json_decode(self::send_curl($url, TRUE, $data));
		return $result;

		// return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function get_sep($noSep) {
		
		$url = config('vclaim.url').'SEP/'.urlencode($noSep);
		$result = json_decode(self::send_curl($url));
		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function delete_sep($data) {

		$url = config('vclaim.url').'SEP/Delete';

		$data = json_encode($data);
		$result = json_decode(self::send_curl($url, TRUE, $data, 'DELETE'));

		return $result;
		// if ($result->response == null) {
		// 	$metadata = $result->metaData;
		// 	return $metadata;
		// }else {
		// 	$metadata = $result->metaData;
		// 	$response = $result->response;
		// }

		// return ($metadata->code == 200) ? $response : FALSE;
	}

	public static function get_histori_peserta($no_kartu, $tgl_awal, $tgl_akhir)
	{
		$url = config('vclaim.url').'monitoring/HistoriPelayanan/NoKartu/'.urlencode($no_kartu).'/tglMulai/'.urlencode($tgl_awal).'/tglAkhir/'.urlencode($tgl_akhir);

		$result = json_decode(self::send_curl($url));
		
		$metadata = $result->metaData;
		$response = $result->response;

		return ($metadata->code == 200) ? $response : FALSE;
	}

	private static function create_curl_header()
	{
		$cons_id = config('vclaim.cons_id');
		$secret_key = config('vclaim.secret_key');

		date_default_timezone_set('UTC');
		$timestamp = time();
		$encodedSignature = base64_encode(hash_hmac('sha256', $cons_id.'&'.$timestamp, $secret_key, TRUE));

		$headers = [
			'X-cons-id: '.$cons_id,
			'X-timestamp: '.$timestamp,
			'X-signature: '.$encodedSignature,
		];

		return $headers;
	}

	private static function send_curl($url, $isPost = FALSE, $data = NULL, $method = 'POST') {

		$headers = self::create_curl_header();
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		if($isPost)
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$headers[] =  'Content-Type: Application/x-www-form-urlencoded';
		}
		else
		{
			$headers[] =  'Content-Type: application/json; charset=UTF-8';
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}
}
