<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpalmMaklumatTamanTable extends Migration
{
    public function up()
    {
        Schema::create('epalm_maklumat_taman', function (Blueprint $table) {
            $table->bigIncrements('id_taman');
            $table->string('nama_taman');
            $table->string('nama_pbt');
            $table->string('kategori_taman');
            $table->string('keluasan_taman')->nullable();
            $table->string('keluasan_unit')->nullable();
            $table->string('panjang_taman')->nullable();
            $table->string('panjang_unit')->nullable();
            $table->string('hakmilik_tanah_taman')->nullable();
            $table->string('status_tanah_taman')->nullable();
            $table->date('tarikhWarta_tanah_taman')->nullable()->comment('Tarikh tanah diwartakan');
            $table->string('fasiliti')->nullable()->comment('FasilitiArr');
            $table->string('alamat1_taman')->nullable();
            $table->string('alamat2_taman')->nullable();
            $table->string('alamat3_taman')->nullable();
            $table->string('poskod_taman')->nullable();
            $table->string('negeri_taman')->nullable();
            $table->string('daerah_taman')->nullable();
            $table->string('mukim_taman')->nullable();
            $table->string('parlimen_taman')->nullable();
            $table->string('dun_taman')->nullable();
            $table->string('lat', 100)->comment('Lokasi Koordinat Latitude')->nullable();
            $table->string('lng', 100)->comment('Lokasi Koordinat Longitude')->nullable();
            $table->string('waktuMula_taman')->nullable();
            $table->string('waktuTamat_taman')->nullable();
            $table->string('mediaSosial_taman')->nullable();
            $table->longText('keterangan_taman')->nullable()->comment('keterangan_taman');
            $table->string('fail_konsep')->nullable(); // For file path
            $table->date('tarikh_siapBina_taman')->nullable()->comment('Tarikh taman siap dibina');
            $table->string('gambar_taman')->nullable();
            $table->string('gambar_360')->nullable()->comment('Gambar Lengkap 360');
            $table->string('is_komponen')->nullable()->comment('Id Landskap Perbandaran');
            $table->string('id_permohonan')->nullable();
            $table->enum('status', ['draft', 'approved'])->default('draft');  // Track draft vs approved
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('epalm_maklumat_taman_draf', function (Blueprint $table) {
            $table->bigIncrements('id_taman_draf');
            $table->string('id_taman');
            $table->string('nama_taman');
            $table->string('nama_pbt');
            $table->string('kategori_taman');
            $table->string('keluasan_taman')->nullable();
            $table->string('keluasan_unit')->nullable();
            $table->string('panjang_taman')->nullable();
            $table->string('panjang_unit')->nullable();
            $table->string('hakmilik_tanah_taman')->nullable();
            $table->string('status_tanah_taman')->nullable();
            $table->date('tarikhWarta_tanah_taman')->nullable()->comment('Tarikh tanah diwartakan');
            $table->string('fasiliti')->nullable()->comment('FasilitiArr');
            $table->string('alamat1_taman')->nullable();
            $table->string('alamat2_taman')->nullable();
            $table->string('alamat3_taman')->nullable();
            $table->string('poskod_taman')->nullable();
            $table->string('negeri_taman')->nullable();
            $table->string('daerah_taman')->nullable();
            $table->string('mukim_taman')->nullable();
            $table->string('parlimen_taman')->nullable();
            $table->string('dun_taman')->nullable();
            $table->string('lat', 100)->comment('Lokasi Koordinat Latitude')->nullable();
            $table->string('lng', 100)->comment('Lokasi Koordinat Longitude')->nullable();
            $table->string('waktuMula_taman')->nullable();
            $table->string('waktuTamat_taman')->nullable();
            $table->string('mediaSosial_taman')->nullable();
            $table->longText('keterangan_taman')->nullable()->comment('keterangan_taman');
            $table->string('fail_konsep')->nullable(); // For file path
            $table->date('tarikh_siapBina_taman')->nullable()->comment('Tarikh taman siap dibina');
            $table->string('gambar_taman')->nullable();
            $table->string('gambar_360')->nullable()->comment('Gambar Lengkap 360');
            $table->string('is_komponen')->nullable()->comment('Id Landskap Perbandaran');
            $table->string('id_permohonan')->nullable();
            $table->enum('status', ['draft', 'approved'])->default('draft');  // Track draft vs approved
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('epalm_maklumat_taman');
        Schema::dropIfExists('epalm_maklumat_taman_draf');
    }
}
