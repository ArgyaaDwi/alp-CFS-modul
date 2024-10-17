<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintInteraction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'complaint_interaction';
    protected $fillable = [
        'complaint_id',
        'user_id',
        'complaint_status_id',
        'notes',
        'supporting_document',
        'created_at',
        'updated_at',
    ];
    public function complaint()
    {
        return $this->belongsTo(Complaints::class, 'complaint_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function complaintStatus()
    {
        return $this->belongsTo(ComplaintStatus::class, 'complaint_status_id', 'id');
    }
}
