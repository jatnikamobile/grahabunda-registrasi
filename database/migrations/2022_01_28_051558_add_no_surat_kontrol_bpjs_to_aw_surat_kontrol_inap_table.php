<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoSuratKontrolBpjsToAwSuratKontrolInapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('AwSuratKontrolInap', function(Blueprint $table) {
            $table->string('no_surat_kontrol_bpjs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('AwSuratKontrolInap', function(Blueprint $table) {
            $table->dropColumn('no_surat_kontrol_bpjs');
        });
    }
}
