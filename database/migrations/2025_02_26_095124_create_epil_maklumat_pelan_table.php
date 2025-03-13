<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpilMaklumatPelanTable extends Migration
{
    public function up()
    {
        Schema::create('epil_maklumat_pelan', function (Blueprint $table) {
            $table->bigIncrements('id_pelan');
            $table->string('nama_pelan');
            $table->string('nama_pbt');
            $table->string('alamat1_pelan')->nullable();
            $table->string('alamat2_pelan')->nullable();
            $table->string('alamat3_pelan')->nullable();
            $table->string('poskod_pelan')->nullable();
            $table->string('negeri_pelan')->nullable();
            $table->string('daerah_pelan')->nullable();
            $table->string('mukim_pelan')->nullable();
            $table->string('parlimen_pelan')->nullable();
            $table->string('dun_pelan')->nullable();
            $table->string('mediaSosial_pelan')->nullable();
            $table->string('gambar_dokumen_pelan')->nullable();
            $table->string('id_permohonan')->nullable();
            $table->enum('status', ['draft', 'approved'])->default('draft');  // Track draft vs approved
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('epil_maklumat_pelan_draf', function (Blueprint $table) {
            $table->bigIncrements('id_pelan_draf');
            $table->string('id_pelan');
            $table->string('nama_pelan');
            $table->string('nama_pbt');
            $table->string('alamat1_pelan')->nullable();
            $table->string('alamat2_pelan')->nullable();
            $table->string('alamat3_pelan')->nullable();
            $table->string('poskod_pelan')->nullable();
            $table->string('negeri_pelan')->nullable();
            $table->string('daerah_pelan')->nullable();
            $table->string('mukim_pelan')->nullable();
            $table->string('parlimen_pelan')->nullable();
            $table->string('dun_pelan')->nullable();
            $table->string('mediaSosial_pelan')->nullable();
            $table->string('gambar_dokumen_pelan')->nullable();
            $table->string('id_permohonan')->nullable();
            $table->enum('status', ['draft', 'approved'])->default('draft');  // Track draft vs approved
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('epil_dokumen_pelan', function (Blueprint $table) {
            $table->bigIncrements('id_dokumen_pelan');
            $table->string('nama_fail');
            $table->string('keterangan_dokumen_pelan');
            $table->string('nama_dokumen_pelan')->nullable();
            $table->string('gambar_dokumen_pelan')->nullable();
            $table->string('id_pelan')->nullable();
            $table->enum('status', ['inactive', 'active'])->default('inactive');  // Track draft vs approved
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('epil_maklumat_pelan');
        Schema::dropIfExists('epil_maklumat_pelan_draf');
        Schema::dropIfExists('epil_dokumen_pelan');
    }
}
