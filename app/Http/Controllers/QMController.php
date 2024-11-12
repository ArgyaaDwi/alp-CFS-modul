<?php

namespace App\Http\Controllers;

use App\Mail\ComplaintStatusUpdateMail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Complaints;
use App\Models\Distributor;
use Illuminate\Http\Request;
use App\Models\ComplaintStatus;
use Illuminate\Support\Facades\DB;
use App\Models\ComplaintInteraction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'no_telephone.required' => 'No. Telepon tidak boleh kosong.',
            'address.required' => 'Alamat tidak boleh kosong.',
            'name.max' => 'Nama tidak boleh melebihi 255 karakter.',
            'profile_pic.image' => 'File harus berupa gambar.',
            'profile_pic.max' => 'File terlalu besar.',
            'profile_pic.mimes' => 'File harus berupa jpeg, png, jpg',
        ]);
        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic')->store('profile_pic', 'public');
            $image = basename($profile_pic);
        } else {
            $image = $user->profile_pic;
        }
        $user->update([
            'name' => $request->name,
            'no_telephone' => $request->no_telephone,
            'address' => $request->address,
            'profile_pic' => $image,
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
        $status = ComplaintStatus::whereIn('id', [$complaint->current_status_id, 2, 3, 7, 4, 12])->get();
        $history = ComplaintInteraction::where('complaint_id', $id)->get();
        return view('pages.role_qm.complaint.detail_complaint', compact('user', 'distributors', 'complaint', 'currentDate', 'status', 'history'));
    }
    public function updateComplaintStatus(Request $request, $complaintId)
    {
        $validated = $request->validate([
            'complaint_status_id' => 'required|exists:complaint_status,id',
            'notes' => 'required|string',
            'supporting_document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'complaint_status_id.required' => 'Status aduan tidak boleh kosong.',
            'notes.required' => 'Catatan tidak boleh kosong.',
        ]);
        DB::beginTransaction();
        try {
            $user = Auth::user();
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
            $latestInteraction = $complaint->complaintInteraction()->latest()->first();
            Mail::to('ferdinandargya@gmail.com')->send(new ComplaintStatusUpdateMail($user, $complaint, $latestInteraction));
            DB::commit();
            return redirect()->back()->with('success', 'Status aduan  Feedback berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal Memperbarui status aduan: ' . $e->getMessage());
        }
    }
    public function toFGM(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'required|string',
            'supporting_document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'supporting_url' => 'nullable|string',
        ], [
            'notes.required' => 'Catatan tidak boleh kosong.',
        ]);
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $userId = $user->id;
            Carbon::setLocale('id');
            $complaint = Complaints::findOrFail($id);
            $filePath = null;
            if ($request->hasFile('supporting_document')) {
                $filePath = $request->file('supporting_document')->store('supporting_document', 'public');
            }
            ComplaintInteraction::create([
                'complaint_id' => $complaint->id,
                'complaint_status_id' => 4,
                'user_id' => $userId,
                'notes' => $validated['notes'],
                'supporting_document' => $filePath,
                'supporting_url' => $request->supporting_url ? $request->supporting_url : null,
                'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
            ]);
            $complaint->update([
                'current_status_id' => 4
            ]);
            $latestInteraction = $complaint->complaintInteraction()->latest()->first();
            Mail::to('ferdinandargya@gmail.com')->send(new ComplaintStatusUpdateMail($user, $complaint, $latestInteraction));
            DB::commit();
            return redirect()->back()->with('success', 'Status aduan Feedback berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal Memperbarui status komplain: ' . $e->getMessage());
        }
    }
    public function revFGM(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'required|string',
            'supporting_document' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'supporting_url' => 'nullable|string',
        ], [
            'notes.required' => 'Catatan tidak boleh kosong.',
        ]);
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $userId = $user->id;
            Carbon::setLocale('id');
            $complaint = Complaints::findOrFail($id);
            $filePath = null;
            if ($request->hasFile('supporting_document')) {
                $filePath = $request->file('supporting_document')->store('supporting_document', 'public');
            }
            ComplaintInteraction::create([
                'complaint_id' => $complaint->id,
                'complaint_status_id' => 12,
                'user_id' => $userId,
                'notes' => $validated['notes'],
                'supporting_document' => $filePath,
                'supporting_url' => $request->supporting_url ? $request->supporting_url : null,
                'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
            ]);
            $complaint->update([
                'current_status_id' => 12
            ]);
            $latestInteraction = $complaint->complaintInteraction()->latest()->first();
            Mail::to('ferdinandargya@gmail.com')->send(new ComplaintStatusUpdateMail($user, $complaint, $latestInteraction));
            DB::commit();
            return redirect()->back()->with('success', 'Status aduan Feedback berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal Revisi: ' . $e->getMessage());
        }
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
            $latestInteraction = $complaint->complaintInteraction()->latest()->first();
            Mail::to('ferdinandargya@gmail.com')->send(new ComplaintStatusUpdateMail($user, $complaint, $latestInteraction));
            DB::commit();
            return redirect()->back()->with('success', 'Status Aduan berhasil diubah menjadi permintaan close!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal Memperbarui status komplain: ' . $e->getMessage());
        }
    }
}
