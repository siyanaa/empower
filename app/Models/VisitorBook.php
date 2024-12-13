<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorBook extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone_no', 'email', 'country_id', 'description'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
