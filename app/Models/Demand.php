<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Demand extends Model
{
    use HasFactory;

    protected $fillable = ['country_id', 'from_date', 'to_date','vacancy', 'content', 'number_of_people_required', 'image'];

    // Define relationship with Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('to_date', '>=', now()->toDateString());
    }
}
