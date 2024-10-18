<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Carbon\Carbon;
use App\Models\CategoryComplaints;
use App\Models\ComplaintFile;
use App\Models\ComplaintInteraction;
use App\Models\Complaints;
use App\Models\ComplaintStatus;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SalesManagerController extends Controller
{
    public function viewDistributor()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        return view('pages.role_user.distributor.distributor', compact('distributors', 'user', 'currentDate'));
    }
    public function viewComplaint()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaints = Complaints::with(['distributor', 'categories', 'currentStatus'])->get();
        return view('pages.role_user.complaint.complaint', compact('user', 'distributors', 'complaints', 'currentDate'));
    }
    public function detailComplaint($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaint = Complaints::with(['distributor', 'categories'])->findOrFail($id);
        $status = ComplaintStatus::whereIn('id', [$complaint->current_status_id, 2, 3])->get();
        $history = ComplaintInteraction::where('complaint_id', $id)->get();
        return view('pages.role_user.complaint.detail_complaint', compact('user', 'distributors', 'complaint', 'currentDate', 'status', 'history'));
    }
    public function addComplaint()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $categoryComplaints = CategoryComplaints::all();
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        return view('pages.role_user.complaint.add_complaint', compact('user', 'distributors', 'categoryComplaints', 'currentDate'));
    }
    public function saveComplaint(Request $request)
    {
        Carbon::setLocale('id');
        $user = Auth::user();
        $mainDistributorId = $user->distributor->id;
        $userId = $user->id;
        $validated = $request->validate([
            'distributor_id' => 'required',
            'batch_number' => 'required',
            'complaint_title' => 'required',
            'complaint_description' => 'required',
            'complaint_hopeful_solution' => 'required',
            'complaint_category_ids' => 'required|array',
            'complaint_category_ids.*' => 'exists:category_complaints,id',
            'files.*' => 'mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            'complaint_description.required' => 'Deskripsi permasalahan wajib diisi',
            'complaint_hopeful_solution.required' => 'Solusi yang diharapkan wajib diisi',
            'complaint_category_ids.required' => 'Kategori komplain wajib dipilih',
            'complaint_category_ids.*.exists' => 'Kategori komplain tidak ditemukan',
            'files.*.mimes' => 'File harus berupa gambar (jpg, jpeg, png) atau video (mp4, mov, avi)',
            'files.*.max' => 'Ukuran file maksimal 10MB',
            'supporting_document.mimes' => 'File harus berupa PDF',
        ]);
        $complaint = Complaints::create([
            'user_id' => $userId,
            'distributor_id' => $validated['distributor_id'],
            'main_distributor_id' => $mainDistributorId,
            'batch_number' => $validated['batch_number'],
            'complaint_title' => $validated['complaint_title'],
            'complaint_description' => $validated['complaint_description'],
            'complaint_hopeful_solution' => $validated['complaint_hopeful_solution'],
            'supporting_document' => $request->file('supporting_document') ? $request->file('supporting_document')->store('supporting_document', 'public') : null,
            'current_status_id' => 1,
            'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);
        $categories = $request->complaint_category_ids;
        foreach ($categories as $categoryId) {
            $otherCategoryName = null;
            if ($categoryId == 4 && $request->complaint_category_name) {
                $otherCategoryName = $request->complaint_category_name;
            }
            $complaint->categories()->attach($categoryId, [
                'other_category_name' => $otherCategoryName,
            ]);
        }
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('complaint_files', 'public');
                ComplaintFile::create([
                    'complaint_id' => $complaint->id,
                    'file_path' => $filePath,
                ]);
            }
        }
        ComplaintInteraction::create([
            'complaint_id' => $complaint->id,
            'user_id' => $userId,
            'complaint_status_id' => 1,
            'title' => 'Aduan Diajukan',
            'notes' => 'Aduan telah diajukan dan menunggu diproses.',
            'supporting_document_path' => $request->file('supporting_document') ? $request->file('supporting_document')->store('supporting_document', 'public') : null,
        ]);
        return redirect()->route('sales.complaint.index')
            ->with('success', 'Komplain berhasil disimpan!');
    }
    public function editComplaint($id){
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $categoryComplaints = CategoryComplaints::all();


        $complaint = Complaints::findOrFail($id);
        $selectedCategoryIds = $complaint->categories->pluck('id')->toArray();
        $distributors = Distributor::all();
        return view('pages.role_user.complaint.edit_complaint', compact('complaint', 'distributors', 'categoryComplaints', 'user', 'currentDate', 'selectedCategoryIds'));
    }
    public function deleteComplaint($id){
        $complaint = Complaints::findOrFail($id);
        $complaint->delete();
        return redirect()->route('sales.complaint.index')
            ->with('success', 'Komplain berhasil dihapus!');
    }

}
