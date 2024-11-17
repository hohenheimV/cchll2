<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slider_image');
            $table->string('title')->nullable();
            $table->string('subtitle',255)->nullable();
            $table->string('url')->nullable();
            $table->string('target')->default('_self');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('web_sliders');
    }
}
