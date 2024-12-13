<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favicons', function (Blueprint $table) {
            $table->id();
            $table->string('android_chrome_oneninetwo');
            $table->string('android_chrome_fiveonetwo');
            $table->string('apple_touch_icon');
            $table->string('favicon_ico');
            $table->string('favicon_sixteen');
            $table->string('favicon_thirtyTwo');
            $table->string('site_webmanifest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favicons');
    }
};
