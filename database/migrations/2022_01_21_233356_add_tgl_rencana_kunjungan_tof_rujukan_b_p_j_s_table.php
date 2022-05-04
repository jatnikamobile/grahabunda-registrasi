<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTglRencanaKunjunganTofRujukanBPJSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fRujukanBPJS', function(Blueprint $table) {
            $table->string('tglRencanaKunjungan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fRujukanBPJS', function(Blueprint $table) {
            $table->dropColumn('tglRencanaKunjungan');
        });
    }
}
