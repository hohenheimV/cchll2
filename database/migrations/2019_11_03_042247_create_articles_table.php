<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['posts', 'pages', 'faqs']);
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('content');
            $table->string('page_image')->nullable();
            $table->string('meta_description')->nullable();
            $table->enum('is_status', ['publish', 'pending', 'draft'])->default('draft');
            $table->boolean('is_features')->default(0);
            $table->integer('view_count')->unsigned()->default(0)->index();
            $table->string('layout')->default('right');
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('articles');
        Schema::dropIfExists('web_articles');
    }
}
