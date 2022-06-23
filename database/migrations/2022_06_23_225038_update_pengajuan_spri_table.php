<?php

use App\Models\Fppri;
use App\Models\PengajuanSPRI;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePengajuanSpriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pengajuan_spri = PengajuanSPRI::get();

        if (count($pengajuan_spri) > 0) {
            foreach ($pengajuan_spri as $ps) {
                if (!$ps->regno) {
                    $fppri = Fppri::where('no_spri', $ps->no_spri)->first();

                    if ($fppri) {
                        $ps->created_at = $ps->created_at;
                        $ps->updated_at = date('Y-m-d H:i:s');
                        $ps->regno = $fppri->Regno;
                        $ps->save();
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
