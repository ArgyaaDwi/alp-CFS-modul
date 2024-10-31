<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Regency;
use App\Models\Province;
use App\Models\Complaints;
use App\Mail\ComplaintMail;
use App\Models\CompanyType;
use App\Models\Distributor;
use Illuminate\Http\Request;
use App\Models\ComplaintFile;
use App\Models\ComplaintStatus;
use App\Models\MainDistributor;
use App\Models\CategoryComplaints;
use App\Models\ComplaintInteraction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

class SalesManagerController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_sm.profile.profile', compact('user', 'currentDate'));
    }
    public function editProfile()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_sm.profile.edit_profile', compact('user', 'currentDate'));
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
        return redirect()->route('sales.profile')->with('success', 'Profil berhasil diperbarui.');
    }
    public function changePassword()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->locale('id')->translatedFormat('l, j F Y ');
        return view('pages.role_sm.profile.change_password', data: compact('user', 'currentDate'));
    }
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
        $validated = $request->validate([
            'distributor_id' => 'required',
            'batch_number' => 'required',
            'complaint_title' => 'required',
            'complaint_description' => 'required',
            'complaint_hopeful_solution' => 'required',
            'complaint_category_ids' => 'required|array',
            'complaint_category_ids.*' => 'exists:category_complaints,id',
            'files' => 'required|array',
            'files.*' => 'mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            'supporting_document' => 'required|mimes:pdf|max:2048',
            'supporting_url' => 'nullable',
        ], [
            'distributor_id.required' => 'Distributor wajib dipilih',
            'batch_number.required' => 'Nomor batch wajib diisi',
            'complaint_title.required' => 'Judul permasalahan wajib diisi',
            'complaint_description.required' => 'Deskripsi permasalahan wajib diisi',
            'complaint_hopeful_solution.required' => 'Solusi yang diharapkan wajib diisi',
            'complaint_category_ids.required' => 'Kategori komplain wajib dipilih minimal 1',
            'complaint_category_ids.*.exists' => 'Kategori komplain tidak ditemukan',
            'files.*.required' => 'File wajib diinputkan',
            'files.required' => 'Wajib input file foto sebagai validasi bukti',
            'files.*.mimes' => 'File harus berupa gambar (jpg, jpeg, png) atau video (mp4, mov, avi)',
            'files.*.max' => 'Ukuran file maksimal 10MB',
            'supporting_document.required' => 'File pendukung wajib diinput',
            'supporting_document.mimes' => 'File harus berupa PDF',
            'supporting_document.max' => 'Ukuran file maksimal 2MB',
        ]);
        DB::beginTransaction();
        try {
            Carbon::setLocale('id');
            $user = Auth::user();
            $mainDistributorId = $user->distributor->id;
            $userId = $user->id;
            $complaint = Complaints::create([
                'user_id' => $userId,
                'distributor_id' => $validated['distributor_id'],
                'main_distributor_id' => $mainDistributorId,
                'batch_number' => $validated['batch_number'],
                'complaint_title' => $validated['complaint_title'],
                'complaint_description' => $validated['complaint_description'],
                'complaint_hopeful_solution' => $validated['complaint_hopeful_solution'],
                'supporting_document' => $request->file('supporting_document') ? $request->file('supporting_document')
                    ->store('supporting_document', 'public') : null,
                'supporting_url' => $request->supporting_url ?? null,
                'current_status_id' => 1,
                'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
            ]);
            $categories = $request->complaint_category_ids;
            foreach ($categories as $categoryId) {
                $otherCategoryName = null;
                if ($categoryId == 4 && $request->other_category_name) {
                    $otherCategoryName = $request->other_category_name;
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
                'notes' => 'Aduan Feedback telah diajukan dan menunggu diproses lebih lanjut.',
                'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
            ]);
            Mail::to('ferdinandargya@gmail.com')->send(new ComplaintMail($user, $complaint, $request
                ->file('supporting_document')));
            DB::commit();
            return redirect()->route('sales.complaint.index')
                ->with('success', 'Aduan Feedback berhasil diajukan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal membuat aduan Feedback: ' . $e->getMessage());
        }
    }
    public function saveComplaint1(Request $request)
    {
        Carbon::setLocale(locale: 'id');
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
            'files' => 'required|array',
            'files.*' => 'mimes:jpg,jpeg,png,mp4,mov,avi|max:10240',
            'supporting_document' => 'required|mimes:pdf|max:2048',
            'supporting_url' => 'nullable',
        ], [
            'distributor_id.required' => 'Distributor wajib dipilih',
            'batch_number.required' => 'Nomor batch wajib diisi',
            'complaint_title.required' => 'Judul permasalahan wajib diisi',
            'complaint_description.required' => 'Deskripsi permasalahan wajib diisi',
            'complaint_hopeful_solution.required' => 'Solusi yang diharapkan wajib diisi',
            'complaint_category_ids.required' => 'Kategori komplain wajib dipilih minimal 1',
            'complaint_category_ids.*.exists' => 'Kategori komplain tidak ditemukan',
            'files.*.required' => 'File wajib diinputkan',
            'files.required' => 'Wajib input file foto sebagai validasi bukti',
            'files.*.mimes' => 'File harus berupa gambar (jpg, jpeg, png) atau video (mp4, mov, avi)',
            'files.*.max' => 'Ukuran file maksimal 10MB',
            'supporting_document.required' => 'File pendukung wajib diinput',
            'supporting_document.mimes' => 'File harus berupa PDF',
            'supporting_document.max' => 'Ukuran file maksimal 2MB',
        ]);
        $complaint = Complaints::create([
            'user_id' => $userId,
            'distributor_id' => $validated['distributor_id'],
            'main_distributor_id' => $mainDistributorId,
            'batch_number' => $validated['batch_number'],
            'complaint_title' => $validated['complaint_title'],
            'complaint_description' => $validated['complaint_description'],
            'complaint_hopeful_solution' => $validated['complaint_hopeful_solution'],
            'supporting_document' => $request->file('supporting_document') ? $request->file('supporting_document')
                ->store('supporting_document', 'public') : null,
            'supporting_url' => $request->supporting_url ? $request->supporting_url : null,
            'current_status_id' => 1,
            'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
            'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);

        $categories = $request->complaint_category_ids;
        foreach ($categories as $categoryId) {
            $otherCategoryName = null;
            if ($categoryId == 4 && $request->other_category_name) {
                $otherCategoryName = $request->other_category_name;
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
            'notes' => 'Aduan telah diajukan dan menunggu diproses.',
            'supporting_document' => $request->file('supporting_document') ? $request->file('supporting_document')
                ->store('supporting_document', 'public') : null,
            'supporting_url' => $request->supporting_url ? $request->supporting_url : null,
            'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);
        Mail::to('ferdinandargya@gmail.com')->send(new ComplaintMail($user, $complaint, $request
            ->file('supporting_document')));
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
        return view(
            'pages.role_sm.complaint.edit_complaint',
            compact(
                'complaint',
                'distributors',
                'categoryComplaints',
                'user',
                'currentDate',
                'selectedCategoryIds'
            )
        );
    }
    public function updateComplaint(Request $request, $id)
    {
        Carbon::setLocale('id');
        $user = Auth::user();
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
            'supporting_document' => 'mimes:pdf|max:2048',
        ]);
        $complaint = Complaints::findOrFail($id);
        $complaint->update([
            'distributor_id' => $validated['distributor_id'],
            'batch_number' => $validated['batch_number'],
            'complaint_title' => $validated['complaint_title'],
            'complaint_description' => $validated['complaint_description'],
            'complaint_hopeful_solution' => $validated['complaint_hopeful_solution'],
            'supporting_document' => $request->file('supporting_document') ? $request->file('supporting_document')->store('supporting_document', 'public') : $complaint->supporting_document,
            'current_status_id' => 10,
            'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);
        $complaint->categories()->detach();
        $categories = $request->complaint_category_ids;
        foreach ($categories as $categoryId) {
            $otherCategoryName = null;
            if ($categoryId == 4 && $request->other_category_name) {
                $otherCategoryName = $request->other_category_name;
            }
            $complaint->categories()->attach($categoryId, [
                'other_category_name' => $otherCategoryName,
            ]);
        }
        if ($request->hasFile('files')) {
            foreach ($complaint->files as $file) {
                Storage::delete('public/' . $file->file_path);
                $file->delete();
            }
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
            'complaint_status_id' => 10,
            'notes' => 'Aduan feedback telah direvisi. Periksa detail terbaru untuk tindak lanjut.',
            'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
            'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
        ]);
        return redirect()->route('sales.complaint.index')
            ->with('success', 'Komplain berhasil direvisi!');
    }
    public function closeComplaint($id)
    {
        DB::beginTransaction();
        try {
            Carbon::setLocale('id');
            $user = Auth::user();
            $userId = $user->id;
            $complaint = Complaints::findOrFail($id);
            $complaint->update([
                'current_status_id' => 6
            ]);
            ComplaintInteraction::create([
                'complaint_id' => $complaint->id,
                'complaint_status_id' => 6,
                'user_id' => $userId,
                'notes' => 'Aduan feedback telah ditutup.',
                'supporting_document' => null,
                'supporting_url' => null,
                'created_at' => Carbon::now()->timezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->timezone('Asia/Jakarta'),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Status Aduan berhasil diubah menjadi close!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal close status komplain: ' . $e->getMessage());
        }
    }
    public function deleteComplaint($id)
    {
        $complaint = Complaints::findOrFail($id);
        $complaint->delete();
        return redirect()->route('sales.complaint.index')
            ->with('success', 'Komplain berhasil dihapus!');
    }
}
