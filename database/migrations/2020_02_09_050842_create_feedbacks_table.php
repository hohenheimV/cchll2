<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_feedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_num', 45)->nullable();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 20)->nullable();
            $table->text('message')->nullable();
            $table->dateTime('feedback_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('officer', 255)->nullable();
            $table->string('form_attachment',255)->nullable();
            $table->dateTime('response_at')->nullable();
            $table->string('status', 255)->nullable()->default('Baru');
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
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('web_feedbacks');
    }
}
