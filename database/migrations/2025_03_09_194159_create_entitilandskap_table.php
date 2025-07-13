<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitilandskapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entiti_maklumat_landskap', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_entiti')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('pbt')->nullable();
            $table->string('agensi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('lat', 100)->comment('Lokasi Koordinat Latitude')->nullable();
            $table->string('lng', 100)->comment('Lokasi Koordinat Longitude')->nullable();
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
        Schema::dropIfExists('entiti_maklumat_landskap');
    }
}
