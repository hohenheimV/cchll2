<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSoftscapesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // Schema::dropIfExists('softscapes');
        // Schema::dropIfExists('softscapes_records');
        // Schema::dropIfExists('softscapes_gambar');
        // Schema::dropIfExists('softscapes_silara');
        // Schema::dropIfExists('softscapes_batang');
        // Schema::dropIfExists('softscapes_daun');
        // Schema::dropIfExists('softscapes_bunga');
        // Schema::dropIfExists('softscapes_buah');

        // Schema::dropIfExists('softscapes_selenggara_pembajaan');
        // Schema::dropIfExists('softscapes_selenggara_pemangkasan');
        // Schema::dropIfExists('softscapes_selenggara_perosak');
        // Schema::dropIfExists('softscapes_selenggara_risiko');
        // DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('softscapes', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('kod', 45)->nullable()->default(null)->comment('Kod Tag');
            $table->integer('tag')->nullable()->default(null)->comment('Kod Tag');
            $table->string('zon', 45)->nullable()->default(null)->comment('Zon');
            $table->string('nama_zon')->nullable()->default(null)->comment('Nama Zon');
            $table->string('lat',25)->nullable()->comment('Lokasi/Koordinat Lat');
            $table->string('lng',25)->nullable()->comment('Lokasi/Koordinat Lng');
            $table->string('jenis', 100)->nullable()->comment('Jenis/Kategori');
            $table->string('nama_botani', 100)->nullable()->comment('Nama Botani');
            $table->string('nama_tempatan', 100)->nullable()->comment('Nama Tempatan');
            $table->string('nama_keluarga', 100)->nullable()->comment('Nama Keluarga/Asal');
            $table->string('negara_asal', 100)->nullable()->comment('Negara Asal');
            $table->string('sumber_benih', 100)->nullable()->comment('Sumber Anak Benih');
            $table->string('taman_persekutuan', 100)->nullable()->comment('Taman Persekutuan');
            $table->longText('keterangan')->nullable()->comment('Keterangan Pokok');
            $table->date('tarikh')->nullable()->comment('Tarikh Ditanam');
            $table->year('tahun_tanam')->nullable()->comment('Tahun Ditanam');
            $table->double('kos_perolehan',5,2)->nullable()->comment('Kos Perolehan');
            $table->string('kategori_tumbuhan', 100)->nullable()->comment('Kategori Tumbuhan');
            $table->integer('umur_pokok')->nullable()->comment('Umur Pokok');
            $table->string('fungsi_pokok', 100)->nullable()->comment('Fungsi Pokok');
            $table->string('kegunaan_pokok', 100)->nullable()->comment('Kegunaan Pokok');
            $table->string('cara_pembiakan', 100)->nullable()->comment('Cara Pembiakan');
            $table->string('jenis_akar', 100)->nullable()->comment('Jenis Akar');
            $table->datetime('tarikh_masa')->nullable()->comment('Tarikh & Masa');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('softscapes_records', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->double('saiz_kenopi',5,2)->nullable()->comment('Saiz Kenopi');
            $table->string('keadaan_semasa', 100)->nullable()->comment('Keadaan Semasa/Masalah');
            $table->double('nilai_semasa',5,2)->nullable()->comment('Nilai Semasa');
            $table->string('status', 100)->nullable()->comment('Status');
            $table->string('rawatan', 100)->nullable()->comment('Rawatan');
            $table->datetime('tarikh')->nullable()->comment('Tarikh & Masa');
            $table->longText('catatan')->nullable()->comment('Catatan');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_gambar', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('keseluruhan', 100)->nullable()->comment('Gambar Keseluruhan');
            $table->string('batang', 100)->nullable()->comment('Gambar Batang');
            $table->string('daun', 100)->nullable()->comment('Gambar Daun');
            $table->string('bunga', 100)->nullable()->comment('Gambar Bunga');
            $table->string('buah', 100)->nullable()->comment('Gambar Buah');
            $table->datetime('tarikh')->nullable()->comment('Tarikh & Masa');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_silara', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('kelebaran', 100)->nullable()->comment('Kelebaran Silara');
            $table->string('bentuk', 100)->nullable()->comment('Bentuk Silara Pokok');
            $table->date('tarikh')->nullable()->comment('Tarikh');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_batang', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('bentuk', 100)->nullable()->comment('Bentuk Batang Pokok');
            $table->string('ketinggian', 100)->nullable()->comment('Ketinggian Batang Pokok');
            $table->string('diameter', 100)->nullable()->comment('Diameter Batang');
            $table->string('tekstur', 100)->nullable()->comment('Tekstur Batang');
            $table->date('tarikh')->nullable()->comment('Tarikh');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_daun', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('warna', 100)->nullable()->comment('Warna Daun');
            $table->string('bentuk', 100)->nullable()->comment('Bentuk Daun');
            $table->string('percambahan', 100)->nullable()->comment('Cara Percambahan Daun');
            $table->string('jenis', 100)->nullable()->comment('Jenis Daun');
            $table->date('tarikh')->nullable()->comment('Tarikh');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_bunga', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('warna', 100)->nullable()->comment('Warna Bunga');
            $table->string('bentuk', 100)->nullable()->comment('Bentuk Bunga');
            $table->integer('saiz')->nullable()->comment('Saiz Bunga');
            $table->integer('bilangan')->nullable()->comment('Bilangan Kelopak Bunga');
            $table->string('wangian', 100)->nullable()->comment('Wangian Bunga');
            $table->string('musim', 100)->nullable()->comment('Musim Berbunga');
            $table->integer('tempoh')->nullable()->comment('Tempoh Berbunga');
            $table->date('tarikh')->nullable()->comment('Tarikh');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_buah', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('warna', 100)->nullable()->comment('Warna Buah');
            $table->string('bentuk', 100)->nullable()->comment('Bentuk Buah');
            $table->integer('saiz')->nullable()->comment('Saiz Buah');
            $table->string('musim', 100)->nullable()->comment('Musim Buah');
            $table->integer('tempoh')->nullable()->comment('Tempoh Berbuah');
            $table->date('tarikh')->nullable()->comment('Tarikh');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_selenggara_pembajaan', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('jenis', 100)->nullable()->comment('Jenis Baja');
            $table->string('kaedah', 100)->nullable()->comment('Kaedah Baja');
            $table->date('tarikh')->nullable()->comment('Tarikh Baja');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });
        Schema::create('softscapes_selenggara_pemangkasan', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('jenis', 100)->nullable()->comment('Jenis Pemangkasan');
            $table->date('tarikh')->nullable()->comment('Tarikh Pemangkasan');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_selenggara_perosak', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('kaedah', 100)->nullable()->comment('Kaedah Rawatan Kawalan Perosak');
            $table->date('tarikh')->nullable()->comment('Tarikh Rawatan Kawalan Perosak');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });

        Schema::create('softscapes_selenggara_risiko', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('softscape_id')->unsigned();
            $table->string('jenis', 100)->nullable()->comment('Jenis Risiko');
            $table->string('tahap', 100)->nullable()->comment('Tahap Risiko');
            $table->date('tarikh')->nullable()->comment('Tarikh Risiko');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('softscape_id')->references('id')->on('softscapes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('softscapes');
        Schema::dropIfExists('softscapes_records');
        Schema::dropIfExists('softscapes_gambar');
        Schema::dropIfExists('softscapes_silara');
        Schema::dropIfExists('softscapes_batang');
        Schema::dropIfExists('softscapes_daun');
        Schema::dropIfExists('softscapes_bunga');
        Schema::dropIfExists('softscapes_buah');

        Schema::dropIfExists('softscapes_selenggara_pembajaan');
        Schema::dropIfExists('softscapes_selenggara_pemangkasan');
        Schema::dropIfExists('softscapes_selenggara_perosak');
        Schema::dropIfExists('softscapes_selenggara_risiko');


    }
}
