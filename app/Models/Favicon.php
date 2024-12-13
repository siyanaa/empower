<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favicon extends Model
{
    use HasFactory;
    protected $fillable = [
        'android_chrome_oneninetwo',
        'android_chrome_fiveonetwo',
        'apple_touch_icon',
        'favicon_ico',
        'favicon_sixteen',
        'favicon_thirtyTwo',
        'site_webmanifest'
    ];
}
