<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'subtitle' => 'Bring your dream into Reality',
            'image' => '1708111815-Lunar Oversea - Landscape.png',
            'description' => 'Emperor Solution is a pioneer organization in overseas employment. The organization is recognized by various overseas companies and a large number of workers who have been successfully placed in different companies all over the globe.',
            'content' => 'Emperor Solution  provides extensive workforce solutions for international human resource needs. With over twenty years of experience, we boast a knowledgeable team to support all overseas staffing requirements. Our services have evolved to meet the changing demands of the global market, catering to clients across various countries such as the UAE, KSA, Kuwait, Qatar, Bahrain, Egypt, India, Nepal, and Bangladesh.

            Emperor Solution  is committed to fostering long-term partnerships built on trust, transparency, and professionalism. We believe in empowering individuals to unlock their full potential while enabling businesses to thrive by acquiring the best talent available.
            
             ',


        ]);
        // About::factory()->count(1)->create();
    }
}
