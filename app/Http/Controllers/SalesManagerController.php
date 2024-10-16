<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Carbon\Carbon;
use App\Models\CategoryComplaints;
use App\Models\ComplaintFile;
use App\Models\Complaints;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SalesManagerController extends Controller
{
    public function viewDistributor()
    {
        $user = Auth::user();
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        return view('pages.role_user.distributor.distributor', compact('distributors', 'user'));
    }
    public function viewComplaint()
    {
        $user = Auth::user();
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaints = Complaints::with(['distributor', 'categories'])->get();
        return view('pages.role_user.complaint.complaint', compact('user', 'distributors', 'complaints'));
    }
    public function detailComplaint($id)
    {
        $user = Auth::user();
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaint = Complaints::with(['distributor', 'categories'])->findOrFail($id);
        return view('pages.role_user.complaint.detail_complaint', compact('user', 'distributors', 'complaint'));
    }
    public function addComplaint()
    {
        $user = Auth::user();
        $categoryComplaints = CategoryComplaints::all();
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        return view('pages.role_user.complaint.add_complaint', compact('user', 'distributors', 'categoryComplaints'));
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
            'supporting_document' => 'nullable|mimes:pdf|max:2048', // Validasi untuk dokumen pendukung


        ], [
            'distributor_id.required' => 'Distributor wajib dipilih salah satu',
            'batch_number.required' => 'Batch Number wajib diisi',
            'complaint_title.required' => 'Judul permasalahan wajib diisi',
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
            'created_at' => Carbon::now()->timezone('Asia/Jakarta'), // Pastikan waktu sesuai zona waktu

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

        return redirect()->route('sales.complaint.index')
            ->with('success', 'Komplain berhasil disimpan!');
    }
}
