<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRegionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('TBLPropinsi', function(Blueprint $table) {
            $table->string('KdPropinsi', 2)->change();
            $table->string('NmPropinsi')->change();
        });

        Schema::table('TBLKabupaten', function(Blueprint $table) {
            $table->string('KdKabupaten', 4)->change();
            $table->string('KdPropinsi', 2)->change();
            $table->string('NmKabupaten')->change();
        });

        Schema::table('TBLKecamatan', function(Blueprint $table) {
            $table->string('KdKecamatan', 7)->change();
            $table->string('KdKabupaten', 4)->change();
            $table->string('NmKecamatan')->change();
        });

        Schema::table('TBLKelurahan', function(Blueprint $table) {
            $table->string('KdKelurahan', 11)->change();
            $table->string('KdKecamatan', 7)->change();
            $table->string('NmKelurahan')->change();
        });
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
