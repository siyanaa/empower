<?php

namespace Database\Seeders;

use App\Models\Favicon;
use Illuminate\Database\Seeder;

class FavIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Favicon::create([
            'android_chrome_oneninetwo' => 'android-chrome-192x192.png',
            'android_chrome_fiveonetwo' => 'android-chrome-512x512.png',
            'favicon_thirtyTwo' => 'favicon-32x32.png',
            'favicon_sixteen' => 'favicon-16x16.png',
            'favicon_ico' => 'favicon.ico',
            'apple_touch_icon' => 'apple-touch-icon.png',
            'site_webmanifest' => 'site.webmanifest',

        ]);
    }
}