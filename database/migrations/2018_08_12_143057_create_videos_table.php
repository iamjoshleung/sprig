<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('video_url');
            $table->string('thumbnail_url');
            $table->string('thumbnail_width');
            $table->string('thumbnail_height');
            $table->string('duration');
            $table->unsignedInteger('site_id');
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('tumblr_sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
