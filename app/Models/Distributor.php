<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;
    protected $table = 'distributors';
    protected $fillable = ['company_type_id', 'company_name', 'company_distributor_id', 'company_province_id', 'company_city_id', 'company_address', 'company_phone', 'company_email', 'company_website'];

    public function user()
    {
        return $this->hasMany(User::class,  'distributor_id', 'id');
    }

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class,  'company_type_id', 'id');
    }

    public function companyProvince()
    {
        return $this->belongsTo(Province::class,  'company_province_id', 'id');
    }

    public function companyCity()
    {
        return $this->belongsTo(Regency::class,  'company_city_id', 'id');
    }

    public function companyDistributor()
    {
        return $this->belongsTo(MainDistributor::class,  'company_distributor_id', 'id');
    }
    public function complaints()
    {
        return $this->hasMany(Complaints::class,  'distributor_id', 'id');
    }

}
