<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintStatus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'complaint_status';

    public function complaints(){
        return $this->hasMany(Complaints::class, 'current_status_id', 'id');
    }
}
