<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaklumatPenggunaPenggiatIndustri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maklumat_pengguna_penggiat_industri', function (Blueprint $table) {
            $table->bigIncrements('id_elind');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('jenis_industri');
            $table->string('no_mof')->nullable()->unique();
            $table->string('no_ssm')->nullable();
            $table->string('bilPekerja')->nullable();
            $table->string('status_eperunding')->nullable();

            $table->string('kelas_kontraktor')->nullable();
            $table->string('no_cidb')->nullable();
            $table->string('taraf_bumiputera')->nullable();
            $table->string('bidang_kepakaran')->nullable();
            
            $table->string('no_ilam')->nullable();
            $table->string('tarikh_luput_ilam')->nullable();

            $table->string('bidang_pembekal')->nullable();
            $table->string('bidang_lain_pembekal')->nullable();
            $table->string('saiz_nurseri')->nullable();

            $table->string('nama_presiden')->nullable();
            $table->string('wakil_negara')->nullable();
            $table->string('kategori_ngo')->nullable();
            $table->string('jenis_institusi')->nullable();

            // Nullable address columns
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('postcode')->nullable();
            $table->string('locality')->nullable();
            $table->string('state')->nullable();

            $table->json('mediaSosial_penggiat')->nullable();
            $table->json('pekerja')->nullable();
            $table->json('pengalaman')->nullable();
            $table->json('produk')->nullable();

            $table->string('prestasi')->nullable();
            $table->string('komen')->nullable();
            $table->string('pentaksir')->nullable();

            $table->enum('status', ['draft', 'approved'])->default('draft');  // Track draft vs approved
            // Additional fields (optional depending on your needs)
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('maklumat_pengguna_penggiat_industri_draf', function (Blueprint $table) {
            $table->bigIncrements('id_elind_draf');
            $table->string('id_elind');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('jenis_industri');
            $table->string('no_mof')->nullable()->unique();
            $table->string('no_ssm')->nullable();
            $table->string('bilPekerja')->nullable();
            $table->string('status_eperunding')->nullable();

            $table->string('kelas_kontraktor')->nullable();
            $table->string('no_cidb')->nullable();
            $table->string('taraf_bumiputera')->nullable();
            $table->string('bidang_kepakaran')->nullable();
            
            $table->string('no_ilam')->nullable();
            $table->string('tarikh_luput_ilam')->nullable();

            $table->string('bidang_pembekal')->nullable();
            $table->string('bidang_lain_pembekal')->nullable();
            $table->string('saiz_nurseri')->nullable();

            $table->string('nama_presiden')->nullable();
            $table->string('wakil_negara')->nullable();
            $table->string('kategori_ngo')->nullable();
            $table->string('jenis_institusi')->nullable();

            // Nullable address columns
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('postcode')->nullable();
            $table->string('locality')->nullable();
            $table->string('state')->nullable();

            $table->json('mediaSosial_penggiat')->nullable();
            $table->json('pekerja')->nullable();
            $table->json('pengalaman')->nullable();
            $table->json('produk')->nullable();

            $table->string('prestasi')->nullable();
            $table->string('komen')->nullable();
            $table->string('pentaksir')->nullable();

            $table->enum('status', ['draft', 'approved'])->default('draft');  // Track draft vs approved
            // Additional fields (optional depending on your needs)
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
        Schema::dropIfExists('maklumat_pengguna_penggiat_industri');
        Schema::dropIfExists('maklumat_pengguna_penggiat_industri_draf');
    }
}
