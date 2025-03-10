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
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('negeri', 255)->nullable();
            $table->string('pbt', 255)->nullable();
            $table->string('taman', 255)->nullable();
            $table->json('kawasan')->nullable();
            $table->json('fail')->nullable();
            $table->string('penduduk', 255)->nullable();
            $table->json('jawatankuasa')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->dateTime('registered_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('officer', 255)->nullable();
            $table->string('form_attachment',255)->nullable();
            $table->string('responsed_by')->nullable();
            $table->dateTime('responsed_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('status', 255)->nullable()->default('Baru');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('maklumat_aktiviti_rakan_taman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_rakan')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('taman', 255)->nullable();
            $table->text('laporan')->nullable();
            $table->json('fail')->nullable();
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
