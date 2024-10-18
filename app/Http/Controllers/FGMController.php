<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Models\ComplaintStatus;
use App\Models\ComplaintInteraction;
use App\Models\Complaints;
use Illuminate\Support\Facades\Auth;

class FGMController extends Controller
{
    public function viewComplaint()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaints = Complaints::with(['distributor', 'categories', 'currentStatus'])->get();
        return view('pages.role_fgm.complaint.complaint', compact('user', 'distributors', 'complaints', 'currentDate'));
    }
    public function detailComplaint($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaint = Complaints::with(['distributor', 'categories'])->findOrFail($id);
        $status = ComplaintStatus::whereIn('id', [$complaint->current_status_id, 5, 9])->get();
        $history = ComplaintInteraction::where('complaint_id', $id)->get();
        return view('pages.role_fgm.complaint.detail_complaint', compact('user', 'distributors', 'complaint', 'currentDate', 'status', 'history'));
    }
    public function updateComplaintStatus(Request $request, $complaintId)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'complaint_status_id' => 'required|exists:complaint_status,id',
            'notes' => 'nullable|string',
            'supporting_document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $complaint = Complaints::findOrFail($complaintId);
        $filePath = null;
        if ($request->hasFile('supporting_document')) {
            $filePath = $request->file('supporting_document')->store('supporting_documents', 'public');
        }
        ComplaintInteraction::create([
            'complaint_id' => $complaint->id,
            'complaint_status_id' => $validated['complaint_status_id'],
            'user_id' => $user->id,
            'notes' => $validated['notes'],
            'supporting_document' => $filePath,
            'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);
        $complaint->update([
            'current_status_id' => $validated['complaint_status_id'],
        ]);
        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui!');
    }
}
