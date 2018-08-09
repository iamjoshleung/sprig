<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photosets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->json('images');
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
        Schema::dropIfExists('photosets');
    }
}
