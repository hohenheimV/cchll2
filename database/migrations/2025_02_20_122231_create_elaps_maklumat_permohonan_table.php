<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElapsMaklumatPermohonanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elaps_maklumat_permohonan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_pemohon');
            
            // Common columns
            $table->string('projectTitle');
            $table->string('referenceNumber');
            $table->decimal('anggaranKos', 15, 2)->nullable();
            $table->string('category')->nullable();
            $table->json('rancangan_pembangunan')->nullable();
            $table->decimal('keluasan', 15, 2)->nullable();
            $table->string('unit_keluasan')->nullable();
            $table->decimal('panjang', 15, 2)->nullable();
            $table->string('unit_panjang')->nullable();
            $table->string('hakmilik_tanah')->nullable();
            $table->json('status_tanah')->nullable();
            $table->string('no_lot')->nullable();
            $table->string('negeri')->nullable();
            $table->string('daerah')->nullable();
            $table->string('mukim')->nullable();
            $table->string('parlimen')->nullable();
            $table->string('dun')->nullable();
            $table->text('aktiviti_semasa')->nullable();
            $table->integer('jumlah_penduduk')->nullable();
            $table->string('kemudahsampaian')->nullable();
            $table->string('guna_tanah')->nullable();
            $table->json('pelan_ukur')->nullable();
            $table->json('masalah')->nullable();
            $table->string('bahagian_jln')->nullable();
            $table->text('ulasan_lawatan')->nullable();
            $table->text('status_permohonan')->nullable();
            
            // File path column for storing file paths
            $table->string('file_path')->nullable();
            
            // Common table columns
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elaps_maklumat_permohonan');
    }
}
