<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    use HasFactory;
    protected $table = 'complaints';
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'distributor_id', 'batch_number', 'main_distributor_id', 'complaint_category_id', 'complaint_title', 'complaint_description', 'complaint_hopeful_solution', 'supporting_document', 'created_at', 'updated_at'];
    public function categories()
    {
        return $this->belongsToMany(CategoryComplaints::class, 'pivot_category_complaint', 'complaint_id', 'category_complaint_id');
    }
    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function files(){
        return $this->hasMany(ComplaintFile::class, 'complaint_id', 'id');
    }
}
