<?php

use App\Models\RsNet\TmAgama;
use App\Models\TBLAgama;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateDataAgama extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rsnet_agama = TmAgama::orderBy('I_Agama')->get();
        if (count($rsnet_agama) > 0) {
            DB::unprepared('truncate table TBLAgama');
            foreach ($rsnet_agama as $agama) {
                $simrs_agama = new TBLAgama();
                $simrs_agama->KdAgama = $agama->I_Agama;
                $simrs_agama->NmAgama = $agama->N_Agama;
                $simrs_agama->save();
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
