<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryComplaints extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'category_complaints';

    public function complaints()
    {
        return $this->belongsToMany(Complaints::class, 'pivot_category_complaint', 'category_complaint_id', 'complaint_id');
    }
}
