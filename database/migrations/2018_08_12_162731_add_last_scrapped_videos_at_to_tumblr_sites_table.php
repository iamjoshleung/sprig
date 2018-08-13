<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastScrappedVideosAtToTumblrSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tumblr_sites', function (Blueprint $table) {
            $table->timestamp('last_scrapped_videos_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tumblr_sites', function (Blueprint $table) {
            $table->dropColumn('last_scrapped_videos_at');
        });
    }
}
