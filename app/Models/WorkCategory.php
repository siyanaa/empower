<?php

namespace App\Models;

use App\Models\StudentDetail;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkCategory extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = ['title', 'slug', 'description', 'image'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function studentDetails()
    {
        return $this->hasMany(StudentDetail::class, 'country_id');
    }
}
