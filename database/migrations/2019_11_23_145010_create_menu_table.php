<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('web_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ordering')->nullable()->default(null);
            $table->integer('parent_id')->nullable()->default(null);
            $table->string('title', 255);
            $table->string('type', 45)->nullable()->default(null);
            $table->integer('page_id')->nullable()->default(null);
            $table->integer('article_id')->nullable()->default(null);
            $table->integer('category_id')->nullable()->default(null);
            $table->string('url', 255)->nullable()->default(null);
            $table->string('target', 255)->default('_self');
            $table->string('icon', 191)->nullable()->default(null);
            $table->string('custom_class', 191)->nullable()->default(null);
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
        Schema::dropIfExists('menu');
        Schema::dropIfExists('web_menu');
    }
}
