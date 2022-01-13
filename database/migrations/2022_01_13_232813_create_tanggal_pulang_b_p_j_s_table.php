<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTanggalPulangBPJSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggal_pulang_bpjs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_sep');
            $table->integer('status_pulang')->comment('1:Atas Persetujuan Dokter, 3:Atas Permintaan Sendiri, 4:Meninggal, 5:Lain-lain');
            $table->string('no_surat_meninggal')->nullable();
            $table->date('tanggal_meninggal')->nullable();
            $table->date('tanggal_pulang');
            $table->date('no_lp_manual')->nullable();
            $table->date('user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanggal_pulang_bpjs');
    }
}
