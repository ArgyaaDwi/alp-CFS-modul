<?php

namespace App\Http\Controllers;
use App\Models\Distributor;
use Carbon\Carbon;
use App\Models\CategoryComplaints;
use App\Models\ComplaintFile;
use App\Models\ComplaintInteraction;
use App\Models\Complaints;
use App\Models\ComplaintStatus;
use App\Models\MainDistributor;
use App\Models\Province;
use App\Models\Regency;
use App\Models\CompanyType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function viewComplaint()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaints = Complaints::with(['distributor', 'categories', 'currentStatus'])->get();
        return view('pages.role_admin.complaint.complaint', compact('user', 'distributors', 'complaints', 'currentDate'));
    }
    public function detailComplaint($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaint = Complaints::with(['distributor', 'categories'])->findOrFail($id);
        $status = ComplaintStatus::whereIn('id', [$complaint->current_status_id, 2, 3])->get();
        $history = ComplaintInteraction::where('complaint_id', $id)->get();
        return view('pages.role_admin.complaint.detail_complaint', compact('user', 'distributors', 'complaint', 'currentDate', 'status', 'history'));
    }
}
