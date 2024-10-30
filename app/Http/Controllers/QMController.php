<?php

namespace App\Http\Controllers;

use App\Models\ComplaintInteraction;
use App\Models\Complaints;
use App\Models\Distributor;
use App\Models\ComplaintStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QMController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_qm.profile.profile', compact('user', 'currentDate'));
    }
    public function editProfile()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_qm.profile.edit_profile', compact('user', 'currentDate'));
    }
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telephone' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'no_telephone.required' => 'No. Telepon tidak boleh kosong.',
            'address.required' => 'Alamat tidak boleh kosong.',
            'name.max' => 'Nama tidak boleh melebihi 255 karakter.',
        ]);
        $user->update([
            'name' => $request->name,
            'no_telephone' => $request->no_telephone,
            'address' => $request->address,
        ]);
        return redirect()->route('qm.profile')->with('success', 'Profil berhasil diperbarui.');
    }
    public function changePassword()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_qm.profile.change_password', data: compact('user', 'currentDate'));
    }
    public function viewComplaint()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $complaints = Complaints::all();
        return view('pages.role_qm.complaint.complaint', compact('user', 'complaints', 'currentDate'));
    }
    public function detailComplaint($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaint = Complaints::with(['distributor', 'categories'])->findOrFail($id);
        $status = ComplaintStatus::whereIn('id', [$complaint->current_status_id, 2, 3, 7, 4])->get();
        $history = ComplaintInteraction::where('complaint_id', $id)->get();
        return view('pages.role_qm.complaint.detail_complaint', compact('user', 'distributors', 'complaint', 'currentDate', 'status', 'history'));
    }
    public function updateComplaintStatus(Request $request, $complaintId)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'complaint_status_id' => 'required|exists:complaint_status,id',
            'notes' => 'required|string',
            'supporting_document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $complaint = Complaints::findOrFail($complaintId);
        $filePath = null;
        if ($request->hasFile('supporting_document')) {
            $filePath = $request->file('supporting_document')->store('supporting_document', 'public');
        }
        ComplaintInteraction::create([
            'complaint_id' => $complaint->id,
            'complaint_status_id' => $validated['complaint_status_id'],
            'user_id' => $user->id,
            'notes' => $validated['notes'],
            'supporting_document' => $filePath,
            'supporting_url' => $request->supporting_url ? $request->supporting_url : null,
            'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);
        $complaint->update([
            'current_status_id' => $validated['complaint_status_id'],
        ]);
        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui!');
    }
    public function requestCloseComplaint($id)
    {
        DB::beginTransaction();
        try {
            Carbon::setLocale('id');
            $user = Auth::user();
            $userId = $user->id;
            $complaint = Complaints::findOrFail($id);
            $complaint->update([
                'current_status_id' => 11
            ]);
            ComplaintInteraction::create([
                'complaint_id' => $complaint->id,
                'complaint_status_id' => 11,
                'user_id' => $userId,
                'notes' => 'Permintaan penutupan aduan telah diajukan, silahkan segera menyetujui apabila ingin menutup aduan ini.',
                'supporting_document' => null,
                'supporting_url' => null,
                'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Status Aduan berhasil diubah menjadi permintaan close!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal Memperbarui status komplain: ' . $e->getMessage());
        }
    }
}
