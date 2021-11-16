<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class SuratKontrolInap extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'AwSuratKontrolInap';
        // Table Primary Key
        $this->primaryKey = 'NoSurat';
        // Type of Primary Key Table
        $this->keyType = 'integer';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function get_list($medrec = '',$nama = '')
    {
        $tgl=date('Y-m-d');
        $data = $this->select(DB::connection('main')->raw("POLItpp.NMPoli, AwSuratKontrolInap.NoSurat, Regno, Medrec, Firstname, '-' as Norujukan, CreateAt as TanggalRujukan, AwSuratKontrolInap.TglKePoli as TanggalSurat"))
                     ->leftJoin("POLItpp", "POLItpp.KDPoli", "=", "AwSuratKontrolInap.KdPoli");
        if($medrec != ''){ $data->where("AwSuratKontrolInap.Medrec", "like", "%".$medrec."%"); }
        if($nama != ''){ $data->where("AwSuratKontrolInap.Firstname", "like", "%".$nama."%"); }
        if ($medrec = '' && $nama == '') {
            $data->where("AwSuratKontrolInap.TglKePoli",$tgl);
        }
        $data = $data->orderBy("NoSurat","DESC")->orderBy("CreateAt","DESC")->paginate(5);

        // dd($data);
        return $data;
    }


    public function update_umum(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'Bod' => $data->Bod,
                'UmurThn' => $data->UmurThn,
                'UmurBln' => $data->UmurBln,
                'UmurHr' => $data->UmurHari,
                'AskesNo' => $data->NoPeserta,
                'Kategori' => $data->Kategori,
                'NmUnit' => $data->NamaUnit,
                'GroupUnit' => $data->GroupUnit
            ]);
        return $data;
    }

    public function update_umum_mutasi(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'AskesNo' => $data->NoPeserta,
                'Kategori' => $data->Kategori
            ]);
        return $data;
    }

    public function update_bpjs(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'Bod' => $data->Bod,
                'AskesNo' => $data->noKartu,
                'NoIden' => $data->NoIden,
                'UmurThn' => $data->UmurThn,
                'UmurBln' => $data->UmurBln,
                'UmurHr' => $data->UmurHari,
                'Kategori' => $data->KategoriPasien,
                'Phone' => $data->Notelp,
                'Keyakinan' => $data->Keyakinan
            ]);
        return $data;
    }
	
	public function update_bpjs_reg(array $data)
    {
        $data = (object) $data;
        DB::connection('main')->table('MasterPS')->where('Medrec', $data->Medrec)
            ->update([
                'Bod' => $data->Bod,
                'AskesNo' => $data->noKartu,
                'NoIden' => $data->NoIden,
                'UmurThn' => $data->UmurThn,
                'UmurBln' => $data->UmurBln,
                'UmurHr' => $data->UmurHari,
                'Phone' => $data->Notelp,
                'Keyakinan' => $data->Keyakinan
            ]);
        return $data;
    }

    public function khusus_validuser($nama)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $data = DB::connection('main')->table('MasterPS')->where('Firstname', 'like', '%'.$nama.'%')->orderBy('TglDaftar', 'desc')->first();
        $val = $data->Medrec;
        $update = DB::connection('main')->table('MasterPS')->where('Medrec', $val)->update(['ValidUser' => $validuser]);
        return $data;
    }
}
