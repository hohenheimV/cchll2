<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanoramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_panorama', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('lat', 100)->comment('Lokasi Koordinat Latitude');
            $table->string('lng', 100)->comment('Lokasi Koordinat Longitude');
            $table->string('tajuk', 200)->nullable()->comment('Gambar Lengkap 360');
            $table->longText('keterangan')->nullable()->comment('Catatan');
            $table->string('gambar_360', 100)->nullable()->comment('Gambar Lengkap 360');
            $table->date('tarikh')->nullable()->comment('Tarikh gambar di ambil');

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
        Schema::dropIfExists('panorama');
        Schema::dropIfExists('web_panorama');
    }
}
