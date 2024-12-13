<?php

namespace App\Models;

use App\Models\WorkCategory;
use App\Models\Country;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentDetail extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone_no', 'email', 'country_id', 'company_id', 'work_category_id', 'intake_month_year', 'image', 'documents'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function work_category()
    {
        return $this->belongsTo(WorkCategory::class, 'work_category_id');
    }
}
