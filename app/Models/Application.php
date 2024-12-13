<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'demand_id',
        'name',
        'email',
        'phone_no',
        'address',
        
    ];

        public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
}