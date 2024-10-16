<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'transactions';
    public function detailTransaction(){
        return $this->hasMany(DetailTransaction::class, 'transaction_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function city(){
        return $this->belongsTo(Regency::class, 'city_id', 'id');
    }
}
