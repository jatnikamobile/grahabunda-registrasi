<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengajuanSPRITable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_spri', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_kartu');
            $table->string('nama')->nullable();
            $table->string('kelamin')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('kode_dokter');
            $table->string('nama_dokter')->nullable();
            $table->string('poli_kontrol');
            $table->string('tanggal_rencana_kontrol');
            $table->string('no_spri')->nullable();
            $table->string('nama_diagnosa')->nullable();
            $table->string('user')->nullable();
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
        Schema::dropIfExists('pengajuan_spri');
    }
}
