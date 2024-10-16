<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    use HasFactory;
    protected $table = 'company_types';

    protected $fillable = [
        'type_name',
        'type_description'
    ];
    public function distributor()
    {
        return $this->hasMany(Distributor::class, 'company_type_id', 'id');
    }
}
