<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_num', 45)->nullable();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->string('fax', 20);
            $table->string('organizer', 255);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('form_attachment',255)->nullable();
            $table->dateTime('apply_at')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('approved_attachment', 255)->nullable();
            $table->string('officer', 255)->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 255)->nullable()->default('Permohonan Baru');
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
        Schema::dropIfExists('activities');
        Schema::dropIfExists('web_activities');
    }
}
