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

class SalesManagerController extends Controller
{
    public function viewDistributor()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        return view('pages.role_sm.distributor.distributor', compact('distributors', 'user', 'currentDate'));
    }
    public function detailDistributor($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity'])->find($id);
        return view('pages.role_sm.distributor.detail_distributor', compact('distributors', 'user', 'currentDate'));
    }

    public function addDistributor()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $company_type = CompanyType::all();
        $company_province = Province::all();
        $company_city = Regency::all();
        $distributors = MainDistributor::all();
        return view('pages.role_sm.distributor.add_distributor',  compact('user',  'company_type', 'company_province', 'company_city', 'distributors', 'currentDate'));
    }
    public function saveDistributor(Request $request)
    {
        $user = Auth::user();
        $validated =  $request->validate([
            'company_type_id' => 'required',
            'company_name' => 'required|string|max:255',
            'company_province_id' => 'required',
            'company_city_id' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required|string|email|max:255|unique:distributors',
        ], [
            'company_type_id.required' => 'Pilih salah satu tipe perusahaan',
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'company_province_id.required' => 'Pilih salah satu provinsi',
            'company_city_id.required' => 'Pilih salah satu kota',
            'company_address.required' => 'Alamat wajib diisi',
            'company_phone.required' => 'No. Telepon wajib diisi',
            'company_email.required' => 'Email wajib diisi',
            'company_email.unique' => 'Email ini sudah terdaftar',
        ]);
        Distributor::create([
            'company_type_id' => $validated['company_type_id'],
            'company_name' => $validated['company_name'],
            'company_distributor_id' => $user->distributor_id,
            'company_province_id' => $validated['company_province_id'],
            'company_city_id' => $validated['company_city_id'],
            'company_address' => $validated['company_address'],
            'company_phone' => $validated['company_phone'],
            'company_email' => $validated['company_email'],
            'company_website' => $validated['company_website'] ?? null
        ]);
        return redirect()->route('sales.distributor.index')->with('success', 'Berhasil menambahkan <strong style="color:green;">' . $validated['company_name'] . '</strong> ke distributor');
    }
    public function editDistributor($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::with(['companyType', 'companyProvince', 'companyCity', 'companyDistributor'])->find($id);
        $company_type = CompanyType::all();
        $company_province = Province::all();
        $company_city = Regency::all();
        $companyDistributor = MainDistributor::all();
        return view('pages.role_sm.distributor.edit_distributor', compact('user', 'distributors', 'company_type', 'company_province', 'company_city', 'companyDistributor', 'currentDate'));
    }

    public function updateDistributor(Request $request, $id)
    {
        $validated =  $request->validate([
            'company_type_id' => 'required',
            'company_name' => 'required|string|max:255',
            'company_province_id' => 'required',
            'company_city_id' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required|string|email|max:255|unique:distributors,company_email,' . $id,
        ], [
            'company_type_id.required' => 'Pilih salah satu tipe perusahaan',
            'company_name.required' => 'Nama perusahaan wajib diisi',
            'company_province_id.required' => 'Pilih salah satu provinsi',
            'company_city_id.required' => 'Pilih salah satu kota',
            'company_address.required' => 'Alamat wajib diisi',
            'company_phone.required' => 'No. Telepon wajib diisi',
            'company_email.required' => 'Email wajib diisi',
            'company_email.unique' => 'Email ini sudah terdaftar',
        ]);
        $distributor = Distributor::find($id);
        $distributor->update([
            'company_type_id' => $validated['company_type_id'],
            'company_name' => $validated['company_name'],
            'company_province_id' => $validated['company_province_id'],
            'company_city_id' => $validated['company_city_id'],
            'company_address' => $validated['company_address'],
            'company_phone' => $validated['company_phone'],
            'company_email' => $validated['company_email'],
            'company_website' => $request->company_website ?? null
        ]);
        return redirect()->route('sales.distributor.index')->with('success', 'Berhasil mengubah <strong style="color:green;">' . $validated['company_name'] . '</strong> distributor');
    }
    public function deleteDistributor($id)
    {
        $distributor = Distributor::where('id', $id)->first();
        if (!$distributor) {
            return redirect()->route('admin.distributor.index')->with('error', 'Distributor tidak ditemukan.');
        }
        Distributor::where('id', $id)->delete();
        return redirect()->route('sales.distributor.index')->with('success', 'Berhasil menghapus <strong style="color:green;">' . e($distributor->company_name) . '</strong> dari distributor');
    }
    public function viewComplaint()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributorIds = Distributor::where('company_distributor_id', $user->distributor_id)
                            ->pluck('id');
        $complaints = Complaints::with(['distributor', 'categories', 'currentStatus'])
                        ->whereIn('distributor_id', $distributorIds)
                        ->get();    
        return view('pages.role_sm.complaint.complaint', compact('user', 'distributorIds', 'complaints', 'currentDate'));
    }

    public function detailComplaint($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        $complaint = Complaints::with(['distributor', 'categories'])->findOrFail($id);
        $status = ComplaintStatus::whereIn('id', [$complaint->current_status_id, 2, 3])->get();
        $history = ComplaintInteraction::where('complaint_id', $id)->get();
        return view('pages.role_sm.complaint.detail_complaint', compact('user', 'distributors', 'complaint', 'currentDate', 'status', 'history'));
    }
    public function addComplaint()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $categoryComplaints = CategoryComplaints::all();
        $distributors = Distributor::where('company_distributor_id', $user->distributor_id)->get();
        return view('pages.role_sm.complaint.add_complaint', compact('user', 'distributors', 'categoryComplaints', 'currentDate'));
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
    public function editComplaint($id)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        $categoryComplaints = CategoryComplaints::all();


        $complaint = Complaints::findOrFail($id);
        $selectedCategoryIds = $complaint->categories->pluck('id')->toArray();
        $distributors = Distributor::all();
        return view('pages.role_sm.complaint.edit_complaint', compact('complaint', 'distributors', 'categoryComplaints', 'user', 'currentDate', 'selectedCategoryIds'));
    }
    public function deleteComplaint($id)
    {
        $complaint = Complaints::findOrFail($id);
        $complaint->delete();
        return redirect()->route('sales.complaint.index')
            ->with('success', 'Komplain berhasil dihapus!');
    }
}
