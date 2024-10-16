<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';
    use HasFactory;
    public function regencies(){
        return $this->hasMany(Regency::class);
    }

    public function distributor(){
        return $this->hasMany(Distributor::class, 'company_province_id', 'id');
    }
}
