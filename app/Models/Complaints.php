<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Complaints extends Model
{
    use HasFactory;
    protected $table = 'complaints';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'distributor_id',
        'batch_number',
        'main_distributor_id',
        'complaint_ticket',
        'complaint_category_id',
        'complaint_title',
        'complaint_description',
        'complaint_hopeful_solution',
        'supporting_document',
        'supporting_url',
        'current_status_id',
        'created_at',
        'updated_at'
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($complaint) {
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $latestComplaint = self::whereMonth('created_at', '=', Carbon::now()->month)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->orderBy('created_at', 'desc')
                ->first();

            $sequence = 1;
            if ($latestComplaint) {
                $ticketParts = explode('/', $latestComplaint->complaint_ticket);
                $sequence = (int)$ticketParts[1] + 1;
            }
            $complaint->complaint_ticket = 'CFS/' . $sequence . '/' . $month . '/ALP/' . $year;
        });
    }

    public function categories()
    {
        return $this->belongsToMany(
            CategoryComplaints::class,
            'pivot_category_complaint',
            'complaint_id',
            'category_complaint_id'
        )->withPivot('other_category_name');
    }
    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function files()
    {
        return $this->hasMany(ComplaintFile::class, 'complaint_id', 'id');
    }
    public function currentStatus()
    {
        return $this->belongsTo(ComplaintStatus::class, 'current_status_id', 'id');
    }
    public function complaintInteraction()
    {
        return $this->hasMany(ComplaintInteraction::class, 'complaint_id', 'id');
    }
    public function mainDistributor()
    {
        return $this->belongsTo(MainDistributor::class, 'main_distributor_id', 'id');
    }
    public function pivot()
    {
        return $this->belongsToMany(CategoryComplaints::class, 'pivot_category_complaint', 'complaint_id', 'category_complaint_id');
    }
}
