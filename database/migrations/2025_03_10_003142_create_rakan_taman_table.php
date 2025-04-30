<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRakanTamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maklumat_rakan_taman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_num', 45)->nullable();
            $table->string('no_siri', 45)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('negeri', 255)->nullable();
            $table->string('pbt', 255)->nullable();
            $table->string('taman', 255)->nullable();
            $table->json('kawasan')->nullable();
            $table->json('fail')->nullable();
            $table->string('penduduk', 255)->nullable();
            $table->json('jawatankuasa')->nullable();
            $table->text('alamat')->nullable();
            $table->string('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('catatan_jln')->nullable();
            $table->string('peruntukan', 255)->nullable();
            $table->enum('status', ['Diperakui', 'Diluluskan'])->default('Diperakui');
            $table->enum('status_keahlian', ['Aktif', 'Tidak Aktif', 'Digugurkan'])->default('Tidak Aktif');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('maklumat_aktiviti_rakan_taman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_rakan')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('taman', 255)->nullable();
            $table->text('laporan')->nullable();
            $table->string('fail', 255)->nullable();
            $table->json('gambar')->nullable();
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
        Schema::dropIfExists('maklumat_rakan_taman');
        Schema::dropIfExists('maklumat_aktiviti_rakan_taman');
    }
}
