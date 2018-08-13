<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameLastScrappedAtToLastScrappedImagesAtToTumblrSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tumblr_sites', function (Blueprint $table) {
            $table->renameColumn('last_scrapped_at', 'last_scrapped_images_at');
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
            $table->renameColumn('last_scrapped_images_at', 'last_scrapped_at');
        });
    }
}
