<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainDistributor extends Model
{
    use HasFactory;
    protected $table = 'main_distributors';
    public function distributors(){
        return $this->hasMany(Distributor::class, 'company_distributor_id', 'id');
    }
    public function complaint(){
        return $this->hasMany(Complaints::class, 'main_distributor_id', 'id');
    }
}
