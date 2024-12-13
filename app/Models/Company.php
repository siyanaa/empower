<?php

namespace App\Models;

use App\Models\Country;
use App\Models\StudentDetail;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = ['logo', 'title', 'slug', 'country_id', 'phone_no', 'email', 'website'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function studentDetails()
    {
        return $this->hasMany(StudentDetail::class, 'country_id');
    }
}
