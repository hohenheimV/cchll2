<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardscapesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardscapes', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            //$table->string('kod_tag', 100)->nullable()->comment('Kod Tag');
            $table->string('kod', 45)->nullable()->default('K');
            $table->integer('tag')->nullable()->default(null)->comment('Kod Tag');
            $table->string('zon', 45)->nullable()->default('K')->comment('Zon');
            $table->string('nama_zon')->nullable()->default(null)->comment('Nama Zon');
            // $table->string('no_rujukan', 100)->nullable()->comment('Nombor Rujukan');
            $table->string('lat', 100)->comment('Lokasi Koordinat Latitude');
            $table->string('lng', 100)->comment('Lokasi Koordinat Longitude');
            $table->string('jenis_komponen', 200)->nullable()->comment('Jenis Komponent / Struktur');
            $table->string('nama_struktur', 200)->nullable()->comment('Nama Komponent / Struktur');
            $table->string('gambar_lengkap', 200)->nullable()->comment('Gambar Lengkap');
            $table->smallInteger('tahun_gambar')->nullable()->default(null);
            $table->string('keadaan_semasa', 255)->nullable()->comment('Keadaan Semasa/Masalah');
            $table->datetime('tarikh')->nullable()->comment('Tarikh dan Masa');
            $table->year('tahun_bina')->nullable()->comment('Tahun Dibina');
            $table->double('kos_pembinaan', 10, 2)->nullable()->comment('Kos Pembinaan');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('hardscapes_records', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('hardscape_id')->unsigned();
            $table->datetime('tarikh')->nullable()->comment('Tarikh dan Masa');
            $table->string('gambar_baikpulih_satu', 200)->nullable()->comment('Gambar Baik Pulih');
            $table->string('gambar_baikpulih_dua', 200)->nullable()->comment('Gambar Baik Pulih');
            $table->string('gambar_baikpulih_tiga', 200)->nullable()->comment('Gambar Baik Pulih');
            $table->string('catatan_baikpulih', 200)->nullable()->comment('Baik Pulih');
            $table->double('kos_baikpulih', 10, 2)->nullable()->comment('Kos Baik Pulih');
            $table->string('catatan_selenggara', 200)->nullable()->comment('Selenggara');
            $table->double('kos_selenggara', 10, 2)->nullable()->comment('Kos Baik Pulih');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hardscape_id')->references('id')->on('hardscapes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hardscapes');
        Schema::dropIfExists('hardscapes_records');
    }
}
