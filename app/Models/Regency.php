<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'city';
    use HasFactory;
    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function distributor(){
        return $this->hasMany(Distributor::class, 'company_city_id', 'id');
    }
    public function transaction(){
        return $this->hasMany(Transaction::class, 'city_id', 'id');
    }
}
