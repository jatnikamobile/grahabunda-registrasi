<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmPasien extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPASIEN';
    protected $primaryKey = 'I_RekamMedis';
    public $incrementing = false;
    public $timestamps = false;

    public function generateCode()
    {
        $temp_rm_number = TempRmNumber::on('sqlsrv_kepri')->first();

        if (!$temp_rm_number) {
            $last_record = $this->on('sqlsrv_kepri')->orderBy('I_RekamMedis', 'desc')->first();

            $next_id = '00-00-00';
            if ($last_record) {
                $I_RekamMedis = $last_record->I_RekamMedis;
                $arr_i_rekammedis = explode('-', $I_RekamMedis);
                if ($arr_i_rekammedis[2] < 99) {
                    $third_number = $arr_i_rekammedis[2] + 1;
                    $next_id = $arr_i_rekammedis[0] . '-' . $arr_i_rekammedis[1] . '-' . sprintf('%02d', $third_number);
                } else {
                    $third_number = '00';
                    if ($arr_i_rekammedis[1] < 99) {
                        $second_number = $arr_i_rekammedis[1] + 1;
                        $next_id = $arr_i_rekammedis[0] . '-' . sprintf('%02d', $second_number) . '-' . sprintf('%02d', $third_number);
                    } else {
                        $second_number = '00';
                        $first_number = $arr_i_rekammedis[0] + 1;
                        $next_id = sprintf('%02d', $first_number) . '-' . sprintf('%02d', $second_number) . '-' . sprintf('%02d', $third_number);
                    }
                }
            }

            $temp_rm_number = new TempRmNumber();
            $temp_rm_number->setConnection('sqlsrv_kepri');
            $temp_rm_number->medrec = $next_id;
            $temp_rm_number->save();
        } else {
            $I_RekamMedis = $temp_rm_number->medrec;
            $arr_i_rekammedis = explode('-', $I_RekamMedis);
            if ($arr_i_rekammedis[2] < 99) {
                $third_number = $arr_i_rekammedis[2] + 1;
                $next_id = $arr_i_rekammedis[0] . '-' . $arr_i_rekammedis[1] . '-' . sprintf('%02d', $third_number);
            } else {
                $third_number = '00';
                if ($arr_i_rekammedis[1] < 99) {
                    $second_number = $arr_i_rekammedis[1] + 1;
                    $next_id = $arr_i_rekammedis[0] . '-' . sprintf('%02d', $second_number) . '-' . sprintf('%02d', $third_number);
                } else {
                    $second_number = '00';
                    $first_number = $arr_i_rekammedis[0] + 1;
                    $next_id = sprintf('%02d', $first_number) . '-' . sprintf('%02d', $second_number) . '-' . sprintf('%02d', $third_number);
                }
            }

            $temp_rm_number->medrec = $next_id;
            $temp_rm_number->save();
        }

        return $next_id;
    }

    public function golongan_darah()
    {
        return $this->belongsTo('App\Models\RsNet\TmGolonganDarah', 'I_GolDarah', 'I_GolonganDarah');
    }

    public function agama()
    {
        return $this->belongsTo('App\Models\RsNet\TmAgama', 'I_Agama', 'I_Agama');
    }

    public function pendidikan()
    {
        return $this->belongsTo('App\Models\RsNet\TmPendidikan', 'I_Pendidikan', 'I_Pendidikan');
    }

    public function pasien_kontraktor()
    {
        return $this->belongsTo('App\Models\RsNet\TmPasienKontraktor', 'I_RekamMedis', 'I_RekamMedis');
    }

    public function pasien_keluarga()
    {
        return $this->belongsTo('App\Models\RsNet\TmPasienHubKeluarga', 'I_RekamMedis', 'I_RekamMedis');
    }
}
